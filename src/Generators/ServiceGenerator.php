<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

class ServiceGenerator extends BaseGenerator
{
    public function generate(string $name, bool $withEvents = false, bool $withRepositories = false): void
    {
        $stubFile = $withRepositories ? 'ServiceWithRepository.stub' : 'Service.stub';

        $ServiceStub = $this->getStubContent($stubFile);
        

        $ServiceStub = str_replace('{{class}}', $name, $ServiceStub);
        $ServiceStub = str_replace('{{model}}', $name, $ServiceStub);
        $ServiceStub = str_replace('{{pluralClass}}', \Illuminate\Support\Str::plural($name), $ServiceStub);

        if ($withEvents) {
           $ServiceStub = str_replace('{{use_events}}', 'use App\Events\\' . $name . 'Created;', $ServiceStub);
           $ServiceStub = str_replace('{{add_event}}', 'event(new ' . $name . 'Created($model));', $ServiceStub);
        } else {
           $ServiceStub = str_replace('{{add_event}}', '', $ServiceStub);
           $ServiceStub = str_replace('{{use_events}}', '', $ServiceStub);   
        }

        $path = app_path('Services/' . $name . 'Service.php');

        File::ensureDirectoryExists(dirname($path));
        File::put($path, $ServiceStub);
    }
}