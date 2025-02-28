@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="animateanimated animatefadeInDown">Интернет-магазин техники</h1>

        <!-- Поиск -->
        <form method="GET" action="{{ route('home') }}" class="mb-4 animateanimated animatefadeIn">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Поиск товаров..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Найти</button>
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
                <p class="animateanimated animatefadeIn">Товаров пока нет.</p>
            @endforelse
        </div>
    </div>
@endsection