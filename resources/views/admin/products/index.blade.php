@extends('layouts.app')

@section('title', 'Tüm Ürünler')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Tüm Ürünler</h3>
                </div>
                <div class="card-body">
                    @php
                        $products = $products->groupBy('category.name');
                    @endphp

                    @forelse($products as $categoryName => $categoryProducts)
                        <div class="mb-4">
                            <h4 class="mb-3">{{ $categoryName }}</h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Resim</th>
                                            <th>Ürün Adı</th>
                                            <th>Satıcı</th>
                                            <th>Fiyat</th>
                                            <th>Stok</th>
                                            <th>Durum</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categoryProducts as $product)
                                            <tr>
                                                <td>
                                                    @if($product->images->isNotEmpty())
                                                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                                            alt="{{ $product->name }}" 
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <span class="text-muted">Resim yok</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $product->name }}
                                                    <small class="d-block text-muted">
                                                        {{ Str::limit($product->description, 50) }}
                                                    </small>
                                                </td>
                                                <td>
                                                    {{ $product->user->name }}
                                                    <small class="d-block text-muted">
                                                        {{ $product->user->email }}
                                                    </small>
                                                </td>
                                                <td>{{ number_format($product->price, 2) }} TL</td>
                                                <td>
                                                    <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                                        {{ $product->stock }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($product->stock > 10)
                                                        <span class="badge bg-success">Stokta var</span>
                                                    @elseif($product->stock > 0)
                                                        <span class="badge bg-warning">Stok azalıyor</span>
                                                    @else
                                                        <span class="badge bg-danger">Stokta yok</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.products.show', $product) }}" 
                                                            class="btn btn-sm btn-info">Detay</a>
                                                        <form action="{{ route('admin.products.destroy', $product) }}" 
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Bu ürünü silmek istediğinizden emin misiniz?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">Sil</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            Henüz ürün bulunmamaktadır.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 