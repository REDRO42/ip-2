<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        $products = Product::with(['category', 'user', 'images'])
            ->latest()
            ->paginate(10);
            
        return view('admin.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        $product->load(['category', 'user', 'images']);
        return view('admin.products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Ürün başarıyla silindi.');
    }
} 