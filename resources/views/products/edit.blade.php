@extends('layouts.app')

@section('title', 'Ürün Düzenle')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3>Ürün Düzenle</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Ürün Adı</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                            id="name" name="name" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Açıklama</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                            id="description" name="description" rows="3" required>{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Fiyat (TL)</label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                            id="price" name="price" value="{{ old('price', $product->price) }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                            id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" 
                            id="category_id" name="category_id" required>
                            <option value="">Kategori Seçin</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mevcut Görseller</label>
                        <div class="row">
                            @foreach($product->images as $image)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                            class="card-img-top" alt="Ürün görseli">
                                        <div class="card-body">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                    name="delete_images[]" value="{{ $image->id }}" 
                                                    id="delete_image_{{ $image->id }}">
                                                <label class="form-check-label" for="delete_image_{{ $image->id }}">
                                                    Bu görseli sil
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Yeni Görseller Ekle</label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" 
                            name="images[]" multiple accept="image/*">
                        <small class="text-muted">Her bir görsel en fazla 2MB olmalıdır. Toplam en az 3 görsel olmalıdır.</small>
                        @error('images')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Değişiklikleri Kaydet</button>
                        <a href="{{ route('seller.products.index') }}" class="btn btn-secondary">İptal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const checkboxes = document.querySelectorAll('input[name="delete_images[]"]:checked');
    const fileInput = document.querySelector('input[type="file"]');
    const remainingImages = {!! $product->images->count() !!} - checkboxes.length;
    const newImages = fileInput.files ? fileInput.files.length : 0;
    
    if (remainingImages + newImages < 3) {
        e.preventDefault();
        alert('Ürünün en az 3 görseli olmalıdır. Lütfen yeni görseller ekleyin veya daha az görsel silmeyi deneyin.');
    }
});
</script>
@endpush

@endsection 