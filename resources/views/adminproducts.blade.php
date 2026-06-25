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
                <label for="category_select" style="font-size: 14px; color: #2c3e50; font-weight: bold;">カテゴリーで絞り込む：</label>
                <select name="category_id" id="category_select" onchange="this.form.submit()" style="padding: 8px 12px; border: 1px solid #eaeded; border-radius: 6px; color: #2c3e50; font-size: 14px; background: #fff;">
                    <option value="">すべてのカテゴリー</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $selectedCategoryId == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                
            </form>
        </div>

        <div class="admin-actions" style="margin-bottom: 0; display: flex; align-items: center; gap: 20px;">
    <a href="{{ route('admin.products.create') }}" class="btn-base btn-green">+ 新規商品を追加する</a>
    
    <a href="{{ route('admin.orders.index') }}" class="btn-base btn-green">📋 注文管理一覧を見る</a>
    
    <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0; display: flex; align-items: center;">
        @csrf
        <button type="submit" class="btn-base" style="background: linear-gradient(135deg, #e74c3c, #c0392b); color: #ffffff; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(231, 76, 60, 0.2);">
            🚪 ログアウト
        </button>
    </form>
</div>
        </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th class="col-id">ID</th>
                <th class="col-img">画像</th>
                <th class="col-name">商品名</th>
                <th class="col-category">カテゴリー</th>
                <th class="col-price">価格</th>
                <th class="col-stock">在庫数</th>
                <th class="col-action">アクション</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td class="col-id">{{ $product->id }}</td>
                <td class="col-img">
                    @if($product->pictureUrl)
                        <img src="{{ asset($product->pictureUrl) }}" class="product-img">
                    @else
                        <div class="product-img" style="font-size: 12px; font-weight: bold; color: #7f8c8d; margin: 0 auto;">
                            なし
                        </div>
                    @endif
                </td>
                <td class="col-name"><strong>{{ $product->name }}</strong></td>
                <td class="col-category">
                    <span style="background: #eef2f3; padding: 4px 8px; border-radius: 4px; font-size: 13px; font-weight: 600; color: #7f8c8d;">
                        {{ $product->category_name ?? '未設定' }}
                    </span>
                </td>
                <td class="col-price">¥{{ number_format($product->price) }}</td>
                <td class="col-stock">{{ $product->stock }} 個</td>
                <td class="col-action">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-base btn-navy btn-sm">編集する</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>