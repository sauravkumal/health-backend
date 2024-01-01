<?php

namespace Tests\Unit\BotHandlers;

use App\Bot\Commands\User\SetreminderCommand;
use App\Bot\Handlers\SetReminderHandler;
use App\Models\TelegramUser;
use Illuminate\Support\Str;
use Longman\TelegramBot\Exception\TelegramException;
use Mockery;
use Tests\BotHandlerTestCase;

class SetReminderHandlerTest extends BotHandlerTestCase
{

    /**
     * @throws TelegramException
     */
    public function test_if_set_reminder_handler_is_working()
    {
        $this->createHandlerTestBench();
        $user = TelegramUser::factory()->create(['telegram_id' => $this->from->getId()]);
        //todo be specific on argument parameters
        $this->client->shouldReceive('post')->with(
            Mockery::on(function ($arg) {
                return Str::contains($arg, 'sendMessage');
            }), Mockery::on(fn($args) => true))->andReturn($this->sendMessageResponse);

        $command = Mockery::mock(SetreminderCommand::class);
        $command->shouldReceive('getMessage')->andReturn($this->message);

        $inputs = ['', '5:10 pm'];
        $this->message->shouldReceive('getText')->andReturn(...$inputs);

        foreach ($inputs as $input) {
            $handler = new SetReminderHandler($command);
            $handler->handle();
        }
        $this->assertDatabaseHas('telegram_users', ['id' => $user->id, 'reminder' => '17:10:00']);
        $this->assertDatabaseCount('telegram_users', 1);
    }

}
