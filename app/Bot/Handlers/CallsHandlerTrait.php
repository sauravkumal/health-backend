<?php

namespace App\Bot\Handlers;

use Longman\TelegramBot\Entities\ServerResponse;

trait CallsHandlerTrait
{

    public function handler($handler): ServerResponse
    {
        $object = new $handler($this);
        /* @var HandlerInterface $object */
        return $object->handle();
    }

}
