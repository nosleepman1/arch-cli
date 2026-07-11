<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

class RepositoryGenerator extends BaseGenerator
{
    public function generate(string $name): void
    {
        $stubFile = 'Repository.stub';

        $stub = $this->getStubContent($stubFile);

        $stub = str_replace('{{class}}', $name, $stub);
        $stub = str_replace('{{model}}', $name, $stub);

        $path = app_path('Repositories/' . $name . 'Repository.php');

        File::ensureDirectoryExists(dirname($path));
        File::put($path, $stub);
    }
}

