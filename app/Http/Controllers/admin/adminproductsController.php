<?php

namespace App\Http\Controllers\admin; 

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminproductsController extends Controller 
{
    // ① 商品一覧を表示
    public function index()
    {
        session(['shopId' => 1]); 
        $shopId = session('shopId');

        $products = DB::table('products')
            ->leftJoin('products_img', function($join) {
                $join->on('products.id', '=', 'products_img.product_id')
                     ->whereRaw('products_img.id = (select min(id) from products_img where product_id = products.id)');
            })
            ->where('products.shop_id', $shopId)
            ->select(
                'products.id',
                'products.name',
                'products.price',
                'products.stock',
                'products_img.url as pictureUrl'
            )
            ->orderBy('products.id', 'asc')
            ->get();

        return view('adminproducts', compact('products'));
    }

    // ② 編集画面を出す
    public function edit($id)
    {
        session(['shopId' => 1]); 
        $shopId = session('shopId');

        // 画像のURLも一緒にゲットするために leftJoin するで！
        $product = DB::table('products')
            ->leftJoin('products_img', function($join) {
                $join->on('products.id', '=', 'products_img.product_id')
                     ->whereRaw('products_img.id = (select min(id) from products_img where product_id = products.id)');
            })
            ->where('products.id', $id)
            ->where('products.shop_id', $shopId)
            ->select('products.*', 'products_img.url as pictureUrl') // 画像URLもセレクト
            ->first();

        if (!$product) {
            return redirect()->route('admin.products.index')->withErrors('商品が見つからんか、権限がありまへん。');
        }

        $categories = DB::table('categories')->get();

        return view('adminproductsupdate', compact('product', 'categories'));
    }

    // ③ データを更新する（画像対応版！）
    public function update(Request $request, $id)
    {
        session(['shopId' => 1]); 
        $shopId = session('shopId');

        // バリデーションに image を追加や！
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|integer',
            'description' => 'nullable|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // ★2MBまでの画像
        ]);

        try {
            // 1. まずは商品の基本情報をアップデート
            DB::table('products')
                ->where('id', $id)
                ->where('shop_id', $shopId)
                ->update([
                    'name'        => $request->name,
                    'price'       => $request->price,
                    'stock'       => $request->stock,
                    'category_id' => $request->category_id,
                    'description' => $request->description,
                    'updated_at'  => now(),
                ]);

            // 2. 画像ファイルがアップロードされたかチェック！
            if ($request->hasFile('product_image')) {
                $file = $request->file('product_image');
                
                // ユニークなファイル名を作成（例: 16875d_20260623.png）
                $fileName = time() . '_' . $file->getClientOriginalName();
                
                // public/images/products/ フォルダにファイルを移動させるで！
                $file->move(public_path('images/products'), $fileName);
                
                // DBに保存する用のURLパスを作成
                $dbImageUrl = '/images/products/' . $fileName;

                // 既存の画像レコードがあるか確認
                $existingImg = DB::table('products_img')->where('product_id', $id)->first();

                if ($existingImg) {
                    // あったらURLをアップデート！
                    DB::table('products_img')
                        ->where('product_id', $id)
                        ->update([
                            'url' => $dbImageUrl,
                            'updated_at' => now()
                        ]);
                } else {
                    // 無かったら新しくインサート！
                    DB::table('products_img')->insert([
                        'product_id' => $id,
                        'url' => $dbImageUrl,
                        'alt' => $request->name,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            return redirect()->route('admin.products.index')->with('success', '商品と画像をアップデートしました！');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors('更新に失敗したで：' . $e->getMessage())->withInput();
        }
    }
}