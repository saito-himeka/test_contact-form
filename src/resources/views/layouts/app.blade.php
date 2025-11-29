<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>test_contact-form</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    <!-- layout.app内のどこか (例: <head>内) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    

    @yield('css')
</head>
    <!-- layout.app内の</body>直前 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<body>
    <header>
    <div class="header-title">FashionablyLate</div>
    
    <div class="header-right-area">
        <!-- 💡 ここで現在のルート名や認証状態をチェックしてボタンを切り替える -->
        
        @if (Request::routeIs('login')) 
            <!-- ログインページの場合: 会員登録ボタンを表示 -->
            <a href="{{ route('register') }}" class="header-btn">register</a>
            
        @elseif (Request::routeIs('register')) 
            <!-- 会員登録ページの場合: ログインボタンを表示 -->
            <a href="{{ route('login') }}" class="header-btn">login</a>
            
        @elseif (Request::routeIs('admin.index')) 
            <!-- 管理者ページの場合: ログアウトボタンを表示 -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">logout</button>
            </form>
            
        @else 
            <!-- お問い合わせページなど、その他のページではボタンを非表示 (または別のボタンを表示) -->
            <div style="width: 80px;"></div> <!-- レイアウトを保つための調整 -->
            
        @endif
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>
