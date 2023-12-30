<?php

namespace App\Http\Controllers;

use App\Facades\Telegram;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramWebhookController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        try {
            Log::debug('telegram updates', $request->all());
            Telegram::handle();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
        }
        return response()->json(['message' => 'success']);
    }
}
