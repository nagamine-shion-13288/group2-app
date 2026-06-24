<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ログイン</title>

    @vite('resources/css/pages/shopManagerLogin.css')
</head>
<body>

<div class="container">
    <div class="card">

        <h1>管理者ログイン</h1>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error-message">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('shopManager.login.post') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="login_id">ログインID</label>
                <input
                    type="text"
                    id="login_id"
                    name="login_id"
                    value="{{ old('login_id') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >
            </div>

            <button type="submit">
                ログイン
            </button>
        </form>
    <div class="link-area">
    <a href="{{ route('shopManager.add') }}">
        管理者アカウントを新規登録する
    </a>
    </div>
    </div>
</div>

</body>
</html>