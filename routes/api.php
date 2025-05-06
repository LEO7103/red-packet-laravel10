<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;


use App\Http\Controllers\Api\RedPacketController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// 發紅包
Route::post('/red-packet', [RedPacketController::class, 'create']);

// 搶紅包
Route::post('/red-packet/{id}/grab', [RedPacketController::class, 'grab']);

// 查排行榜
Route::get('/red-packet/{id}/rank', [RedPacketController::class, 'rank']);

Route::get('/red-packet/{id}/left', [RedPacketController::class, 'left']);
Route::get('/test', function () {
    // 測試是否有使用 Redis 做 Cache
    $data = Cache::remember('test-key', 60, function () {
        // 第一次請求時，這段會執行
        return [
            'message' => 'Hello, this is a Redis cache test.',
            'timestamp' => now(),
        ];
    });

    return response()->json($data);
});