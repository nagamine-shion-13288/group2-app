<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規アカウント登録</title>

    @vite(['resources/css/app.css'])
    <link rel="icon" type="image/png" href="{{ asset('D.png?v=1') }}">
</head>
<body>

    <div class="account-add-page">
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
                        <input type="text" name="login_id" value="{{ old('login_id') }}" placeholder="SuperDaichi">
                    </div>

                    <div class="field">
                        <label>パスワード</label>
                        <input type="password" name="password" placeholder="password">
                    </div>

                    <div class="field">
                        <label>パスワード確認</label>
                        <input type="password" name="password_confirmation" placeholder="password">
                    </div>
                    
                    <div class="field">
                        <label>氏名</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="こばだい">
                    </div>

                    <div class="field">
                        <label>住所</label>
                        <input type="text" name="address" value="{{ old('address') }}" placeholder="東京都渋谷区神南1-19-11">
                    </div>
                    
                     <div class="field">
                        <label>メールアドレス</label>
                        <input type="text" name="email" value="{{ old('email') }}" placeholder="example@example.com">
                    </div>
                    
                    <div class="field">
                        <label>電話番号</label>
                        <input type="text" name="user_phone" value="{{ old('user_phone') }}" placeholder="090-1234-5678">
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
    </div>

</body>
</html>