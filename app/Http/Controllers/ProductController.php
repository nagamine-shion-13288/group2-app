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
        $sort = $request->input('sort');

        $query = Product::with('images');

        if ($selectedCategoryId) {
            $query->where('category_id', $selectedCategoryId);
        }

        if (!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        }

        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::all();

        return view('products', compact('products', 'categories', 'selectedCategoryId', 'sort'));
    }

    public function show(int $id) {
        $product = Product::with(['images', 'shop'])->findOrFail($id);
        return view('products.products_show', compact('product'));
    }
}