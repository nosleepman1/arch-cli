<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

class RequestGenerator
{
    private $fields;

    public function generate($name, $fields = '')
    {
        $this->fields = $fields;
        $this->generateStoreRequest($name);
        $this->generateUpdateRequest($name);
    }

    private function generateStoreRequest($name)
    {
        \Artisan::call('make:request', [
            'name' => $name . '/Store' . $name . 'Request',
        ]);

        // Modify the file to add validation rules
        $path = app_path('Http/Requests/' . $name . '/Store' . $name . 'Request.php');
        $this->addValidationRules($path, $this->fields);
    }

    private function generateUpdateRequest($name)
    {
        \Artisan::call('make:request', [
            'name' => $name . '/Update' . $name . 'Request',
        ]);

        // Modify the file to add validation rules
        $path = app_path('Http/Requests/' . $name . '/Update' . $name . 'Request.php');
        $this->addValidationRules($path, $this->fields);
    }

    private function addValidationRules($path, $fields)
    {
        $content = \File::get($path);
        $rules = $this->generateRules($fields);

        // Replace the empty rules array
        $content = str_replace(
            "    public function rules()\n    {\n        return [\n            // Add validation rules here\n        ];\n    }",
            "    public function rules()\n    {\n        return [\n" . $rules . "        ];\n    }",
            $content
        );

        \File::put($path, $content);
    }

    private function generateRules($fields)
    {
        $fieldList = explode(',', $fields);
        $rules = '';

        foreach ($fieldList as $field) {
            $parts = explode(':', trim($field));
            $fieldName = $parts[0];
            $type = $parts[1] ?? 'string';
            $modifiers = array_slice($parts, 2);

            $rule = "            '{$fieldName}' => 'required";

            if ($type === 'string') {
                $rule .= "|string|max:255";
            } elseif ($type === 'integer') {
                $rule .= "|integer";
            } elseif ($type === 'email') {
                $rule .= "|email";
            } elseif ($type === 'boolean') {
                $rule .= "|boolean";
            }

            foreach ($modifiers as $mod) {
                if ($mod === 'unique') {
                    $rule .= "|unique:{$fieldName}s"; // Assuming table name
                }
            }

            $rule .= "',\n";
            $rules .= $rule;
        }

        return $rules;
    }

   
}