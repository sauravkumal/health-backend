<?php

namespace App\Bot\Handlers;

use App\Models\TelegramUser;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

class SetReminderHandler extends BaseHandler implements HandlerInterface
{

    /**
     * @throws TelegramException
     */
    public function handle(): ServerResponse
    {
        $text = $this->messageText();

        $this->initConversation('setreminder');

        switch ($this->conversationState) {
            case 0:
                $this->setState(1);
                $text = '';
            case 1:
                if (!$text) {
                    $this->setState(1);
                    return $this->replyText("💧When would you like us to remind you? (h:i am/pm)");
                }

                try {
                    Carbon::parse($text);
                } catch (InvalidFormatException $exception) {
                    return $this->replyText("😢Your input is invalid. Please try again");

                }


                $this->setNote('reminder', $text);

            case 2:

                TelegramUser::query()
                    ->where('telegram_id', $this->from()->getId())
                    ->update([
                        'reminder' => Carbon::parse($this->getNote('reminder'))->format('H:i:s'),
                    ]);

                $message = "Your reminder has been set successfully😀";

                $this->stopConversation();

                return $this->replyText($message);

            default:
                throw new \Exception('Unexpected conversation state');
        }
    }
}
