@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ $product->name }}</h3>
                    <div>
                        <form action="{{ route('admin.products.destroy', $product) }}" 
                            method="POST" class="d-inline"
                            onsubmit="return confirm('Bu ürünü silmek istediğinizden emin misiniz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Ürünü Sil</button>
                        </form>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Geri Dön</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if($product->images->isNotEmpty())
                                <div id="productImages" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($product->images as $index => $image)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                    class="d-block w-100" alt="{{ $product->name }}"
                                                    style="height: 400px; object-fit: cover;">
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
                                <div class="alert alert-info">
                                    Bu ürün için görsel bulunmamaktadır.
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h4>Ürün Bilgileri</h4>
                            <hr>
                            <dl class="row">
                                <dt class="col-sm-4">Kategori</dt>
                                <dd class="col-sm-8">{{ $product->category->name }}</dd>

                                <dt class="col-sm-4">Satıcı</dt>
                                <dd class="col-sm-8">
                                    {{ $product->user->name }}
                                    <small class="d-block text-muted">{{ $product->user->email }}</small>
                                </dd>

                                <dt class="col-sm-4">Fiyat</dt>
                                <dd class="col-sm-8">{{ number_format($product->price, 2) }} TL</dd>

                                <dt class="col-sm-4">Stok</dt>
                                <dd class="col-sm-8">
                                    <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                        {{ $product->stock }}
                                    </span>
                                    @if($product->stock > 10)
                                        <span class="badge bg-success">Stokta var</span>
                                    @elseif($product->stock > 0)
                                        <span class="badge bg-warning">Stok azalıyor</span>
                                    @else
                                        <span class="badge bg-danger">Stokta yok</span>
                                    @endif
                                </dd>

                                <dt class="col-sm-4">Eklenme Tarihi</dt>
                                <dd class="col-sm-8">{{ $product->created_at->format('d.m.Y H:i') }}</dd>

                                <dt class="col-sm-4">Son Güncelleme</dt>
                                <dd class="col-sm-8">{{ $product->updated_at->format('d.m.Y H:i') }}</dd>
                            </dl>

                            <h4 class="mt-4">Ürün Açıklaması</h4>
                            <hr>
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 