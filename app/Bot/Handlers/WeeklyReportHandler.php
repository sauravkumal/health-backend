<?php

namespace App\Bot\Handlers;

use App\Models\Record;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

class WeeklyReportHandler extends BaseHandler implements HandlerInterface
{

    /**
     * @throws TelegramException
     */
    public function handle(): ServerResponse
    {
        $records = Record::query()
            ->whereHas('user', function ($q) {
                $q->where('telegram_id', $this->from()->getId());
            })
            ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
            ->get();

        $avgWaterIntake = round($records->average('water_intake'), 2);
        $avgExerciseDuration = round($records->average('exercise_duration'), 2);
        $avgSleepHours = round($records->average('sleep_hours'), 2);

        $message = "<b>Here is your weekly health report💪💪💪</b>\n\n" .
            "💧Average water intake: <strong>$avgWaterIntake litres</strong>\n" .
            "😴Average sleep hour: <strong>$avgSleepHours hours</strong>\n" .
            "🏃‍♂️Average exercise duration: <strong>$avgExerciseDuration hours</strong>\n";

        return $this->replyText($message);
    }
}
