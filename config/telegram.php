<?php

return [
    'token' => env('TELEGRAM_BOT_TOKEN'),
    'username' => env('TELEGRAM_BOT_USERNAME'),
    'admins' => env('TELEGRAM_ADMINS') ? explode(',', env('TELEGRAM_ADMINS')) : null,
];
