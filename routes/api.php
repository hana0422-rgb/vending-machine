<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\SaleApiController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\LoginApiController;

// 🔓 ログインAPI（トークン取得）
Route::post('/login', [LoginApiController::class, 'login']);

// ✅ 購入処理API
Route::post('/purchase', [PurchaseController::class, 'store']);

// ✅ 商品API
Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/products/{product}', [ProductApiController::class, 'show']);
Route::post('/products', [ProductApiController::class, 'store']);
Route::put('/products/{product}', [ProductApiController::class, 'update']);
Route::delete('/products/{product}', [ProductApiController::class, 'destroy']);

// ✅ 売上API
Route::get('/sales', [SaleApiController::class, 'index']);
Route::post('/sales', [SaleApiController::class, 'store']);

// ✅ 疎通確認用
Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

Route::get('/test-api', function () {
    return response()->json(['message' => 'api route OK']);
});

Route::post('/login-test', function (Request $request) {
    return response()->json([
        'email' => $request->email,
        'message' => 'Login Test API reached',
    ]);
});

// ✅ hello API（追加）
Route::get('/hello', function () {
    return response()->json(['message' => 'Hello API']);
});
