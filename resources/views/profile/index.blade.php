@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-4">
            <h4 class="fw-bold">Pengaturan Profil</h4>
            <p class="text-muted">Kelola informasi pribadi dan keamanan akun Anda.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card card-modern border-0">
                <div class="card-body text-center p-4">
                    <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=0d6efd&color=fff&size=128' }}" 
                         alt="{{ auth()->user()->name }}" 
                         class="rounded-circle img-fluid border shadow-sm mb-3" 
                         style="width: 120px; height: 120px; object-fit: cover;">
                    <h5 class="fw-bold mb-1">{{ auth()->user()->name }}</h5>
                    <p class="text-muted mb-3">{{ auth()->user()->email }}</p>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">{{ auth()->user()->role_label }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="card card-modern border-0">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold m-0"><i class="bi bi-person-lines-fill text-primary me-2"></i> Informasi Dasar</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium text-muted small">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium text-muted small">Alamat Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium text-muted small">Nomor Telepon</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone) }}">
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <hr class="my-4" style="border-color: #e8ecf0;">

                        <h6 class="fw-bold mb-3"><i class="bi bi-shield-lock-fill text-danger me-2"></i> Ubah Kata Sandi</h6>
                        <p class="text-muted small mb-3">Kosongkan jika tidak ingin mengubah kata sandi.</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium text-muted small">Kata Sandi Baru</label>
                                <input type="password" name="password" class="form-control">
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium text-muted small">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-medium">
                                <i class="bi bi-floppy-fill me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
