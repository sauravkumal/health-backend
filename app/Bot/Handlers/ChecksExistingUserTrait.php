<?php

namespace App\Bot\Handlers;

use App\Models\TelegramUser;

trait ChecksExistingUserTrait
{
    protected function getExistingUser()
    {
        $message = $this->getMessage();
        $from = $message->getFrom();

        return TelegramUser::query()
            ->where('telegram_id', $from->getId())
            ->first();
    }
}
