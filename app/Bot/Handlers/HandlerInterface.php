<?php

namespace App\Bot\Handlers;

use Longman\TelegramBot\Entities\ServerResponse;

interface HandlerInterface
{
    public function handle(): ServerResponse;
}
