<?php

namespace App\Bot\Handlers;

use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

class NewUserHandler extends BaseHandler implements HandlerInterface
{
    /**
     * @throws TelegramException
     * @throws \Exception
     */
    public function handle(): ServerResponse
    {
        $text = $this->messageText();
        $this->initConversation();

        switch ($this->conversationState) {
            case 0:
                if (!$text) {
                    $this->setState(0);
                    $this->replyText("🌟Welcome to our Health Tracker Bot! Log your daily water ,sleep hours 😴, and exercise duration. Get weekly updates to keep you on track! Please tell us a bit about yourself.🚀");
                    return $this->replyText("Please enter your name:");
                }
                $this->setNote('name', $text);
                $text = '';

            case 1:
                if (!$text) {
                    $this->setState(1);
                    return $this->replyText('🗓🗓🗓🗓🗓📅📅📅📅Enter your date of birth (yyyy-mm-dd):');
                }
                try {
                    Carbon::parse($text);
                } catch (InvalidFormatException $exception) {
                    return $this->replyText('The date you entered is invalid. Please try again:');
                }

                $this->setNote('dob', $text);
                $text = '';

            case 3:
                if (!$text) {
                    $this->setState(3);
                    return $this->replyText('Choose your gender:');
                }

                if (!Str::contains($text, ['male', 'female', 'others'], true)) {
                    return $this->replyText('Your input is invalid. Please select either one among male, female and others:');
                }

                $this->setNote('gender', $text);

            case 4:
                $age = Carbon::parse($this->getNote('dob'))->diffInYears();
                $message =
                    "Congratulations! You have successfully registered in our Health Tracker Program.\n" .
                    "Here are the summary of your personal info:\n\n" .
                    "Name: {$this->getNote('name')}\n" .
                    "Age: {$age} years old, DOB: {$this->getNote('dob')}\n" .
                    "Gender: {$this->getNote('gender')}";

                return $this->replyText($message);


            default:
                throw new \Exception('Unexpected conversation state');
        }
    }
}
