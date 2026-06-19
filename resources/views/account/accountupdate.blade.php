<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント更新</title>
    <style>
        body { font-family: sans-serif; }

        .account-container {
            max-width: 720px;
            margin: 0 auto;
            padding: 24px 16px;
        }
        .account-user { font-size: 14px; color: #555; margin-bottom: 4px; }
        .account-title { font-size: 22px; font-weight: bold; text-decoration: underline; text-align: center; margin-bottom: 24px; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; padding: 10px 14px; margin-bottom: 16px; font-size: 14px; }

        .form-field { padding: 14px 0; border-bottom: 1px solid #e0e0e0; }
        .form-field label { display: block; font-size: 14px; color: #333; margin-bottom: 6px; }
        .form-field input {
            width: 100%;
            border: none;
            border-bottom: 1px solid #aaa;
            font-size: 15px;
            padding: 4px 2px;
            outline: none;
        }
        .form-field input:focus { border-bottom: 1px solid #4f5fe0; }
        .form-hint { font-size: 12px; color: #888; margin-top: 4px; }
        .error-text { font-size: 12px; color: #c0392b; margin-top: 4px; }

        .btn-submit {
            display: block;
            width: 240px;
            margin: 32px auto 0;
            background: #4f5fe0;
            color: #fff;
            text-align: center;
            padding: 12px;
            border-radius: 24px;
            border: none;
            font-weight: bold;
            font-size: 15px;
            cursor: pointer;
        }
        .btn-submit:hover { background: #3d4bc0; }

        .btn-back { display: inline-block; font-size: 13px; color: #555; text-decoration: none; margin-bottom: 12px; }
        .btn-back:hover { color: #000; }
    </style>
</head>
<body>
<div class="account-container">

    <p class="account-user">{{ $account->name ?? 'ゲスト' }}さん</p>
    <a href="javascript:history.back()" class="btn-back">戻る</a>
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
</body>
</html>