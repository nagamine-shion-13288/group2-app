<!DOCTYPE html>

<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規アカウント登録</title>

    <link rel="stylesheet" href="{{ asset('css/accountAdd.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('D.png?v=1') }}">
</head>
<body>

<div class="container">
    <div class="card">

    <div class="brand">
        <h1>新規アカウント登録</h1>
    </div>

    @if ($errors->any())
        <div class="error-box">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('account.store') }}">
        @csrf

        <div class="field">
            <label>ログインID</label>
            <input type="text" name="login_id" value="{{ old('login_id') }}">
        </div>

        <div class="field">
            <label>パスワード</label>
            <input type="password" name="password">
        </div>

        <div class="field">
            <label>パスワード確認</label>
            <input type="password" name="password_confirmation">
        </div>
        
        <div class="field">
            <label>氏名</label>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <div class="field">
            <label>住所</label>
            <input type="text" name="address" value="{{ old('address') }}">
        </div>

        <button type="submit" class="btn-register">
            登録
        </button>
    </form>

    <div class="link-area">
        <a href="/login">ログイン画面へ戻る</a>
    </div>

</div>

</div>

</body>

</html>
