@extends('layouts.app')

@section('title', 'Satıcı Paneli')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Satıcı Paneli</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Ürünlerim</h5>
                                    <p class="card-text">Ürünlerinizi yönetin</p>
                                    <a href="{{ route('seller.products.index') }}" class="btn btn-primary">
                                        Ürünlere Git
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Yeni Ürün</h5>
                                    <p class="card-text">Yeni ürün ekleyin</p>
                                    <a href="{{ route('seller.products.create') }}" class="btn btn-success">
                                        Ürün Ekle
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