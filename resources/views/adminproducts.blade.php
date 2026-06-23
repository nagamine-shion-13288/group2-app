<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者 - 商品一覧</title>
    @vite('resources/css/pages/adminproducts.css')
</head>
<body>

<div class="admin-box">
    <h1>商品一覧</h1>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>アクション</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>
                    @if($product->pictureUrl)
                        <img src="{{ asset($product->pictureUrl) }}" class="product-img">
                    @else
                        <div class="product-img" style="color: #7f8c8d; font-size: 12px; font-weight: bold;">
                            なし
                        </div>
                    @endif
                </td>
                <td><strong>{{ $product->name }}</strong></td>
                <td>¥{{ number_format($product->price) }}</td>
                <td>{{ $product->stock }} 個</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-edit">編集する</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>