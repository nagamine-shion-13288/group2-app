<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/product_route.php';

Route::get('/', function () {
    return view('welcome');

});


use App\Http\Controllers\CartController;

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{id}/add', [CartController::class, 'store'])->name('cart.store');
Route::post('/cart/{id}/delete', [CartController::class, 'destroy'])->name('cart.destroy');

Route::get('/login/add', [UserController::class, 'showAccountAddForm']);
Route::post('/login/add', [UserController::class, 'accountAdd'])->name('account.store');

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

