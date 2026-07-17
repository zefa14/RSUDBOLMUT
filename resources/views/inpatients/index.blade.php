@extends('layouts.app')

@section('title', 'Daftar Rawat Inap')
@section('page-title', 'Rawat Inap (Bed Management)')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 text-primary fw-bold"><i class="bi bi-hospital me-2"></i>Manajemen Bangsal & Rawat Inap</h4>
                <p class="text-muted mb-0">Kelola pasien yang sedang dirawat dan riwayat pemulangan.</p>
            </div>
            <a href="{{ route('inpatients.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
                <i class="bi bi-plus-lg me-2"></i>Daftarkan Pasien Inap
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-header bg-primary bg-opacity-10 border-bottom-0 pt-4 pb-3 px-4">
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-bed text-primary me-2"></i>Pasien Sedang Dirawat</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No. RM</th>
                            <th>Nama Pasien</th>
                            <th>Ruangan / Bed</th>
                            <th>Dokter DPJP</th>
                            <th>Tgl Masuk</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inpatients as $inpatient)
                            <tr>
                                <td class="ps-4 text-muted">{{ $inpatient->patient->patient_code }}</td>
                                <td class="fw-bold text-primary">{{ $inpatient->patient->name }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $inpatient->room->name }}</span>
                                    <div class="small text-muted">{{ $inpatient->room->room_class }}</div>
                                </td>
                                <td>{{ $inpatient->doctor->name }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($inpatient->admission_date)->format('d M Y') }}<br>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($inpatient->admission_date)->format('H:i') }} WIB</small>
                                </td>
                                <td class="text-center pe-4">
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#dischargeModal{{ $inpatient->id }}">
                                        <i class="bi bi-box-arrow-right me-1"></i> Pulangkan (Discharge)
                                    </button>
                                </td>
                            </tr>

                            <!-- Discharge Modal -->
                            <div class="modal fade" id="dischargeModal{{ $inpatient->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow rounded-4">
                                        <div class="modal-header border-bottom bg-light">
                                            <h5 class="modal-title fw-bold text-danger"><i class="bi bi-box-arrow-right me-2"></i>Pulangkan Pasien</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('inpatients.discharge', $inpatient->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body p-4">
                                                <p>Anda akan memulangkan pasien <strong>{{ $inpatient->patient->name }}</strong> dari ruangan <strong>{{ $inpatient->room->name }}</strong>.</p>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Tanggal Kepulangan <span class="text-danger">*</span></label>
                                                    <input type="date" name="discharge_date" class="form-control" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required min="{{ \Carbon\Carbon::parse($inpatient->admission_date)->format('Y-m-d') }}">
                                                </div>
                                                <div class="alert alert-warning small">
                                                    <i class="bi bi-info-circle me-1"></i> Tagihan rawat inap (ruangan) akan diterbitkan otomatis ke Kasir berdasarkan selisih hari x tarif ruangan.
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light border-top">
                                                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger rounded-pill px-4">Ya, Pulangkan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-bed fs-1 text-secondary opacity-25 d-block mb-3"></i>
                                    Tidak ada pasien yang sedang dirawat inap.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($inpatients->hasPages())
            <div class="card-footer bg-white border-top p-3">
                {{ $inpatients->links() }}
            </div>
        @endif
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-success bg-opacity-10 border-bottom-0 pt-4 pb-3 px-4">
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-clock-history text-success me-2"></i>Riwayat Pasien Pulang</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Pasien</th>
                            <th>Ruangan</th>
                            <th>Masuk</th>
                            <th>Pulang</th>
                            <th class="text-center pe-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($discharged as $inpatient)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-primary">{{ $inpatient->patient->name }}</span><br>
                                    <small class="text-muted">{{ $inpatient->patient->patient_code }}</small>
                                </td>
                                <td>{{ $inpatient->room->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($inpatient->admission_date)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($inpatient->discharge_date)->format('d M Y') }}</td>
                                <td class="text-center pe-4">
                                    <span class="badge bg-success rounded-pill px-3">Pulang</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted small">Belum ada riwayat pasien pulang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($discharged->hasPages())
            <div class="card-footer bg-white border-top p-3">
                {{ $discharged->appends(['page' => request('page')])->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
