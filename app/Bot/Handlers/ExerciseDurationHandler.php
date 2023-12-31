<?php

namespace App\Bot\Handlers;

use App\Models\Record;
use App\Models\TelegramUser;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

class ExerciseDurationHandler extends BaseHandler implements HandlerInterface
{

    /**
     * @throws TelegramException
     */
    public function handle(): ServerResponse
    {
        $text = $this->messageText();

        $this->initConversation('exerciseduration');

        switch ($this->conversationState) {
            case 0:
                $this->setState(1);
                $text = '';
            case 1:
                if (!$text) {
                    $this->setState(1);
                    return $this->replyText("🌟Enter today's exercise duration in hours🚀");
                }

                if (!is_numeric($text)) {
                    return $this->replyText("Your input is invalid. Please try again");
                }

                $this->setNote('duration', $text);

            case 2:
                $user = TelegramUser::query()
                    ->where('telegram_id', $this->from()->getId())
                    ->first();

                Record::query()
                    ->updateOrCreate([
                        'telegram_user_id' => $user->id,
                        'date' => now()->format('Y-m-d')
                    ], [
                        'telegram_user_id' => $user->id,
                        'date' => now()->format('Y-m-d'),
                        'exercise_duration' => $text
                    ]);

                $message = "Your input has been recorded successfully!";

                $this->stopConversation();

                return $this->replyText($message);

            default:
                throw new \Exception('Unexpected conversation state');
        }
    }
}
