@extends('layouts.app')

@section('title', 'Laporan Eksekutif SIRS')
@section('page-title', 'Laporan Manajerial')

@section('content')
<div class="container-fluid">
    {{-- Header Page (Non-Print) --}}
    <div class="row mb-4 d-print-none">
        <div class="col-12 d-flex justify-content-between align-items-end flex-wrap gap-3">
            <div>
                <h3 class="mb-1 fw-bold text-dark" style="letter-spacing: -0.5px;"><i class="bi bi-pie-chart-fill text-primary me-2"></i>Laporan & Analitik Keuangan</h3>
                <p class="text-muted mb-0">Modul ringkasan eksekutif untuk memantau performa dan pendapatan rumah sakit.</p>
            </div>
            <div>
                <button onclick="window.print()" class="btn btn-primary px-4 shadow-sm rounded-pill d-flex align-items-center fw-semibold">
                    <i class="bi bi-printer-fill me-2 fs-5"></i> Cetak / Export PDF
                </button>
            </div>
        </div>
    </div>

    {{-- Filter Panel (Non-Print) --}}
    <div class="card border-0 shadow-sm mb-4 d-print-none" style="border-radius: 16px; background: #ffffff;">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('reports.index') }}" method="GET" class="row g-4 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark small text-uppercase" style="letter-spacing: 1px;">Kategori Laporan</label>
                    <select name="type" class="form-select form-select-lg bg-light border-0">
                        <option value="revenue" {{ $reportType == 'revenue' ? 'selected' : '' }}>💰 Laporan Pendapatan (Kasir)</option>
                        <option value="visits" {{ $reportType == 'visits' ? 'selected' : '' }}>🏥 Laporan Kunjungan Pasien</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold text-dark small text-uppercase" style="letter-spacing: 1px;">Mulai Tanggal</label>
                    <input type="date" name="start_date" class="form-control form-control-lg bg-light border-0" value="{{ $startDate }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold text-dark small text-uppercase" style="letter-spacing: 1px;">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control form-control-lg bg-light border-0" value="{{ $endDate }}">
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-dark btn-lg rounded-3 shadow-sm d-flex justify-content-center align-items-center gap-2">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Ringkasan Metrik (Non-Print) --}}
    <div class="row g-4 mb-4 d-print-none">
        @if($reportType == 'revenue')
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden position-relative" style="background: linear-gradient(135deg, #198754 0%, #146c43 100%); color: white;">
                    <div class="card-body p-4 p-md-5 position-relative z-1">
                        <p class="mb-1 text-white opacity-75 fw-semibold text-uppercase small" style="letter-spacing: 1px;">Total Pendapatan Terkumpul</p>
                        <h1 class="display-5 fw-bold mb-0">Rp {{ number_format($totalSum, 0, ',', '.') }}</h1>
                    </div>
                    <i class="bi bi-wallet2 position-absolute" style="font-size: 150px; right: -20px; bottom: -40px; opacity: 0.1; transform: rotate(-15deg);"></i>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden position-relative" style="background: linear-gradient(135deg, #0dcaf0 0%, #08a0e9 100%); color: white;">
                    <div class="card-body p-4 p-md-5 position-relative z-1">
                        <p class="mb-1 text-white opacity-75 fw-semibold text-uppercase small" style="letter-spacing: 1px;">Total Transaksi Lunas</p>
                        <h1 class="display-5 fw-bold mb-0">{{ number_format($subStat, 0, ',', '.') }} <span class="fs-4 opacity-75 fw-normal">Struk</span></h1>
                    </div>
                    <i class="bi bi-receipt position-absolute" style="font-size: 150px; right: -20px; bottom: -40px; opacity: 0.1; transform: rotate(-15deg);"></i>
                </div>
            </div>
        @else
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden position-relative" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); color: white;">
                    <div class="card-body p-4 p-md-5 position-relative z-1">
                        <p class="mb-1 text-white opacity-75 fw-semibold text-uppercase small" style="letter-spacing: 1px;">Total Kunjungan Poli</p>
                        <h1 class="display-5 fw-bold mb-0">{{ number_format($totalSum, 0, ',', '.') }} <span class="fs-4 opacity-75 fw-normal">Kunjungan</span></h1>
                    </div>
                    <i class="bi bi-hospital position-absolute" style="font-size: 150px; right: -20px; bottom: -40px; opacity: 0.1; transform: rotate(-15deg);"></i>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden position-relative" style="background: linear-gradient(135deg, #6f42c1 0%, #59339d 100%); color: white;">
                    <div class="card-body p-4 p-md-5 position-relative z-1">
                        <p class="mb-1 text-white opacity-75 fw-semibold text-uppercase small" style="letter-spacing: 1px;">Jumlah Pasien Unik Berobat</p>
                        <h1 class="display-5 fw-bold mb-0">{{ number_format($subStat, 0, ',', '.') }} <span class="fs-4 opacity-75 fw-normal">Orang</span></h1>
                    </div>
                    <i class="bi bi-people position-absolute" style="font-size: 150px; right: -20px; bottom: -40px; opacity: 0.1; transform: rotate(-15deg);"></i>
                </div>
            </div>
        @endif
    </div>

    {{-- Chart Analitik (Non-Print) --}}
    @if(count($chartLabels) > 0)
    <div class="card border-0 shadow-sm rounded-4 mb-4 d-print-none">
        <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-graph-up-arrow text-primary me-2"></i>Grafik {{ $reportType == 'revenue' ? 'Pendapatan Kasir' : 'Kunjungan Pasien' }} (Harian)</h5>
        </div>
        <div class="card-body p-4">
            <canvas id="reportChart" height="80"></canvas>
        </div>
    </div>
    @endif

    {{-- ========================================================= --}}
    {{--                     PRINT LAYOUT START                    --}}
    {{-- ========================================================= --}}
    <div class="print-container">
        {{-- KOP SURAT CETAK --}}
        <div class="d-none d-print-flex justify-content-between align-items-center mb-4 pb-3" style="border-bottom: 3px solid #000;">
            <div class="d-flex align-items-center gap-4">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5f/Lambang_Kabupaten_Bolaang_Mongondow_Utara.png" alt="Logo Bolmut" style="height: 80px;">
                <div>
                    <h2 class="fw-bold mb-0 text-dark" style="letter-spacing: 1px;">RSUD BOLAANG MONGONDOW UTARA</h2>
                    <p class="mb-0 text-dark" style="font-size: 12pt;">Desa Talaga Tomoagu, Kec. Bolangitang Barat, Kab. Bolaang Mongondow Utara, Sulut</p>
                    <p class="mb-0 text-dark" style="font-size: 10pt;">Telp/WA: 0822-9235-3003 | Email: rsudbolmut.kab@gmail.com</p>
                </div>
            </div>
        </div>

        {{-- JUDUL LAPORAN --}}
        <div class="d-none d-print-block text-center mb-5">
            <h3 class="text-uppercase fw-bold text-dark text-decoration-underline mb-2" style="letter-spacing: 2px;">
                @if($reportType == 'revenue') Laporan Pendapatan & Transaksi Kasir 
                @else Laporan Rekapitulasi Kunjungan Pasien @endif
            </h3>
            <p class="text-dark fw-semibold" style="font-size: 13pt;">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
        </div>

        {{-- TABEL DATA --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                @if($reportType == 'revenue')
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover align-middle mb-0" style="min-width: 800px;">
                            <thead style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                                <tr>
                                    <th class="py-4 px-4 text-secondary text-uppercase small fw-bold" style="letter-spacing: 1px;">No. Invoice</th>
                                    <th class="py-4 text-secondary text-uppercase small fw-bold" style="letter-spacing: 1px;">Tanggal & Waktu</th>
                                    <th class="py-4 text-secondary text-uppercase small fw-bold" style="letter-spacing: 1px;">Nama Pasien</th>
                                    <th class="py-4 text-center text-secondary text-uppercase small fw-bold" style="letter-spacing: 1px;">Metode</th>
                                    <th class="py-4 text-end px-4 text-secondary text-uppercase small fw-bold" style="letter-spacing: 1px;">Nominal Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $payment)
                                    <tr class="border-bottom" style="border-color: #f1f3f5 !important;">
                                        <td class="px-4 py-3 fw-bold text-primary">{{ $payment->invoice_number }}</td>
                                        <td class="py-3 text-muted">{{ \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y H:i') }}</td>
                                        <td class="py-3 fw-semibold text-dark">{{ $payment->registration->patient->name ?? 'Anonim' }}</td>
                                        <td class="py-3 text-center">
                                            <span class="badge bg-dark bg-opacity-10 text-dark rounded-pill px-3 py-2 border">
                                                {{ strtoupper($payment->payment_method) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-end fw-bold fs-6 text-dark">
                                            Rp {{ number_format($payment->total_amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                            Tidak ada transaksi ditemukan pada periode ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot style="background: #f8f9fa;">
                                <tr>
                                    <td colspan="4" class="text-end pe-3 fw-bold py-4 fs-5 text-secondary">TOTAL PENDAPATAN BERSIH :</td>
                                    <td class="text-end pe-4 fw-bolder text-success fs-4 text-nowrap">Rp {{ number_format($totalSum, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                @else
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover align-middle mb-0" style="min-width: 800px;">
                            <thead style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                                <tr>
                                    <th class="py-4 px-4 text-secondary text-uppercase small fw-bold" style="letter-spacing: 1px;">Tgl Masuk</th>
                                    <th class="py-4 text-secondary text-uppercase small fw-bold" style="letter-spacing: 1px;">No. Rekam Medis</th>
                                    <th class="py-4 text-secondary text-uppercase small fw-bold" style="letter-spacing: 1px;">Nama Pasien</th>
                                    <th class="py-4 text-secondary text-uppercase small fw-bold" style="letter-spacing: 1px;">Tujuan / Dokter</th>
                                    <th class="py-4 text-center px-4 text-secondary text-uppercase small fw-bold" style="letter-spacing: 1px;">Status Layan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $reg)
                                    <tr class="border-bottom" style="border-color: #f1f3f5 !important;">
                                        <td class="px-4 py-3 text-muted">{{ \Carbon\Carbon::parse($reg->registration_date)->format('d/m/Y') }}</td>
                                        <td class="py-3 fw-bold font-monospace text-primary">{{ $reg->patient->patient_code }}</td>
                                        <td class="py-3 fw-bold text-dark">{{ $reg->patient->name }}</td>
                                        <td class="py-3">
                                            <div class="fw-semibold text-dark">{{ $reg->department->name ?? '-' }}</div>
                                            <div class="small text-muted">{{ $reg->doctor->name ?? '-' }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            @if($reg->status == 'done')
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-1">Selesai</span>
                                            @elseif($reg->status == 'serving')
                                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning rounded-pill px-3 py-1">Diperiksa</span>
                                            @else
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary rounded-pill px-3 py-1">Menunggu</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                            Tidak ada data kunjungan pada periode ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot style="background: #f8f9fa;">
                                <tr>
                                    <td colspan="4" class="text-end pe-3 fw-bold py-4 fs-5 text-secondary">TOTAL PASIEN DILAYANI :</td>
                                    <td class="text-center pe-4 fw-bolder text-primary fs-4 text-nowrap">{{ number_format($totalSum, 0, ',', '.') }} Jiwa</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- FOOTER TANDA TANGAN (HANYA MUNCUL SAAT CETAK) --}}
        <div class="row mt-5 pt-5 d-none d-print-flex">
            <div class="col-8">
                <p class="small text-dark mb-1">Dicetak dari Sistem Informasi Rumah Sakit Terpadu (SIRS).</p>
                <p class="small text-dark fw-bold">Tanggal Cetak: {{ now()->format('d F Y, H:i') }} WIB</p>
                <div class="mt-4 p-3" style="border: 1px dashed #ccc; border-radius: 8px; width: fit-content;">
                    <i class="bi bi-shield-check text-success me-2"></i> Dokumen ini sah dan di-*generate* oleh sistem.
                </div>
            </div>
            <div class="col-4 text-center">
                <p class="text-dark mb-5 pb-4">Mengetahui,<br><b>Direktur Utama RSUD</b></p>
                <p class="fw-bold text-dark text-decoration-underline mb-0">drg. Firlia Mokoagow</p>
                <p class="text-dark small">NIP. _________________________</p>
            </div>
        </div>
    </div>
</div>

<style>
/* CSS Khusus Layout Print */
@media print {
    @page {
        size: A4 portrait;
        margin: 1.5cm;
    }
    body { background: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    body * { visibility: hidden; }
    
    .print-container, .print-container *, .d-print-block, .d-print-block *, .d-print-flex, .d-print-flex * { 
        visibility: visible; 
    }
    .print-container {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none !important;
        border: none !important;
        background: transparent !important;
    }
    .d-print-none { display: none !important; }
    .d-print-flex { display: flex !important; }
    .d-print-block { display: block !important; }
    
    .card { border: none !important; box-shadow: none !important; }
    .table-borderless td, .table-borderless th { border-bottom: 1px solid #eee !important; }
    tfoot td { border-top: 2px solid #000 !important; }
    
    /* Fix table cut off horizontally */
    .table-responsive { overflow: visible !important; }
    table { min-width: 100% !important; width: 100% !important; max-width: 100% !important; }
}
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(count($chartLabels) > 0)
        const ctx = document.getElementById('reportChart').getContext('2d');
        const labels = @json($chartLabels);
        const data = @json($chartData);
        const isRevenue = '{{ $reportType }}' === 'revenue';
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: isRevenue ? 'Pendapatan (Rp)' : 'Jumlah Pasien',
                    data: data,
                    borderColor: isRevenue ? '#198754' : '#0d6efd',
                    backgroundColor: isRevenue ? 'rgba(25, 135, 84, 0.1)' : 'rgba(13, 110, 253, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: isRevenue ? '#198754' : '#0d6efd',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { borderDash: [2, 4] },
                        ticks: {
                            callback: function(value) {
                                return isRevenue ? 'Rp ' + value.toLocaleString('id-ID') : value;
                            }
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
        @endif
    });
</script>
@endpush
@endsection
