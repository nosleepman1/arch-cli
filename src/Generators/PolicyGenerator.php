<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

class PolicyGenerator
{
    public function generate($name)
    {
        \Artisan::call('make:policy', [
            'name' => $name . 'Policy',
            '--model' => $name,
        ]);
    }
}