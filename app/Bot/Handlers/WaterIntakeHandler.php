<?php

namespace App\Bot\Handlers;

use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

class WaterIntakeHandler extends BaseHandler implements HandlerInterface
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
                    $this->replyText("🌟Enter today's water intake in litres🚀");
                }

                if (!is_numeric($text)) {
                    return $this->replyText("Your input is invalid. Please try again");
                }

                $this->setNote('amount', $text);

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
