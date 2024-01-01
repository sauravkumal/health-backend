<?php

namespace App\Bot\Handlers;

use App\Models\TelegramUser;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
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

        $this->initConversation('start');

        switch ($this->conversationState) {
            case 0:
                $this->setState(1);
                $text = '';
            case 1:
                if (!$text) {
                    $this->setState(1);
                    $this->replyText("🌟Welcome to our Health Tracker Bot! Log your daily water 🥛,sleep hours 😴, and exercise duration 🏃‍♂️. Get weekly updates to keep you on track! Please tell us a bit about yourself.🚀");
                    return $this->replyText("👤Enter your name");
                }
                $this->setNote('name', $text);
                $text = '';

            case 2:
                if (!$text) {
                    $this->setState(2);
                    return $this->replyText('🗓Enter your date of birth (yyyy-mm-dd)');
                }
                try {
                    Carbon::parse($text);
                } catch (InvalidFormatException $exception) {
                    return $this->replyText('😢The date you entered is invalid. Please try again');
                }

                $this->setNote('dob', $text);
                $text = '';

            case 3:
                if (!$text) {
                    $this->setState(3);
                    return $this->reply([
                        'text' => '👫Choose your gender',
                        'reply_markup' => new InlineKeyboard([
                            new InlineKeyboardButton(['text' => '👨‍🦰Male', 'callback_data' => $this->scoped('male')]),
                            new InlineKeyboardButton(['text' => '👩Female', 'callback_data' => $this->scoped('female')]),
                            new InlineKeyboardButton(['text' => '👩‍🦲Others', 'callback_data' => $this->scoped('others')])
                        ])]);
                }

                if (!Str::contains($text, ['male', 'female', 'others'], true)) {
                    return $this->replyText('😢Your input is invalid. Please select either one among male, female and others');
                }

                $this->setNote('gender', $text);

            case 4:
                $age = Carbon::parse($this->getNote('dob'))->diffInYears();
                $gender = ucfirst($this->getNote('gender'));
                $message =
                    "🎉🎉🎉Congratulations!🔥🔥🔥 \n" .
                    "You have successfully registered in our Health Tracker Program.\n" .
                    "Here is a summary of your personal info:\n\n" .
                    "👤Name: {$this->getNote('name')}\n" .
                    "🗓Age: $age years old (dob: {$this->getNote('dob')})\n" .
                    "👫Gender: $gender";

                $from = $this->from();

                TelegramUser::query()
                    ->create([
                        'telegram_id' => $from->getId(),
                        'first_name' => $from->getFirstName(),
                        'last_name' => $from->getLastName(),
                        'display_name' => $this->getNote('name'),
                        'username' => $from->getUsername(),
                        'dob' => Carbon::parse($this->getNote('dob')),
                        'gender' => $this->getNote('gender'),
                    ]);

                $this->stopConversation();

                $this->replyText($message);

                $keyboard = new InlineKeyboard([]);
                $keyboard->addRow(new InlineKeyboardButton([
                    'text' => '💧Add Water Intake',
                    'callback_data' => $this->scoped('waterintake', WaterIntakeHandler::class)]));
                $keyboard->addRow(new InlineKeyboardButton([
                    'text' => '🏃‍♂️Add Exercise Duration',
                    'callback_data' => $this->scoped('exerciseduration', ExerciseDurationHandler::class)]));

                $keyboard->addRow(new InlineKeyboardButton([
                    'text' => '😴Add Sleep Hours',
                    'callback_data' => $this->scoped('sleephours', SleepHoursHandler::class)]));

                $keyboard->addRow(new InlineKeyboardButton([
                    'text' => '⏰Add Reminder',
                    'callback_data' => $this->scoped('setreminder', SetReminderHandler::class)]));

                return $this->reply([
                    'text' => '👉👉Choose any of the available options to record your data👈👈',
                    'reply_markup' => $keyboard]);

            default:
                throw new \Exception('Unexpected conversation state');
        }
    }
}
