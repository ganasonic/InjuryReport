<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('asset/js/bootstrap.bundle.min.js') }}"></script>
    <link href="{{ asset('css/gana.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        @if(false)
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        @else
        <nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #e3f2fd;">
        @endif
            @if(false)
            <div class="container">
            @else
            <div class="container">
            @endif

                <!-- ナビゲーションバーのタイトル -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/images/favicon.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <!-- ナビゲーションバーのタイトル -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse text-end" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">{{ __('ホーム') }}</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (false)
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                            @endif
                        @else
                                <!-- ドロップダウンメニュー　※Bootstrap5ではdata-toggleはdata-bs-toggleに変更 -->
                                <li class="dropdown">
                                    <a class="btn btn-success dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ Auth::user()->name }} 
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="/profile">プロフィール</a></li>
                                        <li><a class="dropdown-item" href="/password/reset">パスワード変更</a></li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
