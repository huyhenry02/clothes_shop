<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return view('admin.pages.product.edit', [
            'mode' => 'create',
            'product' => null,
        ]);
    }

    public function showEdit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.pages.product.edit', [
            'mode' => 'edit',
            'product' => $product,
        ]);
    }
}
