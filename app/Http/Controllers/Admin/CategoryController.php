<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        $categories = Category::withCount('products')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori başarıyla oluşturuldu.');
    }

    public function edit(Category $category)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori başarıyla güncellendi.');
    }

    public function destroy(Category $category)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        if ($category->products()->exists()) {
            return back()->withErrors(['error' => 'Bu kategoriye ait ürünler bulunmaktadır. Önce ürünleri silmelisiniz.']);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori başarıyla silindi.');
    }
} 