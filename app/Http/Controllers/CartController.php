<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\User;

class CartController extends Controller
{
    /**
     * F07: カート一覧表示
     * カートに追加した全商品を表示する
     */
    public function index(): View
    {
        $userId = 1; // テスト用固定ID、認証実装後に Auth::id() に変更

        $user = User::find($userId);

        $cartItems = Cart::with(['product', 'product.images'])
            ->where('user_id', $userId)
            ->get()
            ->map(function ($cart) {
                return [
                    'itemId'    => $cart->product->id,
                    'userId'    => $cart->user_id,
                    'pictureId' => $cart->product->images->first()->url ?? null,
                    'itemName'  => $cart->product->name,
                    'itemPrice' => $cart->product->price,
                    'quantity'  => $cart->quantity,
                    'subtotal'  => $cart->product->price * $cart->quantity,
                ];
            });

        $totalPrice = $cartItems->sum('subtotal');

        return view('cart.cart', compact('cartItems', 'totalPrice', 'user'));
    }

    /**
     * F06: カート追加
     * 商品をカートに追加する
     */
    public function store(Request $request, int $id): RedirectResponse
    {
    $userId   = 1; // テスト用固定ID
    $quantity = $request->integer('quantity', 1);

    $cart = Cart::where('user_id', $userId)
                ->where('product_id', $id)
                ->first();

    if ($cart) {
        $cart->increment('quantity', $quantity);
    } else {
        Cart::create([
            'user_id'    => $userId,
            'product_id' => $id,
            'quantity'   => $quantity,
        ]);
    }

    return redirect()->route('cart.index')
                     ->with('success', 'カートに追加しました。');
    }

    /**
     * F08: カート削除
     * カートから商品を削除する
     */
    public function destroy(int $id): RedirectResponse
    {
        $userId = 1; // テスト用固定ID

        Cart::where('user_id', $userId)
            ->where('product_id', $id)
            ->delete();

        return redirect()->route('cart.index')
                        ->with('success', '商品をカートから削除しました。');
    }
}