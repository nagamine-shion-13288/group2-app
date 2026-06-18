<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - 商品詳細</title>
    <link rel="icon" type="image/png" href="{{ asset('D.png?v=1') }}">
    <style>
        body { font-family: sans-serif; margin: 0; padding: 0; }
        .container {
            max-width: 720px;
            margin: 0 auto;
            padding: 24px 16px;
        }
        .back-link { font-size: 14px; margin-bottom: 16px; }
        .back-link a { color: #555; text-decoration: none; }
        .back-link a:hover { text-decoration: underline; }

        .product-detail { display: flex; gap: 32px; margin-top: 24px; }
        @media (max-width: 600px) {
            .product-detail { flex-direction: column; gap: 24px; }
        }

        /* カート画面の画像スタイルと統一 */
        .product-image { flex-shrink: 0; width: 280px; height: 280px; background: #ccc; border-radius: 4px; overflow: hidden; }
        .product-image img { width: 100%; height: 100%; object-fit: cover; }
        .product-image--placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 16px; background: #aaa; }

        .product-info { flex: 1; }
        .product-name { font-size: 22px; font-weight: bold; margin: 0 0 12px 0; }
        .product-price { font-size: 18px; font-weight: bold; text-decoration: underline; margin-bottom: 24px; }
        
        .stock-status { font-size: 14px; color: #555; margin-bottom: 16px; }
        .stock-out { color: #c0392b; font-weight: bold; }

        /* カート追加フォーム */
        .cart-form { border-top: 1px solid #e0e0e0; padding-top: 20px; }
        .quantity-select { margin-bottom: 16px; font-size: 14px; }
        .quantity-select select { padding: 6px 12px; font-size: 14px; border-radius: 4px; border: 1px solid #ccc; }
        
        /* カート画面のボタンのスタイルを流用 */
        .btn-submit { background: #333; color: #fff; border: none; padding: 10px 24px; border-radius: 4px; font-size: 14px; cursor: pointer; width: 100%; max-width: 200px; }
        .btn-submit:hover { background: #555; }
    </style>
</head>
<body>
<div class="container">

    <div class="back-link">
        <a href="/products">&lt; 商品一覧に戻る</a>
    </div>

    <div class="product-detail">
        <div class="product-image">
            @if ($product->images && $product->images->first())
                <img src="{{ asset('storage/products/' . $product->images->first()->url . '.jpg') }}" alt="{{ $product->name }}">
            @else
                <div class="product-image--placeholder">画像</div>
            @endif
        </div>

        <div class="product-info">
            <h1 class="product-name">{{ $product->name }}</h1>
            <p class="product-price">¥{{ number_format($product->price) }}</p>

            <p class="stock-status">
                @if ($product->stock > 0)
                    在庫あり (残り {{ $product->stock }} 個)
                @else
                    <span class="stock-out">売り切れ</span>
                @endif
            </p>

            @if ($product->stock > 0)
                <form action="{{ route('cart.store', $product->id) }}" method="POST" class="cart-form">
                    @csrf

                    <div class="quantity-select">
                        <label for="quantity">個数：</label>
                        <select name="quantity" id="quantity">
                            @for ($i = 1; $i <= min($product->stock, 10); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <button type="submit" class="btn-submit">カートに入れる</button>
                </form>
            @endif
        </div>
    </div>

</div>
</body>
</html>