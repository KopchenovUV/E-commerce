@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="animateanimated animatefadeInDown">{{ $product->name }}</h1>
        <div class="row">
            <div class="col-md-6">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid animateanimated animatefadeIn" alt="{{ $product->name }}">
                @else
                    <img src="https://via.placeholder.com/300" class="img-fluid animateanimated animatefadeIn" alt="Нет изображения">
                @endif
            </div>
            <div class="col-md-6">
                <p><strong>Цена:</strong> <i class="fas fa-ruble-sign me-1"></i>{{ $product->price }}</p>
                <p><strong>Категории:</strong> {{ $product->categories->pluck('name')->implode(', ') ?: 'Без категорий' }}</p>
                <p><strong>Описание:</strong> {{ $product->description ?? 'Описание отсутствует' }}</p>
                <p><strong>В корзине:</strong> {{ $cartQuantity }} шт.</p>
                
                <form method="POST" action="{{ route('cart.add', $product->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success"><i class="fas fa-cart-plus me-1"></i>Добавить в корзину</button>
                </form>
                
                @auth
                    @if (Auth::user()->favorites && Auth::user()->favorites->contains('product_id', $product->id))
                        <form method="POST" action="{{ route('favorite.remove', $product->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fas fa-heart-broken me-1"></i>Убрать из избранного</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('favorite.add', $product->id) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-warning"><i class="fas fa-heart me-1"></i>В избранное</button>
                        </form>
                    @endif
                @endauth

                <div class="mt-3">
                    <a href="{{ route('home') }}" class="btn btn-secondary"><i class="fas fa-home me-1"></i>На главную</a>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary"><i class="fas fa-list me-1"></i>К категориям</a>
                </div>
            </div>
        </div>
    </div>
@endsection