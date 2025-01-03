@extends('layouts.app')

@section('title', 'Admin Paneli')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Admin Paneli</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Kategoriler</h5>
                                    <p class="card-text">Kategorileri yönetin</p>
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
                                        Kategorilere Git
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Kullanıcılar</h5>
                                    <p class="card-text">Kullanıcıları yönetin</p>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                                        Kullanıcılara Git
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Ürünler</h5>
                                    <p class="card-text">Tüm ürünleri yönetin</p>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                                        Ürünlere Git
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 