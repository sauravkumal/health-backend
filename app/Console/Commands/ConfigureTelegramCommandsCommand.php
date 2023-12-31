<?php

namespace App\Console\Commands;

use App\Facades\Telegram;
use Illuminate\Console\Command;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\BotCommand;
use Longman\TelegramBot\Entities\BotCommandScope\BotCommandScopeDefault;
use Longman\TelegramBot\Request;

class ConfigureTelegramCommandsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:config-telegram-commands';

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

    private function listCommands(): void
    {
        $commands = Request::getMyCommands([])->getResult();
        $this->info('List of available commands:');
        foreach ($commands as $command) {
            /* @var BotCommand $command */
            $this->info('/' . $command->getCommand() . ' - ' . $command->getDescription());
        }
    }

    private function registerCommands(): void
    {
        $localCommands = Telegram::getCommandsList();
        $userCommands = collect($localCommands)
            ->filter(fn($item) => $item instanceof UserCommand)
            ->map(function ($item) {
                /* @var UserCommand $item */
                return [
                    'command' => $item->getName(),
                    'description' => $item->getDescription()
                ];
            })->values();

        $response = Request::setMyCommands([
            'scope' => new BotCommandScopeDefault(),
            'commands' => $userCommands->all()
        ]);
        if ($response->isOk()) {
            $this->info('Commands registered');
        } else {
            $this->error('Failed to register commands');
        }
    }

    private function removeCommands(): void
    {
        $response = Request::deleteMyCommands([]);
        if ($response->isOk()) {
            $this->info('Commands deleted');
        } else {
            $this->error('Failed to delete commands');
        }
    }
}
