<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\VendorController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;


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

Route::post('/auth/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    if (Auth::attempt($request->only('email', 'password'))) {
        $token = $request->user()->createToken(Str::random(5));
        $user = $request->user();
        $user->token = $token->plainTextToken;
        return response()->json(['message' => 'success', 'user' => $user]);
    } else {
        return response()->json([
            'message' => 'These credentials do not match our records.',
            'errors' => ['email' => 'These credentials do not match our records.']
        ], 422);
    }
});

Route::middleware('auth:sanctum')->post('/auth/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'success']);
});

Route::get('/vendor/menu', [VendorController::class, 'vendorMenu']);
Route::post('/vendor/menu/publish', [VendorController::class, 'publishMenu']);

Route::apiResource('/categories', CategoryController::class);
Route::apiResource('/products', ProductController::class);
Route::apiResource('/menus', MenuController::class);



