<?php

namespace Nosleepman\ArchCLI\Console\Commands;

use Illuminate\Console\Command;
use Nosleepman\ArchCLI\Generators\ModelGenerator;
use Nosleepman\ArchCLI\Generators\MigrationGenerator;
use Nosleepman\ArchCLI\Generators\ServiceGenerator;
use Nosleepman\ArchCLI\Generators\ControllerGenerator;
use Nosleepman\ArchCLI\Generators\RequestGenerator;
use Nosleepman\ArchCLI\Generators\PolicyGenerator;
use Nosleepman\ArchCLI\Generators\EventGenerator;
use Nosleepman\ArchCLI\Generators\ListenerGenerator;
use Nosleepman\ArchCLI\Generators\NotificationGenerator;
use Nosleepman\ArchCLI\Generators\ResourceGenerator;

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
        $fields = $this->askForFields();
        $version = $this->choice('Controller version', ['v1', 'v2', 'v3'], 'v1');
        $withPolicies = $this->confirm('Include policies?', true);
        $withEvents = $this->confirm('Include events?', false);

        // Always include service, requests, resources
        $withService = true;
        $withRequests = true;
        $withResources = true;
        $withListeners = $withEvents; 
        $withNotifications = $withEvents; 
        $withTests = false; 

        // Generate components
        $this->generateModel($modelName, $fields);
        $this->generateMigration($modelName, $fields);
        $this->generateService($modelName, $withEvents);
        $this->generateController($modelName, $version, $withService);
        $this->generateRequests($modelName, $fields);
        if ($withPolicies) {
            $this->generatePolicy($modelName);
        }
        if ($withEvents) {
            $this->generateEvent($modelName);
        }
        if ($withListeners) {
            $this->generateListener($modelName);
        }
        if ($withNotifications) {
            $this->generateNotification($modelName);
        }
        if ($withResources) {
            $this->generateResource($modelName, $fields);
        }

        $this->info('Module generated successfully!');
    }

    private function askForFields()
    {
        $fields = [];
        $this->info('Enter fields (name:type, press Enter for each field, empty line to finish):');
        
        while (true) {
            $field = $this->ask('Field (or empty to finish)');
            if (empty($field)) {
                break;
            }
            $fields[] = $field;
        }
        
        return implode(',', $fields);
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

    private function generateService($name, $withEvents = false)
    {
        $generator = new ServiceGenerator();
        $generator->generate($name, $withEvents);
    }

    private function generateController($name, $version, $withService)
    {
        $generator = new ControllerGenerator();
        $generator->generate($name, $version, $withService);
    }

    private function generateRequests($name, $fields = '')
    {
        $generator = new RequestGenerator();
        $generator->generate($name, $fields);
    }

    private function generatePolicy($name)
    {
        $generator = new PolicyGenerator();
        $generator->generate($name);
    }

    private function generateEvent($name)
    {
        $generator = new EventGenerator();
        $generator->generate($name);
    }

    private function generateListener($name)
    {
        $generator = new ListenerGenerator();
        $generator->generate($name);
    }

    private function generateNotification($name)
    {
        $generator = new NotificationGenerator();
        $generator->generate($name);
    }

    private function generateResource($name, $fields = '')
    {
        $generator = new ResourceGenerator();
        $generator->generate($name, $fields);
    }
}