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

.search-form {
    flex: 1;
    display: flex;
    justify-content: center;
    margin: 0 40px;
}

.search-box {
    width: 350px;
    padding: 8px 12px;
    border: 1px solid #cccccc;
    border-radius: 5px;
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

    <form class="search-form">
        <input
            type="text"
            class="search-box"
            placeholder="商品を検索">
    </form>

    <nav class="header-nav">

        @if (session()->has('userId'))

            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-button">
                    ログアウト
                </button>
            </form>

            <a href="{{ url('/orderhistory') }}">
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