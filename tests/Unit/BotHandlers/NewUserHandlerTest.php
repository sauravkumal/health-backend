<?php

namespace Tests\Unit\BotHandlers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class NewUserHandlerTest extends TestCase
{

    use RefreshDatabase;

    protected $seed = true;

    public function test_if_new_user_handler_is_working()
    {
        Artisan::call('command:migrate-telegram-db');
        $this->assertTrue(true);
    }

}
