<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注文履歴</title>
    <link rel="icon" type="image/png" href="{{ asset('D.png?v=1') }}">
    
    @vite(['resources/css/app.css'])
</head>
<body>

@include('layouts.header')

<div class="order-history-page">
    <div class="history-container">

        <h1 class="history-title">注文履歴</h1>

        @if ($orderHistories->isEmpty())
            <p class="history-empty">注文履歴がありません。</p>
        @else
            <div class="history-items">
                @foreach ($orderHistories as $history)
                    <div class="history-item">
                        <div class="history-item__image">
                            @if ($history->pictureUrl)
                                <img src="{{ asset($history->pictureUrl) }}" alt="{{ $history->itemName }}">
                            @else
                                <div class="history-item__image--placeholder">画像</div>
                            @endif
                        </div>
                        
                        <div class="history-item__info">
                            <p class="history-item__name">{{ $history->itemName }}</p>
                            
                            <p class="history-item__meta">
                                <span class="history-item__detail">個数 {{ $history->quantity }}</span>
                                <span class="history-item__price">¥{{ number_format($history->itemPrice) }}</span>
                                <span class="history-item__detail">お届け先：{{ $history->shipping_address }}</span>
                                <span class="history-item__detail">購入日：{{ \Carbon\Carbon::parse($history->orderDate)->format('Y年m月d日') }}</span>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
</body>
</html>