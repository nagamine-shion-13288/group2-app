<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者 - 商品一覧</title>
    @vite('resources/css/pages/adminproducts.css')
</head>
<body>

<div class="admin-box">
    <div style="font-size: 14px; color: #7f8c8d; margin-bottom: 5px; font-weight: bold;">
        店舗：{{ session('shopName', '未設定のショップ') }}
    </div>

    <h1>商品一覧</h1>

    <div class="admin-actions">
        <a href="{{ route('admin.products.create') }}" class="btn-base btn-green">+ 新規商品を追加する</a>
        
        <a href="{{ route('admin.orders.index') }}" class="btn-base btn-green" style="margin-left: 10px;">📋 注文管理一覧を見る</a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <table style="width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 15px; table-layout: fixed;">
        <thead>
            <tr>
                <th style="width: 8%; text-align: center; background: #f8f9fa; color: #7f8c8d; font-weight: 600; text-transform: uppercase; font-size: 13px; padding: 16px; border-bottom: 2px solid #eaeded;">ID</th>
                <th style="width: 12%; text-align: center; background: #f8f9fa; color: #7f8c8d; font-weight: 600; text-transform: uppercase; font-size: 13px; padding: 16px; border-bottom: 2px solid #eaeded;">画像</th>
                <th style="width: 40%; text-align: left; background: #f8f9fa; color: #7f8c8d; font-weight: 600; text-transform: uppercase; font-size: 13px; padding: 16px; border-bottom: 2px solid #eaeded;">商品名</th>
                <th style="width: 15%; text-align: right; background: #f8f9fa; color: #7f8c8d; font-weight: 600; text-transform: uppercase; font-size: 13px; padding: 16px; border-bottom: 2px solid #eaeded;">価格</th>
                <th style="width: 10%; text-align: center; background: #f8f9fa; color: #7f8c8d; font-weight: 600; text-transform: uppercase; font-size: 13px; padding: 16px; border-bottom: 2px solid #eaeded;">在庫数</th>
                <th style="width: 15%; text-align: center; background: #f8f9fa; color: #7f8c8d; font-weight: 600; text-transform: uppercase; font-size: 13px; padding: 16px; border-bottom: 2px solid #eaeded;">アクション</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td style="width: 8%; text-align: center; padding: 16px; vertical-align: middle; border-bottom: 1px solid #eaeded; color: #2c3e50; font-size: 15px; word-wrap: break-word; overflow-wrap: break-word;">{{ $product->id }}</td>
                <td style="width: 12%; text-align: center; padding: 16px; vertical-align: middle; border-bottom: 1px solid #eaeded; color: #2c3e50; font-size: 15px; word-wrap: break-word; overflow-wrap: break-word;">
                    @if($product->pictureUrl)
                        <img src="{{ asset($product->pictureUrl) }}" class="product-img" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); background: #e5e8e8; display: inline-block;">
                    @else
                        <div class="product-img" style="width: 60px; height: 60px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); background: #e5e8e8; display: inline-flex; align-items: center; justify-content: center; color: #7f8c8d; font-size: 12px; font-weight: bold; margin: 0 auto;">
                            なし
                        </div>
                    @endif
                </td>

                <td><strong>{{ $product->name }}</strong></td>
                <td>¥{{ number_format($product->price) }}</td>
                <td>{{ $product->stock }} 個</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-base btn-navy btn-sm">編集する</a>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>