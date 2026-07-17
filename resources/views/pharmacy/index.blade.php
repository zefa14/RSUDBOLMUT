@extends('layouts.app')

@section('title', 'Dashboard Farmasi')
@section('page-title', 'Farmasi & Apotek')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-1 text-primary fw-bold"><i class="bi bi-capsule-pill me-2"></i>Dashboard Instalasi Farmasi</h4>
            <p class="text-muted">Ringkasan aktivitas apotek, resep masuk, dan peringatan stok.</p>
        </div>
    </div>

    {{-- Widget Ringkasan --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card border-0 shadow-sm rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center mb-3 relative z-index-1">
                    <div>
                        <p class="mb-0 fw-semibold opacity-75" style="font-size: 13px; letter-spacing: 0.5px;">E-RESEP MENUNGGU</p>
                        <h2 class="mb-0 fw-bold display-6 mt-1">{{ $pendingPrescriptionsCount }}</h2>
                    </div>
                    <div class="stat-icon" style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 18px;">
                        <i class="bi bi-receipt fs-2"></i>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top border-light border-opacity-25">
                    <a href="{{ route('pharmacy.transaction-resep') }}" class="text-white text-decoration-none fw-medium small d-flex justify-content-between align-items-center">
                        Proses Antrian Resep Sekarang <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <i class="bi bi-receipt position-absolute text-white" style="font-size: 120px; right: -20px; bottom: -30px; opacity: 0.1;"></i>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card border-0 shadow-sm rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, #198754 0%, #146c43 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center mb-3 relative z-index-1">
                    <div>
                        <p class="mb-0 fw-semibold opacity-75" style="font-size: 13px; letter-spacing: 0.5px;">PENJUALAN BEBAS</p>
                        <h2 class="mb-0 fw-bold mt-1 fs-3">POS Kasir</h2>
                    </div>
                    <div class="stat-icon" style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 18px;">
                        <i class="bi bi-cart2 fs-2"></i>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top border-light border-opacity-25">
                    <a href="{{ route('pharmacy.penjualan-bebas') }}" class="text-white text-decoration-none fw-medium small d-flex justify-content-between align-items-center">
                        Buka Aplikasi Kasir <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <i class="bi bi-cart2 position-absolute text-white" style="font-size: 120px; right: -20px; bottom: -30px; opacity: 0.1;"></i>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card border-0 shadow-sm rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center mb-3 relative z-index-1">
                    <div>
                        <p class="mb-0 fw-semibold opacity-75" style="font-size: 13px; letter-spacing: 0.5px;">PERINGATAN STOK TIPIS</p>
                        <h2 class="mb-0 fw-bold display-6 mt-1">{{ $lowStockMedicines->count() }}</h2>
                    </div>
                    <div class="stat-icon" style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 18px;">
                        <i class="bi bi-exclamation-triangle fs-2"></i>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top border-light border-opacity-25">
                    <a href="{{ route('pharmacy.stock-barang') }}" class="text-white text-decoration-none fw-medium small d-flex justify-content-between align-items-center">
                        Cek Detail Stok Gudang <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <i class="bi bi-exclamation-triangle position-absolute text-white" style="font-size: 120px; right: -20px; bottom: -30px; opacity: 0.1;"></i>
            </div>
        </div>
    </div>

    {{-- Widget Manajemen Gudang & PO --}}
    <div class="row mb-3 mt-2">
        <div class="col-12">
            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-box-seam me-2"></i>Manajemen Gudang & PO</h5>
        </div>
    </div>
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card border-0 shadow-sm rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center mb-3 relative z-index-1">
                    <div>
                        <p class="mb-0 fw-semibold opacity-75" style="font-size: 13px; letter-spacing: 0.5px;">BUAT PESANAN</p>
                        <h2 class="mb-0 fw-bold mt-1 fs-3">Purchase Order</h2>
                    </div>
                    <div class="stat-icon" style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 18px;">
                        <i class="bi bi-file-earmark-plus fs-2"></i>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top border-light border-opacity-25">
                    <a href="{{ route('purchase-orders.create') }}" class="text-white text-decoration-none fw-medium small d-flex justify-content-between align-items-center">
                        Buat PO Baru ke Supplier <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <i class="bi bi-file-earmark-plus position-absolute text-white" style="font-size: 120px; right: -20px; bottom: -30px; opacity: 0.1;"></i>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card border-0 shadow-sm rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center mb-3 relative z-index-1">
                    <div>
                        <p class="mb-0 fw-semibold opacity-75" style="font-size: 13px; letter-spacing: 0.5px;">PENERIMAAN BARANG</p>
                        <h2 class="mb-0 fw-bold mt-1 fs-3">Terima Stok</h2>
                    </div>
                    <div class="stat-icon" style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 18px;">
                        <i class="bi bi-box-seam fs-2"></i>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top border-light border-opacity-25">
                    <a href="{{ route('pharmacy.penerimaan') }}" class="text-white text-decoration-none fw-medium small d-flex justify-content-between align-items-center">
                        Proses Penerimaan Barang PO <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <i class="bi bi-box-seam position-absolute text-white" style="font-size: 120px; right: -20px; bottom: -30px; opacity: 0.1;"></i>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card border-0 shadow-sm rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center mb-3 relative z-index-1">
                    <div>
                        <p class="mb-0 fw-semibold opacity-75" style="font-size: 13px; letter-spacing: 0.5px;">DATA TRANSAKSI</p>
                        <h2 class="mb-0 fw-bold mt-1 fs-3">Histori PO</h2>
                    </div>
                    <div class="stat-icon" style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 18px;">
                        <i class="bi bi-clock-history fs-2"></i>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top border-light border-opacity-25">
                    <a href="{{ route('purchase-orders.index') }}" class="text-white text-decoration-none fw-medium small d-flex justify-content-between align-items-center">
                        Lihat Semua Data Purchase Order <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <i class="bi bi-clock-history position-absolute text-white" style="font-size: 120px; right: -20px; bottom: -30px; opacity: 0.1;"></i>
            </div>
        </div>
    </div>

    {{-- Tabel Stok Menipis --}}
    @if($lowStockMedicines->count() > 0)
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-danger bg-opacity-10 border-0 pt-4 pb-3 px-4">
            <h6 class="mb-0 fw-bold text-danger"><i class="bi bi-exclamation-circle me-2"></i>Obat dengan Stok Kritis (Segera Restock)</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Nama Obat</th>
                            <th class="py-3">No. Batch</th>
                            <th class="py-3">Exp. Date</th>
                            <th class="py-3 text-end px-4">Sisa Stok</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @foreach($lowStockMedicines as $stock)
                            <tr>
                                <td class="px-4 fw-bold text-dark">{{ $stock->medicine->name }}</td>
                                <td class="text-muted small">{{ $stock->batch_number }}</td>
                                <td>
                                    @php
                                        $exp = \Carbon\Carbon::parse($stock->expiry_date);
                                        $isExpired = $exp->isPast();
                                        $isNear = $exp->diffInDays(now()) <= 30;
                                    @endphp
                                    <span class="badge {{ $isExpired ? 'bg-danger' : ($isNear ? 'bg-warning text-dark' : 'bg-light text-secondary') }} rounded-pill">
                                        {{ $exp->format('d M Y') }}
                                    </span>
                                </td>
                                <td class="text-end px-4">
                                    <span class="fs-5 fw-bold text-danger">{{ $stock->quantity }}</span>
                                    <span class="small text-muted">{{ $stock->medicine->unit }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
