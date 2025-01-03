@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Ürün Detayı</h3>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Geri Dön
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Ürün Görselleri -->
                        <div class="col-md-6">
                            @if($product->images->isNotEmpty())
                                <div id="productImages" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($product->images as $index => $image)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                    class="d-block w-100 rounded" alt="{{ $product->name }}"
                                                    style="height: 400px; object-fit: contain;">
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($product->images->count() > 1)
                                        <button class="carousel-control-prev" type="button" data-bs-target="#productImages" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Önceki</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#productImages" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Sonraki</span>
                                        </button>
                                    @endif
                                </div>
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                    style="height: 400px;">
                                    <span class="text-muted">Görsel yok</span>
                                </div>
                            @endif
                        </div>

                        <!-- Ürün Bilgileri -->
                        <div class="col-md-6">
                            <h2 class="mb-3">{{ $product->name }}</h2>
                            
                            <div class="mb-4">
                                <span class="badge bg-secondary fs-6">{{ $product->category->name }}</span>
                                <span class="ms-2 text-muted">Satıcı: {{ $product->user->name }}</span>
                            </div>

                            <div class="price-tag-large mb-4">
                                {{ number_format($product->price, 2) }} TL
                            </div>

                            <div class="mb-4">
                                <h5>Stok Durumu</h5>
                                @if($product->stock > 10)
                                    <span class="badge bg-success">Stokta var ({{ $product->stock }} adet)</span>
                                @elseif($product->stock > 0)
                                    <span class="badge bg-warning">Son {{ $product->stock }} adet!</span>
                                @else
                                    <span class="badge bg-danger">Stokta yok</span>
                                @endif
                            </div>

                            <div class="mb-4">
                                <h5>Ürün Açıklaması</h5>
                                <p class="text-muted">{{ $product->description }}</p>
                            </div>

                            @if($product->stock > 0)
                                <div class="mt-4">
                                    <form action="{{ route('cart.store') }}" method="POST" class="mb-2">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <label for="quantity" class="form-label">Adet:</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity" 
                                                    value="1" min="1" max="{{ $product->stock }}" style="width: 80px;">
                                            </div>
                                            <div class="col">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-shopping-cart me-2"></i>
                                                    Sepete Ekle
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    @auth
                                        @if(Auth::user()->favorites()->where('product_id', $product->id)->exists())
                                            <form action="{{ route('favorites.destroy', $product) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger">
                                                    <i class="fas fa-heart-broken me-2"></i>
                                                    Favorilerden Çıkar
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('favorites.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit" class="btn btn-outline-primary">
                                                    <i class="fas fa-heart me-2"></i>
                                                    Favorilere Ekle
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Bu ürün şu anda stokta bulunmamaktadır.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.carousel-control-prev,
.carousel-control-next {
    background-color: rgba(0, 0, 0, 0.3);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
}

.price-tag-large {
    font-size: 2rem;
    font-weight: 600;
    color: var(--orange-primary);
    background: var(--orange-lighter);
    padding: 10px 20px;
    border-radius: 15px;
    display: inline-block;
    border: 3px solid var(--orange-primary);
}

.btn-lg {
    padding: 15px 30px;
}

.carousel {
    background-color: var(--orange-lighter);
    border-radius: 10px;
    padding: 20px;
}

.carousel-item img {
    background-color: white;
}
</style>
@endsection 