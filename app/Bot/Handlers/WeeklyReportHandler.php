<?php

namespace App\Bot\Handlers;

use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

class WeeklyReportHandler extends BaseHandler implements HandlerInterface
{

    /**
     * @throws TelegramException
     */
    public function handle(): ServerResponse
    {
        $message = "<b>Here is your weekly health report</b>\n\n" .
            "Average water intake: <strong>2 litres</strong>\n" .
            "Average sleep hour: <strong>5 hours</strong>\n" .
            "Average exercise duration: <strong>6 hours</strong>\n";

        return $this->replyText($message);
    }
}
