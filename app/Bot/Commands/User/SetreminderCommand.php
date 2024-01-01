<?php

namespace App\Bot\Commands\User;

use App\Bot\Handlers\CallsHandlerTrait;
use App\Bot\Handlers\ChecksExistingUserTrait;
use App\Bot\Handlers\NewUserHandler;
use App\Bot\Handlers\SetReminderHandler;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

/**
 * Start command
 */
class SetreminderCommand extends UserCommand
{
    use CallsHandlerTrait, ChecksExistingUserTrait;

    /**
     * @var string
     */
    protected $name = 'setreminder';

    /**
     * @var string
     */
    protected $description = 'Set reminder for logging data';

    /**
     * @var string
     */
    protected $usage = '/setreminder';

    /**
     * @var string
     */
    protected $version = '1.2.0';

    protected $need_mysql = true;

    protected $private_only = true;

    /**
     * Command execute method
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        if ($this->getExistingUser()) {
            return $this->handler(SetReminderHandler::class);
        }
        return $this->handler(NewUserHandler::class);
    }
}
