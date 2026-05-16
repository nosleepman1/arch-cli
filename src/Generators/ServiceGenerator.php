<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

class ServiceGenerator
{
    public function generate(string $name, bool $withEvents = false): void
    {
        $stubFile = $withEvents ? 'ServiceWithEvent.stub' : 'Service.stub';

        $stub = File::get(__DIR__ . '/../Stubs/' . $stubFile);

        $stub = str_replace('{{class}}', $name, $stub);
        $stub = str_replace('{{model}}', $name, $stub);

        $path = app_path('Services/' . $name . 'Service.php');

        File::ensureDirectoryExists(dirname($path));
        File::put($path, $stub);
    }
}