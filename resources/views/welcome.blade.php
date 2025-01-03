@extends('layouts.app')

@section('title', 'VERONA - Alışverişin Güvenilir Adresi')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="jumbotron text-center py-5 bg-light rounded">
                <h1 class="display-4">VERONA Marketplace'e Hoş Geldiniz</h1>
                <p class="lead">Güvenilir alışverişin adresi</p>
                @guest
                    <hr class="my-4">
                    <p>Hemen üye olun, alışverişin keyfini çıkarın!</p>
                    <a class="btn btn-primary btn-lg" href="{{ route('register') }}" role="button">Üye Ol</a>
                    <a class="btn btn-outline-primary btn-lg" href="{{ route('login') }}" role="button">Giriş Yap</a>
                @endguest
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="border-bottom pb-2">Kategoriler</h2>
        </div>
        @foreach($categories as $category)
            <div class="col-md-3 mb-4">
                <a href="{{ route('categories.show', $category) }}" class="text-decoration-none">
                    <div class="card h-100 category-card">
                        <div class="card-body">
                            <h5 class="card-title text-dark">{{ $category->name }}</h5>
                            <p class="card-text text-muted small">{{ $category->description }}</p>
                            <p class="card-text">
                                <span class="badge bg-primary">{{ $category->products_count }} ürün</span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <!-- Products Section -->
    <div class="row">
        <div class="col-12 mb-4">
            <h2 class="border-bottom pb-2">Son Eklenen Ürünler</h2>
        </div>
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
                            <p class="card-text">
                                <span class="badge bg-secondary">{{ $product->category->name }}</span>
                            </p>
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
                    Henüz ürün eklenmemiş.
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="row mt-4">
            <div class="col-12">
                {{ $products->links() }}
            </div>
        </div>
    @endif
</div>

<style>
.product-card {
    transition: all 0.3s ease;
    border: 1px solid #ddd;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.jumbotron {
    background-color: var(--orange-lighter);
    border: 1px solid var(--orange-light);
}

.card {
    border-radius: 10px;
    overflow: hidden;
}

.card-img-top {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.badge {
    font-weight: 500;
    padding: 0.5em 1em;
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

.category-card {
    transition: all 0.3s ease;
    border: 1px solid #ddd;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    border-color: var(--orange-primary);
}
</style>
@endsection
