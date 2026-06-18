<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ショッピングサイト</title>
    <style>
        /* 全体のベース設定 */
        body {
            font-family: 'Helvetica Neue', Arial, 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', Meiryo, sans-serif;
            margin: 0;
            padding: 40px 20px;
            color: #333;
            background-color: #f9f9f9; /* 少し温かみのある背景色に */
        }

        /* ヘッダー部分：タイトルを完全中央、両脇に要素を浮かせる */
        .header-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 50px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee; /* 下線をつけてヘッダー感を強調 */
            position: relative; 
        }

        /* ★左側に配置するログアウトフォームとボタンのスタイル */
        .logout-form {
            position: absolute;
            left: 10px;
            bottom: 20px;
            margin: 0;
            padding: 0;
        }

        .logout-button {
            background: none;
            border: none;
            padding: 0;
            font-size: 16px;
            color: #e53e3e; /* 警告色（薄い赤） */
            font-weight: bold;
            cursor: pointer;
            font-family: inherit;
            transition: color 0.2s;
        }
        .logout-button:hover {
            color: #c53030; /* ホバー時に少し暗い赤に */
            text-decoration: underline; /* リンク風に見せるための下線 */
        }

        /* 中央のサイトタイトル */
        .site-title {
            font-size: 36px;
            font-weight: 800;
            text-align: center;
            margin: 0;
            letter-spacing: 2px; /* 文字の間隔を少し空けて上品に */
        }

        /* 右側に配置するカートボタン */
        .cart-link {
            font-size: 16px;
            color: #3182ce; /* 爽やかな青 */
            text-decoration: none;
            font-weight: bold;
            position: absolute; 
            right: 10px;      
            bottom: 20px;     
            transition: color 0.2s;
        }
        .cart-link:hover {
            color: #2b6cb0;
        }

        /* カテゴリー選択フォームの配置 */
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

        /* 商品一覧のグリッド配置 */
        .product-grid {
            display: flex;
            flex-wrap: wrap; 
            gap: 35px;      
            padding: 0;
            list-style: none;
        }

        /* 商品1つあたりのボックス設定 */
        .product-item {
            width: 210px; 
            text-align: center;
            background-color: #fff;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        /* ホバーしたときにフワッと浮き上がるアニメーション */
        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }

        /* 画像を表示するボックス */
        .image-box {
            width: 100%;
            height: 210px;
            background-color: #edf2f7; /* 明るめの洗練されたグレー */
            border-radius: 8px;       
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
            overflow: hidden;
            cursor: pointer;
        }

        /* 実際に画像が入った時のサイズ調整 */
        .image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
        }

        /* 画像がない（NotFound）の時のマイルドな赤文字 */
        .not-found-text {
            color: #e53e3e;
            font-weight: bold;
            font-size: 14px;
            line-height: 1.5;
        }

        /* 商品名と価格のテキスト設定 */
        .product-info {
            padding: 5px 0;
        }
        
        .product-name {
            font-size: 16px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 8px;
            height: 44px; /* 2行分先を確保して高さを統一 */
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-name a {
            transition: color 0.2s;
        }
        .product-name a:hover {
            color: #4a5568; /* ホバー時に少し色を薄く */
        }
        
        .product-price {
            font-size: 18px;
            font-weight: 800; /* 数字を太くして目立たせる */
            color: #1a202c;
        }
    </style>
</head>
<body>

    <div class="header-container">
        <form action="{{ url('/logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="logout-button">ログアウト</button>
        </form>

        <h1 class="site-title">ショッピングサイト</h1>

        <a href="{{ url('/cart') }}" class="cart-link">カートを見る</a>
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
                    <div class="product-price">¥ {{ number_format($product->price) }}</div>
                </div>

            </li>
        @endforeach
    </ul>

</body>
</html>