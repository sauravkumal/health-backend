<?php

namespace App\Console\Commands;

use App\Models\Record;
use App\Models\TelegramUser;
use Illuminate\Console\Command;

class TestCommand extends Command
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
        /* @var \App\Models\TelegramUser $user */
        $user = TelegramUser::first();

        $user->records()
            ->saveMany(Record::factory(5)
                ->sequence(
                    ['date' => '2024-01-01'],
                    ['date' => '2024-01-02'],
                    ['date' => '2024-01-03'],
                    ['date' => '2024-01-04'],
                    ['date' => '2024-01-05'])->make());
        return Command::SUCCESS;
    }
}
