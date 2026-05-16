<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

class ControllerGenerator
{
    public function generate(string $name, string $version, bool $withService): void
    {
        $stubFile = $withService ? 'Controller.stub' : 'ControllerWithoutService.stub';

        $stub = File::get(__DIR__ . '/../Stubs/' . $stubFile);

        $stub = str_replace('{{class}}', $name, $stub);
        $stub = str_replace('{{VERSION}}', strtoupper($version), $stub);

        $path = app_path('Http/Controllers/Api/' . strtoupper($version) . '/' . $name . 'Controller.php');

        File::ensureDirectoryExists(dirname($path));
        File::put($path, $stub);
    }
}