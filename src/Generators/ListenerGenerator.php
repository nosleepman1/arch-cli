<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

class ListenerGenerator extends BaseGenerator
{
    public function generate($name)
    {
        $stub = $this->getStubContent('Listener.stub');

        $stub = str_replace('{{class}}', $name, $stub);

        $path = app_path('Listeners/' . $name . 'CreatedListener.php');

        File::ensureDirectoryExists(dirname($path));

        File::put($path, $stub);
    }
}