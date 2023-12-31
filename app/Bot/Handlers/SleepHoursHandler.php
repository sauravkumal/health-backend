<?php

namespace App\Bot\Handlers;

use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

class SleepHoursHandler extends BaseHandler implements HandlerInterface
{

    /**
     * @throws TelegramException
     */
    public function handle(): ServerResponse
    {
        $text = $this->messageText();

        $this->initConversation();

        switch ($this->conversationState) {
            case 0:
                $this->setState(1);
                $text = '';
            case 1:
                if (!$text) {
                    $this->setState(1);
                    $this->replyText("🌟Enter today's sleep duration in hours🚀");
                }

                if (!is_numeric($text)) {
                    return $this->replyText("Your input is invalid. Please try again");
                }

                $this->setNote('duration', $text);

            case 2:
                //todo record input
                $message = "Your input has been recorded successfully!";

                $this->stopConversation();

                return $this->replyText($message);

            default:
                throw new \Exception('Unexpected conversation state');
        }
    }
}
