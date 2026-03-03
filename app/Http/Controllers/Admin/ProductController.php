<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
    public function store(Request $request): ?RedirectResponse
    {
        try {
            $data = $request->validate([
                'category_id'     => ['required', 'integer', 'exists:categories,id'],
                'code'            => ['required', 'string', 'max:100', 'unique:products,code'],
                'name'            => ['required', 'string', 'max:255'],
                'slug'            => ['nullable', 'string', 'max:255', 'unique:products,slug'],
                'description'     => ['required', 'string'],
                'price'           => ['required', 'integer', 'min:0'],
                'discount_price'  => ['nullable', 'integer', 'min:0', 'lte:price'],
                'stock_quantity'  => ['required', 'integer', 'min:0'],
                'color'           => ['nullable', 'string', 'max:50'],
                'material'        => ['nullable', 'string', 'max:100'],
                'style'           => ['nullable', 'string'],
                'is_active'       => ['required', Rule::in([0, 1, '0', '1'])],
                'image'           => ['nullable', 'image', 'max:5120'],
                'image_detail_1'  => ['nullable', 'image', 'max:5120'],
                'image_detail_2'  => ['nullable', 'image', 'max:5120'],
                'image_detail_3'  => ['nullable', 'image', 'max:5120'],
            ]);

            $data['slug'] = $this->normalizeSlug($data['slug'] ?? null, $data['name']);

            foreach (['image', 'image_detail_1', 'image_detail_2', 'image_detail_3'] as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $this->storeImage($request->file($field));
                }
            }

            Product::create($data);

            return redirect()->route('admin.product.showIndex')->with('success', 'Thêm sản phẩm thành công.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Thêm sản phẩm thất bại.');
        }
    }

    public function update(Request $request, $id): ?RedirectResponse
    {
        try {
            $product = Product::findOrFail($id);

            $data = $request->validate([
                'category_id'     => ['required', 'integer', 'exists:categories,id'],
                'code'            => ['required', 'string', 'max:100', Rule::unique('products', 'code')->ignore($product->id)],
                'name'            => ['required', 'string', 'max:255'],
                'slug'            => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($product->id)],
                'description'     => ['required', 'string'],
                'price'           => ['required', 'integer', 'min:0'],
                'discount_price'  => ['nullable', 'integer', 'min:0', 'lte:price'],
                'stock_quantity'  => ['required', 'integer', 'min:0'],
                'color'           => ['nullable', 'string', 'max:50'],
                'material'        => ['nullable', 'string', 'max:100'],
                'style'           => ['nullable', 'string'],
                'is_active'       => ['required', Rule::in([0, 1, '0', '1'])],
                'image'           => ['nullable', 'image', 'max:5120'],
                'image_detail_1'  => ['nullable', 'image', 'max:5120'],
                'image_detail_2'  => ['nullable', 'image', 'max:5120'],
                'image_detail_3'  => ['nullable', 'image', 'max:5120'],
            ]);

            $data['slug'] = $this->normalizeSlug($data['slug'] ?? null, $data['name']);

            foreach (['image', 'image_detail_1', 'image_detail_2', 'image_detail_3'] as $field) {
                if ($request->hasFile($field)) {
                    $this->deleteImageIfLocal($product->{$field} ?? null);
                    $data[$field] = $this->storeImage($request->file($field));
                }
            }

            $product->update($data);

            return redirect()->route('admin.product.showIndex')->with('success', 'Cập nhật sản phẩm thành công.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Cập nhật sản phẩm thất bại.');
        }
    }

    public function destroy($id): ?RedirectResponse
    {
        try {
            $product = Product::findOrFail($id);

            foreach (['image', 'image_detail_1', 'image_detail_2', 'image_detail_3'] as $field) {
                $this->deleteImageIfLocal($product->{$field} ?? null);
            }

            $product->delete();

            return redirect()->route('admin.product.showIndex')->with('success', 'Xóa sản phẩm thành công.');
        } catch (\Throwable $e) {
            return redirect()->route('admin.product.showIndex')->with('error', 'Xóa sản phẩm thất bại.');
        }
    }

    private function normalizeSlug(?string $slug, string $name): string
    {
        $slug = trim((string) $slug);
        return $slug !== '' ? Str::slug($slug) : Str::slug($name);
    }

    private function storeImage($file): string
    {
        $path = $file->store('products', 'public');
        return Storage::disk('public')->url($path);
    }

    private function deleteImageIfLocal(?string $url): void
    {
        $url = trim((string) $url);
        if ($url === '') {
            return;
        }

        $prefix = Storage::disk('public')->url('');
        if (!str_starts_with($url, $prefix)) {
            return;
        }

        $relative = ltrim(str_replace($prefix, '', $url), '/');
        if ($relative !== '') {
            Storage::disk('public')->delete($relative);
        }
    }
}
