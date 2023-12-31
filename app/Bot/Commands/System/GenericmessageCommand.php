<?php

namespace App\Bot\Commands\System;

use App\Bot\Handlers\CallsHandlerTrait;
use App\Bot\Handlers\ChecksExistingUserTrait;
use App\Bot\Handlers\ExistingUserHandler;
use App\Bot\Handlers\NewUserHandler;
use Longman\TelegramBot\Entities\ServerResponse;

class GenericmessageCommand extends \Longman\TelegramBot\Commands\SystemCommands\GenericmessageCommand
{
    use CallsHandlerTrait, ChecksExistingUserTrait;

    public function execute(): ServerResponse
    {
        if ($this->getExistingUser()) {
            return $this->handler(ExistingUserHandler::class);
        }
        return $this->handler(NewUserHandler::class);
    }

}
