<style>
.site-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 40px;
    background-color: #06f32d;
    border-bottom: 1px solid #dddddd;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 15px;
}

.site-title {
    margin: 0;
    font-size: 28px;
}

.site-title a {
    text-decoration: none;
    color: #333333;
    font-weight: bold;
}

.user-name {
    font-size: 15px;
    color: #333333;
}

/* 💡 既存の .search-form に gap を追加して、ボックスとボタンの間に隙間を作る */
.search-form {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center; /* 縦方向の真ん中揃え */
    margin: 0 40px;
    gap: 8px; /* 💡 ボックスとボタンの間隔 */
}

/* 💡 検索ボックスの幅を少し調整（ボタンが入るスペース確保のため） */
.search-box {
    width: 300px; /* 350pxから少し縮めました */
    padding: 8px 12px;
    border: 1px solid #cccccc;
    border-radius: 5px;
}

/* 💡 新しく追加する検索ボタンのスタイル */
.search-button {
    background-color: #333333; /* ボタンの背景色（黒系） */
    color: #ffffff; /* 文字色 */
    border: none;
    padding: 8px 16px;
    font-size: 14px;
    border-radius: 5px;
    cursor: pointer;
    white-space: nowrap; /* ボタン内の文字が改行されるのを防ぐ */
    transition: background-color 0.2s;
}

/* ボタンにマウスを乗せたときの反応 */
.search-button:hover {
    background-color: #555555; /* 少し明るいグレーに */
}

.header-nav {
    display: flex;
    align-items: center;
    gap: 20px;
}

.header-nav a {
    text-decoration: none;
    color: #333333;
}

.header-nav a:hover {
    text-decoration: underline;
}

.logout-form {
    margin: 0;
}

.logout-button {
    background: none;
    border: none;
    color: #333333;
    cursor: pointer;
    font-size: 15px;
    padding: 0;
}

.logout-button:hover {
    text-decoration: underline;
}
</style>

<header class="site-header">

    <div class="header-left">
        <h1 class="site-title">
            <a href="{{ url('/products') }}">
                JUNGLIA
            </a>
        </h1>

        @if (session()->has('userId'))
            <span class="user-name">
                {{ session('userName') }}さん
            </span>
        @endif
    </div>

<form action="{{ url('/products') }}" method="GET" class="search-form">
    <input
        type="text"
        name="keyword" 
        class="search-box"
        placeholder="商品を検索"
        value="{{ request('keyword') }}">
    
    <button type="submit" class="search-button">検索</button>
</form>

    <nav class="header-nav">

        @if (session()->has('userId'))

            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-button">
                    ログアウト
                </button>
            </form>

            <a href="{{ route('order.history') }}">
                注文履歴
            </a>

            <a href="{{ url('/account') }}">
                アカウント情報
            </a>

        @else

            <a href="{{ route('login') }}">
                ログイン
            </a>

        @endif

        <a href="{{ url('/cart') }}">
            カート🛒
        </a>

    </nav>

</header>