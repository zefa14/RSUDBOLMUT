@extends('layouts.app')

@section('title', 'Tambah Supplier Baru')
@section('page-title', 'Mitra Supplier')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-building-add text-primary me-2"></i>Form Supplier PBF Baru</h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('suppliers.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="code" class="form-label fw-semibold">Kode Supplier <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" placeholder="Cth: SUP-001" required>
                                @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-8 mt-3 mt-md-0">
                                <label for="name" class="form-label fw-semibold">Nama Perusahaan (PT/CV) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Cth: PT. Kimia Farma Trading" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label fw-semibold">Alamat Lengkap</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address') }}</textarea>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="contact_person" class="form-label fw-semibold">Contact Person (PIC)</label>
                                <input type="text" class="form-control @error('contact_person') is-invalid @enderror" id="contact_person" name="contact_person" value="{{ old('contact_person') }}" placeholder="Nama Sales/PIC">
                            </div>
                            <div class="col-md-4 mt-3 mt-md-0">
                                <label for="phone" class="form-label fw-semibold">No. Telepon / WA</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                            </div>
                            <div class="col-md-4 mt-3 mt-md-0">
                                <label for="email" class="form-label fw-semibold">Email Perusahaan</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('suppliers.index') }}" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Simpan Supplier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
