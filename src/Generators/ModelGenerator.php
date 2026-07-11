<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

class ModelGenerator
{
    public function generate($name, $fields)
    {
        
        \Artisan::call('make:model', ['name' => $name]);

        
        $path = app_path('Models/' . $name . '.php');
        if (!\File::exists($path)) {
            $path = app_path($name . '.php');
        }

        $content = \File::get($path);
        $fillable = $this->parseFields($fields);
        $fillableStr = $this->formatFillable($fillable);

        // Resiliently inject fillable fields inside the Model class body.
        if (str_contains($content, 'use HasFactory;')) {
            $content = str_replace(
                'use HasFactory;',
                'use HasFactory;' . PHP_EOL . PHP_EOL . '    protected $fillable = [' . $fillableStr . '];',
                $content
            );
        } else {
            $pattern = '/(class\s+' . preg_quote($name, '/') . '\s+extends\s+Model[^{]*\{)/i';
            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, "$1\n    protected \$fillable = [" . $fillableStr . "];\n", $content);
            }
        }

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