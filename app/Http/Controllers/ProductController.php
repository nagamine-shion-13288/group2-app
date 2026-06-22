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
    $keyword = $request->input('keyword'); // 💡検索キーワードを取得

    // 1. クエリの土台を作成
    $query = Product::with('images');

    // 2. カテゴリが選択されていれば条件を追加
    if ($selectedCategoryId) {
        $query->where('category_id', $selectedCategoryId);
    }

    // 3. 💡検索キーワードがあれば「あいまい検索」の条件を追加
    if (!empty($keyword)) {
        $query->where('name', 'LIKE', "%{$keyword}%");
    }

    // 4. 最終的な条件でデータを取得
    $products = $query->get();

    $categories = Category::all();

    return view('products', compact('products', 'categories', 'selectedCategoryId'));
}
}