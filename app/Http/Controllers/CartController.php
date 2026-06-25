<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Account;

class CartController extends Controller
{

    public function index(): View
    {
        $userId = session('userId');

        $user = Account::find($userId);

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

    public function store(Request $request, int $id): RedirectResponse
    {
    $userId = session('userId');
    $quantity = $request->integer('quantity', 1);

    $cart = Cart::where('user_id', $userId)
                ->where('product_id', $id)
                ->first();

    if ($cart) {
        Cart::where('user_id', $userId)
            ->where('product_id', $id)
            ->update(['quantity' => $cart->quantity + $quantity]);
    } else {
        Cart::create([
            'user_id'    => $userId,
            'product_id' => $id,
            'quantity'   => $quantity,
        ]);
    }

    return redirect()->route('cart.index')
                     ->with('success', 'カートに追加しました');
    }

    public function destroy(int $id): RedirectResponse
    {
        $userId = session('userId');

        Cart::where('user_id', $userId)
            ->where('product_id', $id)
            ->delete();

        return redirect()->route('cart.index')
                        ->with('success', '商品をカートから削除しました');
    }
}