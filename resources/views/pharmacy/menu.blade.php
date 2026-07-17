@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="fw-bold">
                <i class="bi bi-capsule me-2"></i>Menu Farmasi
            </h1>
            <p class="text-muted">Pilih transaksi farmasi yang ingin Anda lakukan</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Transaksi Resep -->
        <div class="col-md-4">
            <div class="card card-modern h-100 border-0 shadow-sm" style="overflow: hidden;">
                <div style="height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-receipt fs-1 text-white"></i>
                </div>
                <div class="card-body p-4 text-center">
                    <h5 class="fw-bold mb-2">Transaksi Resep</h5>
                    <p class="text-muted small mb-3">Kelola resep dari dokter</p>
                    <a href="{{ route('pharmacy.transaction-resep') }}" class="btn btn-sm btn-primary rounded-pill">
                        <i class="bi bi-arrow-right me-2"></i>Open
                    </a>
                </div>
            </div>
        </div>

        <!-- Penjualan Bebas -->
        <div class="col-md-4">
            <div class="card card-modern h-100 border-0 shadow-sm" style="overflow: hidden;">
                <div style="height: 120px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-shop fs-1 text-white"></i>
                </div>
                <div class="card-body p-4 text-center">
                    <h5 class="fw-bold mb-2">Penjualan Bebas</h5>
                    <p class="text-muted small mb-3">Penjualan obat langsung</p>
                    <a href="{{ route('pharmacy.penjualan-bebas') }}" class="btn btn-sm btn-danger rounded-pill">
                        <i class="bi bi-arrow-right me-2"></i>Open
                    </a>
                </div>
            </div>
        </div>

        <!-- Pembuatan PO -->
        <div class="col-md-4">
            <div class="card card-modern h-100 border-0 shadow-sm" style="overflow: hidden;">
                <div style="height: 120px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-file-earmark-plus fs-1 text-white"></i>
                </div>
                <div class="card-body p-4 text-center">
                    <h5 class="fw-bold mb-2">Pembuatan PO</h5>
                    <p class="text-muted small mb-3">Buat Purchase Order</p>
                    <a href="{{ route('purchase-orders.create') }}" class="btn btn-sm btn-warning rounded-pill text-white">
                        <i class="bi bi-arrow-right me-2"></i>Open
                    </a>
                </div>
            </div>
        </div>

        <!-- Penerimaan -->
        <div class="col-md-4">
            <div class="card card-modern h-100 border-0 shadow-sm" style="overflow: hidden;">
                <div style="height: 120px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-box-seam fs-1 text-white"></i>
                </div>
                <div class="card-body p-4 text-center">
                    <h5 class="fw-bold mb-2">Penerimaan</h5>
                    <p class="text-muted small mb-3">Terima barang PO</p>
                    <a href="{{ route('pharmacy.penerimaan') }}" class="btn btn-sm btn-info rounded-pill">
                        <i class="bi bi-arrow-right me-2"></i>Open
                    </a>
                </div>
            </div>
        </div>

        <!-- Mutasi Barang -->
        <div class="col-md-4">
            <div class="card card-modern h-100 border-0 shadow-sm" style="overflow: hidden;">
                <div style="height: 120px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-arrow-left-right fs-1 text-white"></i>
                </div>
                <div class="card-body p-4 text-center">
                    <h5 class="fw-bold mb-2">Mutasi Barang</h5>
                    <p class="text-muted small mb-3">Transfer antar gudang</p>
                    <a href="{{ route('pharmacy.mutasi-barang') }}" class="btn btn-sm btn-success rounded-pill">
                        <i class="bi bi-arrow-right me-2"></i>Open
                    </a>
                </div>
            </div>
        </div>

        <!-- Stock Barang -->
        <div class="col-md-4">
            <div class="card card-modern h-100 border-0 shadow-sm" style="overflow: hidden;">
                <div style="height: 120px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-boxes fs-1 text-white"></i>
                </div>
                <div class="card-body p-4 text-center">
                    <h5 class="fw-bold mb-2">Stock Barang</h5>
                    <p class="text-muted small mb-3">Lihat stok obat</p>
                    <a href="{{ route('pharmacy.stock-barang') }}" class="btn btn-sm btn-success rounded-pill">
                        <i class="bi bi-arrow-right me-2"></i>Open
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-3">
            <a href="{{ route('medicines.index') }}" class="btn btn-outline-primary btn-block w-100 rounded-pill">
                <i class="bi bi-capsule me-2"></i>Data Obat
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('suppliers.index') }}" class="btn btn-outline-info btn-block w-100 rounded-pill">
                <i class="bi bi-people-fill me-2"></i>Data Supplier
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('purchase-orders.index') }}" class="btn btn-outline-warning btn-block w-100 rounded-pill">
                <i class="bi bi-file-earmark me-2"></i>Data PO
            </a>
        </div>
        <div class="col-md-3">
            <a href="/" class="btn btn-outline-secondary btn-block w-100 rounded-pill">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>
@endsection
