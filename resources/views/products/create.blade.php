@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
<div class="container">
    <h1 class="mb-4">商品登録</h1>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">商品名</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">価格</label>
            <input type="text" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">説明</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">分類</label>
            <select name="category_id" class="form-select" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">登録</button>
    </form>
    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">商品管理にもどる</a>
</div>
@endsection
