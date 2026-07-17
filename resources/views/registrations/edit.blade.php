@extends('layouts.app')

@section('title', 'Edit Pendaftaran')
@section('page-title', 'Edit Pendaftaran')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil-square text-primary me-2"></i>Edit Data Pendaftaran</h5>
                    <p class="text-muted small mt-1">Perbarui data pendaftaran kunjungan pasien. No. Antrian: <span class="badge bg-primary">{{ $registration->queue_number }}</span></p>
                </div>
                
                <div class="card-body p-4">
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Terdapat kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form action="{{ route('registrations.update', $registration->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- Section 1: Data Pasien & Status -->
                            <div class="col-12">
                                <h6 class="fw-bold text-primary mb-3 border-bottom border-primary border-opacity-25 pb-2">
                                    <i class="bi bi-person-check me-2"></i>Data Pasien & Status
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-5">
                                        <label class="form-label fw-semibold">Pasien <span class="text-danger">*</span></label>
                                        <select name="patient_id" class="form-select" required>
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}" {{ old('patient_id', $registration->patient_id) == $patient->id ? 'selected' : '' }}>
                                                    {{ $patient->patient_code }} - {{ $patient->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Jenis Kunjungan</label>
                                        <select name="visit_type" class="form-select">
                                            <option value="baru" {{ old('visit_type', $registration->visit_type) == 'baru' ? 'selected' : '' }}>Pasien Baru</option>
                                            <option value="lama" {{ old('visit_type', $registration->visit_type) == 'lama' ? 'selected' : '' }}>Pasien Lama</option>
                                            <option value="kontrol" {{ old('visit_type', $registration->visit_type) == 'kontrol' ? 'selected' : '' }}>Kontrol Ulang</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Status Antrian <span class="text-danger">*</span></label>
                                        <select name="status" class="form-select" required>
                                            <option value="waiting" {{ old('status', $registration->status) == 'waiting' ? 'selected' : '' }}>🟡 Menunggu</option>
                                            <option value="serving" {{ old('status', $registration->status) == 'serving' ? 'selected' : '' }}>🔵 Diperiksa</option>
                                            <option value="done" {{ old('status', $registration->status) == 'done' ? 'selected' : '' }}>🟢 Selesai</option>
                                            <option value="cancelled" {{ old('status', $registration->status) == 'cancelled' ? 'selected' : '' }}>🔴 Dibatalkan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2: Tujuan Poliklinik -->
                            <div class="col-12 mt-4">
                                <h6 class="fw-bold text-success mb-3 border-bottom border-success border-opacity-25 pb-2">
                                    <i class="bi bi-hospital me-2"></i>Tujuan Poliklinik & Jadwal
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Tanggal Kunjungan <span class="text-danger">*</span></label>
                                        <input type="date" name="registration_date" class="form-control" value="{{ old('registration_date', $registration->registration_date) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Tujuan Poliklinik <span class="text-danger">*</span></label>
                                        <select name="department_id" id="department_id" class="form-select" required onchange="loadDoctors()">
                                            <option value="">-- Pilih Poliklinik --</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ old('department_id', $registration->department_id) == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Dokter Pemeriksa <span class="text-danger">*</span></label>
                                        <select name="doctor_id" id="doctor_id" class="form-select" required>
                                            <option value="">-- Pilih Poli Terlebih Dahulu --</option>
                                        </select>
                                        <div id="doctor-loading" class="form-text text-primary d-none"><span class="spinner-border spinner-border-sm me-1"></span> Memuat...</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3: Keluhan & Diagnosa -->
                            <div class="col-12 mt-4">
                                <h6 class="fw-bold text-info mb-3 border-bottom border-info border-opacity-25 pb-2">
                                    <i class="bi bi-chat-square-text me-2"></i>Keluhan & Diagnosa Awal
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Keluhan Utama Pasien</label>
                                        <textarea class="form-control" name="complaint" rows="3">{{ old('complaint', $registration->complaint) }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Diagnosa Awal / Keluhan Tambahan</label>
                                        <textarea class="form-control" name="initial_diagnosis" rows="3">{{ old('initial_diagnosis', $registration->initial_diagnosis) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 4: Cara Bayar -->
                            <div class="col-12 mt-4">
                                <h6 class="fw-bold text-warning mb-3 border-bottom border-warning border-opacity-25 pb-2">
                                    <i class="bi bi-wallet2 me-2"></i>Cara Bayar / Penjamin
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Jenis Penjamin <span class="text-danger">*</span></label>
                                        <select class="form-select" id="payment_method" name="payment_method" required>
                                            <option value="umum" {{ old('payment_method', $registration->payment_method) == 'umum' ? 'selected' : '' }}>Umum / Tunai</option>
                                            <option value="bpjs" {{ old('payment_method', $registration->payment_method) == 'bpjs' ? 'selected' : '' }}>BPJS Kesehatan</option>
                                            <option value="asuransi" {{ old('payment_method', $registration->payment_method) == 'asuransi' ? 'selected' : '' }}>Asuransi Swasta</option>
                                            <option value="perusahaan" {{ old('payment_method', $registration->payment_method) == 'perusahaan' ? 'selected' : '' }}>Jaminan Perusahaan</option>
                                            <option value="jamkesda" {{ old('payment_method', $registration->payment_method) == 'jamkesda' ? 'selected' : '' }}>JAMKESDA</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 bpjs-field" style="display:none;">
                                        <label class="form-label fw-semibold">Kelas BPJS</label>
                                        <select class="form-select" id="bpjs_class" name="bpjs_class">
                                            <option value="">-- Pilih --</option>
                                            <option value="1" {{ old('bpjs_class', $registration->bpjs_class) == '1' ? 'selected' : '' }}>Kelas 1</option>
                                            <option value="2" {{ old('bpjs_class', $registration->bpjs_class) == '2' ? 'selected' : '' }}>Kelas 2</option>
                                            <option value="3" {{ old('bpjs_class', $registration->bpjs_class) == '3' ? 'selected' : '' }}>Kelas 3</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 bpjs-field" style="display:none;">
                                        <label class="form-label fw-semibold">Nomor SEP</label>
                                        <input type="text" class="form-control" id="sep_number" name="sep_number" value="{{ old('sep_number', $registration->sep_number) }}">
                                    </div>
                                </div>

                                <div id="referral_fields" class="row g-3 mt-2" style="display:none;">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Nomor Rujukan</label>
                                        <input type="text" class="form-control" id="referral_number" name="referral_number" value="{{ old('referral_number', $registration->referral_number) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Faskes / Klinik Perujuk</label>
                                        <input type="text" class="form-control" name="referral_origin" value="{{ old('referral_origin', $registration->referral_origin) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Upload Surat Rujukan</label>
                                        <input type="file" class="form-control" name="referral_file" accept=".jpg,.jpeg,.png,.pdf">
                                        @if($registration->referral_file_path)
                                            <div class="mt-2">
                                                <a href="{{ asset('storage/' . $registration->referral_file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-file-earmark-text me-1"></i>Lihat File Saat Ini</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Section 5: Catatan Internal -->
                            <div class="col-12 mt-4">
                                <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">
                                    <i class="bi bi-sticky me-2"></i>Catatan Internal Petugas
                                </h6>
                                <textarea class="form-control" name="registration_notes" rows="2">{{ old('registration_notes', $registration->registration_notes) }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-5 pt-4 border-top">
                            <a href="{{ route('registrations.index') }}" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-5"><i class="bi bi-save me-2"></i>Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function loadDoctors(selectedDoctorId = null) {
        let departmentId = document.getElementById('department_id').value;
        let doctorSelect = document.getElementById('doctor_id');
        let loadingMsg = document.getElementById('doctor-loading');

        doctorSelect.innerHTML = '<option value="">-- Pilih Dokter --</option>';
        if (!departmentId) { doctorSelect.disabled = true; return; }

        doctorSelect.disabled = true;
        loadingMsg.classList.remove('d-none');

        fetch(`/get-doctors/${departmentId}`)
            .then(r => r.json())
            .then(data => {
                if (data.length === 0) {
                    doctorSelect.innerHTML = '<option value="">-- Tidak ada dokter --</option>';
                } else {
                    data.forEach(doc => {
                        let opt = document.createElement('option');
                        opt.value = doc.id;
                        opt.textContent = doc.name + (doc.specialization ? ` (${doc.specialization})` : '');
                        if (selectedDoctorId && selectedDoctorId == doc.id) opt.selected = true;
                        doctorSelect.appendChild(opt);
                    });
                }
                doctorSelect.disabled = false;
                loadingMsg.classList.add('d-none');
            })
            .catch(() => {
                doctorSelect.innerHTML = '<option value="">-- Gagal memuat --</option>';
                loadingMsg.classList.add('d-none');
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Auto-load doctors
        let oldDeptId = "{{ old('department_id', $registration->department_id) }}";
        let oldDocId = "{{ old('doctor_id', $registration->doctor_id) }}";
        if (oldDeptId) loadDoctors(oldDocId);

        // Toggle payment fields
        const pm = document.getElementById('payment_method');
        const refFields = document.getElementById('referral_fields');
        const refNum = document.getElementById('referral_number');
        const bpjsFields = document.querySelectorAll('.bpjs-field');

        function toggle() {
            const v = pm.value;
            bpjsFields.forEach(el => el.style.display = v === 'bpjs' ? '' : 'none');
            if (v === 'bpjs' || v === 'asuransi') {
                refFields.style.display = 'flex';
                if (v === 'bpjs') refNum.setAttribute('required','required');
                else refNum.removeAttribute('required');
            } else {
                refFields.style.display = 'none';
                refNum.removeAttribute('required');
            }
        }
        pm.addEventListener('change', toggle);
        toggle();
    });
</script>
@endpush