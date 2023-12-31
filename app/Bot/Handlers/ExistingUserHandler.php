<?php

namespace App\Bot\Handlers;

use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class ExistingUserHandler extends BaseHandler implements HandlerInterface
{

    public function handle(): ServerResponse
    {
        return Request::emptyResponse();
    }
}
