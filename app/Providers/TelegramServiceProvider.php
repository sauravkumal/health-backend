<?php

namespace App\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\TelegramLog;

class TelegramServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Telegram::class, function (Application $app) {
            return new Telegram(config('telegram.token'), config('telegram.username'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /* @var Telegram $telegram */
        $telegram = app()->get(Telegram::class);

        $telegram->enableMySql(config('telegram.db'));

        if (config('telegram.admins')) {
            $telegram->enableAdmins(config('telegram.admins'));
        }

        Request::initialize($telegram);

        $this->registerCommands($telegram);

        $this->configureLog();
    }

    private function registerCommands(Telegram $telegram): void
    {
        $telegram->addCommandsPath(app_path('Bot/Commands/User'));
    }

    private function configureLog(): void
    {
        TelegramLog::$always_log_request_and_response = true;
        TelegramLog::initialize(Log::getLogger(), Log::getLogger());
    }
}
