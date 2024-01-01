<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Longman\TelegramBot\Entities\Chat;
use Longman\TelegramBot\Entities\Message;
use Longman\TelegramBot\Entities\User;
use Longman\TelegramBot\Request;
use Mockery;

class BotHandlerTestCase extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    protected Mockery\LegacyMockInterface|Mockery\MockInterface $client;
    protected Mockery\LegacyMockInterface|Mockery\MockInterface $from;
    protected Mockery\LegacyMockInterface|Mockery\MockInterface $chat;
    protected Mockery\LegacyMockInterface|Mockery\MockInterface $message;
    protected Response $sendMessageResponse;

    protected function createHandlerTestBench(): void
    {
        $this->client = Mockery::mock(Client::class);


        Request::setClient($this->client);

        $id = fake()->numberBetween(10000, 10000);
        $this->chat = Mockery::mock(Chat::class);
        $this->chat->shouldReceive('getId')->andReturn($id);
        $this->from = Mockery::mock(User::class);
        $this->from->shouldReceive('getId')->andReturn($id);
        $this->from->shouldReceive('getFirstName')->andReturn(fake()->firstName);
        $this->from->shouldReceive('getLastName')->andReturn(fake()->lastName);
        $this->from->shouldReceive('getUsername')->andReturn(fake()->userName);

        DB::table('user')
            ->insert([
                'id' => $id,
                'first_name' => fake()->name
            ]);

        DB::table('chat')
            ->insert([
                'id' => $id,
                'type' => 'private'
            ]);


        $this->message = Mockery::mock(Message::class);
        $this->message->shouldReceive('getFrom')->andReturn($this->from);
        $this->message->shouldReceive('getChat')->andReturn($this->chat);


        $respJson = [
            "ok" => true,
            "result" => [
                "message_id" => fake()->randomNumber(),
                "from" => [
                    "id" => $id,
                    "is_bot" => true,
                    "first_name" => "Health Tracker",
                    "username" => "health_tracker_saurav_bot"
                ],
                "chat" => [
                    "id" => $id,
                    "first_name" => fake()->firstName,
                    "last_name" => fake()->lastName,
                    "username" => fake()->userName,
                    "type" => "private"
                ],
                "date" => fake()->unixTime,
                "text" => "👤Enter your name"
            ]
        ];


        $this->sendMessageResponse = new Response(200,
            ['Content-Type' => 'application/json'],
            json_encode($respJson));
    }
}
