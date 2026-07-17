@extends('layouts.app')

@section('title', 'Tambah Dokter')
@section('page-title', 'Tambah Dokter')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-person-plus text-primary me-2"></i>Form Tambah Dokter</h5>
                    <p class="text-muted small mt-1">Lengkapi profil dokter, spesialisasi, dan penempatan poliklinik.</p>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('doctors.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            {{-- Kolom Kiri: Info Dasar --}}
                            <div class="col-md-6 pe-md-4">
                                <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Informasi Dasar</h6>
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="dr. Budi Santoso, Sp.A" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="specialization" class="form-label fw-semibold">Spesialisasi</label>
                                    <input type="text" class="form-control @error('specialization') is-invalid @enderror" id="specialization" name="specialization" value="{{ old('specialization') }}" placeholder="Spesialis Anak">
                                </div>

                                <div class="mb-3">
                                    <label for="department_id" class="form-label fw-semibold">Penempatan Poliklinik <span class="text-danger">*</span></label>
                                    <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id" required>
                                        <option value="">-- Pilih Poliklinik --</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <label for="phone" class="form-label fw-semibold">No. HP <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                                    </div>
                                    <div class="col-sm-6 mt-3 mt-sm-0">
                                        <label for="email" class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="consultation_fee" class="form-label fw-semibold">Tarif Konsultasi (Rp)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control @error('consultation_fee') is-invalid @enderror" id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee') }}" placeholder="Kosongkan jika mengikuti tarif poli" min="0">
                                    </div>
                                    <div class="form-text"><i class="bi bi-info-circle me-1"></i>Jika dikosongkan, tarif konsultasi akan mengikuti tarif poli atau tarif default di Pengaturan Web.</div>
                                    @error('consultation_fee') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Kolom Kanan: Perizinan & Foto --}}
                            <div class="col-md-6 border-start ps-md-4 mt-4 mt-md-0">
                                <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Administrasi & Profil</h6>
                                
                                <div class="mb-3">
                                    <label for="str_number" class="form-label fw-semibold">Nomor STR</label>
                                    <input type="text" class="form-control @error('str_number') is-invalid @enderror" id="str_number" name="str_number" value="{{ old('str_number') }}" placeholder="Sesuai Konsil Kedokteran">
                                </div>

                                <div class="mb-3">
                                    <label for="sip_number" class="form-label fw-semibold">Nomor SIP</label>
                                    <input type="text" class="form-control @error('sip_number') is-invalid @enderror" id="sip_number" name="sip_number" value="{{ old('sip_number') }}" placeholder="Surat Izin Praktik">
                                </div>

                                <div class="mb-3">
                                    <label for="photo" class="form-label fw-semibold">Foto Profil (Opsional)</label>
                                    <input class="form-control @error('photo') is-invalid @enderror" type="file" id="photo" name="photo" accept="image/*">
                                    <div class="form-text">Format: JPG, PNG. Maksimal: 2MB.</div>
                                    @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label fw-semibold">Catatan / Bio</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                                </div>

                                <div class="mb-3 mt-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold text-success ms-2" for="is_active">Dokter Aktif Praktik</label>
                                    </div>
                                    <div class="form-text small">Matikan jika dokter sedang cuti panjang / resign.</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-5 pt-3 border-top">
                            <a href="{{ route('doctors.index') }}" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Simpan Dokter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection