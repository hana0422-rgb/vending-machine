<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>自動販売機管理システム</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> {{-- ← これを追加 --}}
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container">
        {{-- <a class="navbar-brand" href="{{ route('products.index') }}">Vending Machine</a> --}}
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav">

                {{-- 📦 商品関連 --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">商品一覧</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.create') }}">商品登録</a>
                </li>

                {{-- 💰 売上関連（非表示） --}}
                {{--
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sales.index') }}">売上一覧</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sales.create') }}">売上登録</a>
                </li>
                --}}

                {{-- 🔐 認証関連（非表示） --}}
                {{--
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login.form') }}">ログイン</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register.form') }}">新規登録</a>
                    </li>
                @else
                    <li class="nav-item">
                        <span class="nav-link">{{ Auth::user()->name }} さん</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link" style="display:inline; padding:0;">ログアウト</button>
                        </form>
                    </li>
                @endguest
                --}}

            </ul>
        </div>
    </div>
</nav>

<main class="container">
    @yield('content')
</main>
</body>
</html>
