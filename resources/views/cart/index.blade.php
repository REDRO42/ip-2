@extends('layouts.app')

@section('title', 'Sepetim')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="border-bottom pb-2">Sepetim</h2>
        </div>
    </div>

    @if($cartItems->isEmpty())
        <div class="alert alert-info mt-4">
            Sepetinizde ürün bulunmamaktadır.
        </div>
    @else
        <div class="row mt-4">
            <div class="col-md-8">
                @foreach($cartItems as $item)
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-3">
                                @if($item->product->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" 
                                        class="img-fluid rounded-start" alt="{{ $item->product->name }}"
                                        style="height: 150px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                        <span class="text-muted">Görsel yok</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h5 class="card-title">{{ $item->product->name }}</h5>
                                        <form action="{{ route('cart.destroy', $item) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <p class="card-text text-muted small">{{ Str::limit($item->product->description, 100) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="price-tag">{{ number_format($item->product->price, 2) }} TL</div>
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            @method('PUT')
                                            <label class="me-2">Adet:</label>
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                                min="1" max="{{ $item->product->stock }}" 
                                                class="form-control form-control-sm" style="width: 70px;"
                                                onchange="this.form.submit()">
                                        </form>
                                    </div>
                                    <p class="card-text mt-2">
                                        <small class="text-muted">Satıcı: {{ $item->product->user->name }}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Sipariş Özeti</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Toplam Tutar:</span>
                            <strong>{{ number_format($total, 2) }} TL</strong>
                        </div>

                        <div class="mb-3">
                            <h6 class="mb-2">Teslimat Adresi</h6>
                            @if(isset($selectedAddress))
                                <div class="selected-address p-2 border rounded mb-2">
                                    <p class="mb-1"><strong>{{ $selectedAddress->title }}</strong></p>
                                    <p class="mb-1 small">{{ $selectedAddress->address }}</p>
                                    <p class="mb-0 small text-muted">
                                        {{ $selectedAddress->city }} / {{ $selectedAddress->district }}
                                    </p>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#addressModal">
                                    <i class="fas fa-edit me-1"></i> Adresi Değiştir
                                </button>
                            @else
                                <div class="text-center p-3 border rounded mb-2">
                                    <i class="fas fa-map-marker-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-0">Henüz bir teslimat adresi seçilmedi</p>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#addressModal">
                                    <i class="fas fa-plus me-1"></i> Adres Ekle
                                </button>
                            @endif
                        </div>

                        <button class="btn btn-primary w-100">
                            <i class="fas fa-check me-2"></i>Ödemeye Geç
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Adres Modal -->
<div class="modal fade" id="addressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Teslimat Adresi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('address.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Adres Başlığı</label>
                        <input type="text" class="form-control" id="title" name="title" required 
                            placeholder="Örn: Ev, İş">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Açık Adres</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required 
                            placeholder="Sokak, Mahalle, Bina No, Daire No"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">İl</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="district" class="form-label">İlçe</label>
                            <input type="text" class="form-control" id="district" name="district" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefon</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required 
                            placeholder="05XX XXX XX XX">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="save_address" name="save_address" value="1">
                        <label class="form-check-label" for="save_address">
                            Bu adresi kaydet ve sonraki alışverişlerimde kullan
                        </label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_default" name="is_default" value="1">
                        <label class="form-check-label" for="is_default">
                            Varsayılan adresim olarak kaydet
                        </label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Adresi Kaydet ve Kullan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
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

.selected-address {
    background-color: var(--orange-lighter);
    border-color: var(--orange-primary) !important;
}

.modal-header {
    background-color: var(--orange-lighter);
    border-bottom: 2px solid var(--orange-primary);
}

.modal-title {
    color: var(--orange-primary);
    font-weight: bold;
}
</style>
@endsection 