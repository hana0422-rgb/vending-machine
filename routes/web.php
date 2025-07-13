<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

// ユーザー登録・ログイン関連（未ログインでもアクセス可）
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');

// 🔐 認証が必要なルート（ログイン必須）
Route::middleware(['auth'])->group(function () {
    // 商品関連ルート
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    // ⭐︎ ここが重要: より具体的な /products/search を /products/{id} の前に定義する
    Route::get('/products/search', [ProductController::class, 'ajaxSearch'])->name('products.search');
    
    // より一般的な /products/{id} は /products/search の後に定義する
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    
    // 商品一覧のルートはそのまま
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');


    // 売上関連ルート
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');

});

// 👇 トップページはログイン画面にリダイレクト
Route::get('/', function () {
    return redirect()->route('login.form');
});