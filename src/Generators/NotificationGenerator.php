<?php

namespace Nosleepman\ArchCLI\Generators;

use Illuminate\Support\Facades\File;

class NotificationGenerator
{
    public function generate($name)
    {
        $stub = File::get(__DIR__ . '/../Stubs/Notification.stub');

        $stub = str_replace('{{class}}', $name, $stub);

        $path = app_path('Notifications/' . $name . 'CreatedNotification.php');

        File::ensureDirectoryExists(dirname($path));

        File::put($path, $stub);
    }
}