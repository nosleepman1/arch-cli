<?php

namespace Nosleepman\ArchCLI;

use Nosleepman\ArchCLI\Console\Commands\GenerateModuleCommand;
use Illuminate\Support\ServiceProvider;

class ServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->commands([
            GenerateModuleCommand::class,
        ]);
    }

    public function register(): void
    {
        //
    }
}