@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Админ-панель</h1>
        <a href="{{ route('admin.create') }}" class="btn btn-primary mb-3">Добавить товар</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Категории</th>
                    <th>Изображение</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }} руб.</td>
                        <td>{{ $product->categories->pluck('name')->implode(', ') }}</td>
                        <td>
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" width="50" alt="{{ $product->name }}">
                            @else
                                Нет изображения
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.edit', $product->id) }}" class="btn btn-warning btn-sm">Редактировать</a>
                            <form action="{{ route('admin.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить товар?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Товаров нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection