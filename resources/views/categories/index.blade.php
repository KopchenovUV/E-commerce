@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="animateanimated animatefadeInDown">Категории товаров</h1>

        <!-- Поиск -->
        <form method="GET" action="{{ route('categories.index') }}" class="mb-4 animateanimated animatefadeIn">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Поиск товаров..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Найти</button>
            </div>
        </form>

        <!-- Фильтр -->
        <form method="GET" action="{{ route('categories.index') }}" class="mb-4 animateanimated animatefadeIn" style="animation-delay: 0.2s;">
            <div class="row">
                <div class="col-md-4">
                    <label for="category_id">Категория:</label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="">Все категории</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="max_price">Макс. цена:</label>
                    <input type="number" name="max_price" id="max_price" class="form-control" value="{{ request('max_price') }}" placeholder="Введите цену">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary mt-4"><i class="fas fa-filter me-1"></i>Фильтровать</button>
                </div>
            </div>
        </form>

        <!-- Товары -->
        <div class="row">
            @forelse ($products as $product)
                <div class="col-md-4">
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
            @empty
                <p class="animateanimated animatefadeIn">Товаров не найдено.</p>
            @endforelse
        </div>

        <!-- Пагинация -->
        @if ($products->lastPage() > 1)
            <div class="swiper category-pagination mt-4">
                <div class="swiper-wrapper">
                    @for ($i = 1; $i <= $products->lastPage(); $i++)
                        <div class="swiper-slide">
                            <a href="{{ $products->appends(request()->query())->url($i) }}" class="page-link {{ $products->currentPage() == $i ? 'active' : '' }}">{{ $i }}</a>
                        </div>
                    @endfor
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-pagination category-bullets"></div>
            </div>
        @endif
    </div>
<!-- Подключение Swiper.js -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script>
        const categorySwiper = new Swiper('.category-pagination', {
            slidesPerView: 'auto',
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.category-bullets',
                type: 'bullets',
                clickable: true,
            },
        });
    </script>

<style>
    /* Стилизация под цвета проекта (#2C3E50) */
    .category-bullets .swiper-pagination-bullet {
        background: #2C3E50 !important;
        opacity: 0.5;
    }
    .category-bullets .swiper-pagination-bullet-active {
        opacity: 1;
        background: #2C3E50 !important;
    }
    .swiper-button-next, .swiper-button-prev {
        color: #2C3E50 !important;
    }
    .category-pagination {
        display: flex;
        justify-content: center; /* Центрирование всего блока пагинации */
        align-items: center;
    }
    .category-pagination .swiper-wrapper {
        display: flex;
        justify-content: center; /* Центрирование номеров страниц внутри слайдера */
    }
    .category-pagination .swiper-slide {
        width: auto;
    }
    .page-link {
        display: block;
        padding: 5px 10px;
        text-decoration: none;
        color: #2C3E50;
    }
    .page-link.active {
        background: #2C3E50;
        color: white;
        border-radius: 5px;
    }
</style>
@endsection