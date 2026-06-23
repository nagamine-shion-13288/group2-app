<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\admin\adminproductsController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;


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


Route::prefix('admin')->name('admin.')->group(function () {
    
    // 💡 ポイント：{id} を含むルートよりも「上に」create を書くことで、URLの衝突を防ぎます
    // 商品登録画面の表示 (URL: /admin/products/create)
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    
    // 商品登録処理 (URL: /admin/products)
    Route::post('products', [ProductController::class, 'store'])->name('products.store');

    // 商品一覧・編集・更新
    Route::get('/products', [adminproductsController::class, 'index'])->name('products.index');
    Route::get('/products/{id}/edit', [adminproductsController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [adminproductsController::class, 'update'])->name('products.update');

});

