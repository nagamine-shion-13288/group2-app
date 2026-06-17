<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧</title>
</head>
<body>

    <h1>商品一覧</h1>

    <ul>
        @foreach($products as $product)
            <li>{{ $product->name }} - {{ number_format($product->price) }}円</li>
        @endforeach
    </ul>

</body>
</html>