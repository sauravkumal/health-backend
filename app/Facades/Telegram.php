<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Telegram extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return \Longman\TelegramBot\Telegram::class;
    }
}
