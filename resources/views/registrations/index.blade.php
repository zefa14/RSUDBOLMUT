@extends('layouts.app')

@section('title', 'Manajemen Antrian & Pendaftaran')
@section('page-title', 'Antrian Pendaftaran')

@section('content')
<div class="container-fluid">
    {{-- Top Statistik --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%); color: white;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-white bg-opacity-25 rounded p-3 me-3">
                        <i class="bi bi-people fs-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-white-50">Total Pendaftaran Hari Ini</h6>
                        <h3 class="mb-0 fw-bold">{{ $todayCount }} <span class="fs-6 fw-normal">Pasien</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 text-warning rounded p-3 me-3">
                        <i class="bi bi-hourglass-split fs-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">Masih Menunggu Antrian</h6>
                        <h3 class="mb-0 fw-bold text-dark">{{ $waitingCount }} <span class="fs-6 fw-normal text-muted">Pasien</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter & Action Bar --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body p-3">
            <form action="{{ route('registrations.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-auto">
                    <label class="form-label small text-muted fw-bold mb-0">Filter Tanggal</label>
                    <input type="date" name="date" class="form-control form-control-sm shadow-none" value="{{ request('date', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                </div>
                <div class="col-md-auto">
                    <label class="form-label small text-muted fw-bold mb-0">Status</label>
                    <select name="status" class="form-select form-select-sm shadow-none">
                        <option value="">Semua Status</option>
                        <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Menunggu</option>
                        <option value="serving" {{ request('status') == 'serving' ? 'selected' : '' }}>Diperiksa</option>
                        <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>
                <div class="col-md-auto d-flex align-items-end mt-4">
                    <button type="submit" class="btn btn-sm btn-secondary px-3"><i class="bi bi-funnel me-1"></i>Filter</button>
                    <a href="{{ route('registrations.index') }}" class="btn btn-sm btn-light border px-3 ms-1">Reset</a>
                </div>
                <div class="col text-md-end mt-4 mt-md-0">
                    <a href="{{ route('registrations.create') }}" class="btn btn-primary shadow-sm px-4 rounded-pill">
                        <i class="bi bi-plus-circle me-2"></i>Daftarkan Pasien
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel Pendaftaran --}}
    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-secondary" style="font-weight: 600;">No. Antrian</th>
                            <th class="py-3 text-secondary" style="font-weight: 600;">Data Pasien</th>
                            <th class="py-3 text-secondary" style="font-weight: 600;">Poli & Dokter Tujuan</th>
                            <th class="py-3 text-secondary text-center" style="font-weight: 600;">Status</th>
                            <th class="px-4 py-3 text-secondary text-end" style="font-weight: 600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($registrations as $reg)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary fw-bold" style="width: 50px; height: 50px;">
                                        {{ $reg->queue_number ?? '-' }}
                                    </div>
                                    <div class="small text-muted mt-1 text-center" style="width: 50px;">
                                        {{ \Carbon\Carbon::parse($reg->registration_date)->format('d M') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $reg->patient->name }}</div>
                                    <div class="small text-muted"><i class="bi bi-upc-scan me-1"></i>{{ $reg->patient->patient_code }}</div>
                                    @php
                                        $visitBadge = ['baru' => 'primary', 'lama' => 'secondary', 'kontrol' => 'info'];
                                        $visitLabel = ['baru' => 'Baru', 'lama' => 'Lama', 'kontrol' => 'Kontrol'];
                                    @endphp
                                    <span class="badge bg-{{ $visitBadge[$reg->visit_type] ?? 'secondary' }} bg-opacity-10 text-{{ $visitBadge[$reg->visit_type] ?? 'secondary' }} mt-1" style="font-size:0.7rem;">{{ $visitLabel[$reg->visit_type] ?? 'Baru' }}</span>
                                    @if($reg->complaint)
                                        <div class="small mt-1 text-truncate text-secondary" style="max-width: 200px;">
                                            <i class="bi bi-chat-dots me-1"></i>{{ $reg->complaint }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-medium text-primary"><i class="bi bi-hospital me-1"></i>{{ $reg->department->name }}</div>
                                    <div class="small text-muted"><i class="bi bi-person-badge me-1"></i>{{ $reg->doctor->name }}</div>
                                    <div class="small mt-1">
                                        @php $pmLabels = ['umum'=>'Umum','bpjs'=>'BPJS','asuransi'=>'Asuransi','perusahaan'=>'Perusahaan','jamkesda'=>'Jamkesda']; @endphp
                                        <span class="badge {{ $reg->payment_method === 'bpjs' ? 'bg-success' : 'bg-secondary' }} bg-opacity-10 {{ $reg->payment_method === 'bpjs' ? 'text-success' : 'text-secondary' }}" style="font-size:0.7rem;">
                                            <i class="bi bi-wallet2 me-1"></i>{{ $pmLabels[$reg->payment_method] ?? 'Umum' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @php
                                        $statusColors = [
                                            'waiting' => ['bg' => 'warning', 'label' => 'Menunggu'],
                                            'serving' => ['bg' => 'info', 'label' => 'Diperiksa'],
                                            'done' => ['bg' => 'success', 'label' => 'Selesai'],
                                            'cancelled' => ['bg' => 'danger', 'label' => 'Dibatalkan']
                                        ];
                                        $color = $statusColors[$reg->status]['bg'] ?? 'secondary';
                                        $label = $statusColors[$reg->status]['label'] ?? ucfirst($reg->status);
                                    @endphp
                                    <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} rounded-pill px-3 py-2">
                                        <i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i>{{ $label }}
                                    </span>
                                </td>
                                <td class="px-4 text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm border" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi <i class="bi bi-chevron-down ms-1"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm" style="border-radius: 8px;">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('registrations.show', $reg->id) }}">
                                                    <i class="bi bi-printer text-primary me-2"></i>Cetak Antrian
                                                </a>
                                            </li>
                                            
                                            {{-- Form update status --}}
                                            <li><hr class="dropdown-divider"></li>
                                            <li><h6 class="dropdown-header">Ubah Status:</h6></li>
                                            
                                            <li>
                                                <form action="{{ route('registrations.update', $reg->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="patient_id" value="{{ $reg->patient_id }}">
                                                    <input type="hidden" name="department_id" value="{{ $reg->department_id }}">
                                                    <input type="hidden" name="doctor_id" value="{{ $reg->doctor_id }}">
                                                    <input type="hidden" name="registration_date" value="{{ $reg->registration_date }}">
                                                    <input type="hidden" name="visit_type" value="{{ $reg->visit_type }}">
                                                    <input type="hidden" name="payment_method" value="{{ $reg->payment_method }}">
                                                    <input type="hidden" name="referral_number" value="{{ $reg->referral_number }}">
                                                    <input type="hidden" name="referral_origin" value="{{ $reg->referral_origin }}">
                                                    <input type="hidden" name="bpjs_class" value="{{ $reg->bpjs_class }}">
                                                    <input type="hidden" name="sep_number" value="{{ $reg->sep_number }}">
                                                    <input type="hidden" name="complaint" value="{{ $reg->complaint }}">
                                                    <input type="hidden" name="initial_diagnosis" value="{{ $reg->initial_diagnosis }}">
                                                    <input type="hidden" name="registration_notes" value="{{ $reg->registration_notes }}">
                                                    
                                                    @if($reg->status != 'waiting')
                                                    <button type="submit" name="status" value="waiting" class="dropdown-item text-warning"><i class="bi bi-circle-fill small me-2"></i>Menunggu</button>
                                                    @endif
                                                    
                                                    @if($reg->status != 'serving')
                                                    <button type="submit" name="status" value="serving" class="dropdown-item text-info"><i class="bi bi-play-circle-fill small me-2"></i>Proses Periksa</button>
                                                    @endif
                                                    
                                                    @if($reg->status != 'done')
                                                    <button type="submit" name="status" value="done" class="dropdown-item text-success"><i class="bi bi-check-circle-fill small me-2"></i>Selesai</button>
                                                    @endif
                                                    
                                                    @if($reg->status != 'cancelled')
                                                    <button type="submit" name="status" value="cancelled" class="dropdown-item text-danger"><i class="bi bi-x-circle-fill small me-2"></i>Batalkan</button>
                                                    @endif
                                                </form>
                                            </li>
                                            
                                            <li><hr class="dropdown-divider"></li>
                                            
                                            <li>
                                                <a class="dropdown-item" href="{{ route('registrations.edit', $reg->id) }}">
                                                    <i class="bi bi-pencil text-warning me-2"></i>Edit
                                                </a>
                                            </li>
                                            
                                            <li>
                                                <form action="{{ route('registrations.destroy', $reg->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-trash text-danger me-2"></i>Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <div class="mb-3"><i class="bi bi-clipboard-x fs-1 text-secondary opacity-50"></i></div>
                                    Tidak ada data pendaftaran untuk filter yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($registrations->hasPages())
            <div class="card-footer bg-white border-top px-4 py-3">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection