@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="fw-bold">
                    <i class="bi bi-file-earmark me-2"></i>Daftar Purchase Order
                </h1>
                <a href="{{ route('purchase-orders.create') }}" class="btn btn-primary rounded-pill">
                    <i class="bi bi-plus me-2"></i>Buat PO Baru
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

    <div class="card card-modern">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No. PO</th>
                        <th>Supplier</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($purchaseOrders as $po)
                        <tr>
                            <td>
                                <strong>{{ $po->po_number }}</strong>
                            </td>
                            <td>{{ $po->supplier->name }}</td>
                            <td>
                                <strong>Rp {{ number_format($po->total, 2, ',', '.') }}</strong>
                            </td>
                            <td>
                                <span class="badge 
                                    @if($po->status == 'DRAFT') bg-warning text-dark
                                    @elseif($po->status == 'CONFIRMED') bg-info
                                    @elseif($po->status == 'RECEIVED') bg-success
                                    @else bg-danger
                                    @endif
                                ">
                                    {{ $po->status }}
                                </span>
                            </td>
                            <td>{{ $po->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('purchase-orders.show', $po->id) }}" class="btn btn-info" title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if ($po->status == 'DRAFT')
                                        <a href="{{ route('purchase-orders.edit', $po->id) }}" class="btn btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('purchase-orders.destroy', $po->id) }}" method="POST" style="display: inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Tidak ada data Purchase Order
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($purchaseOrders->hasPages())
            <div class="card-footer">
                {{ $purchaseOrders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
