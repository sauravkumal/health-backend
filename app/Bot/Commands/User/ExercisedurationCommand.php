<?php

namespace App\Bot\Commands\User;

use App\Bot\Handlers\CallsHandlerTrait;
use App\Bot\Handlers\ChecksExistingUserTrait;
use App\Bot\Handlers\ExerciseDurationHandler;
use App\Bot\Handlers\NewUserHandler;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

/**
 * Start command
 */
class ExercisedurationCommand extends UserCommand
{
    use CallsHandlerTrait, ChecksExistingUserTrait;

    /**
     * @var string
     */
    protected $name = 'exerciseduration';

    /**
     * @var string
     */
    protected $description = 'Add daily exercise duration';

    /**
     * @var string
     */
    protected $usage = '/exerciseduration';

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
            return $this->handler(ExerciseDurationHandler::class);
        }
        return $this->handler(NewUserHandler::class);
    }
}
