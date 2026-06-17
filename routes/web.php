<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/product_route.php';

Route::get('/', function () {
    return view('welcome');
});