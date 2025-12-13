@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
<div class="welcome-section">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Selamat Datang di Kobarid! 👋</h1>
            <p class="mb-0">Kelola bisnis Anda dengan mudah dan efisien</p>
        </div>
        <div class="welcome-icon d-none d-md-block">
            <i class="fas fa-chart-line"></i>
        </div>
    </div>
</div>

<h4 class="mb-4" style="color: rgba(255,255,255,0.7);">Overview Statistik</h4>

<div class="row">
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title">Total Customer</h5>
                    <p class="card-text" style="font-size: 2.5rem;">{{ $stats['customers'] }}</p>
                </div>
                <div style="font-size: 3.5rem;">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title">Total Barang</h5>
                    <p class="card-text" style="font-size: 2.5rem;">{{ $stats['barangs'] }}</p>
                </div>
                <div style="font-size: 3.5rem;">
                    <i class="fas fa-boxes"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title">Total Pegawai</h5>
                    <p class="card-text" style="font-size: 2.5rem;">{{ $stats['pegawais'] }}</p>
                </div>
                <div style="font-size: 3.5rem;">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title">Purchase Order</h5>
                    <p class="card-text" style="font-size: 2.5rem;">{{ $stats['purchaseOrders'] }}</p>
                </div>
                <div style="font-size: 3.5rem;">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title">Surat Jalan</h5>
                    <p class="card-text" style="font-size: 2.5rem;">{{ $stats['suratJalans'] }}</p>
                </div>
                <div style="font-size: 3.5rem;">
                    <i class="fas fa-truck"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title">Total Invoice</h5>
                    <p class="card-text" style="font-size: 2.5rem;">{{ $stats['invoices'] }}</p>
                </div>
                <div style="font-size: 3.5rem;">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
