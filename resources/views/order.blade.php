<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入確認</title>
    <link rel="icon" type="image/png" href="{{ asset('D.png?v=1') }}">
    
    @vite(['resources/css/app.css'])
</head>
<body>
@include('layouts.header')

<div class="cart-checkout-page">
    <div class="cart-container">
        <h1 class="cart-title">購入確認</h1>

        <div class="cart-items">
            @foreach ($cartItems as $item)
                <div class="cart-item">
                    <div class="cart-item__image">
                        @if ($item->pictureUrl)
                            <img src="{{ asset($item->pictureUrl) }}" alt="{{ $item->itemName }}">
                        @else
                            <div class="cart-item__image--placeholder">画像</div>
                        @endif
                    </div>
                    <div class="cart-item__info">
                        <p class="cart-item__name">{{ $item->itemName }}</p>
                        <p class="cart-item__price">
                            ¥{{ number_format($item->itemPrice) }}
                            <span class="cart-item__quantity">個数 {{ $item->quantity }}</span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="delivery-section">
            <h2 class="delivery-title">お届け先</h2>

            <label class="delivery-option">
                <input type="radio" name="delivery_type" value="home" checked
                       onchange="toggleDelivery(this.value)">
                自宅（{{ $userAddress }}）
            </label>

            <label class="delivery-option">
                <input type="radio" name="delivery_type" value="manual"
                       onchange="toggleDelivery(this.value)">
                手動入力
            </label>

            <div id="manual-input" style="display:none; margin-top: 8px;">
                <input type="text" name="manual_address" placeholder="住所を入力してください"
                       class="address-input">
            </div>
        </div>

        <div class="cart-footer">
            <p class="cart-total">
                合計金額 <span class="cart-total__price">¥{{ number_format($totalPrice) }}</span>
            </p>
            <form action="{{ route('order.complete') }}" method="POST" id="order-form">
                @csrf
                <input type="hidden" name="delivery_type" id="delivery_type_input" value="home">
                <input type="hidden" name="home_address" value="{{ $userAddress }}">
                <input type="hidden" name="manual_address" id="manual_address_input" value="">
                <div style="display:flex; gap:12px;">
                    <a href="/products" class="btn-back-red">戻る</a>
                    <button type="submit" class="btn-primary">購入する</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleDelivery(value) {
    document.getElementById('delivery_type_input').value = value;
    document.getElementById('manual-input').style.display =
        value === 'manual' ? 'block' : 'none';
}

// 手動入力の値をhiddenに同期
const manualAddressInput = document.querySelector('input[name="manual_address"]');
if (manualAddressInput) {
    manualAddressInput.addEventListener('input', function() {
        document.getElementById('manual_address_input').value = this.value;
    });
}
</script>
</body>
</html>