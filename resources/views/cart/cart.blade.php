<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カート</title>
    <style>
        body { font-family: sans-serif; }

        .cart-container {
            max-width: 720px;
            margin: 0 auto;
            padding: 24px 16px;
        }
        .cart-user { font-size: 14px; color: #555; margin-bottom: 4px; }
        .cart-title { font-size: 22px; font-weight: bold; text-decoration: underline; text-align: center; margin-bottom: 24px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; padding: 10px 14px; margin-bottom: 16px; font-size: 14px; }
        .cart-empty { text-align: center; color: #888; margin-top: 48px; font-size: 15px; }
        .cart-item { display: flex; align-items: flex-start; gap: 16px; padding: 16px 0; border-bottom: 1px solid #e0e0e0; }
        .cart-item__image { flex-shrink: 0; width: 96px; height: 96px; background: #ccc; border-radius: 4px; overflow: hidden; }
        .cart-item__image img { width: 100%; height: 100%; object-fit: cover; }
        .cart-item__image--placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 13px; background: #aaa; }
        .cart-item__info { flex: 1; }
        .cart-item__name { font-size: 15px; margin-bottom: 6px; }
        .cart-item__price { font-size: 14px; text-decoration: underline; }
        .cart-item__quantity { text-decoration: none; margin-left: 16px; color: #333; }
        .cart-item__actions { flex-shrink: 0; }
        .btn-delete { background: none; border: 1px solid #ccc; border-radius: 4px; padding: 4px 10px; font-size: 12px; color: #c0392b; cursor: pointer; }
        .btn-delete:hover { background: #fdecea; }
        .cart-footer { display: flex; justify-content: flex-end; align-items: center; gap: 24px; padding-top: 20px; }
        .cart-total { font-size: 14px; }
        .cart-total__price { text-decoration: underline; font-weight: bold; }
        .btn-primary { display: inline-block; background: #333; color: #fff; padding: 8px 20px; border-radius: 4px; text-decoration: none; font-size: 14px; }
        .btn-primary:hover { background: #555; }
    </style>
</head>
<body>
<div class="cart-container">

    <p class="cart-user">{{ $user->name ?? 'ゲスト' }}さん</p>
    <h1 class="cart-title">カート</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($cartItems->isEmpty())
        <p class="cart-empty">カートに商品がありません。</p>
    @else
        <div class="cart-items">
            @foreach ($cartItems as $item)
                <div class="cart-item">
                    <div class="cart-item__image">
                        @if ($item['pictureId'])
                            <img src="{{ asset('storage/products/' . $item['pictureId'] . '.jpg') }}" alt="{{ $item['itemName'] }}">
                        @else
                            <div class="cart-item__image--placeholder">画像</div>
                        @endif
                    </div>
                    <div class="cart-item__info">
                        <p class="cart-item__name">{{ $item['itemName'] }}</p>
                        <p class="cart-item__price">
                            ¥{{ number_format($item['itemPrice']) }}
                            <span class="cart-item__quantity">個数　{{ $item['quantity'] }}</span>
                        </p>
                    </div>
                    <div class="cart-item__actions">
                        <form action="{{ route('cart.destroy', $item['itemId']) }}" method="POST">
                              onsubmit="return confirm('この商品をカートから削除しますか？')">
                            @csrf
                            <button type="submit" class="btn-delete">削除</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="cart-footer">
            <p class="cart-total">
                合計金額　<span class="cart-total__price">¥{{ number_format($totalPrice) }}</span>
            </p>
            <!-- /cart/checkを追加 -->
            <a href="#" class="btn-primary">購入確認へ</a>
        </div>
    @endif

</div>
</body>
</html>