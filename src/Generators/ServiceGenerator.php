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

        if ($withEvents) {
            $eventPath = app_path('Events/' . $name . 'Created.php');
            $eventStub = File::get(__DIR__ . '/../Stubs/Event.stub');
            $eventStub = str_replace('{{class}}', $name, $eventStub);
            $eventStub = str_replace('{{model}}', $name, $eventStub);
            File::ensureDirectoryExists(dirname($eventPath));
            File::put($eventPath, $eventStub);

            $stub = str_replace('//', $name . 'Created', $stub);
        }

        $path = app_path('Services/' . $name . 'Service.php');

        File::ensureDirectoryExists(dirname($path));
        File::put($path, $stub);
    }
}