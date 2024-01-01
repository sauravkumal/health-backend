<?php

namespace Tests\Unit\BotHandlers;

use App\Bot\Commands\User\StartCommand;
use App\Bot\Handlers\ExistingUserHandler;
use Illuminate\Support\Str;
use Longman\TelegramBot\Exception\TelegramException;
use Mockery;
use Tests\BotHandlerTestCase;

class ExistingUserHandlerTest extends BotHandlerTestCase
{

    /**
     * @throws TelegramException
     */
    public function test_if_existing_user_handler_is_working()
    {
        $this->createHandlerTestBench();
        //todo be specific on argument parameters
        $this->client->shouldReceive('post')->with(
            Mockery::on(function ($arg) {
                return Str::contains($arg, 'sendMessage');
            }), Mockery::on(fn($args) => true))->andReturn($this->sendMessageResponse);

        $command = Mockery::mock(StartCommand::class);
        $command->shouldReceive('getMessage')->andReturn($this->message);

        $this->message->shouldReceive('getText')->andReturn('Hi');

        $handler = new ExistingUserHandler($command);
        $handler->handle();

        $this->assertTrue(true);
    }

}
