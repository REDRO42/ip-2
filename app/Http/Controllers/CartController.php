<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cart()->with(['product.images', 'product.user'])->get();
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $selectedAddress = auth()->user()->defaultAddress;

        return view('cart.index', compact('cartItems', 'total', 'selectedAddress'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Stok kontrolü
        if ($product->stock < $validated['quantity']) {
            return back()->with('error', 'Üzgünüz, bu ürün için yeterli stok bulunmamaktadır.');
        }

        // Eğer ürün zaten sepette varsa miktarını güncelle
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $validated['quantity'];
            
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Üzgünüz, bu ürün için yeterli stok bulunmamaktadır.');
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity']
            ]);
        }

        return back()->with('success', 'Ürün sepete eklendi.');
    }

    public function update(Request $request, Cart $cart)
    {
        if (!Auth::check() || $cart->user_id !== Auth::id()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Stok kontrolü
        if ($cart->product->stock < $validated['quantity']) {
            return back()->with('error', 'Üzgünüz, bu ürün için yeterli stok bulunmamaktadır.');
        }

        $cart->update($validated);

        return back()->with('success', 'Sepet güncellendi.');
    }

    public function destroy(Cart $cart)
    {
        if (!Auth::check() || $cart->user_id !== Auth::id()) {
            return redirect()->route('login');
        }

        $cart->delete();

        return back()->with('success', 'Ürün sepetten kaldırıldı.');
    }
}
