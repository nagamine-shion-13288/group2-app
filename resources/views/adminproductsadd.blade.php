<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者用商品追加画面</title>
    @vite('resources/css/pages/adminproductsadd.css')
</head>
<body>

<div class="admin-container">
    <h2 class="page-title">商品新規登録</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="product-form">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">商品名</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required placeholder="例: シバ犬">
        </div>

        <div class="form-group">
            <label for="category_id" class="form-label">カテゴリー</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">カテゴリーを選択してください</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="price" class="form-label">価格 (円)</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" min="0" required placeholder="例: 85000">
        </div>

        <div class="form-group">
            <label for="stock" class="form-label">在庫数</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock') }}" min="0" required placeholder="例: 10">
        </div>

        <div class="form-group">
            <label for="description" class="form-label">商品説明</label>
            <textarea name="description" id="description" class="form-control rows-5" placeholder="商品の詳しい説明を入力してください">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="product_image" class="form-label">商品画像 <span class="badge-optional">(任意)</span></label>
            <input type="file" name="product_image" id="product_image" class="form-file" accept="image/*">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-submit">新しい商品を登録する</button>
        </div>
    </form>

    <div class="footer-links">
        <a href="{{ route('admin.products.index') }}" class="back-link">← 商品一覧に戻る</a>
    </div>
</div>

</body>
</html>