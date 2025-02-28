@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Корзина</h1>
        @if ($cartItems->isEmpty())
            <p>Ваша корзина пуста.</p>
            <a href="{{ route('home') }}" class="btn btn-secondary">Вернуться к покупкам</a>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Товар</th>
                        <th>Цена</th>
                        <th>Количество</th>
                        <th>Итого</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>
                                <a href="{{ route('product.show', $item->product->id) }}">{{ $item->product->name }}</a>
                            </td>
                            <td>{{ $item->product->price }} руб.</td>
                            <td>
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control d-inline" style="width: 80px;">
                                    <button type="submit" class="btn btn-sm btn-primary">Обновить</button>
                                </form>
                            </td>
                            <td>{{ $item->product->price * $item->quantity }} руб.</td>
                            <td>
                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить товар из корзины?')">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                <a href="{{ route('home') }}" class="btn btn-secondary">Продолжить покупки</a>
                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Очистить корзину?')">Очистить корзину</button>
                </form>
            </div>
        @endif
    </div>
@endsection