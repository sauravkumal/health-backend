<?php

namespace Tests\Unit\BotHandlers;

use App\Bot\Commands\User\SleephoursCommand;
use App\Bot\Handlers\SleepHoursHandler;
use App\Models\TelegramUser;
use Illuminate\Support\Str;
use Longman\TelegramBot\Exception\TelegramException;
use Mockery;
use Tests\BotHandlerTestCase;

class SleepHoursHandlerTest extends BotHandlerTestCase
{

    /**
     * @throws TelegramException
     */
    public function test_if_sleep_hours_handler_is_working()
    {
        $this->createHandlerTestBench();
        TelegramUser::factory()->create(['telegram_id' => $this->from->getId()]);
        //todo be specific on argument parameters
        $this->client->shouldReceive('post')->with(
            Mockery::on(function ($arg) {
                return Str::contains($arg, 'sendMessage');
            }), Mockery::on(fn($args) => true))->andReturn($this->sendMessageResponse);

        $command = Mockery::mock(SleephoursCommand::class);
        $command->shouldReceive('getMessage')->andReturn($this->message);

        $inputs = ['', '4'];
        $this->message->shouldReceive('getText')->andReturn(...$inputs);

        foreach ($inputs as $input) {
            $handler = new SleepHoursHandler($command);
            $handler->handle();
        }

        $this->assertDatabaseCount('records', 1);
    }

}
