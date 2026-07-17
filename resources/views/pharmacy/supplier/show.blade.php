@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="fw-bold">
                    <i class="bi bi-people-fill me-2"></i>Detail Supplier
                </h1>
                <a href="{{ route('suppliers.index') }}" class="btn btn-secondary rounded-pill">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card card-modern">
                <div class="card-body p-4">
                    <h5 class="text-muted mb-3">Informasi Supplier</h5>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="text-muted">Kode</td>
                            <td><strong>{{ $supplier->code }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Nama</td>
                            <td>{{ $supplier->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Alamat</td>
                            <td>{{ $supplier->address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Telepon</td>
                            <td>{{ $supplier->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email</td>
                            <td>{{ $supplier->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Kontak</td>
                            <td>{{ $supplier->contact_person ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status</td>
                            <td>
                                <span class="badge @if($supplier->active) bg-success @else bg-secondary @endif">
                                    {{ $supplier->active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                        </tr>
                    </table>

                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning rounded-pill">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-modern">
                <div class="card-body p-4">
                    <h5 class="text-muted mb-3">Purchase Order Terakhir</h5>
                    @if ($supplier->purchaseOrders->count() > 0)
                        <div class="list-group">
                            @foreach ($supplier->purchaseOrders->take(5) as $po)
                                <a href="{{ route('purchase-orders.show', $po->id) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <strong>{{ $po->po_number }}</strong>
                                        <small class="badge bg-info">{{ $po->status }}</small>
                                    </div>
                                    <small class="text-muted">Rp {{ number_format($po->total, 0, ',', '.') }} - {{ $po->created_at->format('d/m/Y') }}</small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Belum ada Purchase Order</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
