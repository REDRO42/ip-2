<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $sellers = User::where('role', 'seller')
            ->with(['products.category'])
            ->get();

        $buyers = User::where('role', 'buyer')
            ->get();

        return view('admin.users.index', compact('sellers', 'buyers'));
    }

    public function destroy(User $user)
    {
        
        if ($user->role === 'admin') {
            return back()->with('error', 'Admin kullanıcısı silinemez!');
        } // aslında gereksiz çünkü admini listelemedik zaten

        
        if ($user->role === 'seller') {
            foreach ($user->products as $product) {
                
                foreach ($product->images as $image) {
                    if (Storage::exists('public/' . $image->image_path)) {
                        Storage::delete('public/' . $image->image_path);
                    }
                }
            }
            
            $user->products()->delete();
        }

        $user->delete();

        return back()->with('success', 'Kullanıcı başarıyla silindi.');
    }
} 