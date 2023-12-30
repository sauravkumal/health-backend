<?php

return [
    'token' => env('TELEGRAM_BOT_TOKEN'),
    'username' => env('TELEGRAM_BOT_USERNAME'),
    'admins' => env('TELEGRAM_ADMINS') ? explode(',', env('TELEGRAM_ADMINS')) : null,
    'db' => [
        'host' => env('TELEGRAM_DB_HOST'),
        'port' => env('TELEGRAM_DB_PORT'),
        'user' => env('TELEGRAM_DB_USERNAME'),
        'password' => env('TELEGRAM_DB_PASSWORD'),
        'database' => env('TELEGRAM_DB_DATABASE'),
    ]
];
