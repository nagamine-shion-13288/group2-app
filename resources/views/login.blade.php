<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>

    @vite(['resources/css/app.css', 'resources/css/pages/login.css'])
    <link rel="icon" type="image/png" href="{{ asset('D.png?v=1') }}">
</head>
<body>
    <div class="login-page">
        <div class="container">
            <div class="card">

                <div class="brand">
                    <h1>ログイン</h1>
                </div>

                @if (session('success'))
                    <div class="success-box">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="error-box">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="field">
                        <label for="id">🌿 ID</label>
                        <input type="text" id="id" name="id" value="{{ old('id') }}" placeholder="IDを入力">
                    </div>

                    <div class="field">
                        <label for="password">🌿 パスワード</label>
                        <input type="password" id="password" name="password" placeholder="パスワードを入力">
                    </div>

                    <button type="submit" class="btn-login">ログイン</button>
                </form>

                <div class="link-area">
                    <a href="/login/add">新規登録はこちら</a>
                </div>

            </div>
        </div>
    </div>
</body>
</html>