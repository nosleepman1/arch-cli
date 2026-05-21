<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

class ServiceGenerator
{
    public function generate(string $name, bool $withEvents = false): void
    {
        

        $ServiceStub = File::get(__DIR__ . '/../Stubs/Service.stub');
        

        $ServiceStub = str_replace('{{class}}', $name, $ServiceStub);
        $ServiceStub = str_replace('{{model}}', $name, $ServiceStub);

        if ($withEvents) {
           $eventStub = File::get(__DIR__ . '/../Stubs/Event.stub');
           $eventStub = str_replace('{{class}}', $name, $eventStub);
           $eventStub = str_replace('{{model}}', $name, $eventStub);
           File::ensureDirectoryExists(dirname($eventPath));
           File::put($eventPath, $eventStub);

           $ServiceStub = str_replace("// use App\Events", "use App\Events", $ServiceStub);
           $ServiceStub = str_replace('// Add event to service', 'event(new ' . $name . 'Created($model));', $ServiceStub);
        } else {
           $ServiceStub = str_replace('// Add event to service', '', $ServiceStub);
           $ServiceStub = str_replace("// use App\Events", "", $ServiceStub);   
        }

        $path = app_path('Services/' . $name . 'Service.php');

        File::ensureDirectoryExists(dirname($path));
        File::put($path, $ServiceStub);
    }
}