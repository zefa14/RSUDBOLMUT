@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="fw-bold">
                    <i class="bi bi-capsule me-2"></i>Data Obat
                </h1>
                <a href="{{ route('medicines.create') }}" class="btn btn-primary rounded-pill">
                    <i class="bi bi-plus me-2"></i>Tambah Obat
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card card-modern">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Obat</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($medicines as $medicine)
                        <tr>
                            <td><strong>{{ $medicine->code }}</strong></td>
                            <td>{{ $medicine->name }}</td>
                            <td>{{ $medicine->unit }}</td>
                            <td>Rp {{ number_format($medicine->price, 2, ',', '.') }}</td>
                            <td>
                                <span class="badge @if($medicine->active) bg-success @else bg-secondary @endif">
                                    {{ $medicine->active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('medicines.show', $medicine->id) }}" class="btn btn-info" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('medicines.edit', $medicine->id) }}" class="btn btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Tidak ada data obat
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($medicines->hasPages())
            <div class="card-footer">
                {{ $medicines->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
