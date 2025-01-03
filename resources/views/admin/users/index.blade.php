@extends('layouts.app')

@section('title', 'Kullanıcı Yönetimi')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Satıcılar -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="mb-0">Satıcılar</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Ad Soyad</th>
                                    <th>E-posta</th>
                                    <th>Kayıt Tarihi</th>
                                    <th>Ürün Kategorileri</th>
                                    <th>Toplam Ürün</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sellers as $seller)
                                    <tr>
                                        <td>{{ $seller->name }}</td>
                                        <td>{{ $seller->email }}</td>
                                        <td>{{ $seller->created_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            @php
                                                $categories = $seller->products->pluck('category')->unique();
                                            @endphp
                                            @forelse($categories as $category)
                                                <span class="badge bg-info">{{ $category->name }}</span>
                                            @empty
                                                <span class="text-muted">Henüz ürün eklenmemiş</span>
                                            @endforelse
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $seller->products->count() }} ürün
                                            </span>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.users.destroy', $seller) }}" 
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Sil</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Henüz satıcı bulunmamaktadır.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Müşteriler -->
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Müşteriler</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Ad Soyad</th>
                                    <th>E-posta</th>
                                    <th>Kayıt Tarihi</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($buyers as $buyer)
                                    <tr>
                                        <td>{{ $buyer->name }}</td>
                                        <td>{{ $buyer->email }}</td>
                                        <td>{{ $buyer->created_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            <form action="{{ route('admin.users.destroy', $buyer) }}" 
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Sil</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Henüz müşteri bulunmamaktadır.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 