@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="category-header p-4 rounded">
                <h1 class="mb-2">{{ $category->name }}</h1>
                <p class="lead mb-0">{{ $category->description }}</p>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-3 mb-4">
                <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                    <div class="card h-100 product-card">
                        @if($product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                class="card-img-top" alt="{{ $product->name }}"
                                style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                style="height: 200px;">
                                <span class="text-muted">Görsel yok</span>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title text-dark">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($product->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="price-tag">{{ number_format($product->price, 2) }} TL</div>
                                <span class="text-muted small">Satıcı: {{ $product->user->name }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Bu kategoride henüz ürün bulunmamaktadır.
                </div>
            </div>
        @endforelse
    </div>

    @if($products->hasPages())
        <div class="row mt-4">
            <div class="col-12">
                {{ $products->links() }}
            </div>
        </div>
    @endif
</div>

<style>
.category-header {
    background-color: var(--orange-lighter);
    border-left: 5px solid var(--orange-primary);
}

.product-card {
    transition: all 0.3s ease;
    border: 1px solid #ddd;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.price-tag {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--orange-primary);
    background: var(--orange-lighter);
    padding: 5px 15px;
    border-radius: 20px;
    display: inline-block;
    border: 2px solid var(--orange-primary);
}
</style>
@endsection 