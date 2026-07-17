@extends('layouts.app')

@section('title', 'Data Supplier (Distributor)')
@section('page-title', 'Mitra Supplier')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="mb-1 text-primary fw-bold"><i class="bi bi-truck me-2"></i>Daftar Pemasok Farmasi</h4>
                <p class="text-muted mb-0">Manajemen data distributor dan penyuplai obat (PBF).</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('suppliers.create') }}" class="btn btn-primary px-4 shadow-sm rounded-pill d-flex align-items-center">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Supplier
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
                            <th class="px-4 py-3 text-secondary" style="font-weight: 600;">Kode & Perusahaan</th>
                            <th class="py-3 text-secondary" style="font-weight: 600;">Kontak Utama</th>
                            <th class="py-3 text-secondary" style="font-weight: 600;">Alamat</th>
                            <th class="py-3 text-secondary text-center" style="font-weight: 600;">Status</th>
                            <th class="px-4 py-3 text-secondary text-end" style="font-weight: 600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($suppliers as $sup)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="fw-bold text-dark">{{ $sup->name }}</div>
                                    <div class="small fw-semibold text-primary"><i class="bi bi-upc-scan me-1"></i>{{ $sup->code }}</div>
                                </td>
                                <td>
                                    <div class="fw-medium text-dark"><i class="bi bi-person me-1"></i>{{ $sup->contact_person ?? '-' }}</div>
                                    <div class="small text-muted"><i class="bi bi-telephone me-1"></i>{{ $sup->phone ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="small text-dark text-truncate" style="max-width: 250px;">
                                        {{ $sup->address ?? '-' }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($sup->active)
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Aktif</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-4 text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('suppliers.edit', $sup->id) }}" class="btn btn-light btn-sm text-primary border" data-bs-toggle="tooltip" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('suppliers.destroy', $sup->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm text-danger border btn-delete" data-bs-toggle="tooltip" title="Nonaktifkan">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <div class="mb-3"><i class="bi bi-building-x fs-1 text-secondary opacity-50"></i></div>
                                    Tidak ada data supplier.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($suppliers->hasPages())
            <div class="card-footer bg-white border-top px-4 py-3">
                {{ $suppliers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Nonaktifkan Supplier?',
                    text: "Supplier yang nonaktif tidak dapat dipilih saat pembuatan Purchase Order.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Nonaktifkan!'
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
