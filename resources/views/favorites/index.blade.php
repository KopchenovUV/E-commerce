@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="animateanimated animatefadeInDown">Избранное</h1>
        @if ($favorite->isEmpty())
            <p class="animateanimated animatefadeIn">Ваш список избранного пуст.</p>
            <a href="{{ route('home') }}" class="btn btn-secondary animateanimated animatefadeIn" style="animation-delay: 0.2s;"><i class="fas fa-shopping-bag me-1"></i>Вернуться к покупкам</a>
        @else
            <div class="row">
                @foreach ($favorite as $favorite)
                    <div class="col-md-4">
                        <div class="card mb-4 animateanimated animatefadeInUp" style="animation-delay: {{ $loop->iteration * 0.1 }}s;">
                            @if ($favorite->product->image)
                                <img src="{{ asset('storage/' . $favorite->product->image) }}" class="card-img-top" alt="{{ $favorite->product->name }}">
                            @else
                                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Нет изображения">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $favorite->product->name }}</h5>
                                <p class="card-text"><i class="fas fa-ruble-sign me-1"></i>{{ $favorite->product->price }}</p>
                                <a href="{{ route('product.show', $favorite->product->id) }}" class="btn btn-primary"><i class="fas fa-eye me-1"></i>Подробнее</a>
                                <form action="{{ route('favorite.remove', $favorite->product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить из избранного?')"><i class="fas fa-trash me-1"></i>Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-3">
                <a href="{{ route('home') }}" class="btn btn-secondary"><i class="fas fa-shopping-bag me-1"></i>Продолжить покупки</a>
                <form action="{{ route('favorites.clear') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Очистить избранное?')"><i class="fas fa-trash-alt me-1"></i>Очистить избранное</button>
                </form>
            </div>
        @endif
    </div>
@endsection