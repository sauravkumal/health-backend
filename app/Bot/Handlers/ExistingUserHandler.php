<?php

namespace App\Bot\Handlers;

use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

class ExistingUserHandler extends BaseHandler implements HandlerInterface
{

    /**
     * @throws TelegramException
     */
    public function handle(): ServerResponse
    {
        $keyboard = new InlineKeyboard([]);
        $keyboard->addRow(new InlineKeyboardButton([
            'text' => 'Add Water Intake',
            'callback_data' => $this->scoped('1', WaterIntakeHandler::class)]));
        $keyboard->addRow(new InlineKeyboardButton([
            'text' => 'Add Exercise Duration',
            'callback_data' => $this->scoped('2', ExerciseDurationHandler::class)]));

        $keyboard->addRow(new InlineKeyboardButton([
            'text' => 'Add Sleep Hours',
            'callback_data' => $this->scoped('3', SleepHoursHandler::class)]));

        return $this->reply([
            'text' => 'Choose any of the available options to record your data',
            'reply_markup' => $keyboard]);
    }
}
