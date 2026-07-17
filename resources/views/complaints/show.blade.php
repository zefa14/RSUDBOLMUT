@extends('layouts.app')

@section('title', 'Detail Pengaduan')
@section('page-title', 'Detail Pengaduan')
@section('page-subtitle', 'Lihat detail dan respon pengaduan masyarakat')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        {{-- Detail Pengaduan --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="fw-bold mb-1"><i class="bi bi-envelope-open-fill text-primary me-2"></i>Pengaduan dari {{ $complaint->name }}</h5>
                            <small class="text-muted">Diterima: {{ $complaint->created_at->format('d F Y, H:i') }} WIT</small>
                        </div>
                        @if($complaint->status === 'baru')
                            <span class="badge bg-warning text-dark px-3 py-2 fs-6">Baru</span>
                        @elseif($complaint->status === 'diproses')
                            <span class="badge bg-info text-white px-3 py-2 fs-6">Diproses</span>
                        @else
                            <span class="badge bg-success px-3 py-2 fs-6">Selesai</span>
                        @endif
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="p-3 rounded-3" style="background: #f8fafc;">
                                <small class="text-muted d-block mb-1"><i class="bi bi-person me-1"></i> Nama</small>
                                <span class="fw-semibold">{{ $complaint->name }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3" style="background: #f8fafc;">
                                <small class="text-muted d-block mb-1"><i class="bi bi-envelope me-1"></i> Email</small>
                                <span class="fw-semibold">{{ $complaint->email ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3" style="background: #f8fafc;">
                                <small class="text-muted d-block mb-1"><i class="bi bi-telephone me-1"></i> Telepon</small>
                                <span class="fw-semibold">{{ $complaint->phone ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <span class="badge bg-light text-dark fw-semibold px-3 py-2"><i class="bi bi-tag me-1"></i> {{ $complaint->category }}</span>
                    </div>

                    <div class="p-4 rounded-3" style="background: #fefce8; border: 1px solid #fef08a;">
                        <h6 class="fw-bold mb-2"><i class="bi bi-chat-left-text me-2 text-warning"></i>Isi Pengaduan</h6>
                        <p class="mb-0" style="line-height: 1.8; white-space: pre-wrap;">{{ $complaint->message }}</p>
                    </div>

                    @if($complaint->admin_response)
                    <div class="p-4 rounded-3 mt-3" style="background: #f0fdfa; border: 1px solid #99f6e4;">
                        <h6 class="fw-bold mb-2" style="color: #0d9488;"><i class="bi bi-reply-fill me-2"></i>Respon Admin</h6>
                        <p class="mb-0" style="line-height: 1.8; white-space: pre-wrap;">{{ $complaint->admin_response }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Respon & Aksi --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-pencil-square text-primary me-2"></i>Tindak Lanjut</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <form action="{{ route('complaints.update', $complaint) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Update Status</label>
                            <select name="status" class="form-select rounded-3">
                                <option value="baru" {{ $complaint->status === 'baru' ? 'selected' : '' }}>🟡 Baru</option>
                                <option value="diproses" {{ $complaint->status === 'diproses' ? 'selected' : '' }}>🔵 Diproses</option>
                                <option value="selesai" {{ $complaint->status === 'selesai' ? 'selected' : '' }}>🟢 Selesai</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Respon Admin</label>
                            <textarea name="admin_response" class="form-control rounded-3" rows="5" placeholder="Tulis respon atau catatan tindak lanjut...">{{ $complaint->admin_response }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold rounded-3 py-2">
                            <i class="bi bi-check2-circle me-2"></i> Simpan Perubahan
                        </button>
                    </form>

                    <hr class="my-4">

                    <form action="{{ route('complaints.destroy', $complaint) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengaduan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100 rounded-3 py-2">
                            <i class="bi bi-trash3 me-2"></i> Hapus Pengaduan
                        </button>
                    </form>

                    <a href="{{ route('complaints.index') }}" class="btn btn-light w-100 rounded-3 py-2 mt-2">
                        <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
