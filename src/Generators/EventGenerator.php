<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

class EventGenerator
{
    public function generate($name)
    {
        $stub = File::get(__DIR__ . '/../Stubs/Event.stub');

        $stub = str_replace('{{class}}', $name, $stub);

        $path = app_path('Events/' . $name . 'Created.php');

        File::ensureDirectoryExists(dirname($path));

        File::put($path, $stub);
    }
}