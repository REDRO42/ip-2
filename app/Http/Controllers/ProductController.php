<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isSeller()) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        $products = Product::with(['category', 'images'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);
            
        return view('products.index', compact('products'));
    }

    public function create()
    {
        if (!Auth::check() || !Auth::user()->isSeller()) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isSeller()) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'required|image|max:2048'
        ]);

        if (!$request->hasFile('images') || count($request->file('images')) < 3) {
            return back()->withErrors(['images' => 'En az 3 ürün görseli yüklemelisiniz.']);
        }

        $validated['user_id'] = Auth::id();
        $product = Product::create($validated);

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'order' => $index
            ]);
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Ürün başarıyla oluşturuldu.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images', 'user']);
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        if (!Auth::check() || !Auth::user()->isSeller() || $product->user_id !== Auth::id()) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if (!Auth::check() || !Auth::user()->isSeller() || $product->user_id !== Auth::id()) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'sometimes|image|max:2048',
            'delete_images.*' => 'sometimes|exists:product_images,id'
        ]);

        $product->update($validated);

        // Silinecek resimleri sil
        if ($request->has('delete_images')) {
            $images = ProductImage::whereIn('id', $request->delete_images)
                ->where('product_id', $product->id)
                ->get();

            foreach ($images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }

        // Yeni resimleri ekle
        if ($request->hasFile('images')) {
            $lastOrder = $product->images()->max('order') ?? -1;
            
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'order' => ++$lastOrder
                ]);
            }
        }

        // En az 3 resim kontrolü
        if ($product->images()->count() < 3) {
            return back()->withErrors(['images' => 'Ürünün en az 3 görseli olmalıdır.']);
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Ürün başarıyla güncellendi.');
    }

    public function destroy(Product $product)
    {
        if (!Auth::check() || !Auth::user()->isSeller() || $product->user_id !== Auth::id()) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Ürün başarıyla silindi.');
    }

    public function allProducts()
    {
        $products = Product::with(['category', 'images', 'user'])
            ->latest()
            ->paginate(12);

        return view('products.all', compact('products'));
    }
} 