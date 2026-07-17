@extends('layouts.app')

@section('title', 'Detail Pendaftaran')
@section('page-title', 'Detail Kunjungan')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
                <a href="{{ route('registrations.index') }}" class="btn btn-light shadow-sm border rounded-pill px-3">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
                <button onclick="window.print()" class="btn btn-primary shadow-sm rounded-pill px-4 fw-bold">
                    <i class="bi bi-printer me-2"></i>Cetak Karcis Antrian
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-print-none" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Karcis Antrian --}}
            <div class="card border-0 shadow ticket-wrapper mx-auto" style="border-radius: 16px; overflow: hidden;">
                {{-- Header Karcis --}}
                <div class="bg-primary text-white text-center p-4 ticket-header">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5f/Lambang_Kabupaten_Bolaang_Mongondow_Utara.png" alt="Logo Bolmut" style="height: 55px; margin-bottom: 12px; filter: drop-shadow(0px 2px 4px rgba(0,0,0,0.3));">
                    <h5 class="fw-bold mb-0">RSUD BOLAANG MONGONDOW UTARA</h5>
                    <p class="mb-0 small opacity-75" style="font-size: 0.75rem;">Desa Talaga Tomoagu, Kec. Bolangitang Barat</p>
                </div>

                {{-- Body Karcis --}}
                <div class="card-body p-4 text-center bg-white">
                    <h6 class="text-uppercase text-muted fw-bold mb-1">Nomor Antrian</h6>
                    <h1 class="display-1 fw-bold text-dark mb-0" style="letter-spacing: -2px;">{{ $registration->queue_number }}</h1>
                    
                    <div class="d-inline-block bg-light rounded-pill px-4 py-2 mt-3 mb-4 border">
                        <span class="text-muted small">Sisa Antrian:</span> 
                        <span class="fw-bold text-danger fs-5 ms-1">{{ $queueAhead }}</span>
                    </div>

                    <hr class="border-secondary border-opacity-25 border-dashed">

                        <div class="row mb-3">
                            <div class="col-5 text-muted small">Nama Pasien</div>
                            <div class="col-7 fw-bold text-dark text-end">{{ $registration->patient->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 text-muted small">No. RM</div>
                            <div class="col-7 fw-medium text-dark text-end">{{ $registration->patient->patient_code }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 text-muted small">Jenis Kunjungan</div>
                            <div class="col-7 fw-bold text-dark text-end">
                                @php
                                    $visitLabels = ['baru' => 'Pasien Baru', 'lama' => 'Pasien Lama', 'kontrol' => 'Kontrol Ulang'];
                                @endphp
                                {{ $visitLabels[$registration->visit_type] ?? ucfirst($registration->visit_type ?? 'baru') }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 text-muted small">Poli Tujuan</div>
                            <div class="col-7 fw-bold text-dark text-end">{{ $registration->department->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 text-muted small">Dokter</div>
                            <div class="col-7 fw-bold text-dark text-end">{{ $registration->doctor->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 text-muted small">Cara Bayar</div>
                            <div class="col-7 fw-bold text-dark text-end">
                                @php
                                    $paymentLabels = ['umum' => 'UMUM', 'bpjs' => 'BPJS', 'asuransi' => 'ASURANSI', 'perusahaan' => 'PERUSAHAAN', 'jamkesda' => 'JAMKESDA'];
                                @endphp
                                {{ $paymentLabels[$registration->payment_method] ?? strtoupper($registration->payment_method ?? 'UMUM') }}
                                @if($registration->payment_method === 'bpjs' && $registration->bpjs_class)
                                    <span class="badge bg-info bg-opacity-10 text-info ms-1">Kelas {{ $registration->bpjs_class }}</span>
                                @endif
                            </div>
                        </div>
                        @if($registration->payment_method === 'bpjs' && $registration->sep_number)
                        <div class="row mb-3">
                            <div class="col-5 text-muted small">No. SEP</div>
                            <div class="col-7 fw-medium text-dark text-end small">{{ $registration->sep_number }}</div>
                        </div>
                        @endif
                        @if($registration->referral_number)
                        <div class="row mb-3">
                            <div class="col-5 text-muted small">No. Rujukan</div>
                            <div class="col-7 fw-medium text-dark text-end small">{{ $registration->referral_number }}</div>
                        </div>
                        @endif
                        @if($registration->referral_origin)
                        <div class="row mb-3">
                            <div class="col-5 text-muted small">Faskes Perujuk</div>
                            <div class="col-7 fw-medium text-dark text-end small">{{ $registration->referral_origin }}</div>
                        </div>
                        @endif
                        @if($registration->referral_file_path)
                        <div class="row mb-3 d-print-none">
                            <div class="col-5 text-muted small">File Rujukan</div>
                            <div class="col-7 text-end">
                                <a href="{{ asset('storage/' . $registration->referral_file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary py-0">Lihat Surat</a>
                            </div>
                        </div>
                        @endif
                        @if($registration->complaint)
                        <div class="row mb-3">
                            <div class="col-5 text-muted small">Keluhan</div>
                            <div class="col-7 fw-medium text-dark text-end small">{{ \Illuminate\Support\Str::limit($registration->complaint, 60) }}</div>
                        </div>
                        @endif
                        <div class="row mb-2">
                            <div class="col-5 text-muted small">Waktu Daftar</div>
                            <div class="col-7 fw-medium text-dark text-end small">
                                {{ \Carbon\Carbon::parse($registration->created_at)->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer Karcis --}}
                <div class="card-footer bg-light border-top-0 text-center p-3">
                    <p class="small text-muted mb-0">Mohon tunggu di ruang tunggu poli yang dituju.<br>Semoga lekas sembuh!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Style garis putus-putus untuk karcis */
.border-dashed {
    border-style: dashed !important;
}

/* CSS Khusus Print (Printer Thermal / Normal) */
@media print {
    body * {
        visibility: hidden;
    }
    .ticket-wrapper, .ticket-wrapper * {
        visibility: visible;
    }
    .ticket-wrapper {
        position: absolute;
        left: 0;
        top: 0;
        width: 100% !important;
        max-width: 80mm !important; /* Ukuran standard printer thermal 80mm */
        margin: 0 !important;
        box-shadow: none !important;
        border: none !important;
        border-radius: 0 !important;
    }
    .ticket-header {
        background-color: #000 !important;
        color: #fff !important;
        -webkit-print-color-adjust: exact;
    }
    .d-print-none {
        display: none !important;
    }
    @page { margin: 0; }
}
</style>
@endsection
