<?php

namespace Nosleepman\ArchCLI\Console\Commands;

use Illuminate\Console\Command;
use Nosleepman\ArchCLI\Generators\ModelGenerator;
use Nosleepman\ArchCLI\Generators\MigrationGenerator;
use Nosleepman\ArchCLI\Generators\ServiceGenerator;
use Nosleepman\ArchCLI\Generators\ControllerGenerator;
use Nosleepman\ArchCLI\Generators\RequestGenerator;
use Nosleepman\ArchCLI\Generators\PolicyGenerator;

class GenerateModuleCommand extends Command
{
    protected $signature = 'arch:module {name} {--full}';

    protected $description = 'Generate a complete backend module for Laravel';

    public function handle()
    {
        $name = $this->argument('name');
        $full = $this->option('full');

        // Interactive prompts
        $modelName = $this->ask('Model name', $name);
        $fields = $this->ask('Fields (e.g., name:string, email:string:unique)', 'name:string');
        $version = $this->choice('Controller version', ['v1', 'v2', 'v3'], 'v1');
        $withService = $this->confirm('Include service layer?', true);
        $withRepository = $this->confirm('Include repository?', false);
        $withRequests = $this->confirm('Include requests?', true);
        $withPolicies = $this->confirm('Include policies?', true);
        $withResources = $this->confirm('Include resources?', false);
        $withEvents = $this->confirm('Include events?', false);
        $withListeners = $this->confirm('Include listeners?', false);
        $withNotifications = $this->confirm('Include notifications?', false);
        $withTests = $this->confirm('Include tests?', false);

        // For Phase 1, generate basic components
        $this->generateModel($modelName, $fields);
        $this->generateMigration($modelName, $fields);
        if ($withService) {
            $this->generateService($modelName);
        }
        $this->generateController($modelName, $version, $withService);
        if ($withRequests) {
            $this->generateRequests($modelName);
        }
        if ($withPolicies) {
            $this->generatePolicy($modelName);
        }

        $this->info('Module generated successfully!');
    }

    private function generateModel($name, $fields)
    {
        $generator = new ModelGenerator();
        $generator->generate($name, $fields);
    }

    private function generateMigration($name, $fields)
    {
        $generator = new MigrationGenerator();
        $generator->generate($name, $fields);
    }

    private function generateService($name)
    {
        $generator = new ServiceGenerator();
        $generator->generate($name);
    }

    private function generateController($name, $version, $withService)
    {
        $generator = new ControllerGenerator();
        $generator->generate($name, $version, $withService);
    }

    private function generateRequests($name)
    {
        $generator = new RequestGenerator();
        $generator->generate($name);
    }

    private function generatePolicy($name)
    {
        $generator = new PolicyGenerator();
        $generator->generate($name);
    }
}