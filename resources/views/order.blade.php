<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入確認</title>
    <link rel="icon" type="image/png" href="{{ asset('D.png?v=1') }}">
    <style>
        body { font-family: sans-serif; margin: 0; padding: 0; }
        .cart-container {
            max-width: 720px;
            margin: 70px auto 0 auto; /* 💡 上にヘッダー分の余白（70px）を追加 */
            padding: 24px 16px;
        }
        .cart-user { font-size: 14px; color: #555; margin-bottom: 4px; }
        .cart-title { font-size: 22px; font-weight: bold; text-decoration: underline; text-align: center; margin-bottom: 24px; }
        .cart-item { display: flex; align-items: flex-start; gap: 16px; padding: 16px 0; border-bottom: 1px solid #e0e0e0; }
        .cart-item__image { flex-shrink: 0; width: 96px; height: 96px; background: #ccc; border-radius: 4px; overflow: hidden; }
        .cart-item__image img { width: 100%; height: 100%; object-fit: cover; }
        .cart-item__image--placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 13px; background: #aaa; }
        .cart-item__info { flex: 1; }
        .cart-item__name { font-size: 15px; margin-bottom: 6px; }
        .cart-item__price { font-size: 14px; text-decoration: underline; }
        .cart-item__quantity { text-decoration: none; margin-left: 16px; color: #333; }
        .cart-footer { display: flex; justify-content: flex-end; align-items: center; gap: 24px; padding-top: 20px; }
        .cart-total { font-size: 14px; }
        .cart-total__price { text-decoration: underline; font-weight: bold; }
        .btn-primary { display: inline-block; background: #333; color: #fff; padding: 8px 20px; border-radius: 4px; text-decoration: none; font-size: 14px; border: none; cursor: pointer; }
        .btn-primary:hover { background: #555; }
        .btn-back { display: inline-block; font-size: 13px; color: #555; text-decoration: none; margin-bottom: 12px; }
        .btn-back:hover { color: #000; }
        .delivery-section { margin: 24px 0; padding: 16px; border: 1px solid #ddd; border-radius: 8px; }
        .delivery-title { font-size: 16px; font-weight: bold; margin-bottom: 12px; }
        .delivery-option { display: block; margin-bottom: 8px; font-size: 14px; cursor: pointer; }
        .address-input { width: 100%; padding: 8px 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; box-sizing: border-box; }
        .btn-back-red {
            display: inline-block;
            background: #c0392b;
            color: #fff;
            padding: 8px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-back-red:hover { background: #a93226; }
    </style>
</head>
<body>
@include('layouts.header')
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