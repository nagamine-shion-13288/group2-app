<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入完了</title>
    <link rel="icon" type="image/png" href="{{ asset('D.png?v=1') }}">
    <style>
        body { font-family: sans-serif; }
        .cart-container { max-width: 720px; margin: 0 auto; padding: 24px 16px; text-align: center; }
        .cart-user { font-size: 14px; color: #555; margin-bottom: 4px; text-align: left; }
        .complete-box { border: 1px solid #ddd; padding: 48px 24px; border-radius: 8px; margin-top: 40px; }
        .complete-box h1 { font-size: 22px; font-weight: bold; margin-bottom: 16px; }
        .complete-box p { color: #555; font-size: 14px; }
        .btn-primary { display: inline-block; margin-top: 32px; background: #333; color: #fff; padding: 10px 28px; border-radius: 4px; text-decoration: none; font-size: 14px; }
        .btn-primary:hover { background: #555; }
    </style>
</head>
<body>
<div class="cart-container">

    <p class="cart-user">{{ $userName }}さん</p>

    <div class="complete-box">
        <h1>ご購入ありがとうございました</h1>
        <p>注文が完了しました。</p>
        <a href="/products" class="btn-primary">トップページへ戻る</a>
    </div>

</div>
</body>
</html>