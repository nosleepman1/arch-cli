<?php

namespace Nosleepman\ArchCLI;

use Nosleepman\ArchCLI\Console\Commands\GenerateModuleCommand;
use Illuminate\Support\ServiceProvider;

class ArchCLIServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->commands([
            GenerateModuleCommand::class,
        ]);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/Stubs' => base_path('stubs/vendor/arch-cli'),
            ], 'arch-cli-stubs');
        }
    }

    public function register(): void
    {
        
    }
}