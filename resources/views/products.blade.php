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

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
        <div class="filter-form">
            <form action="{{ route('admin.products.index') }}" method="GET" id="search-form" style="display: flex; align-items: center; gap: 10px;">
                <label for="category_select" style="font-size: 14px; color: #2c3e50; font-weight: bold;">カテゴリー：</label>
                <select name="category_id" id="category_select" onchange="this.form.submit()" style="padding: 8px 12px; border: 1px solid #eaeded; border-radius: 6px; color: #2c3e50; font-size: 14px; background: #fff;">
                    <option value="">すべてのカテゴリー</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $selectedCategoryId == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <label for="sort_select" style="font-size: 14px; color: #2c3e50; font-weight: bold; margin-left: 15px;">並び順：</label>
                <select name="sort" id="sort_select" onchange="this.form.submit()" style="padding: 8px 12px; border: 1px solid #eaeded; border-radius: 6px; color: #2c3e50; font-size: 14px; background: #fff;">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>新着順</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>価格の安い順</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>価格の高い順</option>
                </select>
            </form>
        </div>

        <div class="admin-actions" style="margin-bottom: 0;">
            <a href="{{ route('admin.products.create') }}" class="btn-base btn-green">+ 新規商品を追加する</a>
            <a href="{{ route('admin.orders.index') }}" class="btn-base btn-green" style="margin-left: 10px;">📋 注文管理一覧を見る</a>
        </div>
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
                <th style="width: 30%; text-align: left; background: #f8f9fa; color: #7f8c8d; font-weight: 600; text-transform: uppercase; font-size: 13px; padding: 16px; border-bottom: 2px solid #eaeded;">商品名</th>
                <th style="width: 15%; text-align: center; background: #f8f9fa; color: #7f8c8d; font-weight: 600; text-transform: uppercase; font-size: 13px; padding: 16px; border-bottom: 2px solid #eaeded;">カテゴリー</th>
                <th style="width: 13%; text-align: right; background: #f8f9fa; color: #7f8c8d; font-weight: 600; text-transform: uppercase; font-size: 13px; padding: 16px; border-bottom: 2px solid #eaeded;">価格</th>
                <th style="width: 10%; text-align: center; background: #f8f9fa; color: #7f8c8d; font-weight: 600; text-transform: uppercase; font-size: 13px; padding: 16px; border-bottom: 2px solid #eaeded;">在庫数</th>
                <th style="width: 12%; text-align: center; background: #f8f9fa; color: #7f8c8d; font-weight: 600; text-transform: uppercase; font-size: 13px; padding: 16px; border-bottom: 2px solid #eaeded;">アクション</th>
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
                <td style="width: 30%; text-align: left; padding: 16px; vertical-align: middle; border-bottom: 1px solid #eaeded; color: #2c3e50; font-size: 15px; word-wrap: break-word; overflow-wrap: break-word;"><strong>{{ $product->name }}</strong></td>
                <td style="width: 15%; text-align: center; padding: 16px; vertical-align: middle; border-bottom: 1px solid #eaeded; color: #2c3e50; font-size: 15px; word-wrap: break-word; overflow-wrap: break-word;">
                    <span style="background: #eef2f3; padding: 4px 8px; border-radius: 4px; font-size: 13px; font-weight: 600; color: #7f8c8d;">
                        {{ $product->category_name ?? '未設定' }}
                    </span>
                </td>
                <td style="width: 13%; text-align: right; padding: 16px; vertical-align: middle; border-bottom: 1px solid #eaeded; color: #2c3e50; font-size: 15px; word-wrap: break-word; overflow-wrap: break-word;">¥{{ number_format($product->price) }}</td>
                <td style="width: 10%; text-align: center; padding: 16px; vertical-align: middle; border-bottom: 1px solid #eaeded; color: #2c3e50; font-size: 15px; word-wrap: break-word; overflow-wrap: break-word;">{{ $product->stock }} 個</td>
                <td style="width: 12%; text-align: center; padding: 16px; vertical-align: middle; border-bottom: 1px solid #eaeded; color: #2c3e50; font-size: 15px; word-wrap: break-word; overflow-wrap: break-word;">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-base btn-navy btn-sm">編集する</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>