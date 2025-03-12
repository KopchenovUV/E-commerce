@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Админ-панель</h1>
        <a href="{{ route('admin.create') }}" class="btn btn-primary mb-3">Добавить товар</a>

        <h2>Товары</h2>
        <table class="table mb-5">
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

        <h2>Заявки на поддержку</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Пользователь</th>
                    <th>Проблема</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ $ticket->user->name }}</td> <!-- Здесь используется user->name -->
                        <td>{{ $ticket->problem }}</td>
                        <td>{{ $ticket->status === 'pending' ? 'На рассмотрении' : ($ticket->status === 'resolved' ? 'Решена' : 'Отклонена') }}</td>
                        <td>
                            <form action="{{ route('admin.ticket.update', $ticket->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-control d-inline w-auto" onchange="this.form.submit()">
                                    <option value="pending" {{ $ticket->status === 'pending' ? 'selected' : '' }}>На рассмотрении</option>
                                    <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Решена</option>
                                    <option value="rejected" {{ $ticket->status === 'rejected' ? 'selected' : '' }}>Отклонена</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Заявок нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection