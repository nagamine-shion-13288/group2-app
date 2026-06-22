<style>
.site-header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 70px;
    z-index: 1000;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 40px;
    background-color: #06f32d;
    border-bottom: 1px solid #dddddd;
    box-sizing: border-box;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-left: 50px;
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
    align-items: center;
    margin: 0 40px;
    gap: 8px;
}

.search-box {
    width: 300px;
    padding: 8px 12px;
    border: 1px solid #cccccc;
    border-radius: 5px;
}

.search-button {
    background-color: #333333;
    color: #ffffff;
    border: none;
    padding: 8px 16px;
    font-size: 14px;
    border-radius: 5px;
    cursor: pointer;
}

.header-nav {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-right: 40px;
}

.header-nav a {
    text-decoration: none;
    color: #333333;
    font-weight: bold;
}

.logout-form {
    margin: 0;
}

.logout-button {
    background: none;
    border: none;
    padding: 0;
    color: red;
    font-size: 16px;
    font-weight: bold;
    font-family: inherit;
    cursor: pointer;
}

.logout-button:hover,
.header-nav a:hover {
    text-decoration: underline;
}

/* ここからハンバーガーメニュー用 */
.hamburger-btn {
    position: fixed;
    top: 22px;
    left: 20px;
    z-index: 2000;
    width: 30px;
    height: 22px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
}

.hamburger-btn span {
    display: block;
    width: 100%;
    height: 3px;
    background-color: #333;
    border-radius: 2px;
    transition: transform 0.3s, opacity 0.3s;
}

.hamburger-btn.open span:nth-child(1) {
    transform: translateY(9px) rotate(45deg);
}

.hamburger-btn.open span:nth-child(2) {
    opacity: 0;
}

.hamburger-btn.open span:nth-child(3) {
    transform: translateY(-10px) rotate(-45deg);
}

.sidebar-menu {
    position: fixed;
    top: 0;
    left: -260px;
    width: 260px;
    height: 100%;
    background-color: #fff;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    z-index: 1900;
    transition: left 0.3s ease;
    padding-top: 80px;
    box-sizing: border-box;
}

.sidebar-menu.open {
    left: 0;
}

.sidebar-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-menu li {
    border-bottom: 1px solid #edf2f7;
}

.sidebar-menu li a,
.sidebar-menu li button {
    display: block;
    width: 100%;
    padding: 15px 25px;
    color: #333;
    text-decoration: none;
    font-size: 16px;
    font-weight: bold;
    text-align: left;
    background: none;
    border: none;
    box-sizing: border-box;
    cursor: pointer;
    font-family: inherit;
}

.sidebar-menu li a:hover,
.sidebar-menu li button:hover {
    background-color: #f7fafc;
}

.menu-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.4);
    z-index: 1800;
    display: none;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.menu-overlay.open {
    display: block;
    opacity: 1;
}
</style>

<header class="site-header">
    <div class="header-left">
        <h1 class="site-title">
            <a href="{{ url('/products') }}">JUNGLIA</a>
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
        <li><a href="{{ url('/cart') }}">カート🛒</a></li>

        @if (session()->has('userId'))
            <li><a href="{{ route('order.history') }}">注文履歴</a></li>
            <li><a href="{{ url('/account') }}">アカウント情報</a></li>
            <li>
                <form action="{{ route('logout') }}"
                      method="POST"
                      class="logout-form"
                      onsubmit="return confirm('ログアウトしますか？')">
                    @csrf
                    <button type="submit" class="logout-button">
                        ログアウト
                    </button>
                </form>
            </li>
        @else
            <li><a href="{{ route('login') }}">ログイン</a></li>
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