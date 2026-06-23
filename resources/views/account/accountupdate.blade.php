<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント更新</title>
    
    @vite(['resources/css/app.css'])
</head>
<body>

@include('layouts.header')

<div class="account-edit-page">
    <div class="account-container">

        <h1 class="account-title">アカウント管理</h1>

        @if ($errors->any())
            <div class="alert-error">
                <ul style="margin:0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($account)
            <form action="{{ route('account.update') }}" method="POST">
                @csrf

                <div class="form-field">
                    <label for="name">名前</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $account->name) }}" required>
                </div>

                <div class="form-field">
                    <label for="password">パスワード</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-field">
                    <label for="address">住所</label>
                    <input type="text" id="address" name="address" value="{{ old('address', $account->address) }}" required>
                </div>

                <div class="form-field">
                    <label for="phone">電話番号</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $account->user_phone) }}">
                </div>

                <button type="submit" class="btn-submit">編集完了</button>
            </form>
        @else
            <p>アカウント情報が見つかりませんでした。</p>
        @endif

    </div>
</div>
</body>
</html>