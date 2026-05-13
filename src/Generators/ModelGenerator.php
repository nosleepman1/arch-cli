<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

class ModelGenerator
{
    public function generate($name, $fields)
    {
        // Use Laravel's make:model
        \Artisan::call('make:model', ['name' => $name]);

        // Then modify the file to add fillable
        $path = app_path('Models/' . $name . '.php');
        $content = \File::get($path);
        $fillable = $this->parseFields($fields);
        $fillableStr = $this->formatFillable($fillable);

        // Add fillable after use HasFactory;
        $content = str_replace(
            'use HasFactory;' . PHP_EOL . PHP_EOL . '    ',
            'use HasFactory;' . PHP_EOL . PHP_EOL . '    protected $fillable = [' . $fillableStr . '];' . PHP_EOL . PHP_EOL . '    ',
            $content
        );

        \File::put($path, $content);
    }

    private function parseFields($fields)
    {
        $fieldList = explode(',', $fields);
        $fillable = [];

        foreach ($fieldList as $field) {
            $parts = explode(':', trim($field));
            $fillable[] = $parts[0];
        }

        return $fillable;
    }

    private function formatFillable($fillable)
    {
        return "'" . implode("', '", $fillable) . "'";
    }
}