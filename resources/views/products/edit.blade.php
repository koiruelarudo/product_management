@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    商品編集
                </div>
                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">商品名</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}">
                        </div>
                        <div class="form-group">
                            <label for="price">価格</label>
                            <input type="text" name="price" id="price" class="form-control" value="{{ $product->price }}">
                        </div>
                        <div class="form-group">
                            <label for="description">説明</label>
                            <textarea name="description" id="description" class="form-control">{{ $product->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="category_id">カテゴリ</label>
                            <select name="category_id" id="category_id" class="form-control">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">更新する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
