<?php

namespace App\Bot\Commands\System;

use App\Bot\Handlers\CallsHandlerTrait;
use App\Bot\Handlers\ChecksExistingUserTrait;
use App\Bot\Handlers\ExistingUserHandler;
use App\Bot\Handlers\NewUserHandler;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\ServerResponse;

class GenericmessageCommand extends \Longman\TelegramBot\Commands\SystemCommands\GenericmessageCommand
{
    use CallsHandlerTrait, ChecksExistingUserTrait;

    public function execute(): ServerResponse
    {
        if ($this->getExistingUser()) {

            $conversation = new Conversation(
                $this->getMessage()->getFrom()->getId(),
                $this->getMessage()->getChat()->getId()
            );

            if ($conversation->exists() && ($command = $conversation->getCommand())) {
                return $this->telegram->executeCommand($command);
            }

            return $this->handler(ExistingUserHandler::class);
        }
        return $this->handler(NewUserHandler::class);
    }

}
