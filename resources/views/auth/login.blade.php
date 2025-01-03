@extends('layouts.app')

@section('title', 'Giriş Yap')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Giriş Yap</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta Adresi</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email') }}" required autofocus>
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

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Beni Hatırla</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Giriş Yap</button>
                            <div class="text-center mt-3">
                                <p class="mb-0">
                                    <a href="{{ route('register') }}" class="register-link">
                                        Hesabınız yok mu? <span class="text-primary fw-bold">Kayıt olun</span>
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
.register-link {
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
    padding: 5px 10px;
    border-radius: 5px;
}

.register-link:hover {
    background-color: var(--orange-lighter);
    transform: translateY(-2px);
}

.register-link span {
    color: var(--orange-primary);
}

.register-link:hover span {
    color: var(--orange-dark);
}
</style>
@endsection 