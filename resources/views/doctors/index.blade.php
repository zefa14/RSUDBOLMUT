@extends('layouts.app')

@section('title', 'Data Dokter')
@section('page-title', 'Dokter')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="mb-1 text-primary fw-bold"><i class="bi bi-person-badge me-2"></i>Data Dokter</h4>
                <p class="text-muted mb-0">Kelola master data dokter, spesialisasi, dan jadwal poliklinik.</p>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('doctors.index') }}" method="GET" class="d-flex position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" name="search" class="form-control ps-5 rounded-pill shadow-sm border-0" placeholder="Cari dokter, NIP..." value="{{ request('search') }}" style="width: 250px;">
                </form>
                <a href="{{ route('doctors.create') }}" class="btn btn-primary px-4 shadow-sm rounded-pill d-flex align-items-center">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Dokter
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-secondary" style="font-weight: 600;">Profil Dokter</th>
                            <th class="py-3 text-secondary" style="font-weight: 600;">Spesialisasi & Poli</th>
                            <th class="py-3 text-secondary" style="font-weight: 600;">Kontak</th>
                            <th class="py-3 text-secondary text-center" style="font-weight: 600;">Status</th>
                            <th class="px-4 py-3 text-secondary text-end" style="font-weight: 600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($doctors as $doc)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $doc->photo_url }}" alt="Foto {{ $doc->name }}" class="rounded-circle shadow-sm me-3" width="45" height="45" style="object-fit: cover; border: 2px solid #fff;">
                                        <div>
                                            <div class="fw-bold text-dark">{{ $doc->name }}</div>
                                            <div class="small text-muted">NIP: {{ $doc->employee_code }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $doc->specialization ?? '-' }}</div>
                                    <div class="small text-primary"><i class="bi bi-hospital me-1"></i>{{ $doc->department->name ?? 'Belum ada Poli' }}</div>
                                </td>
                                <td>
                                    <div class="small text-dark"><i class="bi bi-telephone-fill text-muted me-1"></i>{{ $doc->phone }}</div>
                                    @if($doc->email)
                                        <div class="small text-dark"><i class="bi bi-envelope-fill text-muted me-1"></i>{{ $doc->email }}</div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $doc->status_color }} bg-opacity-10 text-{{ $doc->status_color }} rounded-pill px-3 py-2">
                                        <i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i>{{ $doc->status_label }}
                                    </span>
                                </td>
                                <td class="px-4 text-end text-nowrap">
                                    <a href="{{ route('doctors.schedules', $doc->id) }}" class="btn btn-light btn-sm text-success border me-1" data-bs-toggle="tooltip" title="Kelola Jadwal Praktik">
                                        <i class="bi bi-calendar-week"></i> Jadwal
                                    </a>
                                    <a href="{{ route('doctors.edit', $doc->id) }}" class="btn btn-light btn-sm text-primary border me-1" data-bs-toggle="tooltip" title="Edit Profil">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('doctors.destroy', $doc->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm text-danger border btn-delete" data-bs-toggle="tooltip" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <div class="mb-3"><i class="bi bi-person-x fs-1 text-secondary opacity-50"></i></div>
                                    Tidak ada data dokter ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($doctors->hasPages())
            <div class="card-footer bg-white border-top px-4 py-3">
                {{ $doctors->links() }}
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
                    title: 'Hapus Data Dokter?',
                    text: "Seluruh informasi terkait akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
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