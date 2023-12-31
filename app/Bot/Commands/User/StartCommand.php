<?php

namespace App\Bot\Commands\User;

use App\Bot\Handlers\CallsHandlerTrait;
use App\Bot\Handlers\ExistingUserHandler;
use App\Bot\Handlers\NewUserHandler;
use App\Models\TelegramUser;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

/**
 * Start command
 */
class StartCommand extends UserCommand
{
    use CallsHandlerTrait;

    /**
     * @var string
     */
    protected $name = 'start';

    /**
     * @var string
     */
    protected $description = 'Start bot';

    /**
     * @var string
     */
    protected $usage = '/start';

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
        $message = $this->getMessage();
        $from = $message->getFrom();

        $user = TelegramUser::query()
            ->where('telegram_id', $from->getId())
            ->first();

        if ($user) {
            return $this->handler(ExistingUserHandler::class);
        }
        return $this->handler(NewUserHandler::class);
    }
}
