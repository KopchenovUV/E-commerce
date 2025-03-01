@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="animateanimated animatefadeInDown">Ваш профиль</h1>
        <div class="card animateanimated animatefadeIn">
            <div class="card-body">
                <p><strong>Имя пользователя:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>ФИО:</strong> {{ $user->full_name ?? 'Не указано' }}</p>
                <p><strong>Дата рождения:</strong> {{ $user->birth_date ? $user->birth_date->format('d.m.Y') : 'Не указано' }}</p>
                <p><strong>Пол:</strong> {{ $user->gender ? ucfirst($user->gender) : 'Не указано' }}</p>
                <p><strong>Телефон:</strong> {{ $user->phone ?? 'Не указано' }}</p>
                <a href="{{ route('profile.edit') }}" class="btn btn-primary"><i class="fas fa-edit me-1"></i>Редактировать</a>
            </div>
        </div>
    </div>
@endsection