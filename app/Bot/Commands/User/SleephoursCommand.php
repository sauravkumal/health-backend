<?php

namespace App\Bot\Commands\User;

use App\Bot\Handlers\CallsHandlerTrait;
use App\Bot\Handlers\ChecksExistingUserTrait;
use App\Bot\Handlers\ExistingUserHandler;
use App\Bot\Handlers\NewUserHandler;
use App\Bot\Handlers\SleepHoursHandler;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

/**
 * Start command
 */
class SleephoursCommand extends UserCommand
{
    use CallsHandlerTrait, ChecksExistingUserTrait;

    /**
     * @var string
     */
    protected $name = 'sleephours';

    /**
     * @var string
     */
    protected $description = 'Add daily sleep hours';

    /**
     * @var string
     */
    protected $usage = '/sleephours';

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
            return $this->handler(SleepHoursHandler::class);
        }
        return $this->handler(NewUserHandler::class);
    }
}
