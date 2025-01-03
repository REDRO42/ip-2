@extends('layouts.app')

@section('title', 'Kategoriler')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Kategoriler</h3>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        Yeni Kategori Ekle
                    </a>
                </div>
                <div class="card-body">
                    @if($categories->isEmpty())
                        <div class="alert alert-info">
                            Henüz kategori bulunmamaktadır.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Kategori Adı</th>
                                        <th>Açıklama</th>
                                        <th>Ürün Sayısı</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->description }}</td>
                                            <td>{{ $category->products_count }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.categories.edit', $category) }}" 
                                                        class="btn btn-sm btn-secondary">Düzenle</a>
                                                    <form action="{{ route('admin.categories.destroy', $category) }}" 
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Bu kategoriyi silmek istediğinizden emin misiniz?')">
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
                            {{ $categories->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 