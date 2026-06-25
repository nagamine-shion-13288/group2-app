<?php

namespace App\Http\Controllers\admin; 

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminproductsController extends Controller 
{
    public function index(Request $request)
    {
        $shopId = session('shopId');

        $selectedCategoryId = $request->input('category_id');
        $sort = $request->input('sort', 'latest');

        $query = DB::table('products')
            ->leftJoin('products_img', function($join) {
                $join->on('products.id', '=', 'products_img.product_id')
                     ->whereRaw('products_img.id = (select min(id) from products_img where product_id = products.id)');
            })
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.shop_id', $shopId)
            ->select(
                'products.id',
                'products.name',
                'products.price',
                'products.stock',
                'products_img.url as pictureUrl',
                'categories.name as category_name'
            );

        if (!empty($selectedCategoryId)) {
            $query->where('products.category_id', $selectedCategoryId);
        }

        if ($sort === 'price_asc') {
            $query->orderBy('products.price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('products.price', 'desc');
        } else {
            $query->orderBy('products.id', 'asc');
        }

        $products = $query->get();
        $categories = DB::table('categories')->get();

        return view('adminproducts', compact('products', 'categories', 'selectedCategoryId'));
    }

    public function edit($id)
    {
        $shopId = session('shopId');

        $product = DB::table('products')
            ->leftJoin('products_img', function($join) {
                $join->on('products.id', '=', 'products_img.product_id')
                     ->whereRaw('products_img.id = (select min(id) from products_img where product_id = products.id)');
            })
            ->where('products.id', $id)
            ->where('products.shop_id', $shopId)
            ->select('products.*', 'products_img.url as pictureUrl')
            ->first();

        if (!$product) {
            return redirect()->route('admin.products.index')->withErrors('商品が見つからんか、権限がありません');
        }

        $categories = DB::table('categories')->get();

        return view('adminproductsupdate', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $shopId = session('shopId');

        $request->validate([
            'name'          => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'category_id'   => 'required|integer',
            'description'   => 'nullable|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'voice_file'    => 'nullable|mimes:mp3|max:5120',
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'name'        => $request->name,
                'price'       => $request->price,
                'stock'       => $request->stock,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'updated_at'  => now(),
            ];

            if ($request->hasFile('voice_file')) {
                $audioFile = $request->file('voice_file');
                $audioName = time() . '_' . $audioFile->getClientOriginalName();
                $audioFile->move(public_path('audio/voices'), $audioName);
                $updateData['voice_url'] = '/audio/voices/' . $audioName;
            }

            DB::table('products')
                ->where('id', $id)
                ->where('shop_id', $shopId)
                ->update($updateData);

            if ($request->hasFile('product_image')) {
                $file = $request->file('product_image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/products'), $fileName);
                $dbImageUrl = '/images/products/' . $fileName;

                $existingImg = DB::table('products_img')->where('product_id', $id)->first();

                if ($existingImg) {
                    DB::table('products_img')
                        ->where('product_id', $id)
                        ->update([
                            'url' => $dbImageUrl,
                            'updated_at' => now()
                        ]);
                } else {
                    DB::table('products_img')->insert([
                        'product_id' => $id,
                        'url' => $dbImageUrl,
                        'alt' => $request->name,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', '商品、画像、ボイスをアップデートしました');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('更新に失敗しました：' . $e->getMessage())->withInput();
        }
    }

    public function create()
    {
        $categories = DB::table('categories')->get();
        return view('adminproductsadd', compact('categories'));
    }

    public function store(Request $request)
    {
        $shopId = session('shopId');

        $request->validate([
            'name'          => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'category_id'   => 'required|integer',
            'description'   => 'nullable|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $productId = DB::table('products')->insertGetId([
                'shop_id'     => $shopId,
                'name'        => $request->name,
                'price'       => $request->price,
                'stock'       => $request->stock,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            if ($request->hasFile('product_image')) {
                $file = $request->file('product_image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/products'), $fileName);
                $dbImageUrl = '/images/products/' . $fileName;

                DB::table('products_img')->insert([
                    'product_id' => $productId,
                    'url'        => $dbImageUrl,
                    'alt'        => $request->name,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', '新しい商品を登録しました');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('登録に失敗しました：' . $e->getMessage())->withInput();
        }
    }
}