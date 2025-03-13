@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center animateanimated animatefadeInDown">Интернет-магазин техники</h1>

        
        <!-- Поиск -->
        <form method="GET" action="{{ route('home') }}" class="mb-4 animateanimated animatefadeIn">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Поиск товаров..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Найти</button>
            </div>
        </form>

        <!-- Баннер -->
        <div class="swiper banner-swiper mb-4">
            <div class="swiper-wrapper">
                <!-- Вставьте фото баннеров сюда -->
                <div class="swiper-slide"><img src="{{ asset('images/banner1.png') }}" alt="Баннер 1" style="width: 100%; height: auto;"></div>
                <div class="swiper-slide"><img src="{{ asset('images/banner2.png') }}" alt="Баннер 2" style="width: 100%; height: auto;"></div>
                <div class="swiper-slide"><img src="{{ asset('images/banner3.png') }}" alt="Баннер 3" style="width: 100%; height: auto;"></div>
            </div>
        </div>

        <!-- Секция категорий -->
        <div class="categories-section mb-5">
            <h2 class="text-center animateanimated animatefadeIn">Наши категории</h2>
            <p class="text-center animateanimated animatefadeIn mb-4">Широкий ассортимент техники для любых нужд. Выбирайте и покупайте!</p>
            <div class="row g-0">
                <!-- Электроника -->
                <div class="col-md-4 category-item">
                    <a href="{{ route('categories.index', 1) }}" class="text-decoration-none text-dark">
                        <i class="fas fa-plug fa-2x mb-2 d-block mx-auto"></i>
                        <p class="text-center">Электроника</p>
                    </a>
                </div>
                <!-- Смартфоны -->
                <div class="col-md-4 category-item">
                    <a href="{{ route('categories.index', 2) }}" class="text-decoration-none text-dark">
                        <i class="fas fa-mobile-alt fa-2x mb-2 d-block mx-auto"></i>
                        <p class="text-center">Смартфоны</p>
                    </a>
                </div>
                <!-- Ноутбуки -->
                <div class="col-md-4 category-item">
                    <a href="{{ route('categories.index', 3) }}" class="text-decoration-none text-dark">
                        <i class="fas fa-laptop fa-2x mb-2 d-block mx-auto"></i>
                        <p class="text-center">Ноутбуки</p>
                    </a>
                </div>

                <!-- Разделитель -->
                <div class="w-100 border-bottom border-gray"></div>

                <!-- Планшеты -->
                <div class="col-md-4 category-item">
                    <a href="{{ route('categories.index', 4) }}" class="text-decoration-none text-dark">
                        <i class="fas fa-tablet-alt fa-2x mb-2 d-block mx-auto"></i>
                        <p class="text-center">Планшеты</p>
                    </a>
                </div>
                <!-- Аксессуары -->
                <div class="col-md-4 category-item">
                    <a href="{{ route('categories.index', 5) }}" class="text-decoration-none text-dark">
                        <i class="fas fa-headphones fa-2x mb-2 d-block mx-auto"></i>
                        <p class="text-center">Аксессуары</p>
                    </a>
                </div>
                <!-- Телевизоры -->
                <div class="col-md-4 category-item">
                    <a href="{{ route('categories.index', 6) }}" class="text-decoration-none text-dark">
                        <i class="fas fa-tv fa-2x mb-2 d-block mx-auto"></i>
                        <p class="text-center">Телевизоры</p>
                    </a>
                </div>
                <!-- Разделитель -->
                <div class="w-100 border-bottom border-gray"></div>

                <!-- Аудиотехника -->
                <div class="col-md-4 category-item">
                    <a href="{{ route('categories.index', 7) }}" class="text-decoration-none text-dark">
                        <i class="fas fa-volume-up fa-2x mb-2 d-block mx-auto"></i>
                        <p class="text-center">Аудиотехника</p>
                    </a>
                </div>
                <!-- Игровые консоли -->
                <div class="col-md-4 category-item">
                    <a href="{{ route('categories.index', 8) }}" class="text-decoration-none text-dark">
                        <i class="fas fa-gamepad fa-2x mb-2 d-block mx-auto"></i>
                        <p class="text-center">Игровые консоли</p>
                    </a>
                </div>
                <!-- Бытовая техника -->
                <div class="col-md-4 category-item">
                    <a href="{{ route('categories.index', 9) }}" class="text-decoration-none text-dark">
                        <i class="fas fa-blender fa-2x mb-2 d-block mx-auto"></i>
                        <p class="text-center">Бытовая техника</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Товары -->
        @if ($products->isEmpty())
            <p class="animateanimated animatefadeIn">Товаров пока нет.</p>
        @else
            <div class="swiper products-swiper">
                <div class="swiper-wrapper">
                    @foreach ($products as $product)
                        <div class="swiper-slide">
                            <div class="card mb-4 animateanimated animatefadeInUp" style="animation-delay: {{ $loop->iteration * 0.1 }}s;">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                                @else
                                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Нет изображения">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text"><i class="fas fa-ruble-sign me-1"></i>{{ $product->price }}</p>
                                    <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary"><i class="fas fa-eye me-1"></i>Подробнее</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-pagination products-pagination"></div>
            </div>
        @endif
    </div>

    <!-- Подключение Swiper.js -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script>
        // Баннер
        const bannerSwiper = new Swiper('.banner-swiper', {
            autoplay: {
                delay: 5000, // 5 секунд
                disableOnInteraction: false,
            },
            speed: 1000, // Плавность переключения (1 секунда)
            effect: 'fade', // Эффект затухания для плавности
        });

        // Товары
        const productsSwiper = new Swiper('.products-swiper', {
            slidesPerView: 3,
            spaceBetween: 20,
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.products-pagination',
                type: 'bullets',
                clickable: true,
                dynamicBullets: true,
                dynamicMainBullets: 5, // Максимум 5 точек
            },
            breakpoints: {
                320: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
            },
        });
    </script>

    <style>
        /* Стилизация под цвета проекта */
        .products-pagination .swiper-pagination-bullet {
            background: #2C3E50 !important;
            opacity: 0.5;
        }
        .products-pagination .swiper-pagination-bullet-active {
            opacity: 1;
            background: #2C3E50 !important;
        }
        .swiper-button-next, .swiper-button-prev {
            color: #2C3E50 !important;
        }
        .swiper-slide .card {
            width: 100%;
            margin: 0 auto;
        }
        .banner-swiper {
            margin-bottom: 40px;
        }
        .swiper-slide {
            transition: opacity 0.5s ease;
        }

        /* Стили для категорий */
        .categories-section {
            padding: 20px 0;
        }
        .category-item {
            padding: 20px;
            text-align: center;
        }
        .category-item a:hover {
            color: #2C3E50;
            text-decoration: none;
        }
        .border-gray {
            border-color: #d3d3d3; /* Серый невзрачный цвет для разделителей */
            margin: 0;
        }
    </style>
@endsection