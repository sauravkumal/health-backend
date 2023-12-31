<?php

namespace App\Bot\Handlers;

use Longman\TelegramBot\Entities\ServerResponse;

trait CallsHandlerTrait
{

    protected function handler($handler): ServerResponse
    {
        $object = new $handler($this);
        /* @var HandlerInterface $object */
        return $object->handle();
    }

    protected function constructHandlerClass(string $data): string
    {
        $classInitials = explode('_', $data)[0];
        return "App\\Bot\\Handlers\\" . $classInitials . "Handler";
    }
}
