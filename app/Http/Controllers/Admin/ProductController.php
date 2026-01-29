<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function showIndex()
    {
        $products = Product::all();
        return view('admin.pages.product.index', [
            'products' => $products
        ]);
    }
    public function showCreate()
    {
        $categories = Category::all();
        return view('admin.pages.product.edit', [
            'mode' => 'create',
            'product' => null,
            'categories' => $categories
        ]);
    }

    public function showEdit($id)
    {
        $categories = Category::all();
        $product = Product::findOrFail($id);
        return view('admin.pages.product.edit', [
            'mode' => 'edit',
            'product' => $product,
            'categories' => $categories
        ]);
    }

    public function showDetail($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.pages.product.detail', [
            'product' => $product,
        ]);
    }
}
