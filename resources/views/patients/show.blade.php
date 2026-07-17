@extends('layouts.app')

@section('title', 'Profil Pasien - ' . $patient->name)
@section('page-title', 'Profil Pasien')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('patients.index') }}" class="btn btn-light shadow-sm border rounded-pill px-3">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
            <div>
                <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-outline-primary px-4 shadow-sm rounded-pill me-2">
                    <i class="bi bi-pencil-square me-2"></i>Edit
                </a>
                <button onclick="window.print()" class="btn btn-primary px-4 shadow-sm rounded-pill">
                    <i class="bi bi-printer me-2"></i>Cetak Kartu
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Kolom Kiri: Profil & Cetak Kartu --}}
        <div class="col-md-4">
            {{-- Tampilan Kartu Pasien (Akan ikut dicetak) --}}
            <div class="card border-0 shadow mb-4 patient-card-wrapper" style="border-radius: 16px; overflow: hidden; background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                <div class="card-body p-0 position-relative">
                    <div class="position-absolute top-0 end-0 p-3 opacity-25">
                        <i class="bi bi-hospital fs-1 text-white"></i>
                    </div>
                    
                    <div class="p-4 text-center border-bottom border-light border-opacity-25">
                        <h5 class="text-white fw-bold mb-0">SIRS RSUD</h5>
                        <p class="text-white-50 small mb-0">Kartu Identitas Pasien</p>
                    </div>

                    <div class="p-4 bg-white">
                        <div class="d-flex align-items-center mb-4">
                            <img src="{{ $patient->photo_url }}" alt="Foto Pasien" class="rounded shadow-sm me-3" width="70" height="70" style="object-fit: cover; border: 3px solid #e9ecef;">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">{{ $patient->name }}</h5>
                                <div class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fs-6 fw-bold" style="letter-spacing: 1px;">
                                    {{ $patient->patient_code }}
                                </div>
                            </div>
                        </div>

                        <table class="table table-borderless table-sm mb-0 small">
                            <tr>
                                <td class="text-muted ps-0" width="35%">NIK</td>
                                <td class="fw-medium text-dark">: {{ $patient->nik }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0">Tgl. Lahir</td>
                                <td class="fw-medium text-dark">: {{ $patient->birth_date?->format('d M Y') ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0">Gol. Darah</td>
                                <td class="fw-medium text-dark">: <span class="text-danger fw-bold">{{ $patient->blood_type ?? '-' }}</span></td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0">Alamat</td>
                                <td class="fw-medium text-dark">: {{ \Illuminate\Support\Str::limit($patient->address, 30) }}</td>
                            </tr>
                        </table>
                        
                        <div class="text-center mt-4">
                            @php
                                $qrData = $patient->patient_code ?: ($patient->nik ?: 'PASIEN-'.$patient->id);
                            @endphp
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data={{ urlencode($qrData) }}" alt="QR Code {{ $qrData }}" width="80" height="80" class="shadow-sm border p-1 rounded">
                            <div class="small text-muted mt-2">Scan untuk pendaftaran mandiri</div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Info Kontak Dasar --}}
            <div class="card border-0 shadow-sm d-print-none mb-4" style="border-radius: 12px;">
                <div class="card-body">
                    <h6 class="fw-bold text-danger border-bottom border-danger border-opacity-25 pb-2 mb-3">Kontak Darurat</h6>
                    <div class="mb-2">
                        <div class="text-muted small">Nama Kontak</div>
                        <div class="fw-medium">{{ $patient->emergency_contact_name ?? '-' }}</div>
                    </div>
                    <div class="mb-2">
                        <div class="text-muted small">Hubungan</div>
                        <div class="fw-medium">{{ $patient->emergency_contact_relation ?? '-' }}</div>
                    </div>
                    <div class="mb-0">
                        <div class="text-muted small">Nomor HP</div>
                        <div class="fw-medium text-danger">{{ $patient->emergency_contact_phone ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Riwayat Pendaftaran & Tab Profil --}}
        <div class="col-md-8 d-print-none">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; height: 100%;">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <ul class="nav nav-tabs card-header-tabs" id="patientTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat" type="button" role="tab" aria-controls="riwayat" aria-selected="true">
                                <i class="bi bi-clock-history me-1"></i> Riwayat Kunjungan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold" id="profil-tab" data-bs-toggle="tab" data-bs-target="#profil" type="button" role="tab" aria-controls="profil" aria-selected="false">
                                <i class="bi bi-person-lines-fill me-1"></i> Informasi Lengkap
                            </button>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body p-0 mt-3">
                    <div class="tab-content" id="patientTabsContent">
                        
                        {{-- Tab Riwayat Kunjungan --}}
                        <div class="tab-pane fade show active" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                            <div class="px-4 pb-3 text-end">
                                <a href="{{ route('registrations.create', ['patient_id' => $patient->id]) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="bi bi-plus-circle me-1"></i>Daftarkan Kunjungan Baru
                                </a>
                            </div>
                            <div class="list-group list-group-flush border-top">
                                @forelse($patient->registrations as $reg)
                                    <div class="list-group-item px-4 py-3">
                                        <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold">{{ $reg->department->name ?? 'Poli Terhapus' }}</h6>
                                            <small class="text-muted">{{ $reg->registration_date ? \Carbon\Carbon::parse($reg->registration_date)->format('d M Y') : $reg->created_at->format('d M Y') }}</small>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="mb-1 text-muted small">
                                                Dokter: <span class="fw-medium text-dark">{{ $reg->doctor->name ?? 'Dokter Terhapus' }}</span>
                                            </p>
                                            @php
                                                $statusColors = ['waiting' => 'warning', 'serving' => 'info', 'done' => 'success', 'cancelled' => 'danger'];
                                                $color = $statusColors[$reg->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} rounded-pill">
                                                {{ ucfirst($reg->status ?? 'menunggu') }}
                                            </span>
                                        </div>
                                        @if($reg->complaint)
                                            <div class="small mt-2 p-2 bg-light rounded text-muted">
                                                <i class="bi bi-chat-text me-1"></i> "{{ $reg->complaint }}"
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="text-center py-5">
                                        <i class="bi bi-journal-x fs-1 text-secondary opacity-50 mb-3 d-block"></i>
                                        <span class="text-muted">Belum ada riwayat kunjungan.</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- Tab Informasi Lengkap --}}
                        <div class="tab-pane fade p-4" id="profil" role="tabpanel" aria-labelledby="profil-tab">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">Identitas Utama</h6>
                                    <table class="table table-sm table-borderless small">
                                        <tr><td width="40%" class="text-muted">Nama Lengkap</td><td class="fw-medium">: {{ $patient->name }}</td></tr>
                                        <tr><td class="text-muted">NIK KTP</td><td class="fw-medium">: {{ $patient->nik }}</td></tr>
                                        <tr><td class="text-muted">Nomor BPJS</td><td class="fw-medium text-success">: {{ $patient->bpjs_number ?? '-' }}</td></tr>
                                        <tr><td class="text-muted">Tempat Lahir</td><td class="fw-medium">: {{ $patient->birth_place ?? '-' }}</td></tr>
                                        <tr><td class="text-muted">Tanggal Lahir</td><td class="fw-medium">: {{ $patient->birth_date ? $patient->birth_date->format('d M Y') : '-' }}</td></tr>
                                        <tr><td class="text-muted">Usia</td><td class="fw-medium">: {{ $patient->age }}</td></tr>
                                        <tr><td class="text-muted">Jenis Kelamin</td><td class="fw-medium">: {{ $patient->gender_label }}</td></tr>
                                        <tr><td class="text-muted">Gol. Darah</td><td class="fw-medium text-danger">: {{ $patient->blood_type ?? '-' }}</td></tr>
                                        <tr><td class="text-muted">Agama</td><td class="fw-medium">: {{ $patient->religion ?? '-' }}</td></tr>
                                        <tr><td class="text-muted">Status Pernikahan</td><td class="fw-medium">: {{ $patient->marital_status ?? '-' }}</td></tr>
                                        <tr><td class="text-muted">Pendidikan</td><td class="fw-medium">: {{ $patient->education ?? '-' }}</td></tr>
                                        <tr><td class="text-muted">Pekerjaan</td><td class="fw-medium">: {{ $patient->occupation ?? '-' }}</td></tr>
                                    </table>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6 class="fw-bold text-success mb-3 border-bottom pb-2">Kontak & Alamat Detail</h6>
                                    <table class="table table-sm table-borderless small">
                                        <tr><td width="40%" class="text-muted">No. Telepon / HP</td><td class="fw-medium">: {{ $patient->phone }}</td></tr>
                                        <tr><td class="text-muted">Email</td><td class="fw-medium">: {{ $patient->email ?? '-' }}</td></tr>
                                        <tr><td class="text-muted align-top">Alamat Lengkap</td><td class="fw-medium">: {{ $patient->address }}</td></tr>
                                        <tr><td class="text-muted">RT / RW</td><td class="fw-medium">: {{ $patient->rt_rw ?? '-' }}</td></tr>
                                        <tr><td class="text-muted">Kelurahan/Desa</td><td class="fw-medium">: {{ $patient->kelurahan ?? '-' }}</td></tr>
                                        <tr><td class="text-muted">Kecamatan</td><td class="fw-medium">: {{ $patient->kecamatan ?? '-' }}</td></tr>
                                        <tr><td class="text-muted">Kabupaten/Kota</td><td class="fw-medium">: {{ $patient->kabupaten ?? '-' }}</td></tr>
                                        <tr><td class="text-muted">Provinsi</td><td class="fw-medium">: {{ $patient->provinsi ?? '-' }}</td></tr>

                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="fw-bold text-info mb-3 border-bottom pb-2">Informasi Medis & Catatan</h6>
                                    <div class="p-3 bg-light rounded mb-3">
                                        <div class="mb-2">
                                            <span class="text-muted small d-block">Catatan Alergi:</span>
                                            <span class="fw-medium text-danger">{{ $patient->allergy_notes ?? 'Tidak ada riwayat alergi yang tercatat.' }}</span>
                                        </div>
                                        <div>
                                            <span class="text-muted small d-block">Catatan Umum / Riwayat Penyakit:</span>
                                            <span class="fw-medium">{{ $patient->notes ?? 'Tidak ada catatan khusus.' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* CSS Khusus untuk Print Kartu Pasien */
@media print {
    body * {
        visibility: hidden;
    }
    .patient-card-wrapper, .patient-card-wrapper * {
        visibility: visible;
    }
    .patient-card-wrapper {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 400px !important;
        margin: 0;
        box-shadow: none !important;
        border: 1px solid #ccc !important;
    }
    /* Sembunyikan elemen lain yang punya class d-print-none */
    .d-print-none {
        display: none !important;
    }
}
</style>
@endsection
