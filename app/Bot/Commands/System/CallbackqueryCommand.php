<?php

namespace App\Bot\Commands\System;

use App\Bot\Handlers\CallsHandlerTrait;
use Longman\TelegramBot\Entities\ServerResponse;

class CallbackqueryCommand extends \Longman\TelegramBot\Commands\SystemCommands\CallbackqueryCommand
{
    use CallsHandlerTrait;

    public function execute(): ServerResponse
    {
        $callbackQuery = $this->getCallbackQuery();
        $data = $callbackQuery->getData();

        $callbackQuery->answer();
        return $this->handler($this->constructHandlerClass($data));
    }
}
