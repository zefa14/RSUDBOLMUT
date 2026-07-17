@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="fw-bold">
                <i class="bi bi-arrow-left-right me-2"></i>Mutasi Barang
            </h1>
            <p class="text-muted">Transfer obat antar gudang</p>
        </div>
    </div>

    <div class="alert alert-info" role="alert">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Coming Soon!</strong> Fitur Mutasi Barang sedang dalam pengembangan
    </div>

    <a href="{{ route('pharmacy.index') }}" class="btn btn-secondary rounded-pill">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Menu Farmasi
    </a>
</div>
@endsection
