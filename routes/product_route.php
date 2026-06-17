<?php

// ①【必須】Laravelの基本機能を使うための住所
use Illuminate\Support\Facades\Route;

// ②【必須】あなたが作ったProductControllerの住所
use App\Http\Controllers\ProductController;

use App\Http\Controllers\CartController;

// ③【必須】ユーザーがアクセスしたときの交通整理（ルート定義）
Route::get('/products', [ProductController::class, 'products']);

