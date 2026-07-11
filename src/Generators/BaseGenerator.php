<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

abstract class BaseGenerator
{
    /**
     * Get the stub content.
     * Checks if a published stub exists in the application's stubs folder,
     * otherwise falls back to the package's internal stub.
     *
     * @param string $stub
     * @return string
     */
    protected function getStubContent(string $stub): string
    {
        $publishedPath = function_exists('base_path') ? base_path('stubs/vendor/arch-cli/' . $stub) : '';

        if (!empty($publishedPath) && File::exists($publishedPath)) {
            return File::get($publishedPath);
        }

        return File::get(__DIR__ . '/../Stubs/' . $stub);
    }
}
