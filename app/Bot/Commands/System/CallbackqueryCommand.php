<?php

namespace App\Bot\Commands\System;

use App\Bot\Handlers\CallsHandlerTrait;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;

class CallbackqueryCommand extends SystemCommand
{
    use CallsHandlerTrait;

    public function execute(): ServerResponse
    {
        $callbackQuery = $this->getCallbackQuery();
        $data = $callbackQuery->getData();
    }
}
