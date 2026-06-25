<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\admin\adminproductsController; 
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopManagerController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

require __DIR__.'/product_route.php';

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{id}/add', [CartController::class, 'store'])->name('cart.store');
Route::post('/cart/{id}/delete', [CartController::class, 'destroy'])->name('cart.destroy');

Route::get('/login/add', [UserController::class, 'showAccountAddForm']);
Route::post('/login/add', [UserController::class, 'accountAdd'])->name('account.store');
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/account', [UserController::class, 'showAccount'])->name('account.index');
Route::get('/account/edit', [UserController::class, 'showAccountUpdateForm'])->name('account.edit');
Route::post('/account/update', [UserController::class, 'accountUpdate'])->name('account.update');

Route::get('/cart/check', [OrderController::class, 'confirm'])->name('cart.check');
Route::post('/complete', [OrderController::class, 'complete'])->name('order.complete');
Route::get('/orderhistory', [OrderController::class, 'history'])->name('order.history');

Route::get('/shopManager/add', [ShopManagerController::class, 'showAddForm'])->name('shopManager.add');
Route::post('/shopManager/add', [ShopManagerController::class, 'add'])->name('shopManager.add.post');

Route::get('/admin/login',[ShopManagerController::class, 'showLoginForm'])->name('shopManager.login');
Route::post('/admin/login',[ShopManagerController::class, 'login'])->name('shopManager.login.post');

Route::get('/login/add', [UserController::class, 'showAccountAddForm'])->name('account.add');
Route::post('/login/add', [UserController::class, 'accountAdd'])->name('account.store');

Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::patch('order-details/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::get('/products/create', [adminproductsController::class, 'create'])->name('products.create');
    Route::post('/products', [adminproductsController::class, 'store'])->name('products.store');
    Route::get('/products', [adminproductsController::class, 'index'])->name('products.index');

    Route::get('/products/{id}/edit', [adminproductsController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [adminproductsController::class, 'update'])->name('products.update');

});