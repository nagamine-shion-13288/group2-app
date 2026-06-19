<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ショッピングサイト</title>
    <link rel="icon" type="image/png" href="{{ asset('D.png?v=1') }}">

    <style>
        body {
            font-family: 'Helvetica Neue', Arial, 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', Meiryo, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f9f9f9;
        }

        .main-content {
            padding: 40px 20px;
        }

        .filter-form {
            margin-bottom: 40px;
            text-align: left;
            background-color: #fff;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            display: inline-block;
        }

        .filter-form label {
            font-size: 14px;
            font-weight: bold;
            color: #4a5568;
            margin-right: 10px;
        }

        .filter-form select {
            padding: 8px 16px;
            font-size: 14px;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            background-color: #fff;
            cursor: pointer;
            outline: none;
        }

        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 35px;
            padding: 0;
            list-style: none;
        }

        .product-item {
            width: 210px;
            text-align: center;
            background-color: #fff;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }

        .image-box {
            width: 100%;
            height: 210px;
            background-color: #edf2f7;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
            overflow: hidden;
            cursor: pointer;
        }

        .image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .not-found-text {
            color: #e53e3e;
            font-weight: bold;
            font-size: 14px;
            line-height: 1.5;
        }

        .product-info {
            padding: 5px 0;
        }

        .product-name {
            font-size: 16px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 8px;
            height: 44px;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price {
            font-size: 18px;
            font-weight: 800;
            color: #1a202c;
        }
    </style>
</head>

<body>

    @include('layouts.header')

    <main class="main-content">

        <div class="filter-form">
            <form action="{{ url('/products') }}" method="GET">
                <label for="category_select">カテゴリーで絞り込む：</label>

                <select name="category_id" id="category_select" onchange="this.form.submit()">
                    <option value="">すべてのカテゴリー</option>

                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $selectedCategoryId == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <ul class="product-grid">
            @foreach($products as $product)
                <li class="product-item">

                    <a href="{{ url('/products/' . $product->id) }}" style="text-decoration: none; color: inherit;">
                        <div class="image-box">
                            @if($product->images->isNotEmpty() && $product->images->first()->url)
                                <img src="{{ $product->images->first()->url }}" alt="{{ $product->images->first()->alt ?? $product->name }}">
                            @else
                                <span class="not-found-text">No Image<br>画像がありません</span>
                            @endif
                        </div>
                    </a>

                    <div class="product-info">
                        <div class="product-name">
                            <a href="{{ url('/products/' . $product->id) }}" style="text-decoration: none; color: inherit;">
                                {{ $product->name }}
                            </a>
                        </div>

                        <div class="product-price">
                            ¥ {{ number_format($product->price) }}
                        </div>
                    </div>

                </li>
            @endforeach
        </ul>

    </main>

</body>
</html>