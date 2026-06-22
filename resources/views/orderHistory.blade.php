<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注文履歴</title>
    <link rel="icon" type="image/png" href="{{ asset('D.png?v=1') }}">
    <style>
        body { font-family: sans-serif; margin: 0; padding: 0; }

        /* --- メインコンテンツ（注文履歴）のスタイル --- */
        .history-container {
            max-width: 720px;
            margin: 0 auto;
            padding: 24px 16px;
        }
        .history-title { font-size: 22px; font-weight: bold; text-decoration: underline; text-align: center; margin-bottom: 24px; }
        .history-empty { text-align: center; color: #888; margin-top: 48px; font-size: 15px; }
        
        .history-item { display: flex; align-items: flex-start; gap: 16px; padding: 16px 0; border-bottom: 1px solid #e0e0e0; }
        .history-item__image { flex-shrink: 0; width: 96px; height: 96px; background: #ccc; border-radius: 4px; overflow: hidden; }
        .history-item__image img { width: 100%; height: 100%; object-fit: cover; }
        .history-item__image--placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 13px; background: #aaa; }
        .history-item__info { flex: 1; display: flex; flex-direction: column; gap: 6px; }
        .history-item__name { font-size: 15px; margin: 0; }
        
        .history-item__meta { font-size: 14px; color: #333; display: flex; flex-wrap: wrap; gap: 16px; margin: 0; }
        .history-item__price { text-decoration: underline; font-weight: bold; }
        .history-item__detail { color: #555; }

        .btn-back { display: inline-block; font-size: 13px; color: #555; text-decoration: none; margin-bottom: 12px; }
        .btn-back:hover { color: #000; }
    </style>
</head>
<body>

@include('layouts.header')
<div class="history-container">

    <a href="javascript:history.back()" class="btn-back">戻る</a>
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
</body>
</html>