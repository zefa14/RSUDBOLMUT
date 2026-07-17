@extends('layouts.app')

@section('title', 'Rincian Tagihan Kasir')
@section('page-title', 'Kasir & Tagihan')

@section('content')
<div class="container-fluid">
    <div class="row mb-4 d-print-none">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('payments.index') }}" class="btn btn-light shadow-sm border rounded-pill px-3">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Antrian
            </a>
            @if($payment->status == 'paid')
                <button onclick="window.print()" class="btn btn-outline-primary px-4 shadow-sm rounded-pill">
                    <i class="bi bi-printer me-2"></i>Cetak Struk Tagihan
                </button>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 d-print-none" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Kolom Invoice Utama --}}
        <div class="col-lg-{{ $payment->status == 'pending' ? '8' : '12' }}">
            <div class="card border-0 shadow-sm print-container" style="border-radius: 16px;">
                <div class="card-body p-4 p-md-5">
                    
                    {{-- Header Invoice --}}
                    <div class="row mb-5 pb-4 border-bottom">
                        <div class="col-sm-7 mb-3 mb-sm-0">
                            <h3 class="fw-bold text-success mb-1 d-flex align-items-center">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5f/Lambang_Kabupaten_Bolaang_Mongondow_Utara.png" alt="Logo Bolmut" style="height: 45px; margin-right: 12px;">
                                RSUD BOLAANG MONGONDOW UTARA
                            </h3>
                            <p class="text-muted small mb-0">Desa Talaga Tomoagu, Kec. Bolangitang Barat, Kab. Bolaang Mongondow Utara, Sulut</p>
                            <p class="text-muted small">Telp/WA: 0822-9235-3003 | Email: rsudbolmut.kab@gmail.com</p>
                        </div>
                        <div class="col-sm-5 text-sm-end">
                            <h5 class="text-uppercase fw-bold text-dark mb-1">
                                {{ $payment->status == 'paid' ? 'KWITANSI PEMBAYARAN' : 'TAGIHAN BIAYA PELAYANAN' }}
                            </h5>
                            <p class="mb-0 fw-semibold text-primary">NO: {{ $payment->invoice_number }}</p>
                            <p class="text-muted small mb-0">Tgl Terbit: {{ $payment->created_at->format('d/m/Y') }}</p>
                            <span class="badge bg-{{ $payment->status_color }} mt-2 px-3 py-2 rounded-pill fs-6">
                                STATUS: {{ strtoupper($payment->status_label) }}
                            </span>
                        </div>
                    </div>

                    {{-- Info Pasien & Kunjungan --}}
                    <div class="row mb-5">
                        <div class="col-sm-6 mb-4 mb-sm-0">
                            <h6 class="text-uppercase text-muted fw-bold mb-3 small" style="letter-spacing: 1px;">Ditagihkan Kepada:</h6>
                            @if($payment->payment_type == 'pharmacy_sale')
                                <h5 class="fw-bold text-dark mb-1">{{ $payment->customer_name ?? ($payment->patient->name ?? 'Pembeli Umum') }}</h5>
                                @if($payment->patient)
                                    <p class="mb-0 text-muted">No. RM: {{ $payment->patient->patient_code }}</p>
                                @endif
                                <p class="mb-0 text-muted">Pelanggan Apotek</p>
                            @else
                                <h5 class="fw-bold text-dark mb-1">{{ $payment->registration->patient->name ?? 'Unknown' }}</h5>
                                <p class="mb-0 text-muted">No. RM: {{ $payment->registration->patient->patient_code ?? '-' }}</p>
                                <p class="mb-0 text-muted">NIK: {{ $payment->registration->patient->nik ?? '-' }}</p>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <h6 class="text-uppercase text-muted fw-bold mb-3 small" style="letter-spacing: 1px;">Info Layanan Medis:</h6>
                            <table class="table table-sm table-borderless mb-0">
                                @if($payment->payment_type == 'pharmacy_sale')
                                    <tr>
                                        <td class="text-muted ps-0" width="40%">Layanan</td>
                                        <td class="fw-bold text-dark">: Penjualan Apotek (Obat Bebas)</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="text-muted ps-0" width="40%">Poliklinik</td>
                                        <td class="fw-bold text-dark">: {{ $payment->registration->department->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted ps-0">Dokter</td>
                                        <td class="fw-medium">: {{ $payment->registration->doctor->name ?? '-' }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    {{-- Tabel Rincian Item --}}
                    <h6 class="text-uppercase text-muted fw-bold mb-3 small" style="letter-spacing: 1px;">Rincian Biaya:</h6>
                    <div class="table-responsive mb-4 border rounded-3">
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="table-light border-bottom">
                                <tr>
                                    <th class="py-3 ps-4 text-secondary">Deskripsi Layanan / Obat</th>
                                    <th class="py-3 text-center text-secondary" width="15%">Qty</th>
                                    <th class="py-3 text-end text-secondary" width="20%">Harga Satuan</th>
                                    <th class="py-3 text-end pe-4 text-secondary" width="25%">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payment->items as $item)
                                    <tr class="border-bottom border-light">
                                        <td class="py-3 ps-4 fw-medium text-dark">{{ $item->description }}</td>
                                        <td class="py-3 text-center">{{ $item->quantity }}</td>
                                        <td class="py-3 text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="py-3 text-end pe-4 fw-semibold text-dark">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Total Sum --}}
                    <div class="row">
                        <div class="col-sm-6">
                            @if($payment->notes)
                                <div class="p-3 bg-light rounded-3 mt-3">
                                    <p class="small fw-bold text-muted mb-1">Catatan:</p>
                                    <p class="small text-dark mb-0">{{ $payment->notes }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-sm-6 text-end">
                            <table class="table table-sm table-borderless text-end ms-auto" style="max-width: 300px;">
                                <tr>
                                    <td class="text-muted fs-5 pb-2">TOTAL TAGIHAN</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-primary display-6 border-top pt-2">{{ $payment->formatted_amount }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Tanda Tangan (Cetak) --}}
                    @if($payment->status == 'paid')
                        <div class="row mt-5 pt-4 d-none d-print-flex">
                            <div class="col-8">
                                <p class="small text-muted mb-0">Pembayaran Lunas via {{ $payment->payment_method_label }}.</p>
                                <p class="small text-muted">Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
                            </div>
                            <div class="col-4 text-center">
                                <p class="mb-5">Petugas Kasir,</p>
                                <p class="fw-bold text-decoration-underline mb-0">{{ $payment->processor->name ?? 'Sistem' }}</p>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- Kolom Proses Pembayaran (Jika Belum Lunas) --}}
        @if($payment->status == 'pending')
            <div class="col-lg-4 d-print-none">
                <div class="card border-0 shadow-sm rounded-4 position-sticky" style="top: 100px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-wallet2 text-primary me-2"></i>Proses Pembayaran</h5>
                        
                        <form action="{{ route('payments.process', $payment->id) }}" method="POST">
                            @csrf
                            
                            <div class="mb-4 bg-light p-3 rounded-3 text-center">
                                <span class="d-block text-muted small mb-1">TOTAL YANG HARUS DIBAYAR</span>
                                <span class="fs-3 fw-bold text-danger">{{ $payment->formatted_amount }}</span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary">Metode Pembayaran</label>
                                <select name="payment_method" id="paymentMethod" class="form-select border-primary shadow-sm py-2">
                                    <option value="cash">Uang Tunai (Cash)</option>
                                    <option value="debit">Kartu Debit / EDC</option>
                                    <option value="transfer">Transfer Bank / QRIS</option>
                                    <option value="bpjs">BPJS Kesehatan</option>
                                    <option value="insurance">Asuransi Swasta</option>
                                </select>
                            </div>

                            <div class="mb-4" id="cashInputGroup">
                                <label class="form-label fw-semibold text-secondary">Jumlah Uang Diterima (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">Rp</span>
                                    <input type="number" name="cash_received" id="cashReceived" class="form-control border-start-0 fs-5 fw-bold" placeholder="0">
                                </div>
                                <div class="mt-3 d-flex justify-content-between p-2 rounded-2" id="changeAlert" style="display: none !important; background: #e7f1ff;">
                                    <span class="text-primary fw-semibold small">Kembalian:</span>
                                    <span class="text-primary fw-bold fs-6" id="changeAmount">Rp 0</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-secondary">Catatan (Opsional)</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Catatan pembayaran..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm d-flex justify-content-center align-items-center gap-2">
                                <i class="bi bi-check2-circle fs-5"></i> Konfirmasi Pelunasan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
@media print {
    body { background: white; }
    body * { visibility: hidden; }
    .print-container, .print-container * { visibility: visible; }
    .print-container {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .d-print-none { display: none !important; }
    .d-print-flex { display: flex !important; }
}
</style>

@if($payment->status == 'pending')
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const methodSelect = document.getElementById('paymentMethod');
        const cashInputGroup = document.getElementById('cashInputGroup');
        const cashReceived = document.getElementById('cashReceived');
        const changeAlert = document.getElementById('changeAlert');
        const changeAmount = document.getElementById('changeAmount');
        const totalTagihan = {{ $payment->total_amount }};

        methodSelect.addEventListener('change', function() {
            if(this.value === 'cash') {
                cashInputGroup.style.display = 'block';
            } else {
                cashInputGroup.style.display = 'none';
            }
        });

        cashReceived.addEventListener('input', function() {
            let cash = parseFloat(this.value) || 0;
            let change = cash - totalTagihan;
            
            changeAlert.style.setProperty('display', 'flex', 'important');

            if(change >= 0) {
                changeAmount.textContent = 'Rp ' + change.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                changeAmount.className = 'fw-bold fs-6 text-success';
                changeAlert.style.background = '#d1e7dd'; // bg-success-subtle
                changeAlert.querySelector('span:first-child').className = 'text-success fw-semibold small';
            } else {
                changeAmount.textContent = 'Kurang Rp ' + Math.abs(change).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                changeAmount.className = 'fw-bold fs-6 text-danger';
                changeAlert.style.background = '#f8d7da'; // bg-danger-subtle
                changeAlert.querySelector('span:first-child').className = 'text-danger fw-semibold small';
            }
        });
    });
</script>
@endpush
@endif
@endsection
