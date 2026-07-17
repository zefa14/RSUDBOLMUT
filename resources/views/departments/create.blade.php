@extends('layouts.app')

@section('title', 'Tambah Poliklinik')
@section('page-title', 'Tambah Poliklinik')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-plus-circle text-primary me-2"></i>Form Tambah Poliklinik</h5>
                    <p class="text-muted small mt-1">Silakan lengkapi informasi poliklinik baru di bawah ini.</p>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('departments.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">Nama Poliklinik <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Poliklinik Mata" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="consultation_fee" class="form-label fw-semibold">Tarif Konsultasi Default (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('consultation_fee') is-invalid @enderror" id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee') }}" placeholder="Kosongkan jika mengikuti tarif Global di Pengaturan" min="0">
                            </div>
                            <div class="form-text"><i class="bi bi-info-circle me-1"></i>Jika dikosongkan, tarif akan mengikuti tarif default di Pengaturan Web (Umum / Spesialis).</div>
                            @error('consultation_fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Penjelasan singkat mengenai layanan di poliklinik ini...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('departments.index') }}" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection