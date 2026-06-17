<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Product;
class ProductController extends Controller 
{ 
    public function products() { 
        $products = Product::all();
        return view('products', compact('products'));
    } 
}