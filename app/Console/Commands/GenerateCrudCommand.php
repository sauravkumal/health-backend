<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

class GenerateCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates model crud';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $modelName = $this->argument('model');
        Artisan::call("make:model {$modelName} -m -s -c -f --api -r --policy");
        Artisan::call("make:resource {$modelName}Resource");
        return Command::SUCCESS;
    }
}
