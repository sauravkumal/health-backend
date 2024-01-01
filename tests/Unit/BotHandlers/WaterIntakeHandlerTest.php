<?php

namespace Tests\Unit\BotHandlers;

use App\Bot\Commands\User\WaterintakeCommand;
use App\Bot\Handlers\WaterIntakeHandler;
use App\Models\TelegramUser;
use Illuminate\Support\Str;
use Longman\TelegramBot\Exception\TelegramException;
use Mockery;
use Tests\BotHandlerTestCase;

class WaterIntakeHandlerTest extends BotHandlerTestCase
{

    /**
     * @throws TelegramException
     */
    public function test_if_water_intake_handler_is_working()
    {
        $this->createHandlerTestBench();
        TelegramUser::factory()->create(['telegram_id' => $this->from->getId()]);
        //todo be specific on argument parameters
        $this->client->shouldReceive('post')->with(
            Mockery::on(function ($arg) {
                return Str::contains($arg, 'sendMessage');
            }), Mockery::on(fn($args) => true))->andReturn($this->sendMessageResponse);

        $command = Mockery::mock(WaterintakeCommand::class);
        $command->shouldReceive('getMessage')->andReturn($this->message);

        $inputs = ['', '2'];
        $this->message->shouldReceive('getText')->andReturn(...$inputs);

        foreach ($inputs as $input) {
            $handler = new WaterIntakeHandler($command);
            $handler->handle();
        }

        $this->assertDatabaseCount('records', 1);
    }

}
