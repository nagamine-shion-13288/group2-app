<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // 購入確認画面
    public function confirm()
    {
        $userId   = session('userId');
        $userName = session('userName');

        // 未ログインの場合はログイン画面へ
        if (!$userId) {
            return redirect('/login');
        }
    // ユーザーの住所を取得
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

    // 購入完了処理
    public function complete(Request $request)
    {
        $userId   = session('userId');
        $userName = session('userName');

        if (!$userId) {
            return redirect('/login');
        }

    // お届け先の決定
    $address = $request->delivery_type === 'home'
        ? $request->home_address
        : $request->manual_address;

        $cartItems = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.user_id', $userId)
            ->select(
                'products.id as itemId',
                'products.price as itemPrice',
                'carts.quantity'
            )
            ->get();

        $totalPrice = $cartItems->sum(fn($item) => $item->itemPrice * $item->quantity);

        DB::transaction(function () use ($userId, $cartItems, $totalPrice) {

            $orderId = DB::table('orders')->insertGetId([
                'user_id'     => $userId,
                'total_price' => $totalPrice,
            ]);

            foreach ($cartItems as $item) {
                DB::table('order_details')->insert([
                    'order_id'   => $orderId,
                    'product_id' => $item->itemId,
                    'quantity'   => $item->quantity,
                    'price'      => $item->itemPrice,
                ]);
            }

            DB::table('carts')->where('user_id', $userId)->delete();
        });

        return view('ordercomplete', [
            'userName' => $userName,
        ]);
    }

    // 注文履歴画面を表示
    public function history()
    {
        $userId   = session('userId');
        $userName = session('userName');

        // 未ログインの場合はログイン画面へ
        if (!$userId) {
            return redirect('/login');
        }

        // ログインユーザーの注文履歴を取得
        $orderHistories = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->leftJoin('products_img', 'products.id', '=', 'products_img.product_id')
            ->where('orders.user_id', $userId)
            ->select(
                'products_img.url as pictureUrl',   // 商品画像
                'products.name as itemName',       // 商品名
                'order_details.quantity',          // 個数
                'order_details.price as itemPrice',// 値段（購入時の単価）
                'orders.shipping_address',         // お届け先
                'orders.created_at as orderDate'   // 購入日
            )
            // 最新の購入履歴が一番上に来るように並び替え
            ->orderBy('orders.created_at', 'desc') 
            ->get();

        return view('orderHistory', [
            'userName'       => $userName,
            'orderHistories' => $orderHistories,
        ]);
    }
}