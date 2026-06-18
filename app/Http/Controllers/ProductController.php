<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller 
{ 
    public function products(Request $request) { 
        
        $selectedCategoryId = $request->input('category_id');

        if ($selectedCategoryId) {
            $products = Product::with('images')->where('category_id', $selectedCategoryId)->get();
        } else {
            // ★ここを「all()」から「get()」に変更します
            $products = Product::with('images')->get();
        }

        $categories = Category::all();

        return view('products', compact('products', 'categories', 'selectedCategoryId'));
    } 
}