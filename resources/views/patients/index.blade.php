@extends('layouts.app')

@section('title', 'Data Pasien')
@section('page-title', 'Pasien')

@section('content')
<div class="container-fluid">
    {{-- Top Statistik --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%); color: white;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-white bg-opacity-25 rounded p-3 me-3">
                        <i class="bi bi-people fs-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-white-50">Total Pasien</h6>
                        <h3 class="mb-0 fw-bold">{{ $totalPatients }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 text-info rounded p-3 me-3">
                        <i class="bi bi-gender-male fs-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">Laki-Laki</h6>
                        <h3 class="mb-0 fw-bold text-dark">{{ $totalMale }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-pink bg-opacity-10 text-pink rounded p-3 me-3" style="color: #d63384;">
                        <i class="bi bi-gender-female fs-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">Perempuan</h6>
                        <h3 class="mb-0 fw-bold text-dark">{{ $totalFemale }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Header & Search --}}
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex gap-2 w-100 w-md-auto">
                <form action="{{ route('patients.index') }}" method="GET" class="d-flex position-relative flex-grow-1">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" name="search" class="form-control ps-5 rounded-pill shadow-sm border-0" placeholder="Cari NIK, BPJS, Nama..." value="{{ request('search') }}" style="min-width: 250px;">
                </form>
            </div>
            <a href="{{ route('patients.create') }}" class="btn btn-primary px-4 shadow-sm rounded-pill d-flex align-items-center">
                <i class="bi bi-person-plus-fill me-2"></i>Pasien Baru
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel Pasien --}}
    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-secondary" style="font-weight: 600;">No RM / Profil Pasien</th>
                            <th class="py-3 text-secondary" style="font-weight: 600;">Identitas (NIK/BPJS)</th>
                            <th class="py-3 text-secondary" style="font-weight: 600;">Demografi</th>
                            <th class="py-3 text-secondary text-center" style="font-weight: 600;">Kontak</th>
                            <th class="px-4 py-3 text-secondary text-end" style="font-weight: 600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($patients as $patient)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $patient->photo_url }}" alt="Foto {{ $patient->name }}" class="rounded-circle shadow-sm me-3" width="45" height="45" style="object-fit: cover;">
                                        <div>
                                            <div class="fw-bold text-dark">{{ $patient->name }}</div>
                                            <div class="small fw-semibold text-primary"><i class="bi bi-upc-scan me-1"></i>{{ $patient->patient_code }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small text-muted mb-1">NIK: <span class="text-dark fw-medium">{{ $patient->nik }}</span></div>
                                    <div class="small text-muted">BPJS: <span class="text-dark fw-medium">{{ $patient->bpjs_number ?? '-' }}</span></div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $patient->gender_color }} bg-opacity-10 text-{{ $patient->gender_color }} rounded-pill me-1 px-2">
                                        <i class="bi bi-gender-{{ $patient->gender == 'L' || $patient->gender == 'male' ? 'male' : 'female' }} me-1"></i>{{ $patient->gender_label }}
                                    </span>
                                    <span class="badge bg-light text-dark border px-2">{{ $patient->age }}</span>
                                    @if($patient->blood_type)
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2">Gol. {{ $patient->blood_type }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="small text-dark">{{ $patient->phone }}</div>
                                </td>
                                <td class="px-4 text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-light btn-sm text-info border" data-bs-toggle="tooltip" title="Lihat Profil / Cetak Kartu">
                                            <i class="bi bi-person-vcard"></i>
                                        </a>
                                        <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-light btn-sm text-primary border" data-bs-toggle="tooltip" title="Edit Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm text-danger border btn-delete" data-bs-toggle="tooltip" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <div class="mb-3"><i class="bi bi-people fs-1 text-secondary opacity-50"></i></div>
                                    Tidak ada data pasien yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($patients->hasPages())
            <div class="card-footer bg-white border-top px-4 py-3">
                {{ $patients->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Hapus Data Pasien?',
                    text: "Data tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush