<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class MigrationGenerator
{
    public function generate($name, $fields)
    {
        $table = strtolower($name) . 's'; // assuming plural

        $migrationName = 'create_' . $table . '_table';

        // Use Artisan to create the migration
        Artisan::call('make:migration', [
            'name' => $migrationName,
            '--create' => $table,
        ]);

        // Now, find the created migration file and modify it
        $migrationFiles = File::files(database_path('migrations'));
        $latestMigration = collect($migrationFiles)->sort()->last();

        if ($latestMigration) {
            $content = File::get($latestMigration);
            $columns = $this->generateColumns($fields);
            // Insert columns before the closing brace
            $content = str_replace('        });', $columns . "\n        });", $content);
            File::put($latestMigration, $content);
        }
    }

    private function generateColumns($fields)
    {
        $fieldList = explode(',', $fields);
        $columns = '';

        foreach ($fieldList as $field) {
            $parts = explode(':', trim($field));
            $fieldName = $parts[0];
            $type = $parts[1] ?? 'string';
            $modifiers = array_slice($parts, 2);

            $columns .= "            \$table->{$type}('{$fieldName}')";

            foreach ($modifiers as $mod) {
                if ($mod === 'unique') {
                    $columns .= '->unique()';
                } elseif ($mod === 'nullable') {
                    $columns .= '->nullable()';
                }
            }

            $columns .= ";\n";
        }

        return $columns;
    }
}