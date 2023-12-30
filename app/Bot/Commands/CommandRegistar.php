<?php

namespace App\Bot\Commands;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CommandRegistar
{
    private static Collection $commands;

    public static function all(): Collection
    {
        if (self::$commands->isEmpty()) {
            self::loadCommands();
        }
        return self::$commands;
    }

    private static function loadCommands(): void
    {
        $functionsDirectory = app_path('Bot/Commands');
        self::$commands = collect(File::files($functionsDirectory))
            ->filter(function ($item) {
                return !Str::contains($item->getFileName(), ['CommandRegistar', 'CommandInterface']);
            })->map(function ($item) {
                $fileName = $item->getFilenameWithoutExtension();
                /* @var CommandInterface $class */
                $class = 'App\\Bot\\Commands\\' . Str::studly($fileName);
                return new $class();
            });
    }
}
