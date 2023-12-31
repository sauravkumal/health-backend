<?php

use App\Http\Controllers\RecordController;
use App\Http\Controllers\TelegramUserController;
use App\Http\Controllers\TelegramWebhookController;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return new UserResource($request->user());
});

Route::get('/webhook', [TelegramWebhookController::class, 'handle'])->name('telegram.webhook');
Route::post('/webhook', [TelegramWebhookController::class, 'handle'])->name('telegram.webhook');

Route::apiResource('/users', UserController::class);
Route::apiResource('/telegramUsers', TelegramUserController::class)->only('index', 'show', 'destroy');
Route::apiResource('/records', RecordController::class)->only('index', 'show', 'destroy');



