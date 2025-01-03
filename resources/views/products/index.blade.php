@extends('layouts.app')

@section('title', 'Ürünlerim')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Ürünlerim</h3>
                    <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
                        Yeni Ürün Ekle
                    </a>
                </div>
                <div class="card-body">
                    @if($products->isEmpty())
                        <div class="alert alert-info">
                            Henüz ürün eklememişsiniz.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Resim</th>
                                        <th>Ürün Adı</th>
                                        <th>Kategori</th>
                                        <th>Fiyat</th>
                                        <th>Stok</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>
                                                @if($product->images->isNotEmpty())
                                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                                        alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <span class="text-muted">Resim yok</span>
                                                @endif
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>{{ number_format($product->price, 2) }} TL</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('seller.products.edit', $product) }}" 
                                                        class="btn btn-sm btn-secondary">Düzenle</a>
                                                    <form action="{{ route('seller.products.destroy', $product) }}" 
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

                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 