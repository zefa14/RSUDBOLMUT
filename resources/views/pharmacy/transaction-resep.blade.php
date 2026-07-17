@extends('layouts.app')

@section('title', 'Penebusan E-Resep')
@section('page-title', 'Farmasi & Apotek')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('pharmacy.index') }}" class="btn btn-light shadow-sm border rounded-pill px-3 mb-3">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
            <h4 class="mb-1 text-primary fw-bold"><i class="bi bi-receipt-cutoff me-2"></i>Antrian Penebusan E-Resep</h4>
            <p class="text-muted">Proses resep obat dari dokter dan serahkan ke pasien.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @forelse($records as $rm)
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-header bg-white border-bottom pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-warning text-dark rounded-pill mb-2 px-3 py-2"><i class="bi bi-clock-history me-1"></i>Menunggu Diproses</span>
                            <h5 class="mb-0 fw-bold text-dark">{{ $rm->patient->name }}</h5>
                            <p class="small text-muted mb-0 mt-1"><i class="bi bi-upc-scan me-1"></i>RM: {{ $rm->patient->patient_code }} | <i class="bi bi-person-badge ms-2 me-1"></i>{{ $rm->doctor->name }}</p>
                        </div>
                        <div class="text-end">
                            <div class="fs-4 text-primary fw-bold">{{ $rm->created_at->format('H:i') }}</div>
                            <div class="small text-muted">{{ $rm->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                    
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 py-2" width="45%">Nama Obat</th>
                                        <th class="py-2 text-center" width="15%">Qty</th>
                                        <th class="py-2" width="40%">Dosis/Signa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rm->prescriptions as $resep)
                                        @if(!$resep->is_dispensed)
                                        <tr class="border-bottom">
                                            <td class="ps-4 py-3 fw-semibold text-dark">
                                                {{ $resep->medicine->name ?? 'Obat Tidak Ditemukan' }}
                                                <div class="small text-muted fw-normal">{{ $resep->instructions }}</div>
                                            </td>
                                            <td class="py-3 text-center">
                                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill fs-6 px-3">{{ $resep->quantity }}</span>
                                            </td>
                                            <td class="py-3 text-muted small">{{ $resep->dosage }}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-top p-4 d-flex justify-content-between align-items-center">
                        <div class="small text-muted">
                            <i class="bi bi-info-circle me-1"></i>Klik proses untuk memotong stok.
                        </div>
                        <form action="{{ route('pharmacy.process-resep', $rm->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary rounded-pill px-4 btn-process">
                                <i class="bi bi-check2-circle me-2"></i>Tebus & Serahkan Obat
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-check-circle text-success" style="font-size: 80px; opacity: 0.5;"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Antrian Resep Kosong</h4>
                        <p class="text-muted mb-0">Semua resep dari dokter sudah berhasil dilayani hari ini.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $records->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const processBtns = document.querySelectorAll('.btn-process');
        processBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Proses Resep?',
                    text: "Stok obat akan otomatis berkurang dari inventaris.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Proses!',
                    cancelButtonText: 'Batal'
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
