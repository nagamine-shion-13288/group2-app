<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者 - 商品編集</title>
    @vite('resources/css/pages/adminproductsupdate.css')
</head>
<body>

<div class="form-box">
    <h1>📝 商品データの編集 (ID: {{ $product->id }})</h1>

    @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>現在の画像</label>
            @if($product->pictureUrl)
                <img src="{{ asset($product->pictureUrl) }}" class="current-img">
            @else
                <div style="background:#ccc; width:120px; height:120px; border-radius:6px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:12px; margin-bottom:8px;">画像なし</div>
            @endif
            <label for="product_image" style="margin-top: 10px;">画像をチェンジする（新しいファイルを選択）</label>
            <input type="file" id="product_image" name="product_image" accept="image/*">
        </div>

        <div class="form-group">
            <label for="voice_file">鳴き声（ボイス）をチェンジする（MP3ファイルを選択）</label>
            <input type="file" id="voice_file" name="voice_file" accept="audio/mp3, audio/mpeg">
        </div>

        <div class="form-group">
            <label>商品名</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}">
        </div>

        <div class="form-group">
            <label>カテゴリー</label>
            <select name="category_id" class="form-control">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>価格 (¥)</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', (int)$product->price) }}">
        </div>

        <div class="form-group">
            <label>在庫数</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}">
        </div>

        <div class="form-group">
            <label>商品説明</label>
            <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>

        <div style="margin-top: 24px;">
            <button type="submit" class="btn-submit">変更をセーブする</button>
            <a href="{{ route('admin.products.index') }}" class="btn-cancel">戻る</a>
        </div>
    </form>
</div>

</body>
</html>