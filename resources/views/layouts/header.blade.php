<header class="site-header">
    <div class="header-left">
        <h1 class="site-title">
            <a href="{{ url('/products') }}"><img src="{{ asset('images/header/JUN.png') }}" alt="JUNGLIA" class="logo-image"></a>
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

    <div class="header-nav">
        @if (session()->has('userId'))
            <form action="{{ route('logout') }}"
                  method="POST"
                  class="logout-form"
                  onsubmit="return confirm('ログアウトしますか？')">
                @csrf
                <button type="submit" class="logout-button">
                    ログアウト
                </button>
            </form>
        @endif

        <a href="{{ url('/cart') }}">
            カート🛒
        </a>
    </div>
</header>

<button class="hamburger-btn" id="menu-btn">
    <span></span>
    <span></span>
    <span></span>
</button>

<div class="menu-overlay" id="menu-overlay"></div>

<nav class="sidebar-menu" id="sidebar-menu">
    <ul>
        <li><a href="{{ url('/cart') }}" class="menu-link-btn">カート🛒</a></li>

        @if (session()->has('userId'))
            <li><a href="{{ route('order.history') }}" class="menu-link-btn">注文履歴</a></li>
            <li><a href="{{ url('/account') }}" class="menu-link-btn">アカウント情報</a></li>
            <li>
                <form action="{{ route('logout') }}"
                      method="POST"
                      class="logout-form"
                      onsubmit="return confirm('ログアウトしますか？')">
                    @csrf
                    <button type="submit" class="menu-link-btn">
                        ログアウト
                    </button>
                </form>
            </li>
        @else
            <li><a href="{{ route('login') }}" class="menu-link-btn">ログイン</a></li>
        @endif
    </ul>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('menu-btn');
    const sidebarMenu = document.getElementById('sidebar-menu');
    const menuOverlay = document.getElementById('menu-overlay');

    function toggleMenu() {
        menuBtn.classList.toggle('open');
        sidebarMenu.classList.toggle('open');
        menuOverlay.classList.toggle('open');
    }

    if (menuBtn && sidebarMenu && menuOverlay) {
        menuBtn.addEventListener('click', toggleMenu);
        menuOverlay.addEventListener('click', toggleMenu);
    }
});
</script>