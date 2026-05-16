<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

class ResourceGenerator
{
    public function generate($name, $fields = '')
    {
        $stub = File::get(__DIR__ . '/../Stubs/Resource.stub');

        $stub = str_replace('{{class}}', $name, $stub);
        $fields_array = $this->parseFields($fields);
        $fieldsStr = $this->formatFields($fields_array);
        $stub = str_replace('{{fields}}', $fieldsStr, $stub);

        $path = app_path('Http/Resources/' . $name . 'Resource.php');

        File::ensureDirectoryExists(dirname($path));

        File::put($path, $stub);
    }

    private function parseFields($fields)
    {
        if (empty($fields)) {
            return [];
        }
        $fieldList = explode(',', $fields);
        $result = [];
        foreach ($fieldList as $field) {
            $parts = explode(':', trim($field));
            $result[] = $parts[0];
        }
        return $result;
    }

    private function formatFields($fields)
    {
        if (empty($fields)) {
            return "'id' => \$this->id,";
        }
        $result = "'id' => \$this->id,\n";
        foreach ($fields as $field) {
            $result .= "            '{$field}' => \$this->{$field},\n";
        }
        return rtrim($result, ",\n");
    }
}