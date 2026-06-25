<?php
// app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImg;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * 商品登録画面の表示
     */
    public function create()
    {
        // セレクトボックス用にカテゴリ一覧を取得
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * 商品登録処理
     */
    public function store(Request $request)
    {
        // 1. バリデーション（テーブル定義の桁数や型に準拠）
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0|max:9999999999', // DECIMAL(10,0)考慮
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048', // 最大2MB
        ]);

        // ★【先行実装用モック】テスト用のショップID（1）を固定
        $mockShopId = 1; 

        try {
            DB::transaction(function () use ($request, $mockShopId) {
                // 2. 商品テーブル（products）に保存
                $product = Product::create([
                    'shop_id'     => $mockShopId,
                    'name'        => $request->name,
                    'description' => $request->description,
                    'category_id' => $request->category_id,
                    'price'       => $request->price,
                    'stock'       => $request->stock,
                ]);

                if ($request->hasFile('image')) {
                    $path = $request->file('image')->store('products', 'public');
                    
                    ProductImg::create([
                        'product_id' => $product->id,
                        'url'        => Storage::url($path),
                        'alt'        => $request->name, 
                    ]);
                }
        });

            return redirect()
                ->route('admin.products.create')
                ->with('status', '【テスト環境】ショップID: ' . $mockShopId . ' に商品を登録しました！');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => '登録に失敗しました。データベースの設定などを確認してください。']);
        }
    }
}