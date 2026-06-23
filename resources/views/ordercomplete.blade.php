<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入完了</title>
    <link rel="icon" type="image/png" href="{{ asset('D.png?v=1') }}">
    
    @vite(['resources/css/app.css'])
</head>
<body>
@include('layouts.header')

<div class="cart-complete-page">
    <div class="cart-container">

        <p class="cart-user">{{ $userName }}さん</p>

        <div class="complete-box">
            <h1>ご購入ありがとうございました</h1>
            <p>注文が完了しました。</p>
            <a href="/products" class="btn-primary">トップページへ戻る</a>
        </div>

    </div>
</div>
</body>
</html>