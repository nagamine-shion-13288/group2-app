<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ショッピングサイト</title>
    <link rel="icon" type="image/png" href="{{ asset('D.png?v=1') }}">

    @vite(['resources/css/app.css'])
</head>

<body class="product-list-page">

    @include('layouts.header')

    <div class="product-list-page">
        <main class="main-content">
            
            <div class="marquee-container">
                <div id="marquee-wrap" style="display:flex; white-space:nowrap;">
                    <span id="marquee-track" style="display:inline-block; font-size:14px; font-weight:bold; color:#fff;">
                        　🎉 配送料無料キャンペーン実施中！ 🌿　&nbsp;&nbsp;&nbsp;　🐱 毎日新しい子が入荷中！ 🐶　&nbsp;&nbsp;&nbsp;　🐩 冷やし中華はじめました！ 😼　&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                </div>
            </div>

            <script>
            (function() {
                const wrap = document.getElementById('marquee-wrap');
                const track = document.getElementById('marquee-track');

                for (let i = 0; i < 5; i++) {
                    const clone = track.cloneNode(true);
                    clone.removeAttribute('id');
                    wrap.appendChild(clone);
                }

                let pos = 0;
                const speed = 1.0;
                const unit = track.offsetWidth;

                function animate() {
                    pos -= speed;
                    if (Math.abs(pos) >= unit) {
                        pos += unit;
                    }
                    wrap.style.transform = `translateX(${pos}px)`;
                    requestAnimationFrame(animate);
                }
                requestAnimationFrame(animate);
            })();
            </script>

            <div class="filter-form">
                <form action="{{ url('/products') }}" method="GET" id="search-form">
                    @if(request('keyword'))
                        <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                    @endif

                    <label for="category_select">カテゴリーで絞り込む：</label>
                    <select name="category_id" id="category_select" onchange="this.form.submit()">
                        <option value="">すべてのカテゴリー</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $selectedCategoryId == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <label for="sort_select" style="margin-left: 20px;">並び順：</label>
                    <select name="sort" id="sort_select" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>新着順</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>価格の安い順</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>価格の高い順</option>
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

            <div class="pagination-wrapper">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>

        </main>
    </div>

</body>
</html>