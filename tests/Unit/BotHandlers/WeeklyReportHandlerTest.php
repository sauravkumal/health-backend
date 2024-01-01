<?php

namespace Tests\Unit\BotHandlers;

use App\Bot\Commands\User\WeeklyreportCommand;
use App\Bot\Handlers\WeeklyReportHandler;
use App\Models\Record;
use App\Models\TelegramUser;
use Illuminate\Support\Str;
use Longman\TelegramBot\Exception\TelegramException;
use Mockery;
use Tests\BotHandlerTestCase;

class WeeklyReportHandlerTest extends BotHandlerTestCase
{

    /**
     * @throws TelegramException
     */
    public function test_if_weekly_report_handler_is_working()
    {
        $this->createHandlerTestBench();
        $user = TelegramUser::factory()->create(['telegram_id' => $this->from->getId()]);
        $user->records()->saveMany(Record::factory(7)
            ->sequence(
                ['date' => today()->format('Y-m-d')],
                ['date' => today()->addDay()->format('Y-m-d')],
                ['date' => today()->addDays(2)->format('Y-m-d')],
                ['date' => today()->addDays(3)->format('Y-m-d')],
                ['date' => today()->addDays(4)->format('Y-m-d')],
                ['date' => today()->addDays(5)->format('Y-m-d')],
                ['date' => today()->addDays(6)->format('Y-m-d')],
            )
            ->make());
        //todo be specific on argument parameters
        $this->client->shouldReceive('post')->with(
            Mockery::on(function ($arg) {
                return Str::contains($arg, 'sendMessage');
            }), Mockery::on(function ($arg) {
            return Str::contains($arg['form_params']['text'], 'Here is your weekly health report');
        }))->andReturn($this->sendMessageResponse);

        $command = Mockery::mock(WeeklyreportCommand::class);
        $command->shouldReceive('getMessage')->andReturn($this->message);

        $handler = new WeeklyReportHandler($command);
        $handler->handle();


        $this->assertTrue(true);
    }

}
