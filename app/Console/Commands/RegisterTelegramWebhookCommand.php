<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Longman\TelegramBot\Request;

class RegisterTelegramWebhookCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:register-telegram-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Registers telegram webhook';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $webhookUrl = $this->ask('Enter telegram webhook url', env('APP_URL'));

        Request::sendMessage();
        return Command::SUCCESS;
    }
}
