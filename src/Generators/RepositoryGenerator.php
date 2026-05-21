<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

class RepositoryGenerator
{
    public function generate(string $name): void
    {
        $stubFile = 'Repository.stub';

        $stub = File::get(__DIR__ . '/../Stubs/' . $stubFile);

        $stub = str_replace('{{class}}', $name, $stub);
        $stub = str_replace('{{model}}', $name, $stub);

        $path = app_path('Repositories/' . $name . 'Repository.php');

        File::ensureDirectoryExists(dirname($path));
        File::put($path, $stub);
    }
}

