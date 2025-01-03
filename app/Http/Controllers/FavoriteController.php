<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $favorites = Auth::user()->favorites()->with(['images', 'user'])->get();
        return view('favorites.index', compact('favorites'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user = Auth::user();
        $product = Product::findOrFail($validated['product_id']);

        if (!$user->favorites()->where('product_id', $product->id)->exists()) {
            $user->favorites()->attach($product);
            return back()->with('success', 'Ürün favorilere eklendi.');
        }

        return back()->with('error', 'Bu ürün zaten favorilerinizde.');
    }

    public function destroy(Product $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $user->favorites()->detach($product);

        return back()->with('success', 'Ürün favorilerden kaldırıldı.');
    }
} 