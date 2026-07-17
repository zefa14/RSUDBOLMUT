@extends('layouts.app')

@section('title', 'Master Bangsal')
@section('page-title', 'Master Data Bangsal & Bed')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 text-primary fw-bold"><i class="bi bi-hospital me-2"></i>Master Bangsal & Konfigurasi Kamar</h4>
                <p class="text-muted mb-0">Kelola gedung, bangsal, dan atur kelas kamar beserta jumlah bed-nya di sini. Data ini akan otomatis muncul di halaman Bed Management (Admin).</p>
            </div>
            <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#createWardModal">
                <i class="bi bi-plus-lg me-1"></i> Tambah Bangsal
            </button>
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
                <span class="input-group-text bg-white border-end-0 border-light" id="search-addon">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" id="searchInput" class="form-control border-start-0 border-light py-2 bg-white" placeholder="Cari gedung, lantai, atau nama bangsal..." aria-label="Search" aria-describedby="search-addon">
            </div>
        </div>
    </div>

    {{-- Daftar Bangsal --}}
    @forelse($wards as $ward)
    <div class="card border-0 shadow-sm rounded-4 mb-4 ward-card-item" data-search="{{ $ward->building }} {{ $ward->floor }} {{ $ward->name }}">
        {{-- Header Bangsal --}}
        <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                            <i class="bi bi-building me-1"></i>{{ $ward->building }}
                        </span>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2">
                            <i class="bi bi-layers me-1"></i>{{ $ward->floor }}
                        </span>
                    </div>
                    <h5 class="fw-bold text-dark mb-0 mt-2">
                        <i class="bi bi-hospital text-primary me-2"></i>{{ $ward->name }}
                    </h5>
                </div>
                <div class="d-flex align-items-center gap-2">
                    {{-- Progress Bar Kapasitas --}}
                    <div class="text-end me-3" style="min-width: 180px;">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Terpakai</small>
                            <small class="fw-bold {{ $ward->total_beds > $ward->max_capacity ? 'text-danger' : 'text-dark' }}">
                                {{ $ward->total_beds }} / {{ $ward->max_capacity }} bed
                            </small>
                        </div>
                        @php $pct = $ward->max_capacity > 0 ? round(($ward->total_beds / $ward->max_capacity) * 100) : 0; @endphp
                        <div class="progress" style="height: 8px; border-radius: 4px;">
                            <div class="progress-bar {{ $pct >= 100 ? 'bg-danger' : ($pct >= 75 ? 'bg-warning' : 'bg-success') }}"
                                 style="width: {{ min($pct, 100) }}%"></div>
                        </div>
                        <small class="text-muted">Sisa: <strong>{{ $ward->max_capacity - $ward->total_beds }}</strong> bed tersedia</small>
                    </div>

                    <button class="btn btn-sm btn-outline-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#editWardModal{{ $ward->id }}" title="Edit Bangsal">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <form action="{{ route('wards.destroy', $ward->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus bangsal {{ $ward->name }} beserta semua kamarnya?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" title="Hapus Bangsal">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Body: Daftar Kamar/Kelas --}}
        <div class="card-body p-4">
            @if($ward->rooms->count() > 0)
                <div class="row g-3">
                    @foreach($ward->rooms as $room)
                    <div class="col-md-3 col-sm-6">
                        <div class="border rounded-3 p-3 h-100 position-relative" style="background: #f8fafc;">
                            {{-- Tombol Hapus Kamar --}}
                            <form action="{{ route('wards.removeRoom', [$ward->id, $room->id]) }}" method="POST"
                                  class="position-absolute top-0 end-0 mt-2 me-2"
                                  onsubmit="return confirm('Hapus kamar kelas {{ $room->room_class }} dari bangsal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle p-0"
                                        style="width: 24px; height: 24px; font-size: 0.7rem; display: flex; align-items: center; justify-content: center;"
                                        title="Hapus Kamar" {{ $room->occupied_beds > 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>

                            <div class="text-center">
                                <span class="badge rounded-pill px-3 py-2 mb-2
                                    @if(in_array($room->room_class, ['VVIP','VIP']))
                                        bg-warning text-dark
                                    @elseif($room->room_class == 'Kelas I')
                                        bg-primary text-white
                                    @elseif($room->room_class == 'Kelas II')
                                        bg-info text-dark
                                    @elseif(str_contains($room->room_class, 'IGD') || str_contains($room->room_class, 'ICU'))
                                        bg-danger text-white
                                    @else
                                        bg-secondary text-white
                                    @endif
                                ">{{ $room->room_class }}</span>

                                <h3 class="fw-bold mb-0 mt-2">{{ $room->total_beds }}</h3>
                                <small class="text-muted">Bed</small>

                                @if($room->occupied_beds > 0)
                                    <div class="mt-2">
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill">
                                            <i class="bi bi-person-fill me-1"></i>{{ $room->occupied_beds }} Terisi
                                        </span>
                                    </div>
                                @else
                                    <div class="mt-2">
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                                            <i class="bi bi-check-circle me-1"></i>Semua Kosong
                                        </span>
                                    </div>
                                @endif
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

            {{-- Tombol Tambah Kamar --}}
            <div class="mt-3 pt-3 border-top">
                <button class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#addRoomModal{{ $ward->id }}"
                    {{ $ward->total_beds >= $ward->max_capacity ? 'disabled' : '' }}>
                    <i class="bi bi-plus-circle me-1"></i> Tambah Kelas Kamar
                </button>
                @if($ward->total_beds >= $ward->max_capacity)
                    <small class="text-danger ms-2"><i class="bi bi-exclamation-circle me-1"></i>Kapasitas bangsal sudah penuh.</small>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Tambah Kamar untuk bangsal ini --}}
    <div class="modal fade" id="addRoomModal{{ $ward->id }}" tabindex="-1">
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

    {{-- Modal Edit Bangsal --}}
    <div class="modal fade" id="editWardModal{{ $ward->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('wards.update', $ward->id) }}" method="POST" class="modal-content border-0 shadow" style="border-radius: 16px;">
                @csrf
                @method('PUT')
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Edit Bangsal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Gedung</label>
                        <input type="text" name="building" class="form-control bg-light border-0" value="{{ $ward->building }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Lantai</label>
                        <input type="text" name="floor" class="form-control bg-light border-0" value="{{ $ward->floor }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Bangsal</label>
                        <input type="text" name="name" class="form-control bg-light border-0" value="{{ $ward->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kapasitas Maksimal (Max Bed)</label>
                        <input type="number" name="max_capacity" class="form-control bg-light border-0" value="{{ $ward->max_capacity }}" min="{{ $ward->total_beds > 0 ? $ward->total_beds : 1 }}" required>
                        @if($ward->total_beds > 0)
                            <small class="text-warning"><i class="bi bi-info-circle me-1"></i>Minimal {{ $ward->total_beds }} (sudah terkonfigurasi {{ $ward->total_beds }} bed di kamar).</small>
                        @else
                            <small class="text-muted">Admin tidak bisa mengisi bed melebihi angka ini.</small>
                        @endif
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @empty
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body text-center py-5">
            <i class="bi bi-hospital fs-1 text-muted opacity-50 mb-3 d-block"></i>
            <h5 class="text-muted">Belum ada data Master Bangsal.</h5>
            <p class="text-muted small">Klik "Tambah Bangsal" untuk menambahkan gedung dan bangsal baru.</p>
        </div>
    </div>
    @endforelse
</div>

{{-- Create Bangsal Modal --}}
<div class="modal fade" id="createWardModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('wards.store') }}" method="POST" class="modal-content border-0 shadow" style="border-radius: 16px;">
            @csrf
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Master Bangsal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Gedung <span class="text-danger">*</span></label>
                    <input type="text" name="building" class="form-control bg-light border-0" placeholder="Contoh: Gedung 4 Lantai" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Lantai <span class="text-danger">*</span></label>
                    <input type="text" name="floor" class="form-control bg-light border-0" placeholder="Contoh: Lantai 2" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Bangsal <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control bg-light border-0" placeholder="Contoh: Teratai 1" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Kapasitas Maksimal (Max Bed) <span class="text-danger">*</span></label>
                    <input type="number" name="max_capacity" class="form-control bg-light border-0" placeholder="Contoh: 20" min="1" required>
                    <small class="text-muted">Setelah bangsal dibuat, Anda bisa langsung menambahkan kelas kamar beserta jumlah bed-nya di bawah.</small>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Bangsal</button>
            </div>
        </form>
    </div>
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
                    // Get all searchable text from the card header
                    const searchData = card.getAttribute('data-search').toLowerCase();
                    
                    if (searchData.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endpush
