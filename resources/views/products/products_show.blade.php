<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - 商品詳細</title>
    <link rel="icon" type="image/png" href="{{ asset('D.png?v=1') }}">

    @vite(['resources/css/app.css'])
</head>
<body>
@include('layouts.header')

<div class="product-detail-page">
    <div class="container">

        <div class="back-link">
            <a href="/products">&lt; 商品一覧に戻る</a>
        </div>

        <div class="product-detail">
            <div class="product-image">
                @if ($product->images && $product->images->isNotEmpty() && $product->images->first()->url)
                    <img src="{{ $product->images->first()->url }}" alt="{{ $product->name }}">
                @else
                    <div class="product-image--placeholder">画像</div>
                @endif
            </div>

            <div class="product-info">
                @if($product->shop)
                    <p class="shop-name">{{ $product->shop->name }}</p>
                @endif

                <h1 class="product-name">{{ $product->name }}</h1>
                <p class="product-price">¥{{ number_format($product->price) }}</p>

                @if($product->description)
                    <div class="product-description">{{ $product->description }}</div>
                @endif

                <p class="stock-status">
                    @if ($product->stock > 0)
                        在庫あり (残り {{ $product->stock }} 個)
                    @else
                        <span class="stock-out">売り切れ</span>
                    @endif
                </p>

                @if ($product->stock > 0)
                    @if (session('userId'))
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
                    @else
                        <div class="cart-form">
                            <a href="{{ route('login') }}" class="btn-submit" style="display:inline-block; text-align:center; text-decoration:none;">
                                カートに入れるためにログイン
                            </a>
                        </div>
                    @endif
                @endif
            </div>
        </div>

    </div>
</div>

@if($product->voice_url)
<script>
window.addEventListener('load', function () {
    const audio = new Audio("{{ asset($product->voice_url) }}");
    audio.volume = 1.0;

    audio.play().catch(function(error) {
        console.log('音声の自動再生がブロックされました', error);
    });
});
</script>
@endif

</body>
</html>