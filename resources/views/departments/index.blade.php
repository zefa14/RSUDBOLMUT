@extends('layouts.app')

@section('title', 'Data Poliklinik')
@section('page-title', 'Poliklinik')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 text-primary fw-bold"><i class="bi bi-hospital me-2"></i>Data Poliklinik</h4>
                <p class="text-muted mb-0">Kelola master data poliklinik rumah sakit.</p>
            </div>
            <a href="{{ route('departments.create') }}" class="btn btn-primary px-4 shadow-sm" style="border-radius: 8px;">
                <i class="bi bi-plus-lg me-2"></i>Tambah Poliklinik
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

    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-secondary" style="font-weight: 600; width: 5%;">No</th>
                            <th class="py-3 text-secondary" style="font-weight: 600; width: 25%;">Nama Poliklinik</th>
                            <th class="py-3 text-secondary" style="font-weight: 600; width: 40%;">Deskripsi</th>
                            <th class="py-3 text-secondary text-center" style="font-weight: 600; width: 15%;">Jumlah Dokter</th>
                            <th class="px-4 py-3 text-secondary text-end" style="font-weight: 600; width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($departments as $key => $dept)
                            <tr>
                                <td class="px-4 text-muted">{{ $departments->firstItem() + $key }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $dept->name }}</div>
                                </td>
                                <td>
                                    <span class="text-muted text-truncate d-inline-block" style="max-width: 350px;">
                                        {{ $dept->description ?: '-' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">
                                        {{ $dept->doctors_count }} Dokter
                                    </span>
                                </td>
                                <td class="px-4 text-end">
                                    <a href="{{ route('departments.edit', $dept->id) }}" class="btn btn-light btn-sm text-primary border me-1" data-bs-toggle="tooltip" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('departments.destroy', $dept->id) }}" method="POST" class="d-inline">
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
                                    <div class="mb-3"><i class="bi bi-inbox fs-1 text-secondary opacity-50"></i></div>
                                    Belum ada data Poliklinik yang ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($departments->hasPages())
            <div class="card-footer bg-white border-top px-4 py-3">
                {{ $departments->links() }}
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

        // SweetAlert untuk konfirmasi hapus
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Hapus Poliklinik?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
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