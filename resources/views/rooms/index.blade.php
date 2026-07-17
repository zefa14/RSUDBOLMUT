@extends('layouts.app')

@section('title', 'Manajemen Ruang Rawat Inap')
@section('page-title', 'Rawat Inap & Kamar')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-1 text-primary fw-bold"><i class="bi bi-hospital me-2"></i>Bed Management (Rawat Inap)</h4>
            <p class="text-muted mb-0">Kelola keterisian kasur (bed) secara real-time. Konfigurasi kamar diatur oleh Super Admin di Master Bangsal.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Search Bar --}}
    <div class="row mb-4">
        <div class="col-md-5">
            <div class="input-group shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <span class="input-group-text bg-white border-end-0 border-light">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" id="searchInput" class="form-control border-start-0 border-light py-2 bg-white" placeholder="Cari bangsal, gedung, atau kelas kamar...">
            </div>
        </div>
    </div>

    @forelse($wards as $ward)
        <div class="card border-0 shadow-sm rounded-4 mb-4 ward-card-item" data-search="{{ $ward->building }} {{ $ward->floor }} {{ $ward->name }} {{ $ward->rooms->pluck('room_class')->join(' ') }}">
            <div class="card-header bg-white border-bottom pt-3 pb-2 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-building text-primary me-2"></i>{{ $ward->building }} - {{ $ward->floor }}
                        </h6>
                        <small class="text-primary fw-semibold">{{ $ward->name }}</small>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        @php
                            $pct = $ward->total_beds > 0 ? round(($ward->occupied_beds / $ward->total_beds) * 100) : 0;
                        @endphp
                        <div class="text-end" style="min-width: 140px;">
                            <small class="text-muted">Keterisian: <strong>{{ $ward->occupied_beds }}/{{ $ward->total_beds }}</strong></small>
                            <div class="progress mt-1" style="height: 6px; border-radius: 3px;">
                                <div class="progress-bar {{ $pct >= 90 ? 'bg-danger' : ($pct >= 60 ? 'bg-warning' : 'bg-success') }}"
                                     style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                @if($ward->rooms->count() > 0)
                <div class="row g-4">
                    @foreach($ward->rooms as $room)
                    <div class="col-md-4 col-lg-3">
                        <div class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden">
                            {{-- Header Warna berdasarkan status --}}
                            @if($room->available_beds == 0)
                                <div style="height: 6px; background-color: #dc3545; width: 100%;"></div>
                            @elseif($room->available_beds <= 2)
                                <div style="height: 6px; background-color: #ffc107; width: 100%;"></div>
                            @else
                                <div style="height: 6px; background-color: #198754; width: 100%;"></div>
                            @endif

                            <div class="card-body p-4 text-center">
                                <div class="badge bg-light text-primary border border-primary px-3 py-2 rounded-pill mb-3 fw-bold mt-1">
                                    {{ $room->room_class }}
                                </div>

                                <div class="d-flex justify-content-center align-items-center gap-4 mb-3">
                                    <div>
                                        <h2 class="fw-bold mb-0 {{ $room->occupied_beds > 0 ? 'text-danger' : 'text-muted' }}">{{ $room->occupied_beds }}</h2>
                                        <small class="text-muted">Terisi</small>
                                    </div>
                                    <div style="width: 2px; height: 40px; background-color: #eee;"></div>
                                    <div>
                                        <h2 class="fw-bold mb-0 {{ $room->available_beds > 0 ? 'text-success' : 'text-danger' }}">{{ $room->available_beds }}</h2>
                                        <small class="text-muted">Kosong</small>
                                    </div>
                                </div>

                                <p class="text-muted small mb-3">Total: {{ $room->total_beds }} Kasur</p>

                                {{-- Tombol Aksi Pasien Masuk/Keluar --}}
                                <div class="d-flex gap-2 justify-content-center">
                                    <form action="{{ route('rooms.occupancy', $room->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="fill">
                                        <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3"
                                            {{ $room->available_beds == 0 ? 'disabled' : '' }}
                                            title="Pasien Masuk">
                                            <i class="bi bi-person-plus me-1"></i> Masuk
                                        </button>
                                    </form>
                                    <form action="{{ route('rooms.occupancy', $room->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="empty">
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                            {{ $room->occupied_beds == 0 ? 'disabled' : '' }}
                                            title="Pasien Keluar">
                                            <i class="bi bi-person-dash me-1"></i> Keluar
                                        </button>
                                    </form>
                                </div>

                                <div class="mt-3">
                                    <a href="{{ route('inpatients.index') }}" class="btn btn-sm btn-light rounded-pill px-3 text-primary">
                                        <i class="bi bi-person-lines-fill me-1"></i> Kelola Pasien
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-3 text-muted">
                    <i class="bi bi-inbox fs-4 d-block mb-2 opacity-50"></i>
                    <small>Belum ada kamar dikonfigurasi di bangsal ini.</small>
                </div>
                @endif

                {{-- Tombol Tambah Kelas Kamar --}}
                <div class="mt-3 pt-3 border-top">
                    <button class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#addRoomBedModal{{ $ward->id }}"
                        {{ $ward->total_beds >= $ward->max_capacity ? 'disabled' : '' }}>
                        <i class="bi bi-plus-circle me-1"></i> Tambah Kelas Kamar
                    </button>
                    @if($ward->total_beds >= $ward->max_capacity)
                        <small class="text-danger ms-2"><i class="bi bi-exclamation-circle me-1"></i>Kapasitas bangsal sudah penuh ({{ $ward->max_capacity }} bed).</small>
                    @else
                        <small class="text-muted ms-2">Sisa kapasitas: <strong>{{ $ward->max_capacity - $ward->total_beds }}</strong> bed.</small>
                    @endif
                </div>
            </div>
        </div>

        {{-- Modal Tambah Kamar --}}
        <div class="modal fade" id="addRoomBedModal{{ $ward->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <form action="{{ route('wards.addRoom', $ward->id) }}" method="POST" class="modal-content border-0 shadow" style="border-radius: 16px;">
                    @csrf
                    <div class="modal-header border-0 pb-0">
                        <h6 class="modal-title fw-bold">Tambah Kamar di {{ $ward->name }}</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kelas Layanan <span class="text-danger">*</span></label>
                            <select name="room_class" class="form-select rounded-3" required>
                                <option value="VVIP">VVIP</option>
                                <option value="VIP">VIP</option>
                                <option value="Kelas I">Kelas I</option>
                                <option value="Kelas II">Kelas II</option>
                                <option value="Kelas III" selected>Kelas III</option>
                                <option value="IGD / ICU">IGD / ICU</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jumlah Bed <span class="text-danger">*</span></label>
                            <input type="number" name="total_beds" class="form-control rounded-3" min="1" max="{{ $ward->max_capacity - $ward->total_beds }}" value="1" required>
                            <small class="text-muted">Sisa kapasitas: <strong>{{ $ward->max_capacity - $ward->total_beds }}</strong> bed.</small>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-3"><i class="bi bi-plus-lg me-1"></i>Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted opacity-50 mb-3 d-block"></i>
                <h5 class="text-muted">Belum ada data Kamar/Bangsal.</h5>
                <p class="text-muted small">Hubungi Super Admin untuk mengkonfigurasi Master Bangsal terlebih dahulu.</p>
            </div>
        </div>
    @endforelse
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const wardCards = document.querySelectorAll('.ward-card-item');

        if(searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                wardCards.forEach(card => {
                    const searchData = card.getAttribute('data-search').toLowerCase();
                    card.style.display = searchData.includes(searchTerm) ? 'block' : 'none';
                });
            });
        }
    });
</script>
@endpush
