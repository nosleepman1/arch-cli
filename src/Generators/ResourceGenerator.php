<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

class ResourceGenerator
{
    public function generate($name)
    {
        $stub = File::get(__DIR__ . '/../Stubs/Resource.stub');

        $stub = str_replace('{{class}}', $name, $stub);

        $path = app_path('Http/Resources/' . $name . 'Resource.php');

        File::ensureDirectoryExists(dirname($path));

        File::put($path, $stub);
    }
}