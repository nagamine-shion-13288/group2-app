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
        $keyword = $request->input('keyword'); 
        $selectedSort = $request->input('sort', 'latest'); 

        $query = Product::with('images');

        if ($selectedCategoryId) {
            $query->where('category_id', $selectedCategoryId);
        }

        if (!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        }

        if ($selectedSort === 'price_asc') {
            $query->orderBy('price', 'asc'); 
        } elseif ($selectedSort === 'price_desc') {
            $query->orderBy('price', 'desc'); 
        } else {
            $query->orderBy('created_at', 'desc'); 
        }

        $products = $query->paginate(16);

        $categories = Category::all();

        return view('products', compact('products', 'categories', 'selectedCategoryId', 'selectedSort', 'keyword'));
    }

    public function show(int $id) {
        $product = Product::with(['images', 'shop'])->findOrFail($id);
        return view('products.products_show', compact('product'));
    }
}