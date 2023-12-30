<?php

namespace App\Console\Commands;

use App\Models\TelegramUser;
use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

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
        \Longman\TelegramBot\Commands\Command::
        TelegramUser::factory(10)->create();
        return Command::SUCCESS;
    }
}
