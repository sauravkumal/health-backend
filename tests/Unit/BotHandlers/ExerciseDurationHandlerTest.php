<?php

namespace Tests\Unit\BotHandlers;

use App\Bot\Commands\User\ExercisedurationCommand;
use App\Bot\Handlers\ExerciseDurationHandler;
use App\Models\TelegramUser;
use Illuminate\Support\Str;
use Longman\TelegramBot\Exception\TelegramException;
use Mockery;
use Tests\BotHandlerTestCase;

class ExerciseDurationHandlerTest extends BotHandlerTestCase
{

    /**
     * @throws TelegramException
     */
    public function test_if_exercise_duration_handler_is_working()
    {
        $this->createHandlerTestBench();
        TelegramUser::factory()->create(['telegram_id' => $this->from->getId()]);
        //todo be specific on argument parameters
        $this->client->shouldReceive('post')->with(
            Mockery::on(function ($arg) {
                return Str::contains($arg, 'sendMessage');
            }), Mockery::on(fn($args) => true))->andReturn($this->sendMessageResponse);

        $command = Mockery::mock(ExercisedurationCommand::class);
        $command->shouldReceive('getMessage')->andReturn($this->message);

        $inputs = ['', '1'];
        $this->message->shouldReceive('getText')->andReturn(...$inputs);

        foreach ($inputs as $input) {
            $handler = new ExerciseDurationHandler($command);
            $handler->handle();
        }

        $this->assertDatabaseCount('records', 1);
    }

}
