<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'TechShop') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div id="app">
        <!-- Навигация -->
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}"><i class="fas fa-store me-2"></i>TechShop</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item {{ Route::is('home') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Главная</a>
                        </li>
                        <li class="nav-item {{ Route::is('categories.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('categories.index') }}"><i class="fas fa-list me-1"></i>Категории</a>
                        </li>
                        <li class="nav-item {{ Route::is('cart.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('cart.index') }}"><i class="fas fa-shopping-cart me-1"></i>Корзина</a>
                        </li>
                        @auth
                            <li class="nav-item {{ Route::is('favorites.index') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('favorites.index') }}"><i class="fas fa-heart me-1"></i>Избранное</a>
                            </li>
                        @endauth
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        @auth
                            <li class="nav-item {{ Route::is('profile.show') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('profile.show') }}"><i class="fas fa-user me-1"></i>{{ auth()->user()->name }}</a>
                            </li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="nav-link btn btn-link"><i class="fas fa-sign-out-alt me-1"></i>Выйти</button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item {{ Route::is('login') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i>Войти</a>
                            </li>
                            <li class="nav-item {{ Route::is('register') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus me-1"></i>Регистрация</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Сообщения -->
        @if (session('success'))
            <div class="alert alert-success container animateanimated animatefadeIn">
{{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger container animateanimated animatefadeIn">
                {{ session('error') }}
            </div>
        @endif

        <!-- Контент -->
        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>

        <!-- Футер -->
        <footer class="bg-dark text-light py-4 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h5><i class="fas fa-store me-2"></i>TechShop</h5>
                        <p>Ваш надёжный магазин техники.</p>
                    </div>
                    <div class="col-md-4">
                        <h5><i class="fas fa-link me-2"></i>Ссылки</h5>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('home') }}" class="text-light"><i class="fas fa-home me-2"></i>Главная</a></li>
                            <li><a href="{{ route('categories.index') }}" class="text-light"><i class="fas fa-list me-2"></i>Категории</a></li>
                            <li><a href="{{ route('cart.index') }}" class="text-light"><i class="fas fa-shopping-cart me-2"></i>Корзина</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5><i class="fas fa-envelope me-2"></i>Контакты</h5>
                        <p>Email: support@techshop.com</p>
                        <p>Телефон: +7 (999) 123-45-67</p>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <p>© {{ date('Y') }} TechShop. Все права защищены.</p>
                </div>
            </div>
        </footer>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>