<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\admin\adminproductsController; // 他のメンバーが作ったコントローラを活かす
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// 外部ルートファイルの読み込み
require __DIR__.'/product_route.php';

Route::get('/', function () {
    return view('welcome');
});

// カート関連
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{id}/add', [CartController::class, 'store'])->name('cart.store');
Route::post('/cart/{id}/delete', [CartController::class, 'destroy'])->name('cart.destroy');

// ユーザー登録・ログイン関連
Route::get('/login/add', [UserController::class, 'showAccountAddForm']);
Route::post('/login/add', [UserController::class, 'accountAdd'])->name('account.store');
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// アカウント関連
Route::get('/account', [UserController::class, 'showAccount'])->name('account.index');
Route::get('/account/edit', [UserController::class, 'showAccountUpdateForm'])->name('account.edit');
Route::post('/account/update', [UserController::class, 'accountUpdate'])->name('account.update');

// 注文関連
Route::get('/cart/check', [OrderController::class, 'confirm'])->name('cart.check');
Route::post('/complete', [OrderController::class, 'complete'])->name('order.complete');
Route::get('/orderhistory', [OrderController::class, 'history'])->name('order.history');


// ==========================================
// 管理画面（admin）関連のルーティング
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // 1. 【注文管理】
    // 注文一覧画面 (URL: /admin/orders)
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    // 配送ステータス更新 (URL: /admin/order-details/{id}/status)
    Route::patch('order-details/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // 2. 【他メンバー作成の商品追加・管理】
    // 💡 重要：{id} を含む編集ルートよりも「上に」具体的なURL（/products や /products/create 等があればそれ）を配置して衝突を防ぎます
    Route::get('/products', [adminproductsController::class, 'index'])->name('products.index');
    
    // 商品編集・更新ルート（{id} が入るルートは一番下に配置）
    Route::get('/products/{id}/edit', [adminproductsController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [adminproductsController::class, 'update'])->name('products.update');

});