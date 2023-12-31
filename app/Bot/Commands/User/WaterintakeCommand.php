<?php

namespace App\Bot\Commands\User;

use App\Bot\Handlers\CallsHandlerTrait;
use App\Bot\Handlers\ChecksExistingUserTrait;
use App\Bot\Handlers\NewUserHandler;
use App\Bot\Handlers\WaterIntakeHandler;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

/**
 * Start command
 */
class WaterintakeCommand extends UserCommand
{
    use CallsHandlerTrait, ChecksExistingUserTrait;

    /**
     * @var string
     */
    protected $name = 'waterintake';

    /**
     * @var string
     */
    protected $description = 'Add daily water intake';

    /**
     * @var string
     */
    protected $usage = '/waterintake';

    /**
     * @var string
     */
    protected $version = '1.2.0';

    protected $need_mysql = true;

    protected $private_only = true;

    protected $conversation;

    protected $notes;

    protected $state;

    /**
     * Command execute method
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        error_log('water intake execute');
        if ($this->getExistingUser()) {
            return $this->handler(WaterIntakeHandler::class);
        }
        return $this->handler(NewUserHandler::class);
    }
}
