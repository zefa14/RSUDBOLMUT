@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0 text-gray-800">Detail Supplier</h1>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Supplier</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="20%">Nama Supplier</th>
                    <td>{{ $supplier->name }}</td>
                </tr>
                <tr>
                    <th>Kontak Person</th>
                    <td>{{ $supplier->contact_person ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Telepon</th>
                    <td>{{ $supplier->phone ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $supplier->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $supplier->address ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($supplier->active)
                            <span class="badge bg-success text-white">Aktif</span>
                        @else
                            <span class="badge bg-danger text-white">Nonaktif</span>
                        @endif
                    </td>
                </tr>
            </table>
            
            <div class="mt-3">
                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Supplier
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
