<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $products = Product::with(['category', 'images', 'user'])
            ->latest()
            ->paginate(12);

        return view('welcome', compact('products', 'categories'));
    }
} 