<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ショッピングサイト</title>
    <style>
        /* 全体の文字の配置や余白を整える設定 */
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            background-color: #fff;
        }

        /* ヘッダー部分（タイトル、〇〇さん、カート）の横並び設定 */
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 40px;
            padding-bottom: 10px;
        }

        .user-info {
            font-size: 24px;
            width: 20%;
        }

        .site-title {
            font-size: 42px;
            font-weight: bold;
            text-align: center;
            text-decoration: underline;
            width: 60%;
            margin: 0;
        }

        .cart-link {
            font-size: 24px;
            text-align: right;
            text-decoration: underline;
            width: 20%;
            cursor: pointer;
        }

        /* カテゴリー選択フォームの配置 */
        .filter-form {
            margin-bottom: 30px;
            text-align: left;
        }
        
        .filter-form select {
            padding: 5px 10px;
            font-size: 16px;
        }

        /* ★商品を横に並べるための設定 */
        .product-grid {
            display: flex;
            flex-wrap: wrap; /* 画面幅が狭くなったら自動で折り返す設定 */
            gap: 30px;      /* 商品と商品の間のすき間 */
            padding: 0;
            list-style: none;
        }

        /* 商品1つあたりのボックス設定 */
        .product-item {
            width: 200px; /* 商品ボックスの横幅 */
            text-align: center;
        }

        /* 画像を表示するグレーの四角いボックス（角丸） */
        .image-box {
            width: 200px;
            height: 200px;
            background-color: #b3b3b3; /* イメージ通りのグレー */
            border-radius: 20px;       /* 角を丸くする設定 */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            color: #000;
            margin-bottom: 15px;
            overflow: hidden;
        }

        /* 実際に画像が入った時のサイズ調整 */
        .image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* 枠線に合わせて綺麗に収める */
        }

        /* 画像がない（NotFound）の時の赤文字 */
        .not-found-text {
            color: #ff0000;
            font-weight: bold;
            font-size: 16px;
        }

        /* 商品名と価格のテキスト設定 */
        .product-info {
            font-size: 18px;
            line-height: 1.4;
        }
        
        .product-price {
            margin-top: 4px;
        }
    </style>
</head>
<body>

    <div class="header-container">
        <div class="user-info">〇〇さん</div>
        <h1 class="site-title">ショッピングサイト</h1>
        <div class="cart-link">カート</div>
    </div>

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
                
                <div class="image-box">
                    @if($product->images->isNotEmpty() && $product->images->first()->url)
                        <img src="{{ $product->images->first()->url }}" alt="{{ $product->images->first()->alt ?? $product->name }}">
                    @else
                        <span class="not-found-text">画像<br>NotFound</span>
                    @endif
                </div>

                <div class="product-info">
                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-price">¥ {{ number_format($product->price) }}</div>
                </div>

            </li>
        @endforeach
    </ul>

</body>
</html>