<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


// 商品一覧画面（兼、検索結果表示）
Route::get('/products', [ProductController::class, 'products'])->name('products.index');

//商品詳細画面用
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');