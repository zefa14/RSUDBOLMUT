@extends('layouts.app')

@section('title', 'Pengaduan Masyarakat')
@section('page-title', 'Pengaduan Masyarakat')
@section('page-subtitle', 'Kelola pengaduan & masukan dari masyarakat')

@section('content')
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #dbeafe; display: flex; align-items: center; justify-content: center;"><i class="bi bi-inbox-fill text-primary fs-4"></i></div>
                    <div><div class="fs-5 fw-bold">{{ $complaints->count() }}</div><small class="text-muted">Total Pengaduan</small></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #fef3c7; display: flex; align-items: center; justify-content: center;"><i class="bi bi-exclamation-circle-fill text-warning fs-4"></i></div>
                    <div><div class="fs-5 fw-bold">{{ $complaints->where('status', 'baru')->count() }}</div><small class="text-muted">Baru</small></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #e0e7ff; display: flex; align-items: center; justify-content: center;"><i class="bi bi-arrow-repeat text-info fs-4"></i></div>
                    <div><div class="fs-5 fw-bold">{{ $complaints->where('status', 'diproses')->count() }}</div><small class="text-muted">Diproses</small></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #d1fae5; display: flex; align-items: center; justify-content: center;"><i class="bi bi-check-circle-fill text-success fs-4"></i></div>
                    <div><div class="fs-5 fw-bold">{{ $complaints->where('status', 'selesai')->count() }}</div><small class="text-muted">Selesai</small></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0"><i class="bi bi-megaphone text-primary me-2"></i>Daftar Pengaduan</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Nama</th>
                            <th class="py-3">Kategori</th>
                            <th class="py-3">Ringkasan</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaints as $i => $c)
                        <tr>
                            <td class="px-4">{{ $i + 1 }}</td>
                            <td><small class="text-muted">{{ $c->created_at->format('d/m/Y H:i') }}</small></td>
                            <td>
                                <div class="fw-semibold">{{ $c->name }}</div>
                                @if($c->email)<small class="text-muted">{{ $c->email }}</small>@endif
                            </td>
                            <td><span class="badge bg-light text-dark fw-semibold">{{ $c->category }}</span></td>
                            <td><small class="text-muted">{{ Str::limit($c->message, 60) }}</small></td>
                            <td class="text-center">
                                @if($c->status === 'baru')
                                    <span class="badge bg-warning text-dark px-3 py-1">Baru</span>
                                @elseif($c->status === 'diproses')
                                    <span class="badge bg-info text-white px-3 py-1">Diproses</span>
                                @else
                                    <span class="badge bg-success px-3 py-1">Selesai</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('complaints.show', $c) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada pengaduan masuk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
