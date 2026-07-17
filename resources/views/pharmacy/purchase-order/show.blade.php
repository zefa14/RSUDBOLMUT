@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="fw-bold">
                    <i class="bi bi-file-earmark-check me-2"></i>Detail Purchase Order
                </h1>
                <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary rounded-pill">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
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

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card card-modern">
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted mb-3">Informasi PO</h5>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="text-muted">No. PO</td>
                                    <td><strong>{{ $purchaseOrder->po_number }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">No. Faktur</td>
                                    <td>{{ $purchaseOrder->invoice_number ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tanggal Faktur</td>
                                    <td>{{ $purchaseOrder->invoice_date?->format('d/m/Y') ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Status</td>
                                    <td>
                                        <span class="badge 
                                            @if($purchaseOrder->status == 'DRAFT') bg-warning text-dark
                                            @elseif($purchaseOrder->status == 'CONFIRMED') bg-info
                                            @elseif($purchaseOrder->status == 'RECEIVED') bg-success
                                            @else bg-danger
                                            @endif
                                        ">
                                            {{ $purchaseOrder->status }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted mb-3">Data Supplier</h5>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="text-muted">Supplier</td>
                                    <td><strong>{{ $purchaseOrder->supplier->name }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Alamat</td>
                                    <td>{{ $purchaseOrder->supplier->address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Telepon</td>
                                    <td>{{ $purchaseOrder->supplier->phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Email</td>
                                    <td>{{ $purchaseOrder->supplier->email ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <h5 class="text-muted mb-3">Detail Item</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Obat</th>
                                    <th>Nama Obat</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Diskon</th>
                                    <th>Subtotal</th>
                                    <th>HPP</th>
                                    <th>Exp Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchaseOrder->items as $item)
                                    <tr>
                                        <td>{{ $item->medicine->code }}</td>
                                        <td>{{ $item->medicine->name }}</td>
                                        <td>{{ $item->quantity }} {{ $item->unit }}</td>
                                        <td>Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                                        <td>{{ $item->discount_percent }}%</td>
                                        <td>Rp {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item->hpp, 2, ',', '.') }}</td>
                                        <td>{{ $item->expiry_date?->format('d/m/Y') ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-modern">
                <div class="card-body p-4">
                    <h5 class="mb-3">Ringkasan Biaya</h5>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="text-muted">Subtotal</td>
                            <td class="text-end">Rp {{ number_format($purchaseOrder->subtotal, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Diskon</td>
                            <td class="text-end">Rp {{ number_format($purchaseOrder->discount_amount, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Pajak ({{ $purchaseOrder->tax_percent }}%)</td>
                            <td class="text-end">Rp {{ number_format($purchaseOrder->tax_amount, 2, ',', '.') }}</td>
                        </tr>
                        <tr class="border-top">
                            <td class="fw-bold">Total</td>
                            <td class="text-end fw-bold">Rp {{ number_format($purchaseOrder->total, 2, ',', '.') }}</td>
                        </tr>
                    </table>

                    <div class="d-grid gap-2 mt-4">
                        @if ($purchaseOrder->status == 'DRAFT')
                            <a href="{{ route('purchase-orders.edit', $purchaseOrder->id) }}" class="btn btn-warning rounded-pill">
                                <i class="bi bi-pencil me-2"></i>Edit
                            </a>
                            <form action="{{ route('purchase-orders.confirm', $purchaseOrder->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success rounded-pill w-100">
                                    <i class="bi bi-check-circle me-2"></i>Konfirmasi
                                </button>
                            </form>
                        @elseif ($purchaseOrder->status == 'CONFIRMED')
                            <form action="{{ route('purchase-orders.receive', $purchaseOrder->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-info rounded-pill w-100">
                                    <i class="bi bi-box-seam me-2"></i>Terima Barang
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
