@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="fw-bold">
                    <i class="bi bi-capsule me-2"></i>Detail Obat
                </h1>
                <a href="{{ route('medicines.index') }}" class="btn btn-secondary rounded-pill">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="card card-modern">
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="text-muted mb-3">Informasi Obat</h5>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="text-muted">Kode</td>
                            <td><strong>{{ $medicine->code }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Nama</td>
                            <td>{{ $medicine->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Satuan</td>
                            <td>{{ $medicine->unit }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Harga</td>
                            <td>Rp {{ number_format($medicine->price, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status</td>
                            <td>
                                <span class="badge @if($medicine->active) bg-success @else bg-secondary @endif">
                                    {{ $medicine->active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="text-muted mb-3">Deskripsi</h5>
                    <p>{{ $medicine->description ?? '-' }}</p>
                </div>
            </div>

            <div class="d-grid gap-2">
                <a href="{{ route('medicines.edit', $medicine->id) }}" class="btn btn-warning rounded-pill">
                    <i class="bi bi-pencil me-2"></i>Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
