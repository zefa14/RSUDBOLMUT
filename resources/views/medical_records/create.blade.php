@extends('layouts.app')

@section('title', 'Input Rekam Medis & Resep')
@section('page-title', 'Pemeriksaan Medis')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Info Pendaftaran (Jika dari Antrian) --}}
            @if($registration)
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background-color: #f8f9fa;">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                <i class="bi bi-person-heart fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">{{ $registration->patient->name }}</h5>
                                <div class="text-muted small">
                                    RM: <span class="fw-bold text-dark">{{ $registration->patient->patient_code }}</span> | 
                                    Antrian: <span class="fw-bold text-primary">{{ $registration->queue_number }}</span> | 
                                    Keluhan Awal: "{{ $registration->complaint ?? 'Tidak ada' }}"
                                </div>
                            </div>
                        </div>
                        <div class="text-end d-none d-md-block">
                            <div class="text-muted small">Dokter Pemeriksa:</div>
                            <div class="fw-bold">{{ $registration->doctor->name }}</div>
                            <div class="badge bg-info bg-opacity-10 text-info mt-1">{{ $registration->department->name }}</div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-file-medical text-primary me-2"></i>Form Rekam Medis</h5>
                    <p class="text-muted small mt-1">Catat hasil pemeriksaan, diagnosa, dan tindakan medis.</p>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('medical_records.store') }}" method="POST">
                        @csrf
                        @if($registration)
                            <input type="hidden" name="registration_id" value="{{ $registration->id }}">
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label fw-semibold">Pasien <span class="text-danger">*</span></label>
                                <select class="form-select bg-light" name="patient_id" {{ $registration ? 'readonly' : '' }} required>
                                    @if($registration)
                                        <option value="{{ $registration->patient_id }}" selected>{{ $registration->patient->name }}</option>
                                    @else
                                        <option value="">-- Pilih Pasien --</option>
                                        @foreach($patients as $p)
                                            <option value="{{ $p->id }}">{{ $p->patient_code }} - {{ $p->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label fw-semibold">Poliklinik <span class="text-danger">*</span></label>
                                <select class="form-select bg-light" name="department_id" {{ $registration ? 'readonly' : '' }} required>
                                    @if($registration)
                                        <option value="{{ $registration->department_id }}" selected>{{ $registration->department->name }}</option>
                                    @else
                                        <option value="">-- Pilih Poliklinik --</option>
                                        @foreach($departments as $d)
                                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Dokter <span class="text-danger">*</span></label>
                                <select class="form-select bg-light" name="doctor_id" {{ $registration ? 'readonly' : '' }} required>
                                    @if($registration)
                                        <option value="{{ $registration->doctor_id }}" selected>{{ $registration->doctor->name }}</option>
                                    @else
                                        <option value="">-- Pilih Dokter --</option>
                                        @foreach($doctors as $d)
                                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        {{-- S - Subjective (Keluhan) --}}
                        <div class="card mb-4 border border-light shadow-sm">
                            <div class="card-header bg-light fw-bold text-primary"><i class="bi bi-chat-text me-2"></i>Subjective (Keluhan Utama)</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <label class="form-label fw-semibold">Tanggal Pemeriksaan <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="record_date" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label fw-semibold">Anamnesis / Keluhan</label>
                                        <textarea class="form-control" name="subjective" rows="3" placeholder="Gejala yang dirasakan pasien...">{{ old('subjective', $registration->complaint ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- O - Objective (Pemeriksaan Fisik) --}}
                        <div class="card mb-4 border border-light shadow-sm">
                            <div class="card-header bg-light fw-bold text-success"><i class="bi bi-activity me-2"></i>Objective (Pemeriksaan Fisik)</div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label small">Tekanan Darah (mmHg)</label>
                                        <input type="text" class="form-control" name="blood_pressure" placeholder="120/80" value="{{ old('blood_pressure') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small">Suhu (&deg;C)</label>
                                        <input type="number" step="0.1" class="form-control" name="temperature" placeholder="36.5" value="{{ old('temperature') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small">Berat Badan (kg)</label>
                                        <input type="number" step="0.1" class="form-control" name="weight" placeholder="60.5" value="{{ old('weight') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small">Tinggi Badan (cm)</label>
                                        <input type="number" step="0.1" class="form-control" name="height" placeholder="165" value="{{ old('height') }}">
                                    </div>
                                    <div class="col-12 mt-3">
                                        <label class="form-label small">Catatan Fisik Lainnya</label>
                                        <textarea class="form-control" name="objective" rows="2" placeholder="Keadaan umum, kesadaran, dll.">{{ old('objective') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- A - Assessment (Diagnosa) --}}
                        <div class="card mb-4 border border-light shadow-sm">
                            <div class="card-header bg-light fw-bold text-danger"><i class="bi bi-clipboard2-pulse me-2"></i>Assessment (Diagnosa)</div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Kode ICD-10</label>
                                        <input type="text" class="form-control" name="icd10_code" placeholder="Cth: J06.9" value="{{ old('icd10_code') }}">
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label fw-semibold">Diagnosa Klinis <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('assessment') is-invalid @enderror" name="assessment" placeholder="Cth: Acute upper respiratory infection" required value="{{ old('assessment') }}">
                                        @error('assessment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- P - Plan (Tindakan) --}}
                        <div class="card mb-4 border border-light shadow-sm">
                            <div class="card-header bg-light fw-bold text-info"><i class="bi bi-journal-medical me-2"></i>Plan (Rencana / Tindakan)</div>
                            <div class="card-body">
                                <label class="form-label fw-semibold">Tindakan / Edukasi Pasien</label>
                                <textarea class="form-control" name="plan" rows="3" placeholder="Tindakan yang diberikan atau saran edukasi ke pasien...">{{ old('plan') }}</textarea>
                            </div>
                        </div>

                        {{-- Bagian Resep Obat Dinamis --}}
                        <div class="mt-5 bg-light p-4 rounded border">
                            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                <h6 class="fw-bold text-dark mb-0"><i class="bi bi-capsule text-success me-2"></i>E-Resep (Resep Obat)</h6>
                                <button type="button" class="btn btn-sm btn-outline-success rounded-pill" onclick="addMedicineRow()">
                                    <i class="bi bi-plus-circle me-1"></i>Tambah Obat
                                </button>
                            </div>

                            <div id="prescription-container">
                                {{-- Baris Resep Pertama (Default kosong) --}}
                                <div class="prescription-row row g-2 mb-3 align-items-end" id="row-1">
                                    <div class="col-md-4">
                                        <label class="form-label small text-muted">Pilih Obat</label>
                                        <select class="form-select form-select-sm" name="medicines[]">
                                            <option value="">-- Kosong --</option>
                                            @foreach($medicines as $med)
                                                <option value="{{ $med->id }}">{{ $med->name }} ({{ $med->unit }}) - Sisa: {{ $med->stock ?? 99 }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small text-muted">Jumlah</label>
                                        <input type="number" class="form-control form-control-sm" name="quantities[]" min="1" placeholder="Cth: 10">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small text-muted">Dosis (Signa)</label>
                                        <input type="text" class="form-control form-control-sm" name="dosages[]" placeholder="Cth: 3 x 1">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small text-muted">Instruksi Khusus</label>
                                        <input type="text" class="form-control form-control-sm" name="instructions[]" placeholder="Sesudah makan">
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger w-100" onclick="removeRow(1)" title="Hapus baris" disabled>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-text mt-2"><i class="bi bi-info-circle me-1"></i>Abaikan (biarkan kosong) bagian ini jika pasien tidak membutuhkan resep obat.</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3">
                            <a href="{{ route('registrations.index') }}" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold"><i class="bi bi-save me-2"></i>Selesai & Simpan Rekam Medis</button>
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
    let rowCount = 1;

    // Data obat dari PHP ke JS (untuk dirender ulang di baris baru)
    const medicinesData = @json($medicines->map(function($m) { return ['id' => $m->id, 'name' => $m->name . ' (' . $m->unit . ')']; }));

    function addMedicineRow() {
        rowCount++;
        
        // Buat options HTML
        let optionsHtml = '<option value="">-- Pilih Obat --</option>';
        medicinesData.forEach(med => {
            optionsHtml += `<option value="${med.id}">${med.name}</option>`;
        });

        const html = `
            <div class="prescription-row row g-2 mb-3 align-items-end" id="row-${rowCount}">
                <div class="col-md-4">
                    <select class="form-select form-select-sm" name="medicines[]">
                        ${optionsHtml}
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control form-control-sm" name="quantities[]" min="1" placeholder="Cth: 10">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control form-control-sm" name="dosages[]" placeholder="Cth: 3 x 1">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" name="instructions[]" placeholder="Sesudah makan">
                </div>
                <div class="col-md-1 text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger w-100" onclick="removeRow(${rowCount})" title="Hapus baris">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        
        document.getElementById('prescription-container').insertAdjacentHTML('beforeend', html);
        
        // Aktifkan tombol hapus di baris pertama jika baris lebih dari 1
        document.querySelector('#row-1 .btn-outline-danger').disabled = false;
    }

    function removeRow(id) {
        const row = document.getElementById(`row-${id}`);
        if(row) {
            row.remove();
        }
        
        // Jika sisa 1 baris, disable tombol hapusnya
        const remainingRows = document.querySelectorAll('.prescription-row');
        if(remainingRows.length === 1) {
            remainingRows[0].querySelector('.btn-outline-danger').disabled = true;
        }
    }

    // Auto-fill Poliklinik & Dokter ketika Pasien dipilih
    document.addEventListener('DOMContentLoaded', function() {
        const patientSelect = document.querySelector('select[name="patient_id"]');
        if (patientSelect && !patientSelect.hasAttribute('readonly')) {
            patientSelect.addEventListener('change', function() {
                const patientId = this.value;
                if (patientId) {
                    fetch(`/get-active-registration/${patientId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Auto-fill Poliklinik dan Dokter
                                document.querySelector('select[name="department_id"]').value = data.department_id;
                                document.querySelector('select[name="doctor_id"]').value = data.doctor_id;
                                
                                // Auto-fill Keluhan Utama jika ada
                                const subjectiveInput = document.querySelector('textarea[name="subjective"]');
                                if (subjectiveInput && data.complaint) {
                                    subjectiveInput.value = data.complaint;
                                }

                                // Tambahkan hidden input registration_id agar status antrian bisa terupdate
                                let form = document.querySelector('form[action="{{ route('medical_records.store') }}"]');
                                let regInput = document.querySelector('input[name="registration_id"]');
                                if (!regInput) {
                                    regInput = document.createElement('input');
                                    regInput.type = 'hidden';
                                    regInput.name = 'registration_id';
                                    form.appendChild(regInput);
                                }
                                regInput.value = data.registration_id;
                            } else {
                                // Reset jika tidak ada antrian aktif
                                document.querySelector('select[name="department_id"]').value = '';
                                document.querySelector('select[name="doctor_id"]').value = '';
                                let regInput = document.querySelector('input[name="registration_id"]');
                                if (regInput) regInput.remove();
                            }
                        })
                        .catch(error => console.error('Error fetching registration:', error));
                } else {
                    document.querySelector('select[name="department_id"]').value = '';
                    document.querySelector('select[name="doctor_id"]').value = '';
                    let regInput = document.querySelector('input[name="registration_id"]');
                    if (regInput) regInput.remove();
                }
            });
        }
    });
</script>
@endpush