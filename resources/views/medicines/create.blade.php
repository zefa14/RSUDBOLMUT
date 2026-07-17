@extends('layouts.app')

@section('title', 'Tambah Obat Baru')
@section('page-title', 'Data Obat')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-plus-square text-primary me-2"></i>Form Obat Baru</h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('medicines.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="code" class="form-label fw-semibold">Kode Obat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" placeholder="Cth: OBT-001" required>
                                @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <label for="category_id" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Obat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Cth: Paracetamol 500mg" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="unit" class="form-label fw-semibold">Satuan / Kemasan <span class="text-danger">*</span></label>
                                <select class="form-select @error('unit') is-invalid @enderror" id="unit" name="unit" required>
                                    <option value="">-- Pilih Satuan --</option>
                                    <option value="Tablet" {{ old('unit') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                                    <option value="Kapsul" {{ old('unit') == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                                    <option value="Botol" {{ old('unit') == 'Botol' ? 'selected' : '' }}>Botol (Sirup/Cair)</option>
                                    <option value="Ampul" {{ old('unit') == 'Ampul' ? 'selected' : '' }}>Ampul (Injeksi)</option>
                                    <option value="Tube" {{ old('unit') == 'Tube' ? 'selected' : '' }}>Tube (Salep)</option>
                                    <option value="Pcs" {{ old('unit') == 'Pcs' ? 'selected' : '' }}>Pcs (Alkes)</option>
                                    <option value="Box" {{ old('unit') == 'Box' ? 'selected' : '' }}>Box</option>
                                    <option value="Strip" {{ old('unit') == 'Strip' ? 'selected' : '' }}>Strip</option>
                                </select>
                                @error('unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <label for="price" class="form-label fw-semibold">Harga Jual (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">Rp</span>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', 0) }}" min="0" required>
                                </div>
                                @error('price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">Keterangan / Indikasi <span class="text-muted fw-normal">(Opsional)</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Keterangan obat atau indikasi medis...">{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4 form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="active" name="active" value="1" {{ old('active', '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold ms-2" for="active">Status Aktif (Tersedia untuk diresepkan)</label>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('medicines.index') }}" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Simpan Obat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
