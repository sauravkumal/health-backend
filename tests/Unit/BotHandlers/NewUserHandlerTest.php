<?php

namespace Tests\Unit\BotHandlers;

use App\Bot\Commands\User\StartCommand;
use App\Bot\Handlers\NewUserHandler;
use Illuminate\Support\Str;
use Longman\TelegramBot\Exception\TelegramException;
use Mockery;
use Tests\BotHandlerTestCase;

class NewUserHandlerTest extends BotHandlerTestCase
{

    /**
     * @throws TelegramException
     */
    public function test_if_new_user_handler_is_working()
    {
        $this->createHandlerTestBench();

        $command = Mockery::mock(StartCommand::class);
        $command->shouldReceive('getMessage')->andReturn($this->message);

        $inputs = ['', 'Saurav Kumal', '2000-12-15', 'male'];
        $this->message->shouldReceive('getText')
            ->andReturn(...$inputs);

        foreach ($inputs as $input) {
            $handler = new NewUserHandler($command);
            $handler->handle();
        }

        $this->assertTrue(true);
    }

}
