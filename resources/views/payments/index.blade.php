@extends('layouts.app')

@section('title', 'Kasir Utama & Pembayaran')
@section('page-title', 'Kasir & Tagihan')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 text-primary fw-bold"><i class="bi bi-wallet2 me-2"></i>Antrian Kasir & Tagihan Pasien</h4>
                <p class="text-muted mb-0">Kelola pembayaran biaya konsultasi dokter, obat, dan tindakan medis.</p>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Kolom Kiri: Antrian Belum Dibayar & Draft --}}
        <div class="col-lg-7">
            {{-- Antrian yang butuh pembuatan Draft --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-warning bg-opacity-10 border-bottom-0 pt-4 pb-3 px-4">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-hourglass-split text-warning me-2"></i>Menunggu Pembuatan Tagihan</h6>
                    <small class="text-muted">Pasien selesai periksa yang belum diterbitkan rincian tagihannya.</small>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($unpaidRegistrations as $reg)
                            <div class="list-group-item p-4 border-bottom">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold mb-0 text-primary">{{ $reg->patient->name }}</h6>
                                    <span class="badge bg-light text-dark border">{{ \Carbon\Carbon::parse($reg->registration_date)->format('d/m/Y') }}</span>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted d-block"><i class="bi bi-upc-scan me-1"></i>RM: {{ $reg->patient->patient_code }}</small>
                                    <small class="text-muted d-block"><i class="bi bi-person-badge me-1"></i>{{ $reg->doctor->name }} ({{ $reg->department->name }})</small>
                                </div>
                                <div class="d-grid">
                                    <a href="{{ route('payments.createDraft', $reg->id) }}" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold shadow-sm">
                                        <i class="bi bi-receipt me-1"></i> Buat Rincian Tagihan
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-muted small">
                                Tidak ada antrian pembuatan tagihan.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Draft Tagihan Siap Bayar --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-primary bg-opacity-10 border-bottom-0 pt-4 pb-3 px-4">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-cash-stack text-primary me-2"></i>Tagihan Menunggu Pembayaran</h6>
                    <small class="text-muted">Draft tagihan yang sudah siap dilunasi oleh pasien.</small>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($pendingPayments as $pending)
                            <a href="{{ route('payments.show', $pending->id) }}" class="list-group-item p-4 border-bottom list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold mb-0 text-primary">
                                        @if($pending->payment_type == 'pharmacy_sale')
                                            {{ $pending->customer_name ?? ($pending->patient->name ?? 'Pembeli Umum') }}
                                        @else
                                            {{ $pending->registration->patient->name ?? 'Unknown' }}
                                        @endif
                                    </h6>
                                    <span class="badge bg-warning text-dark border">{{ $pending->invoice_number }}</span>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted d-block"><i class="bi bi-tags me-1"></i>Tipe: {{ $pending->payment_type == 'pharmacy_sale' ? 'Penjualan Apotek' : 'Pendaftaran Medis' }}</small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">{{ $pending->formatted_amount }}</span>
                                    <span class="btn btn-primary btn-sm rounded-pill fw-semibold shadow-sm">
                                        <i class="bi bi-credit-card me-1"></i> Proses Pembayaran
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="p-4 text-center text-muted small">
                                Tidak ada draft tagihan yang menunggu pembayaran.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Riwayat Pembayaran Lunas --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-success bg-opacity-10 border-bottom-0 pt-4 pb-3 px-4">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-check-circle-fill text-success me-2"></i>Transaksi Lunas Terakhir</h6>
                    <small class="text-muted">Riwayat pembayaran bulan ini.</small>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($paidPayments as $payment)
                            <a href="{{ route('payments.show', $payment->id) }}" class="list-group-item list-group-item-action p-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div class="fw-bold text-dark">{{ $payment->invoice_number }}</div>
                                    <span class="badge bg-success rounded-pill px-2">Lunas</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-end">
                                    <div>
                                        <div class="small text-muted">
                                            @if($payment->payment_type == 'pharmacy_sale')
                                                <i class="bi bi-shop me-1"></i>Apotek: {{ $payment->customer_name ?? ($payment->patient->name ?? 'Umum') }}
                                            @else
                                                <i class="bi bi-person me-1"></i>Poli: {{ $payment->registration->patient->name ?? 'Unknown' }}
                                            @endif
                                        </div>
                                        <div class="small text-muted opacity-75 mt-1">{{ $payment->paid_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                    <div class="fw-bold text-success">
                                        {{ $payment->formatted_amount }}
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-4 text-center text-muted small">
                                Belum ada riwayat pembayaran lunas.
                            </div>
                        @endforelse
                    </div>
                </div>
                @if($paidPayments->hasPages())
                    <div class="card-footer bg-white px-4 py-3 border-top">
                        {{ $paidPayments->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
