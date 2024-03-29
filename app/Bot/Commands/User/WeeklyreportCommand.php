<?php

namespace App\Bot\Commands\User;

use App\Bot\Handlers\CallsHandlerTrait;
use App\Bot\Handlers\ChecksExistingUserTrait;
use App\Bot\Handlers\NewUserHandler;
use App\Bot\Handlers\WeeklyReportHandler;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

/**
 * Start command
 */
class WeeklyreportCommand extends UserCommand
{
    use CallsHandlerTrait, ChecksExistingUserTrait;

    /**
     * @var string
     */
    protected $name = 'weeklyreport';

    /**
     * @var string
     */
    protected $description = 'Show weekly health report';

    /**
     * @var string
     */
    protected $usage = '/weeklyreport';

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
            return $this->handler(WeeklyReportHandler::class);
        }
        return $this->handler(NewUserHandler::class);
    }
}
