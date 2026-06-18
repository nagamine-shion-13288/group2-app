<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/product_route.php';

Route::get('/', function () {
    return view('welcome');

});

use App\Http\Controllers\CartController;

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{id}/add', [CartController::class, 'store'])->name('cart.store');
Route::post('/cart/{id}/delete', [CartController::class, 'destroy'])->name('cart.destroy');

?>

