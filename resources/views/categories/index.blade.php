@extends('layouts.app')

@section('title', 'Kategoriler')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h2>Kategoriler</h2>
        @auth
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Yeni Kategori Ekle</a>
        @endauth
    </div>
</div>

<div class="row">
    @forelse($categories as $category)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $category->name }}</h5>
                    <p class="card-text text-muted">
                        {{ $category->description ?? 'Açıklama bulunmuyor.' }}
                    </p>
                    <p class="card-text">
                        <small class="text-muted">
                            {{ $category->products_count }} ürün
                        </small>
                    </p>
                    <a href="{{ route('categories.show', $category) }}" 
                        class="btn btn-primary">Ürünleri Görüntüle</a>
                    @auth
                        <a href="{{ route('categories.edit', $category) }}" 
                            class="btn btn-secondary">Düzenle</a>
                        <form action="{{ route('categories.destroy', $category) }}" 
                            method="POST" class="d-inline"
                            onsubmit="return confirm('Bu kategoriyi silmek istediğinizden emin misiniz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Sil</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">
                Henüz kategori bulunmamaktadır.
            </div>
        </div>
    @endforelse
</div>
@endsection 