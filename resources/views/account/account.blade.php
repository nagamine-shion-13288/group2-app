<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント管理</title>
    <style>
        body { font-family: sans-serif; }

        .account-container {
            max-width: 720px;
            margin: 0 auto;
            padding: 24px 16px;
        }
        .account-user { font-size: 14px; color: #555; margin-bottom: 4px; }
        .account-title { font-size: 22px; font-weight: bold; text-decoration: underline; text-align: center; margin-bottom: 24px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; padding: 10px 14px; margin-bottom: 16px; font-size: 14px; }

        .account-field { display: flex; align-items: center; gap: 16px; padding: 14px 0; border-bottom: 1px solid #e0e0e0; }
        .account-field__label { width: 160px; flex-shrink: 0; font-size: 14px; color: #333; }
        .account-field__value { flex: 1; font-size: 15px; text-decoration: underline; }

        .btn-edit {
            display: block;
            width: 240px;
            margin: 32px auto 0;
            background: #4f5fe0;
            color: #fff;
            text-align: center;
            padding: 12px;
            border-radius: 24px;
            text-decoration: none;
            font-weight: bold;
            font-size: 15px;
        }
        .btn-edit:hover { background: #3d4bc0; }

        .btn-back { display: inline-block; font-size: 13px; color: #555; text-decoration: none; margin-bottom: 12px; }
        .btn-back:hover { color: #000; }
    </style>
</head>
<body>
<div class="account-container">

    <p class="account-user">{{ $account->name ?? 'ゲスト' }}さん</p>
    <a href="javascript:history.back()" class="btn-back">戻る</a>
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
</body>
</html>