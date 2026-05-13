<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

class RequestGenerator
{
    public function generate($name)
    {
        $this->generateStoreRequest($name);
        $this->generateUpdateRequest($name);
    }

    private function generateStoreRequest($name)
    {
        \Artisan::call('make:request', [
            'name' => $name . '/Store' . $name . 'Request',
        ]);
    }

    private function generateUpdateRequest($name)
    {
        \Artisan::call('make:request', [
            'name' => $name . '/Update' . $name . 'Request',
        ]);
    }
}