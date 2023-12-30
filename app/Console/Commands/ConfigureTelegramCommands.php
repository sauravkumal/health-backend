<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConfigureTelegramCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:configure-telegram-commands';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $option = $this->choice('Please select any option', [
            'List commands',
            'Register commands',
            'Remove commands'
        ]);

        match ($option) {
            'List commands' => $this->listCommands(),
            'Register commands' => $this->registerCommands(),
            'Remove commands' => $this->removeCommands()
        };

        return Command::SUCCESS;
    }
}
