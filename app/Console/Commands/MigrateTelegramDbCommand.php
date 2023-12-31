<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateTelegramDbCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:migrate-telegram-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate telegram database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = base_path('vendor/longman/telegram-bot/structure.sql');
        $sql = file_get_contents($path);
        $resp = DB::unprepared($sql);
        if ($resp) {
            $this->info('Database migrated successfully');
        } else {
            $this->error('Failed to migrate database');
        }
        return Command::SUCCESS;
    }
}
