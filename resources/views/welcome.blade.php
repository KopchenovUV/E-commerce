@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Баннер -->
        <div class="swiper banner-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="{{ asset('images/banner1.png') }}" alt="Баннер 1" style="width: 100%; height: auto;"></div>
                <div class="swiper-slide"><img src="{{ asset('images/banner2.png') }}" alt="Баннер 2" style="width: 100%; height: auto;"></div>
                <div class="swiper-slide"><img src="{{ asset('images/banner3.png') }}" alt="Баннер 3" style="width: 100%; height: auto;"></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <!-- Секция товаров -->
        <h2>Популярные товары</h2>
        <div class="swiper products-swiper">
            <div class="swiper-wrapper">
                @foreach ($products as $product)
                    <div class="swiper-slide">
                        <div class="card">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('images/placeholder.jpg') }}" class="card-img-top" alt="Нет изображения">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->price }} руб.</p>
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">Подробнее</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <script>
        // Баннер
        const bannerSwiper = new Swiper('.banner-swiper', {
            pagination: {
                el: '.swiper-pagination',
                type: 'bullets',
                clickable: true,
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
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
                el: '.swiper-pagination',
                type: 'bullets',
                clickable: true,
                dynamicBullets: true,
                dynamicMainBullets: 5, // Максимум 5 точек
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
        });
    </script>

    <style>
        /* Стилизация под цвета проекта (пример: синий #007bff) */
        .swiper-pagination-bullet {
            background: #007bff; /* Цвет точек */
            opacity: 0.5;
        }
        .swiper-pagination-bullet-active {
            opacity: 1;
            background: #007bff;
        }
        .swiper-button-next, .swiper-button-prev {
            color: #007bff; /* Цвет стрелок */
        }
        .swiper-slide .card {
            width: 100%;
            margin: 0 auto;
        }
    </style>
@endsection