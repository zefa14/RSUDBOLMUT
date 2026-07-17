@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="fw-bold">
                <i class="bi bi-box-seam me-2"></i>Penerimaan Barang
            </h1>
            <p class="text-muted">Terima barang dari Purchase Order</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No. PO</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>Total Item</th>
                            <th>Total Harga</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($confirmedPOs as $po)
                            <tr>
                                <td class="ps-4 fw-bold text-primary">{{ $po->po_number }}</td>
                                <td>{{ $po->invoice_date?->format('d/m/Y') ?? $po->created_at->format('d/m/Y') }}</td>
                                <td>{{ $po->supplier->name }}</td>
                                <td>{{ $po->items()->count() }} Item</td>
                                <td>Rp {{ number_format($po->total, 0, ',', '.') }}</td>
                                <td class="text-center pe-4">
                                    <a href="{{ route('purchase-orders.show', $po->id) }}" class="btn btn-sm btn-info rounded-pill text-white px-3">
                                        <i class="bi bi-box-seam me-1"></i> Proses Terima
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-check2-all fs-1 text-success opacity-25 d-block mb-3"></i>
                                    Tidak ada Purchase Order yang menunggu penerimaan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($confirmedPOs->hasPages())
            <div class="card-footer bg-white border-top p-3">
                {{ $confirmedPOs->links() }}
            </div>
        @endif
    </div>

    <a href="{{ route('pharmacy.index') }}" class="btn btn-light border shadow-sm rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard Farmasi
    </a>
</div>
@endsection
