<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ショップ管理者 新規登録</title>

    @vite('resources/css/pages/shopManagerAdd.css')
</head>
<body>

<div class="container">
    <div class="card">
        <h1>ショップ管理者登録</h1>

        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('shopManager.add.post') }}">
            @csrf

            <label>店舗</label>
            <select name="shop_id" required>
                <option value="">店舗を選択してください</option>
                @foreach ($shops as $shop)
                    <option value="{{ $shop->id }}" {{ old('shop_id') == $shop->id ? 'selected' : '' }}>
                        {{ $shop->name }}
                    </option>
                @endforeach
            </select>

            <label>ログインID</label>
            <input type="text" name="login_id" value="{{ old('login_id') }}" required>

            <label>管理者名</label>
            <input type="text" name="name" value="{{ old('name') }}" required>

            <label>パスワード</label>
            <input type="password" name="password" required>

            <button type="submit">登録する</button>
        </form>
        <div class="link-area">
            <a href="{{ route('shopManager.login') }}">
                ログイン画面へ戻る
            </a>
        </div>
    </div>
</div>

</body>
</html>