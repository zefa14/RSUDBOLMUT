@extends('layouts.app')

@section('content')
    <div class="hero-box p-4 mb-4 card-modern" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); color: white;">
        <div class="row align-items-center">
            <div class="col-md-8">
                <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill shadow-sm">
                    <i class="bi bi-hospital me-1"></i> Dashboard SIRS Terpadu
                </span>
                <h2 class="fw-bold mb-2">Selamat Datang di Sistem Informasi Rumah Sakit</h2>
                <p class="mb-0 opacity-75">
                    Pantau kinerja operasional, grafik kunjungan pasien, dan manajemen klinis dalam satu layar.
                </p>
            </div>
            <div class="col-md-4 text-center d-none d-md-block">
                <i class="bi bi-activity text-white opacity-25" style="font-size: 120px;"></i>
            </div>
        </div>
    </div>

    {{-- Widget Angka --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card p-3 border-0 shadow-sm rounded-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted fw-semibold">Total Pasien</small>
                        <h3 class="fw-bold mb-0 text-dark">{{ $totalPatients }}</h3>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary p-3 rounded-3 fs-4">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card p-3 border-0 shadow-sm rounded-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted fw-semibold">Total Dokter</small>
                        <h3 class="fw-bold mb-0 text-dark">{{ $totalDoctors }}</h3>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success p-3 rounded-3 fs-4">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card p-3 border-0 shadow-sm rounded-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted fw-semibold">Total Poli</small>
                        <h3 class="fw-bold mb-0 text-dark">{{ $totalDepartments }}</h3>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning p-3 rounded-3 fs-4">
                        <i class="bi bi-building"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card p-3 border-0 shadow-sm rounded-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted fw-semibold">Total Pendaftaran</small>
                        <h3 class="fw-bold mb-0 text-dark">{{ $totalRegistrations }}</h3>
                    </div>
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger p-3 rounded-3 fs-4">
                        <i class="bi bi-journal-medical"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Area Grafik Analitik --}}
    <div class="row g-4 mb-4">
        {{-- Grafik Bar Tren Kunjungan --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-bar-chart-fill text-primary me-2"></i>Tren Kunjungan Pasien ({{ date('Y') }})</h5>
                </div>
                <div class="card-body p-4">
                    <canvas id="kunjunganChart" height="100"></canvas>
                </div>
            </div>
        </div>

        {{-- Grafik Donut Rasio Poli --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-pie-chart-fill text-success me-2"></i>Kepadatan Poliklinik</h5>
                </div>
                <div class="card-body p-4 d-flex justify-content-center align-items-center">
                    <canvas id="poliChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Menu Navigasi Cepat --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4">Akses Cepat Modul Operasional</h5>
            <div class="row g-3">
                <div class="col-md-3">
                    <a href="{{ route('registrations.create') }}" class="text-decoration-none">
                        <div class="p-3 bg-light rounded-4 text-center border h-100 hover-elevate">
                            <i class="bi bi-journal-plus fs-2 text-primary"></i>
                            <h6 class="mt-2 mb-1 text-dark">Pendaftaran (Admisi)</h6>
                            <small class="text-muted">Daftarkan pasien baru/lama</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('medical_records.index') }}" class="text-decoration-none">
                        <div class="p-3 bg-light rounded-4 text-center border h-100 hover-elevate">
                            <i class="bi bi-heart-pulse-fill fs-2 text-danger"></i>
                            <h6 class="mt-2 mb-1 text-dark">Poli & Rekam Medis</h6>
                            <small class="text-muted">Pemeriksaan Dokter & E-Resep</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ url('/pharmacy') }}" class="text-decoration-none">
                        <div class="p-3 bg-light rounded-4 text-center border h-100 hover-elevate">
                            <i class="bi bi-capsule fs-2 text-info"></i>
                            <h6 class="mt-2 mb-1 text-dark">Instalasi Farmasi</h6>
                            <small class="text-muted">Tebus resep & stok obat</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('payments.index') }}" class="text-decoration-none">
                        <div class="p-3 bg-light rounded-4 text-center border h-100 hover-elevate">
                            <i class="bi bi-cash-coin fs-2 text-success"></i>
                            <h6 class="mt-2 mb-1 text-dark">Kasir Utama</h6>
                            <small class="text-muted">Pembayaran & Cetak Struk</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-elevate { transition: transform 0.2s, box-shadow 0.2s; }
        .hover-elevate:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; background: white !important;}
    </style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Grafik Bar Kunjungan ---
        const ctxKunjungan = document.getElementById('kunjunganChart').getContext('2d');
        const dataKunjungan = @json($chartKunjungan);
        
        new Chart(ctxKunjungan, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Jumlah Pasien Masuk',
                    data: dataKunjungan,
                    backgroundColor: 'rgba(13, 110, 253, 0.8)',
                    borderRadius: 6,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                    x: { grid: { display: false } }
                }
            }
        });

        // --- Grafik Donut Poli ---
        const ctxPoli = document.getElementById('poliChart').getContext('2d');
        const labelsPoli = @json($chartPoliLabels);
        const dataPoli = @json($chartPoliData);
        
        new Chart(ctxPoli, {
            type: 'doughnut',
            data: {
                labels: labelsPoli.length > 0 ? labelsPoli : ['Belum Ada Data'],
                datasets: [{
                    data: dataPoli.length > 0 ? dataPoli : [1],
                    backgroundColor: [
                        '#0d6efd', '#198754', '#ffc107', '#dc3545', '#0dcaf0', '#6610f2'
                    ],
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endpush