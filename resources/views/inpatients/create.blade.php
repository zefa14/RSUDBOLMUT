@extends('layouts.app')

@section('title', 'Pendaftaran Rawat Inap')
@section('page-title', 'Bed Management')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-door-open text-primary me-2"></i>Form Rawat Inap Baru</h5>
                        <p class="text-muted small mt-1 mb-0">Alokasikan kamar rawat inap untuk pasien.</p>
                    </div>
                    <a href="{{ route('inpatients.index') }}" class="btn btn-light shadow-sm border rounded-pill px-3">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('inpatients.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Pilih Pasien <span class="text-danger">*</span></label>
                            <select name="patient_id" class="form-select border-primary shadow-sm" required>
                                <option value="">-- Cari Pasien --</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->patient_code }} - {{ $patient->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('patient_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-4 mb-md-0">
                                <label class="form-label fw-semibold">Alokasi Kamar (Bed) <span class="text-danger">*</span></label>
                                <select name="room_id" class="form-select bg-light" required>
                                    <option value="">-- Pilih Kamar Tersedia --</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            {{ $room->name }} ({{ $room->room_class }}) - Sisa {{ $room->total_beds - $room->occupied_beds }} Bed
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Dokter Penanggung Jawab (DPJP) <span class="text-danger">*</span></label>
                                <select name="doctor_id" class="form-select bg-light" required>
                                    <option value="">-- Pilih Dokter --</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('doctor_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-4 mb-md-0">
                                <label class="form-label fw-semibold">Tanggal Masuk Inap <span class="text-danger">*</span></label>
                                <input type="date" name="admission_date" class="form-control" value="{{ old('admission_date', \Carbon\Carbon::today()->format('Y-m-d')) }}" required>
                                @error('admission_date') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Catatan Medis (Opsional)</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Kondisi pasien saat masuk...">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                                <i class="bi bi-save me-2"></i>Simpan Pendaftaran Inap
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
