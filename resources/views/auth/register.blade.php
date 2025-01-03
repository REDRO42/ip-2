@extends('layouts.app')

@section('title', 'Kayıt Ol')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Kayıt Ol</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Ad Soyad</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta Adresi</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Şifre</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Şifre Tekrar</label>
                            <input type="password" class="form-control" 
                                id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_seller" name="is_seller" value="1">
                            <label class="form-check-label" for="is_seller">
                                Bizimle çalışmak ister misiniz? (Satıcı hesabı oluştur)
                            </label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Kayıt Ol</button>
                            <div class="text-center mt-3">
                                <p class="mb-0">
                                    <a href="{{ route('login') }}" class="login-link">
                                        Zaten hesabınız var mı? <span class="text-primary fw-bold">Giriş yapın</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.login-link {
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
    padding: 5px 10px;
    border-radius: 5px;
}

.login-link:hover {
    background-color: var(--orange-lighter);
    transform: translateY(-2px);
}

.login-link span {
    color: var(--orange-primary);
}

.login-link:hover span {
    color: var(--orange-dark);
}
</style>
@endsection 