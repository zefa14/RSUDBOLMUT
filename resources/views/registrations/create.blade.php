@extends('layouts.app')

@section('title', 'Pendaftaran Poliklinik Baru')
@section('page-title', 'Pendaftaran Poli')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-clipboard2-plus text-primary me-2"></i>Form Registrasi Kunjungan Poliklinik</h5>
                    <p class="text-muted small mt-1">Lengkapi data di bawah ini untuk mendaftarkan kunjungan pasien ke poliklinik.</p>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('registrations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row g-4">
                            <!-- Section 1: Data Pasien -->
                            <div class="col-12">
                                <h6 class="fw-bold text-primary mb-3 border-bottom border-primary border-opacity-25 pb-2">
                                    <i class="bi bi-person-check me-2"></i>Data Pasien
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label for="patient_id" class="form-label fw-semibold">Pilih Pasien <span class="text-danger">*</span></label>
                                        <select class="form-select @error('patient_id') is-invalid @enderror" id="patient_id" name="patient_id" required>
                                            <option value="">-- Cari Nama Pasien atau NIK --</option>
                                            @foreach($patients as $p)
                                                <option value="{{ $p->id }}" 
                                                    data-bpjs="{{ $p->bpjs_number }}"
                                                    {{ (old('patient_id') == $p->id || ($selectedPatient && $selectedPatient->id == $p->id)) ? 'selected' : '' }}>
                                                    {{ $p->patient_code }} - {{ $p->name }} (NIK: {{ $p->nik }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('patient_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        @if(!$selectedPatient)
                                            <div class="form-text">Pasien belum ada? <a href="{{ route('patients.create') }}">Daftarkan Pasien Baru</a></div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <label for="visit_type" class="form-label fw-semibold">Jenis Kunjungan <span class="text-danger">*</span></label>
                                        <select class="form-select @error('visit_type') is-invalid @enderror" id="visit_type" name="visit_type" required>
                                            <option value="baru" {{ old('visit_type') == 'baru' ? 'selected' : '' }}>Pasien Baru</option>
                                            <option value="lama" {{ old('visit_type') == 'lama' ? 'selected' : '' }}>Pasien Lama</option>
                                            <option value="kontrol" {{ old('visit_type') == 'kontrol' ? 'selected' : '' }}>Kontrol Ulang</option>
                                        </select>
                                        @error('visit_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- Info Pasien Card (muncul setelah pasien dipilih) --}}
                                <div id="patient-info-card" class="mt-3 p-3 bg-light rounded-3 d-none">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                                                <i class="bi bi-person-fill fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="fw-bold" id="info-patient-name">-</div>
                                            <div class="small text-muted">
                                                <span id="info-patient-code">-</span> &bull; 
                                                NIK: <span id="info-patient-nik">-</span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2" id="info-patient-bpjs" style="display:none;">
                                                <i class="bi bi-shield-check me-1"></i>BPJS: <span id="info-bpjs-number"></span>
                                            </span>
                                        </div>
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
                                        <label for="registration_date" class="form-label fw-semibold">Tanggal Kunjungan <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('registration_date') is-invalid @enderror" id="registration_date" name="registration_date" value="{{ old('registration_date', \Carbon\Carbon::today()->format('Y-m-d')) }}" required>
                                        @error('registration_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="department_id" class="form-label fw-semibold">Tujuan Poliklinik <span class="text-danger">*</span></label>
                                        <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id" required onchange="loadDoctors()">
                                            <option value="">-- Pilih Poliklinik --</option>
                                            @foreach($departments as $dept)
                                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="doctor_id" class="form-label fw-semibold">Dokter Pemeriksa <span class="text-danger">*</span></label>
                                        <select class="form-select @error('doctor_id') is-invalid @enderror" id="doctor_id" name="doctor_id" required disabled>
                                            <option value="">-- Pilih Poli Terlebih Dahulu --</option>
                                        </select>
                                        <div id="doctor-loading" class="form-text text-primary d-none"><span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memuat daftar dokter...</div>
                                        @error('doctor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                                        <label for="complaint" class="form-label fw-semibold">Keluhan Utama Pasien</label>
                                        <textarea class="form-control @error('complaint') is-invalid @enderror" id="complaint" name="complaint" rows="3" placeholder="Cth: Sakit kepala, demam sejak 3 hari yang lalu, mual...">{{ old('complaint') }}</textarea>
                                        @error('complaint') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="initial_diagnosis" class="form-label fw-semibold">Diagnosa Awal / Keluhan Tambahan <span class="text-muted fw-normal">(Opsional)</span></label>
                                        <textarea class="form-control @error('initial_diagnosis') is-invalid @enderror" id="initial_diagnosis" name="initial_diagnosis" rows="3" placeholder="Cth: Suspek Typhoid, Vertigo, dll...">{{ old('initial_diagnosis') }}</textarea>
                                        @error('initial_diagnosis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Section 4: Cara Bayar / Penjamin -->
                            <div class="col-12 mt-4">
                                <h6 class="fw-bold text-warning mb-3 border-bottom border-warning border-opacity-25 pb-2">
                                    <i class="bi bi-wallet2 me-2"></i>Cara Bayar / Penjamin
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="payment_method" class="form-label fw-semibold">Jenis Penjamin <span class="text-danger">*</span></label>
                                        <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                            <option value="umum" {{ old('payment_method') == 'umum' ? 'selected' : '' }}>Umum / Tunai</option>
                                            <option value="bpjs" {{ old('payment_method') == 'bpjs' ? 'selected' : '' }}>BPJS Kesehatan</option>
                                            <option value="asuransi" {{ old('payment_method') == 'asuransi' ? 'selected' : '' }}>Asuransi Swasta</option>
                                            <option value="perusahaan" {{ old('payment_method') == 'perusahaan' ? 'selected' : '' }}>Jaminan Perusahaan</option>
                                            <option value="jamkesda" {{ old('payment_method') == 'jamkesda' ? 'selected' : '' }}>JAMKESDA</option>
                                        </select>
                                        @error('payment_method') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Field khusus BPJS --}}
                                    <div class="col-md-4 bpjs-field" style="display:none;">
                                        <label for="bpjs_class" class="form-label fw-semibold">Kelas BPJS</label>
                                        <select class="form-select @error('bpjs_class') is-invalid @enderror" id="bpjs_class" name="bpjs_class">
                                            <option value="">-- Pilih Kelas --</option>
                                            <option value="1" {{ old('bpjs_class') == '1' ? 'selected' : '' }}>Kelas 1</option>
                                            <option value="2" {{ old('bpjs_class') == '2' ? 'selected' : '' }}>Kelas 2</option>
                                            <option value="3" {{ old('bpjs_class') == '3' ? 'selected' : '' }}>Kelas 3</option>
                                        </select>
                                        @error('bpjs_class') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4 bpjs-field" style="display:none;">
                                        <label for="sep_number" class="form-label fw-semibold">Nomor SEP</label>
                                        <input type="text" class="form-control @error('sep_number') is-invalid @enderror" id="sep_number" name="sep_number" value="{{ old('sep_number') }}" placeholder="Nomor Surat Eligibilitas Peserta">
                                        @error('sep_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- Field Rujukan (BPJS / Asuransi) --}}
                                <div id="referral_fields" class="row g-3 mt-2" style="display:none;">
                                    <div class="col-md-4">
                                        <label for="referral_number" class="form-label fw-semibold">Nomor Rujukan</label>
                                        <input type="text" class="form-control @error('referral_number') is-invalid @enderror" id="referral_number" name="referral_number" value="{{ old('referral_number') }}" placeholder="19 digit nomor rujukan">
                                        @error('referral_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="referral_origin" class="form-label fw-semibold">Faskes / Klinik Perujuk</label>
                                        <input type="text" class="form-control @error('referral_origin') is-invalid @enderror" id="referral_origin" name="referral_origin" value="{{ old('referral_origin') }}" placeholder="Cth: Puskesmas Kota Barat">
                                        @error('referral_origin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="referral_file" class="form-label fw-semibold">Upload Surat Rujukan <span class="text-muted fw-normal">(Opsional)</span></label>
                                        <input type="file" class="form-control @error('referral_file') is-invalid @enderror" id="referral_file" name="referral_file" accept=".jpg,.jpeg,.png,.pdf">
                                        <div class="form-text">Format: JPG, PNG, PDF. Max: 2MB.</div>
                                        @error('referral_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Section 5: Catatan Internal -->
                            <div class="col-12 mt-4">
                                <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">
                                    <i class="bi bi-sticky me-2"></i>Catatan Internal Petugas <span class="text-muted fw-normal small">(Opsional)</span>
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <textarea class="form-control @error('registration_notes') is-invalid @enderror" id="registration_notes" name="registration_notes" rows="2" placeholder="Catatan khusus untuk petugas internal, misalnya: Pasien menggunakan kursi roda, pasien diantar ambulans, dll...">{{ old('registration_notes') }}</textarea>
                                        @error('registration_notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-5 pt-4 border-top">
                            <a href="{{ route('registrations.index') }}" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-5"><i class="bi bi-save me-2"></i>Proses Pendaftaran</button>
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
        
        if (!departmentId) {
            doctorSelect.disabled = true;
            return;
        }

        doctorSelect.disabled = true;
        loadingMsg.classList.remove('d-none');

        fetch(`/get-doctors/${departmentId}`)
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    doctorSelect.innerHTML = '<option value="">-- Tidak ada dokter di poli ini --</option>';
                } else {
                    data.forEach(doctor => {
                        let option = document.createElement('option');
                        option.value = doctor.id;
                        let spec = doctor.specialization ? ` (${doctor.specialization})` : '';
                        option.textContent = doctor.name + spec;
                        
                        if (selectedDoctorId && selectedDoctorId == doctor.id) {
                            option.selected = true;
                        }
                        
                        doctorSelect.appendChild(option);
                    });
                }
                doctorSelect.disabled = false;
                loadingMsg.classList.add('d-none');
            })
            .catch(error => {
                console.error('Error fetching doctors:', error);
                doctorSelect.innerHTML = '<option value="">-- Gagal memuat dokter --</option>';
                loadingMsg.classList.add('d-none');
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Auto-load doctors jika form reload karena validasi error
        let oldDeptId = "{{ old('department_id') }}";
        let oldDocId = "{{ old('doctor_id') }}";
        if (oldDeptId) {
            loadDoctors(oldDocId);
        }

        // === Patient Info Card ===
        const patientSelect = document.getElementById('patient_id');
        const infoCard = document.getElementById('patient-info-card');

        function updatePatientInfo() {
            const selected = patientSelect.options[patientSelect.selectedIndex];
            if (selected && selected.value) {
                const text = selected.textContent.trim();
                const parts = text.split(' - ');
                const code = parts[0] || '-';
                const rest = parts[1] || '';
                const nameMatch = rest.match(/^(.+?)\s*\(NIK:\s*(.+?)\)$/);
                const name = nameMatch ? nameMatch[1].trim() : rest;
                const nik = nameMatch ? nameMatch[2].trim() : '-';
                const bpjs = selected.getAttribute('data-bpjs');
                
                document.getElementById('info-patient-name').textContent = name;
                document.getElementById('info-patient-code').textContent = code;
                document.getElementById('info-patient-nik').textContent = nik;
                
                if (bpjs && bpjs !== '') {
                    document.getElementById('info-patient-bpjs').style.display = '';
                    document.getElementById('info-bpjs-number').textContent = bpjs;
                } else {
                    document.getElementById('info-patient-bpjs').style.display = 'none';
                }
                
                infoCard.classList.remove('d-none');
            } else {
                infoCard.classList.add('d-none');
            }
        }

        patientSelect.addEventListener('change', updatePatientInfo);
        updatePatientInfo(); // Initialize on load

        // === Toggle Cara Bayar Fields ===
        const paymentMethod = document.getElementById('payment_method');
        const referralFields = document.getElementById('referral_fields');
        const referralNumber = document.getElementById('referral_number');
        const bpjsFields = document.querySelectorAll('.bpjs-field');

        function togglePaymentFields() {
            const val = paymentMethod.value;
            
            // BPJS-specific fields
            bpjsFields.forEach(el => {
                el.style.display = (val === 'bpjs') ? '' : 'none';
            });
            
            // Referral fields (for BPJS and Asuransi)
            if (val === 'bpjs' || val === 'asuransi') {
                referralFields.style.display = 'flex';
                if (val === 'bpjs') {
                    referralNumber.setAttribute('required', 'required');
                } else {
                    referralNumber.removeAttribute('required');
                }
            } else {
                referralFields.style.display = 'none';
                referralNumber.removeAttribute('required');
            }
        }

        paymentMethod.addEventListener('change', togglePaymentFields);
        togglePaymentFields(); // Initialize on load
    });
</script>
@endpush