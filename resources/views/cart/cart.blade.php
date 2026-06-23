<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カート</title>
    <link rel="icon" type="image/png" href="{{ asset('D.png?v=1') }}">
    
    @vite(['resources/css/app.css'])
</head>
<body>
@include('layouts.header')

<div class="cart-page">
    <div class="cart-container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (!$user)
            <p class="cart-empty">ログインするとカートをご利用いただけます。</p>
        @elseif ($cartItems->isEmpty())
            <p class="cart-empty">カートに商品がありません。</p>
        @else
            <div class="cart-items">
                @foreach ($cartItems as $item)
                    <div class="cart-item">
                        <div class="cart-item__image">
                            @if ($item['pictureId'])
                                <img src="{{ asset($item['pictureId']) }}" alt="{{ $item['itemName'] }}">
                            @else
                                <div class="cart-item__image--placeholder">画像</div>
                            @endif
                        </div>
                        <div class="cart-item__info">
                            <p class="cart-item__name">{{ $item['itemName'] }}</p>
                            <p class="cart-item__price">
                                ¥{{ number_format($item['itemPrice']) }}
                                <span class="cart-item__quantity">個数 {{ $item['quantity'] }}</span>
                            </p>
                        </div>
                        <div class="cart-item__actions">
                            <form action="{{ route('cart.destroy', $item['itemId']) }}" method="POST"
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
                    合計金額 <span class="cart-total__price">¥{{ number_format($totalPrice) }}</span>
                </p>
                <a href="{{ route('cart.check') }}" class="btn-primary">購入確認へ</a>
            </div>
        @endif

    </div>
</div>
</body>
</html>