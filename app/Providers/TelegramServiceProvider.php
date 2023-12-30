<?php

namespace App\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;

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
     * @throws BindingResolutionException
     */
    public function boot()
    {
        Request::initialize($this->app->make(Telegram::class));
    }
}
