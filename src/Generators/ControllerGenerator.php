<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

class ControllerGenerator
{
    public function generate($name, $version, $withService)
    {
        // Use Laravel's make:controller --api
        \Artisan::call('make:controller', [
            'name' => $name . 'Controller',
            '--api' => true,
        ]);

        // Move to API/V1/
        $oldPath = app_path('Http/Controllers/' . $name . 'Controller.php');
        $newPath = app_path('Http/Controllers/API/' . strtoupper($version) . '/' . $name . 'Controller.php');
        \File::ensureDirectoryExists(dirname($newPath));
        \File::move($oldPath, $newPath);

        // Modify the content
        $content = \File::get($newPath);
        $content = $this->modifyControllerContent($content, $name, $version, $withService);
        \File::put($newPath, $content);
    }

    private function modifyControllerContent($content, $name, $version, $withService)
    {
        // Change namespace
        $content = str_replace(
            'namespace App\Http\Controllers;',
            'namespace App\Http\Controllers\API\\' . strtoupper($version) . ';',
            $content
        );

        // Add uses
        $uses = '';
        if ($withService) {
            $uses .= "use App\Services\\{$name}Service;\n";
        }
        $uses .= "use App\Http\Requests\\{$name}\\Store{$name}Request;\n";
        $uses .= "use App\Http\Requests\\{$name}\\Update{$name}Request;\n";

        // Insert after namespace
        $content = str_replace(
            'namespace App\Http\Controllers\API\\' . strtoupper($version) . ';' . PHP_EOL . PHP_EOL . 'use Illuminate\Http\Request;',
            'namespace App\Http\Controllers\API\\' . strtoupper($version) . ';' . PHP_EOL . PHP_EOL . $uses . 'use Illuminate\Http\Request;',
            $content
        );

        // Add service property and constructor if withService
        if ($withService) {
            $content = str_replace(
                'class ' . $name . 'Controller extends Controller' . PHP_EOL . '{',
                'class ' . $name . 'Controller extends Controller' . PHP_EOL . '{' . PHP_EOL . '    protected ' . $name . 'Service $service;' . PHP_EOL . PHP_EOL . '    public function __construct()' . PHP_EOL . '    {' . PHP_EOL . '        $this->service = new ' . $name . 'Service();' . PHP_EOL . '    }' . PHP_EOL,
                $content
            );
        }

        // Modify methods to use requests and service
        $content = $this->modifyMethods($content, $name, $withService);

        return $content;
    }

    private function modifyMethods($content, $name, $withService)
    {
        // Replace store method
        $content = preg_replace(
            '/public function store\(Request \$request\)\s*\{[^}]*\}/s',
            'public function store(Store' . $name . 'Request $request)' . PHP_EOL . '    {' . PHP_EOL . '        ' . ($withService ? '$data = $request->validated();' . PHP_EOL . '        return response()->json($this->service->create' . $name . '($data), 201);' : '$data = $request->validated();' . PHP_EOL . '        return response()->json(' . $name . '::create($data), 201);') . PHP_EOL . '    }',
            $content
        );

        // Replace update method
        $content = preg_replace(
            '/public function update\(Request \$request, [^}]*\}/s',
            'public function update(Update' . $name . 'Request $request, $id)' . PHP_EOL . '    {' . PHP_EOL . '        ' . ($withService ? '$data = $request->validated();' . PHP_EOL . '        return response()->json($this->service->update' . $name . '($id, $data));' : '$model = ' . $name . '::findOrFail($id);' . PHP_EOL . '        $model->update($request->validated());' . PHP_EOL . '        return response()->json($model);') . PHP_EOL . '    }',
            $content
        );

        // Modify index and show if withService
        if ($withService) {
            $content = str_replace(
                'return response()->json(' . $name . '::all());',
                'return response()->json($this->service->get' . $name . 'es());',
                $content
            );
            $content = str_replace(
                'return response()->json(' . $name . '::findOrFail($id));',
                'return response()->json($this->service->get' . $name . '($id));',
                $content
            );
            $content = str_replace(
                $name . '::findOrFail($id)->delete();',
                '$this->service->delete' . $name . '($id);',
                $content
            );
        }

        return $content;
    }

    private function getServiceMethods($name)
    {
        return "
    public function index()
    {
        return response()->json(\$this->service->get{$name}es());
    }

    public function show(\$id)
    {
        return response()->json(\$this->service->get{$name}(\$id));
    }

    public function store(Store{$name}Request \$request)
    {
        \$data = \$request->validated();
        return response()->json(\$this->service->create{$name}(\$data), 201);
    }

    public function update(Update{$name}Request \$request, \$id)
    {
        \$data = \$request->validated();
        return response()->json(\$this->service->update{$name}(\$id, \$data));
    }

    public function destroy(\$id)
    {
        \$this->service->delete{$name}(\$id);
        return response()->json(['message' => '{$name} deleted']);
    }
";
    }

    private function getDirectMethods($name)
    {
        return "
    public function index()
    {
        return response()->json({$name}::all());
    }

    public function show(\$id)
    {
        return response()->json({$name}::findOrFail(\$id));
    }

    public function store(Store{$name}Request \$request)
    {
        \$data = \$request->validated();
        return response()->json({$name}::create(\$data), 201);
    }

    public function update(Update{$name}Request \$request, \$id)
    {
        \$model = {$name}::findOrFail(\$id);
        \$model->update(\$request->validated());
        return response()->json(\$model);
    }

    public function destroy(\$id)
    {
        {$name}::findOrFail(\$id)->delete();
        return response()->json(['message' => '{$name} deleted']);
    }
";
    }
}