@extends('layouts.app')

@section('title', 'Detail Rekam Medis')
@section('page-title', 'Detail Rekam Medis')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('medical_records.index') }}" class="btn btn-light shadow-sm border rounded-pill px-3">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
            <button onclick="window.print()" class="btn btn-outline-primary px-4 shadow-sm rounded-pill d-print-none">
                <i class="bi bi-printer me-2"></i>Cetak Dokumen
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm print-container" style="border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-white border-bottom pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0 fw-bold text-dark">Laporan Rekam Medis</h4>
                <p class="text-muted small mb-0 mt-1">Tanggal Periksa: {{ \Carbon\Carbon::parse($record->record_date)->format('d F Y') }}</p>
            </div>
            <div class="text-end d-none d-sm-block">
                <h3 class="mb-0 text-primary"><i class="bi bi-hospital"></i> SIRS RSUD</h3>
            </div>
        </div>
        
        <div class="card-body p-4 p-md-5">
            {{-- Bagian Info Identitas --}}
            <div class="row mb-5">
                <div class="col-sm-6 mb-4 mb-sm-0">
                    <h6 class="text-uppercase text-muted fw-bold mb-3 small" style="letter-spacing: 1px;">Data Pasien</h6>
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted ps-0" width="35%">No. Rekam Medis</td>
                            <td class="fw-bold">: {{ $record->patient->patient_code }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Nama Lengkap</td>
                            <td class="fw-bold text-primary">: {{ $record->patient->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Tanggal Lahir</td>
                            <td class="fw-medium">: {{ \Carbon\Carbon::parse($record->patient->birth_date)->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($record->patient->birth_date)->age }} Thn)</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Jenis Kelamin</td>
                            <td class="fw-medium">: {{ $record->patient->gender == 'L' || $record->patient->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-6 border-start ps-sm-4">
                    <h6 class="text-uppercase text-muted fw-bold mb-3 small" style="letter-spacing: 1px;">Pemeriksa</h6>
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted ps-0" width="35%">Dokter Utama</td>
                            <td class="fw-bold text-dark">: {{ $record->doctor->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Poliklinik</td>
                            <td class="fw-medium">: {{ $record->department->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Waktu Catat</td>
                            <td class="fw-medium">: {{ $record->created_at->format('H:i:s') }} WIB</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Bagian Diagnosa (SOAP Lengkap) --}}
            <div class="mb-5">
                <h6 class="text-uppercase border-bottom pb-2 mb-3 fw-bold text-secondary">Hasil Pemeriksaan Klinis (SOAP)</h6>
                
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="text-primary small fw-bold mb-1"><i class="bi bi-chat-text me-1"></i>S - Subjective (Keluhan):</div>
                        <div class="p-3 bg-light rounded text-dark border-start border-primary border-4 h-100">
                            {{ $record->subjective ?: ($record->complaint ?: 'Tidak ada catatan.') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-success small fw-bold mb-1"><i class="bi bi-activity me-1"></i>O - Objective (Fisik & Vitals):</div>
                        <div class="p-3 bg-light rounded text-dark border-start border-success border-4 h-100">
                            <div class="row g-2 small mb-2 text-muted fw-medium">
                                <div class="col-6">TD: <span class="text-dark">{{ $record->blood_pressure ?: '-' }}</span> mmHg</div>
                                <div class="col-6">Suhu: <span class="text-dark">{{ $record->temperature ?: '-' }}</span> &deg;C</div>
                                <div class="col-6">BB: <span class="text-dark">{{ $record->weight ?: '-' }}</span> kg</div>
                                <div class="col-6">TB: <span class="text-dark">{{ $record->height ?: '-' }}</span> cm</div>
                            </div>
                            <div class="border-top pt-2">
                                {{ $record->objective ?: 'Tidak ada catatan fisik tambahan.' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-danger small fw-bold mb-1"><i class="bi bi-clipboard2-pulse me-1"></i>A - Assessment (Diagnosa):</div>
                        <div class="p-3 bg-danger bg-opacity-10 text-danger rounded fw-medium border border-danger border-opacity-25 h-100">
                            @if($record->icd10_code)
                                <span class="badge bg-danger mb-2">{{ $record->icd10_code }}</span><br>
                            @endif
                            {{ $record->assessment ?: ($record->diagnosis ?: 'Tidak ada diagnosa.') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-info small fw-bold mb-1"><i class="bi bi-journal-medical me-1"></i>P - Plan (Tindakan):</div>
                        <div class="p-3 bg-light rounded text-dark border-start border-info border-4 h-100">
                            {{ $record->plan ?: ($record->treatment ?: 'Tidak ada plan/tindakan khusus yang dicatat.') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Resep Obat --}}
            <div>
                <h6 class="text-uppercase border-bottom pb-2 mb-3 fw-bold text-success"><i class="bi bi-capsule me-2"></i>E-Resep Obat</h6>
                @if($record->prescriptions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" width="5%">No</th>
                                    <th>Nama Obat</th>
                                    <th class="text-center" width="15%">Jumlah</th>
                                    <th width="20%">Dosis / Signa</th>
                                    <th width="30%">Instruksi Khusus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($record->prescriptions as $key => $prescription)
                                    <tr>
                                        <td class="text-center text-muted">{{ $key + 1 }}</td>
                                        <td class="fw-bold">{{ $prescription->medicine->name ?? 'Obat Terhapus' }}</td>
                                        <td class="text-center fw-medium">{{ $prescription->quantity }} {{ $prescription->medicine->unit ?? 'Pcs' }}</td>
                                        <td>{{ $prescription->dosage ?? '-' }}</td>
                                        <td class="text-muted small">{{ $prescription->instructions ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 bg-light rounded text-muted">
                        <i class="bi bi-shield-check fs-2 text-secondary opacity-50 mb-2 d-block"></i>
                        Pasien tidak diberikan resep obat pada kunjungan ini.
                    </div>
                @endif
            </div>

            {{-- Tanda Tangan (Khusus Print) --}}
            <div class="row mt-5 pt-5 d-none d-print-flex">
                <div class="col-8"></div>
                <div class="col-4 text-center">
                    <p class="mb-5">Dokter Pemeriksa,</p>
                    <p class="fw-bold text-decoration-underline mb-0">{{ $record->doctor->name }}</p>
                    <p class="small text-muted">SIP: {{ $record->doctor->sip_number ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .print-container, .print-container * {
        visibility: visible;
    }
    .print-container {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none !important;
        border: none !important;
    }
    .d-print-none {
        display: none !important;
    }
    .d-print-flex {
        display: flex !important;
    }
}
</style>
@endsection
