@extends('layouts.app')

@section('title', 'Riwayat Rekam Medis')
@section('page-title', 'Rekam Medis')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="mb-1 text-primary fw-bold"><i class="bi bi-journal-medical me-2"></i>Arsip Rekam Medis</h4>
                <p class="text-muted mb-0">Database riwayat pemeriksaan, diagnosa, dan tindakan medis pasien.</p>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('medical_records.index') }}" method="GET" class="d-flex position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" name="search" class="form-control ps-5 rounded-pill shadow-sm border-0" placeholder="Cari Nama / No RM..." value="{{ request('search') }}" style="width: 250px;">
                </form>
                {{-- Form Create Rekam Medis Langsung (Tanpa Antrian) biasanya opsional, tapi disiapkan --}}
                <a href="{{ route('medical_records.create') }}" class="btn btn-primary px-4 shadow-sm rounded-pill d-flex align-items-center">
                    <i class="bi bi-file-earmark-plus me-2"></i>Input Manual
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-secondary" style="font-weight: 600; width: 15%;">Tanggal</th>
                            <th class="py-3 text-secondary" style="font-weight: 600; width: 25%;">Identitas Pasien</th>
                            <th class="py-3 text-secondary" style="font-weight: 600; width: 25%;">Diagnosa Utama</th>
                            <th class="py-3 text-secondary" style="font-weight: 600; width: 20%;">Dokter Pemeriksa</th>
                            <th class="px-4 py-3 text-secondary text-end" style="font-weight: 600; width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($records as $rm)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($rm->record_date)->format('d M Y') }}</div>
                                    <div class="small text-muted">{{ $rm->created_at->format('H:i') }} WIB</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-primary">{{ $rm->patient->name }}</div>
                                    <div class="small text-muted"><i class="bi bi-upc-scan me-1"></i>RM: {{ $rm->patient->patient_code }}</div>
                                </td>
                                <td>
                                    <div class="fw-medium text-dark text-truncate" style="max-width: 250px;" title="{{ $rm->diagnosis }}">
                                        {{ $rm->diagnosis }}
                                    </div>
                                    @if($rm->prescriptions->count() > 0)
                                        <div class="small mt-1"><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2"><i class="bi bi-capsule me-1"></i>{{ $rm->prescriptions->count() }} Resep Obat</span></div>
                                    @endif
                                </td>
                                <td>
                                    <div class="small text-dark fw-semibold"><i class="bi bi-person-badge me-1"></i>{{ $rm->doctor->name }}</div>
                                    <div class="small text-muted">{{ $rm->department->name }}</div>
                                </td>
                                <td class="px-4 text-end">
                                    <a href="{{ route('medical_records.show', $rm->id) }}" class="btn btn-light btn-sm text-primary border me-1" data-bs-toggle="tooltip" title="Lihat Detail Rekam Medis">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <div class="mb-3"><i class="bi bi-folder-x fs-1 text-secondary opacity-50"></i></div>
                                    Belum ada data Rekam Medis.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($records->hasPages())
            <div class="card-footer bg-white border-top px-4 py-3">
                {{ $records->links() }}
            </div>
        @endif
    </div>
</div>
@endsection