@extends('layouts.app')

@section('title', 'Katalog Data Obat')
@section('page-title', 'Data Obat')

@section('content')
<div class="container-fluid">
    {{-- Header & Aksi --}}
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="mb-1 text-primary fw-bold"><i class="bi bi-capsule-pill me-2"></i>Katalog Obat & Alkes</h4>
                <p class="text-muted mb-0">Manajemen master data obat, harga, dan kategorinya.</p>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('medicines.index') }}" method="GET" class="d-flex position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" name="search" class="form-control ps-5 rounded-pill shadow-sm border-0" placeholder="Cari kode atau nama..." value="{{ request('search') }}" style="width: 250px;">
                </form>
                <a href="{{ route('medicines.create') }}" class="btn btn-primary px-4 shadow-sm rounded-pill d-flex align-items-center">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Obat Baru
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

    {{-- Tabel Data Obat --}}
    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-secondary" style="font-weight: 600;">Kode & Nama Obat</th>
                            <th class="py-3 text-secondary" style="font-weight: 600;">Kategori</th>
                            <th class="py-3 text-secondary" style="font-weight: 600;">Kemasan</th>
                            <th class="py-3 text-secondary" style="font-weight: 600;">Harga Jual</th>
                            <th class="py-3 text-secondary text-center" style="font-weight: 600;">Status</th>
                            <th class="px-4 py-3 text-secondary text-end" style="font-weight: 600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($medicines as $med)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="fw-bold text-dark">{{ $med->name }}</div>
                                    <div class="small fw-semibold text-primary"><i class="bi bi-upc-scan me-1"></i>{{ $med->code }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">{{ $med->category->name ?? '-' }}</span>
                                </td>
                                <td>
                                    <div class="text-dark">{{ $med->unit }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-success">Rp {{ number_format($med->price, 0, ',', '.') }}</div>
                                </td>
                                <td class="text-center">
                                    @if($med->active)
                                        <span class="badge bg-success rounded-pill px-3 py-1"><i class="bi bi-check-circle me-1"></i>Aktif</span>
                                    @else
                                        <span class="badge bg-danger rounded-pill px-3 py-1"><i class="bi bi-x-circle me-1"></i>Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-4 text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('medicines.edit', $med->id) }}" class="btn btn-light btn-sm text-primary border" data-bs-toggle="tooltip" title="Edit Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('medicines.destroy', $med->id) }}" method="POST" class="d-inline">
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
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="mb-3"><i class="bi bi-box-seam fs-1 text-secondary opacity-50"></i></div>
                                    Tidak ada data obat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($medicines->hasPages())
            <div class="card-footer bg-white border-top px-4 py-3">
                {{ $medicines->links() }}
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
                    title: 'Nonaktifkan Obat?',
                    text: "Obat tidak akan terhapus sepenuhnya, tapi tidak akan bisa dipilih saat meresepkan.",
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
