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

        
        $oldPath = app_path('Http/Controllers/' . $name . 'Controller.php');
        $newPath = app_path('Http/Controllers/Api/' . strtoupper($version) . '/' . $name . 'Controller.php');
        \File::ensureDirectoryExists(dirname($newPath));
        \File::move($oldPath, $newPath);

       
        $content = \File::get($newPath);
        $content = $this->modifyControllerContent($content, $name, $version, $withService);
        \File::put($newPath, $content);
    }

    private function modifyControllerContent($content, $name, $version, $withService)
    {
        // Change namespace
        $content = str_replace(
            'namespace App\Http\Controllers;',
            'namespace App\Http\Controllers\Api\\' . strtoupper($version) . ';',
            $content
        );


        // Add uses
        $uses = "use App\Http\Controllers\Controller;\n";
        $uses .= "use App\Models\\{$name};\n";
       
        if ($withService) {
            $uses .= "use App\Services\\{$name}Service;\n";
        }

        $uses .= "use App\Http\Resources\\{$name}Resource;\n";
        $uses .= "use Illuminate\Http\Request;\n";

        // Insert or replace use statements
        if (strpos($content, 'use App\Http\Controllers\Controller;') !== false) {
            $content = str_replace("use App\Http\Controllers\Controller;\nuse Illuminate\Http\Request;", $uses, $content);
            $content = str_replace('use App\Http\Controllers\Controller;', $uses, $content);
        } elseif (strpos($content, 'use Illuminate\Http\Request;') !== false) {
            $content = str_replace('use Illuminate\Http\Request;', $uses, $content);
        } else {
            $content = str_replace(
                'namespace App\Http\Controllers;'.PHP_EOL,
                'namespace App\Http\Controllers;'.PHP_EOL.PHP_EOL.$uses,
                $content
            );
        }

        // Add service property and constructor if withService
        if ($withService) {
            $content = str_replace(
                'class ' . $name . 'Controller extends Controller' . PHP_EOL . '{',
                'class ' . $name . 'Controller extends Controller' . PHP_EOL . '{' . PHP_EOL . '    protected ' . $name . 'Service $service;' . PHP_EOL . PHP_EOL . '    public function __construct(' . $name . 'Service $service)' . PHP_EOL . '    {' . PHP_EOL . '        $this->service = $service;' . PHP_EOL . '    }' . PHP_EOL,
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
            'public function store(Store' . $name . 'Request $request)' . PHP_EOL . '    {' . PHP_EOL . '        ' . ($withService ? '$data = $request->validated();' . PHP_EOL . '        $model = $this->service->create' . $name . '($data);' . PHP_EOL . '        return response()->json(new ' . $name . 'Resource($model), 201);' : '$data = $request->validated();' . PHP_EOL . '        $model = ' . $name . '::create($data);' . PHP_EOL . '        return response()->json(new ' . $name . 'Resource($model), 201);') . PHP_EOL . '    }',
            $content
        );

        // Replace update method
        $content = preg_replace(
            '/public function update\(Request \$request, [^}]*\}/s',
            'public function update(Update' . $name . 'Request $request, int $id)' . PHP_EOL . '    {' . PHP_EOL . '        ' . ($withService ? '$data = $request->validated();' . PHP_EOL . '        $model = $this->service->update' . $name . '($id, $data);' . PHP_EOL . '        return response()->json(new ' . $name . 'Resource($model));' : '$model = ' . $name . '::findOrFail($id);' . PHP_EOL . '        $model->update($request->validated());' . PHP_EOL . '        return response()->json(new ' . $name . 'Resource($model));') . PHP_EOL . '    }',
            $content
        );

        // Modify index and show if withService
        if ($withService) {
            $content = str_replace(
                'return response()->json(' . $name . '::all());',
                'return response()->json(' . $name . 'Resource::collection($this->service->get' . $name . 'es()));',
                $content
            );
            $content = str_replace(
                'return response()->json(' . $name . '::findOrFail($id));',
                'return response()->json(new ' . $name . 'Resource($this->service->get' . $name . '($id)));',
                $content
            );
            $content = str_replace(
                $name . '::findOrFail($id)->delete();',
                '$this->service->delete' . $name . '($id);',
                $content
            );
        } else {
            // When no service, still wrap responses in resources
            $content = str_replace(
                'return response()->json(' . $name . '::all());',
                'return response()->json(' . $name . 'Resource::collection(' . $name . '::all()));',
                $content
            );
            $content = str_replace(
                'return response()->json(' . $name . '::findOrFail($id));',
                'return response()->json(new ' . $name . 'Resource(' . $name . '::findOrFail($id)));',
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