@extends('layouts.app')

@section('title', 'Product List')

@section('content')
<div class="container">
    <h1 class="mb-4">商品管理</h1>
    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">商品登録</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品名</th>
                <th>価格</th>
                <th>説明</th>
                <th>分類</th>
                <th>編集/削除</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">編集</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
