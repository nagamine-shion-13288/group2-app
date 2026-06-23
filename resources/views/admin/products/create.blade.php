<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>【テスト用】商品新規登録 - 管理画面</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 py-10">

<div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">商品新規登録（先行実装確認用）</h2>

    @if (session('status'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->has('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
            {{ $errors->first('error') }}
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">商品名 <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required>
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">カテゴリ <span class="text-red-500">*</span></label>
            <select name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required>
                <option value="">選択してください</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">価格 (円) <span class="text-red-500">*</span></label>
                <input type="number" name="price" value="{{ old('price') }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required>
                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">在庫数 <span class="text-red-500">*</span></label>
                <input type="number" name="stock" value="{{ old('stock') }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required>
                @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">商品説明</label>
            <textarea name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="border-t pt-4">
            <h3 class="text-md font-medium text-gray-900 mb-2">商品画像（任意）</h3>
            <div>
                <input type="file" name="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500">
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition font-bold">
                テスト登録を実行する
            </button>
        </div>
    </form>
</div>

</body>
</html>