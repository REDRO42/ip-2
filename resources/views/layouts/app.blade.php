<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VERONA - @yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Turuncu Tema Renkleri */
        :root {
            --orange-primary: #ff6b00;
            --orange-dark: #e65c00;
            --orange-light: #ff8533;
            --orange-lighter: #fff0e6;
        }

        /* Navbar Stilleri */
        .navbar {
            background-color: var(--orange-primary) !important;
        }

        .navbar-dark .navbar-brand,
        .navbar-dark .nav-link {
            color: white !important;
        }

        .navbar-dark .nav-link:hover {
            color: var(--orange-lighter) !important;
        }

        /* Buton Stilleri */
        .btn-primary {
            background-color: var(--orange-primary) !important;
            border-color: var(--orange-primary) !important;
        }

        .btn-primary:hover {
            background-color: var(--orange-dark) !important;
            border-color: var(--orange-dark) !important;
        }

        .btn-outline-primary {
            color: var(--orange-primary) !important;
            border-color: var(--orange-primary) !important;
        }

        .btn-outline-primary:hover {
            color: white !important;
            background-color: var(--orange-primary) !important;
        }

        /* Geri Dön Butonu Stilleri */
        .btn-outline-secondary {
            color: var(--orange-primary) !important;
            border-color: var(--orange-primary) !important;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            color: white !important;
            background-color: var(--orange-primary) !important;
            border-color: var(--orange-primary) !important;
            transform: translateX(-5px);
        }

        .btn-outline-secondary i {
            margin-right: 5px;
            transition: transform 0.3s ease;
        }

        .btn-outline-secondary:hover i {
            transform: translateX(-3px);
        }

        /* Card Stilleri */
        .card {
            border-color: #ddd;
        }

        .card-header {
            background-color: var(--orange-lighter) !important;
            border-bottom: 2px solid var(--orange-primary);
        }

        /* Form Stilleri */
        .form-control:focus {
            border-color: var(--orange-primary);
            box-shadow: 0 0 0 0.25rem rgba(255, 107, 0, 0.25);
        }

        /* Link Stilleri */
        a {
            color: var(--orange-primary);
            text-decoration: none;
        }

        a:hover {
            color: var(--orange-dark);
        }

        /* Badge Stilleri */
        .badge.bg-primary {
            background-color: var(--orange-primary) !important;
        }

        .badge.bg-secondary {
            background-color: var(--orange-dark) !important;
        }

        /* Footer Stilleri */
        .footer {
            background-color: var(--orange-primary);
            color: white;
        }

        /* Alert Stilleri */
        .alert-primary {
            background-color: var(--orange-lighter);
            border-color: var(--orange-light);
            color: var(--orange-dark);
        }

        /* Pagination Stilleri */
        .page-link {
            color: var(--orange-primary);
        }

        .page-link:hover {
            color: var(--orange-dark);
        }

        .page-item.active .page-link {
            background-color: var(--orange-primary);
            border-color: var(--orange-primary);
        }

        .categories-btn {
            padding: 8px;
            font-size: 1.2rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .categories-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <button class="btn btn-link text-white me-2 categories-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#categoriesOffcanvas">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand" href="/">VERONA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Ürünler</a>
                    </li>
                    @auth
                        @if(Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Paneli</a>
                            </li>
                        @endif
                        @if(Auth::user()->isSeller())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('seller.dashboard') }}">Satıcı Paneli</a>
                            </li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Giriş Yap</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Kayıt Ol</a>
                        </li>
                    @else
                        <li class="nav-item me-2">
                            <a class="nav-link position-relative" href="{{ route('favorites.index') }}">
                                <i class="fas fa-heart"></i>
                                @php
                                    $favoritesCount = Auth::user()->favorites()->count();
                                @endphp
                                @if($favoritesCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $favoritesCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart"></i>
                                @php
                                    $cartCount = Auth::user()->cart()->sum('quantity');
                                @endphp
                                @if($cartCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        Hesabım
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                        @csrf
                                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Çıkış Yap
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Kategoriler Offcanvas -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="categoriesOffcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Kategoriler</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            @php
                $categories = \App\Models\Category::all();
            @endphp
            <div class="list-group">
                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category) }}" 
                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        {{ $category->name }}
                        <span class="badge bg-primary rounded-pill">{{ $category->products->count() }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        .offcanvas {
            border-right: 3px solid var(--orange-primary);
        }
        
        .offcanvas-header {
            background-color: var(--orange-lighter);
            border-bottom: 2px solid var(--orange-primary);
        }
        
        .offcanvas-title {
            color: var(--orange-primary);
            font-weight: bold;
        }
        
        .list-group-item {
            border-left: none;
            border-right: none;
            border-radius: 0 !important;
            transition: all 0.3s ease;
        }
        
        .list-group-item:hover {
            background-color: var(--orange-lighter);
            color: var(--orange-primary);
            transform: translateX(5px);
        }
        
        .list-group-item:first-child {
            border-top: none;
        }
        
        .list-group-item:last-child {
            border-bottom: none;
        }
    </style>

    <main class="container my-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer py-5 mt-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-4">
                    <h5 class="text-white mb-3">VERONA Marketplace</h5>
                    <p class="text-white-50 mb-3">Alışverişin güvenilir adresi</p>
                    <div class="social-links">
                        <a href="#" class="me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5 class="text-white mb-3">Özelliklerimiz</h5>
                    <div class="features-list">
                        <div class="feature-item mb-3">
                            <i class="fas fa-shield-alt text-white-50 me-2"></i>
                            <div>
                                <h6 class="text-white mb-1">Güvenli Alışveriş</h6>
                                <p class="text-white-50 mb-0">%100 güvenli ödeme sistemi</p>
                            </div>
                        </div>
                        <div class="feature-item mb-3">
                            <i class="fas fa-truck text-white-50 me-2"></i>
                            <div>
                                <h6 class="text-white mb-1">Hızlı Teslimat</h6>
                                <p class="text-white-50 mb-0">Aynı gün kargo imkanı</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-headset text-white-50 me-2"></i>
                            <div>
                                <h6 class="text-white mb-1">7/24 Destek</h6>
                                <p class="text-white-50 mb-0">Her zaman yanınızdayız</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5 class="text-white mb-3">İletişim</h5>
                    <div class="contact-info">
                        <p class="text-white-50 mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            İstanbul, Türkiye
                        </p>
                        <p class="text-white-50 mb-2">
                            <i class="fas fa-phone me-2"></i>
                            +90 (212) 123 45 67
                        </p>
                        <p class="text-white-50 mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            info@verona.com
                        </p>
                    </div>
                </div>
            </div>
            <hr class="border-white-50">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-white-50 mb-0">&copy; 2024 VERONA. Tüm hakları saklıdır.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-white-50 me-3">Gizlilik Politikası</a>
                    <a href="#" class="text-white-50 me-3">Kullanım Şartları</a>
                    <a href="#" class="text-white-50">KVKK</a>
                </div>
            </div>
        </div>
    </footer>

    <style>
    .footer {
        background-color: var(--orange-primary);
        position: relative;
    }

    .footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(to right, var(--orange-lighter), var(--orange-primary), var(--orange-lighter));
    }

    .footer .social-links a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        color: white;
        transition: all 0.3s ease;
    }

    .footer .social-links a:hover {
        background-color: white;
        color: var(--orange-primary);
        transform: translateY(-3px);
    }

    .footer .feature-item {
        display: flex;
        align-items: start;
    }

    .footer .feature-item i {
        font-size: 1.5rem;
        margin-top: 0.2rem;
    }

    .footer a {
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer a:hover {
        color: white !important;
    }

    .footer hr {
        margin: 2rem 0;
    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html> 