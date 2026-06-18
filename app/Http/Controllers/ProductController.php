<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller 
{ 
    // 商品一覧画面用（これまでの処理）
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


    public function show(int $id) {
        // 画像リレーション（images）を一緒に読み込みつつ、IDで1件取得
        $product = Product::with('images')->findOrFail($id);

        return view('products.products_show', compact('product'));
}

}