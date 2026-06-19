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

        $cartItems = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->leftJoin('products_img', 'products.id', '=', 'products_img.product_id')
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
}