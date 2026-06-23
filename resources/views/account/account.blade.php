<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント管理</title>
    
    @vite(['resources/css/app.css'])
</head>
<body>

@include('layouts.header')

<div class="account-page">
    <div class="account-container">

        <h1 class="account-title">アカウント管理</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($account)
            <div class="account-field">
                <span class="account-field__label">現在の名前</span>
                <span class="account-field__value">{{ $account->name }}</span>
            </div>

            <div class="account-field">
                <span class="account-field__label">現在のパスワード</span>
                <span class="account-field__value">********</span>
            </div>

            <div class="account-field">
                <span class="account-field__label">現在の住所</span>
                <span class="account-field__value">{{ $account->address }}</span>
            </div>

            <div class="account-field">
                <span class="account-field__label">現在の電話番号</span>
                <span class="account-field__value">{{ $account->user_phone ?? '未登録' }}</span>
            </div>

            <a href="{{ route('account.edit') }}" class="btn-edit">編集する</a>
        @else
            <p>アカウント情報が見つかりませんでした。</p>
        @endif

    </div>
</div>
</body>
</html>