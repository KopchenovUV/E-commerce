@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редактировать товар</h1>
        <form method="POST" action="{{ route('admin.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Название</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="price">Цена</label>
                <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Описание</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="categories">Категории</label>
                <select name="categories[]" id="categories" class="form-control @error('categories') is-invalid @enderror" multiple>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->categories->pluck('id')->contains($category->id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('categories')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="image">Изображение</label>
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" width="100" alt="{{ $product->name }}" class="mb-2">
                @endif
                <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Обновить</button>
            <a href="{{ route('admin.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection