<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

class ServiceGenerator
{
        public function generate($name, $withEvents = false)
        {
            $stub = File::get(__DIR__ . '/../Stubs/Service.stub');

            $stub = str_replace('{{class}}', $name, $stub);
            $stub = str_replace('{{model}}', $name, $stub);
            $stub = str_replace('{{withEvents}}', $withEvents ? 'true' : 'false', $stub);

        File::ensureDirectoryExists(dirname($path));

        File::put($path, $stub);
    }
}