@extends('layouts.app')

@section('title', 'Manajemen Stok Gudang Apotek')
@section('page-title', 'Farmasi & Apotek')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <a href="{{ route('pharmacy.index') }}" class="btn btn-light shadow-sm border rounded-pill px-3 mb-3">
                    <i class="bi bi-arrow-left me-2"></i>Dashboard
                </a>
                <h4 class="mb-1 text-primary fw-bold"><i class="bi bi-box-seam me-2"></i>Inventaris & Stok Gudang</h4>
                <p class="text-muted mb-0">Pantau ketersediaan barang dan tanggal kedaluwarsa (Expired Date).</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary px-4 shadow-sm rounded-pill d-flex align-items-center" onclick="window.print()">
                    <i class="bi bi-printer me-2"></i>Cetak Laporan Stok
                </button>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-secondary" style="font-weight: 600;">Kode & Nama Obat</th>
                            <th class="py-3 text-secondary" style="font-weight: 600;">Lokasi Gudang</th>
                            <th class="py-3 text-secondary" style="font-weight: 600;">No. Batch</th>
                            <th class="py-3 text-secondary" style="font-weight: 600;">Tgl Kadaluarsa (ED)</th>
                            <th class="px-4 py-3 text-secondary text-end" style="font-weight: 600;">Sisa Qty</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($stocks as $stock)
                            @php
                                $exp = \Carbon\Carbon::parse($stock->expiry_date);
                                $isExpired = $exp->isPast();
                                $isNear = $exp->diffInDays(now()) <= 30;
                                $isLow = $stock->quantity <= 10;
                            @endphp
                            <tr class="{{ $isExpired ? 'table-danger' : ($isNear || $isLow ? 'table-warning' : '') }}">
                                <td class="px-4 py-3">
                                    <div class="fw-bold text-dark">{{ $stock->medicine->name }}</div>
                                    <div class="small fw-semibold text-primary"><i class="bi bi-upc-scan me-1"></i>{{ $stock->medicine->code }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">{{ $stock->warehouse ?? 'Gudang Utama' }}</span>
                                </td>
                                <td>
                                    <div class="fw-medium font-monospace text-muted">{{ $stock->batch_number }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold {{ $isExpired ? 'text-danger' : ($isNear ? 'text-warning text-dark' : 'text-success') }}">
                                        {{ $exp->format('d/m/Y') }}
                                        @if($isExpired) <i class="bi bi-exclamation-circle-fill ms-1" title="Sudah Kadaluarsa"></i> @endif
                                    </div>
                                    <div class="small text-muted">{{ $exp->diffForHumans() }}</div>
                                </td>
                                <td class="px-4 text-end">
                                    <div class="fs-5 fw-bold {{ $isLow ? 'text-danger' : 'text-dark' }}">
                                        {{ $stock->quantity }}
                                    </div>
                                    <div class="small text-muted">{{ $stock->medicine->unit }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <div class="mb-3"><i class="bi bi-inboxes fs-1 text-secondary opacity-50"></i></div>
                                    Belum ada data stok masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($stocks->hasPages())
            <div class="card-footer bg-white border-top px-4 py-3">
                {{ $stocks->links() }}
            </div>
        @endif
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    .card, .card * { visibility: visible; }
    .card { position: absolute; left: 0; top: 0; width: 100%; box-shadow: none !important; }
    .btn, .card-footer { display: none !important; }
}
</style>
@endsection
