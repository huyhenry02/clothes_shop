<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function showIndex()
    {
        $categories = Category::all();
        return view('admin.pages.category.index', [
            'categories' => $categories
        ]);
    }
    public function showCreate()
    {
        return view('admin.pages.category.edit', [
            'mode' => 'create',
            'category' => null,
        ]);
    }

    public function showEdit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.pages.category.edit', [
            'mode' => 'edit',
            'category' => $category,
        ]);
    }
}
