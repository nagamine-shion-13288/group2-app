<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function confirm()
    {
        $userId   = session('userId');
        $userName = session('userName');

        if (!$userId) {
            return redirect('/login');
        }

        $user = DB::table('users')->where('id', $userId)->first();

        $cartItems = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->leftJoin('products_img', function($join) {
                $join->on('products.id', '=', 'products_img.product_id')
                     ->whereRaw('products_img.id = (select min(id) from products_img where product_id = products.id)');
            })
            ->where('carts.user_id', $userId)
            ->select(
                'products.id as itemId',
                'products.name as itemName',
                'products.price as itemPrice',
                'products_img.url as pictureUrl',
                'carts.quantity'
            )
            ->get();

        $totalPrice = $cartItems->sum(fn($item) => $item->itemPrice * $item->quantity);

        return view('order', [
            'userName'   => $userName,
            'userAddress' => $user->address ?? '',
            'cartItems'  => $cartItems,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function complete(Request $request)
    {
        $userId   = session('userId');
        $userName = session('userName');

        if (!$userId) {
            return redirect('/login');
        }

        $address = $request->delivery_type === 'home'
            ? $request->home_address
            : $request->manual_address;

        $cartItems = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.user_id', $userId)
            ->select(
                'products.id as itemId',
                'products.name as itemName',
                'products.price as itemPrice',
                'products.stock',
                'carts.quantity'
            )
            ->get();

        $totalPrice = $cartItems->sum(fn($item) => $item->itemPrice * $item->quantity);

        try {
            DB::transaction(function () use ($userId, $cartItems, $totalPrice, $address) {
                
                // ★購入確定の現在日時をクリエイトするで！
                $currentDateTime = now();

                // 注文親データの登録
                $orderId = DB::table('orders')->insertGetId([
                    'user_id'          => $userId,
                    'total_price'      => $totalPrice,
                    'shipping_address' => $address,
                    'created_at'       => $currentDateTime, // ★ここに現在日時をインサート！
                    'updated_at'       => $currentDateTime, // 一緒にupdated_atも入れておくと親切やね
                ]);

                foreach ($cartItems as $item) {
                    if ($item->stock < $item->quantity) {
                        throw new \Exception($item->itemName . 'の在庫が足りまへん！');
                    }

                    // 注文明細の登録
                    DB::table('order_details')->insert([
                        'order_id'         => $orderId,
                        'product_id'       => $item->itemId,
                        'quantity'         => $item->quantity,
                        'price'            => $item->itemPrice,
                        'created_at'       => $currentDateTime, // ★明細側にも同じ日時をシンク！
                        'updated_at'       => $currentDateTime,
                    ]);

                    DB::table('products')
                        ->where('id', $item->itemId)
                        ->decrement('stock', $item->quantity);
                }

                DB::table('carts')->where('user_id', $userId)->delete();
            });

        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return view('ordercomplete', [
            'userName' => $userName,
        ]);
    }

    public function history()
    {
        $userId   = session('userId');
        $userName = session('userName');

        if (!$userId) {
            return redirect('/login');
        }

        $orderHistories = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->leftJoin('products_img', 'products.id', '=', 'products_img.product_id')
            ->where('orders.user_id', $userId)
            ->select(
                'products_img.url as pictureUrl',
                'products.name as itemName',
                'order_details.quantity',
                'order_details.price as itemPrice',
                'orders.shipping_address',
                'orders.created_at as orderDate'
            )
            ->orderBy('orders.created_at', 'desc') 
            ->get();

        return view('orderHistory', [
            'userName'       => $userName,
            'orderHistories' => $orderHistories,
        ]);
    }
}