<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::whereNull('deleted_at')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $product = new Product($request->all());
        $product->save();
        return redirect()->route('products.index');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // バリデーションルールの定義
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        // フォームから送られてきたデータで商品を更新
        $product->update($request->all());
    
        // 更新後に商品一覧ページにリダイレクト
        return redirect()->route('products.index')->with('success', '商品が更新されました');
    }
    
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index');
    }
}
