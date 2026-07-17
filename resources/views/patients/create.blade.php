@extends('layouts.app')

@section('title', 'Pendaftaran Pasien Baru')
@section('page-title', 'Pendaftaran Pasien')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            {{-- Header --}}
            <div class="text-center mb-4">
                <h4 class="fw-bold text-dark mb-1"><i class="bi bi-person-plus-fill text-primary me-2"></i>Formulir Pendaftaran Pasien Baru</h4>
                <p class="text-muted">Lengkapi data pasien secara bertahap. Kolom bertanda <span class="text-danger">*</span> wajib diisi.</p>
            </div>

            {{-- Step Indicator --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
                <div class="card-body py-4 px-5">
                    <div class="step-indicator d-flex justify-content-between align-items-center position-relative">
                        <div class="step-line position-absolute" style="top:20px;left:40px;right:40px;height:3px;background:#e9ecef;z-index:0;">
                            <div class="step-line-progress" id="stepLineProgress" style="width:0%;height:100%;background:linear-gradient(90deg,#0d6efd,#0b5ed7);transition:width 0.4s ease;border-radius:3px;"></div>
                        </div>
                        <div class="step-item text-center position-relative" style="z-index:1;" data-step="1">
                            <div class="step-circle mx-auto mb-2 d-flex align-items-center justify-content-center rounded-circle active" style="width:42px;height:42px;border:3px solid #0d6efd;background:#0d6efd;color:white;font-weight:700;transition:all 0.3s;">1</div>
                            <div class="step-label small fw-bold text-primary">Identitas</div>
                        </div>
                        <div class="step-item text-center position-relative" style="z-index:1;" data-step="2">
                            <div class="step-circle mx-auto mb-2 d-flex align-items-center justify-content-center rounded-circle" style="width:42px;height:42px;border:3px solid #e9ecef;background:white;color:#adb5bd;font-weight:700;transition:all 0.3s;">2</div>
                            <div class="step-label small fw-bold text-muted">Alamat & Kontak</div>
                        </div>
                        <div class="step-item text-center position-relative" style="z-index:1;" data-step="3">
                            <div class="step-circle mx-auto mb-2 d-flex align-items-center justify-content-center rounded-circle" style="width:42px;height:42px;border:3px solid #e9ecef;background:white;color:#adb5bd;font-weight:700;transition:all 0.3s;">3</div>
                            <div class="step-label small fw-bold text-muted">Kontak Darurat</div>
                        </div>
                        <div class="step-item text-center position-relative" style="z-index:1;" data-step="4">
                            <div class="step-circle mx-auto mb-2 d-flex align-items-center justify-content-center rounded-circle" style="width:42px;height:42px;border:3px solid #e9ecef;background:white;color:#adb5bd;font-weight:700;transition:all 0.3s;">4</div>
                            <div class="step-label small fw-bold text-muted">Data Medis</div>
                        </div>
                        <div class="step-item text-center position-relative" style="z-index:1;" data-step="5">
                            <div class="step-circle mx-auto mb-2 d-flex align-items-center justify-content-center rounded-circle" style="width:42px;height:42px;border:3px solid #e9ecef;background:white;color:#adb5bd;font-weight:700;transition:all 0.3s;">5</div>
                            <div class="step-label small fw-bold text-muted">Konfirmasi</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data" id="patientForm">
                @csrf

                {{-- STEP 1: Identitas Utama --}}
                <div class="step-panel" id="step-1">
                    <div class="card border-0 shadow-sm" style="border-radius:16px;">
                        <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
                            <h5 class="fw-bold text-primary mb-0"><i class="bi bi-person-vcard me-2"></i>Langkah 1: Identitas Utama Pasien</h5>
                            <p class="text-muted small mt-1 mb-0">Masukkan data dasar identitas pasien sesuai KTP/Kartu Identitas.</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-primary"></i></span>
                                        <input type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Sesuai KTP" required>
                                    </div>
                                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="nik" class="form-label fw-semibold">Nomor NIK (KTP) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-credit-card text-primary"></i></span>
                                        <input type="text" class="form-control border-start-0 @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}" placeholder="16 digit NIK" maxlength="20" required>
                                    </div>
                                    @error('nik') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="bpjs_number" class="form-label fw-semibold">Nomor BPJS <span class="text-muted fw-normal">(Opsional)</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-shield-check text-success"></i></span>
                                        <input type="text" class="form-control border-start-0 @error('bpjs_number') is-invalid @enderror" id="bpjs_number" name="bpjs_number" value="{{ old('bpjs_number') }}" placeholder="13 digit">
                                    </div>
                                    @error('bpjs_number') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="birth_place" class="form-label fw-semibold">Tempat Lahir</label>
                                    <input type="text" class="form-control @error('birth_place') is-invalid @enderror" id="birth_place" name="birth_place" value="{{ old('birth_place') }}" placeholder="Cth: Jakarta">
                                    @error('birth_place') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="birth_date" class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                                    <div class="form-text small" id="age-display"></div>
                                    @error('birth_date') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="gender" class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('gender') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="blood_type" class="form-label fw-semibold">Golongan Darah</label>
                                    <select class="form-select @error('blood_type') is-invalid @enderror" id="blood_type" name="blood_type">
                                        <option value="">-- Pilih --</option>
                                        @foreach(['A', 'B', 'AB', 'O', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bt)
                                            <option value="{{ $bt }}" {{ old('blood_type') == $bt ? 'selected' : '' }}>{{ $bt }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="religion" class="form-label fw-semibold">Agama</label>
                                    <select class="form-select @error('religion') is-invalid @enderror" id="religion" name="religion">
                                        <option value="">-- Pilih --</option>
                                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'] as $rel)
                                            <option value="{{ $rel }}" {{ old('religion') == $rel ? 'selected' : '' }}>{{ $rel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="marital_status" class="form-label fw-semibold">Status Pernikahan</label>
                                    <select class="form-select @error('marital_status') is-invalid @enderror" id="marital_status" name="marital_status">
                                        <option value="">-- Pilih --</option>
                                        @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                                            <option value="{{ $status }}" {{ old('marital_status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="education" class="form-label fw-semibold">Pendidikan Terakhir</label>
                                    <select class="form-select @error('education') is-invalid @enderror" id="education" name="education">
                                        <option value="">-- Pilih --</option>
                                        @foreach(['Tidak Sekolah', 'SD/Sederajat', 'SMP/Sederajat', 'SMA/SMK/Sederajat', 'D1/D2/D3', 'S1/D4', 'S2', 'S3'] as $edu)
                                            <option value="{{ $edu }}" {{ old('education') == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="occupation" class="form-label fw-semibold">Pekerjaan</label>
                                    <input type="text" class="form-control @error('occupation') is-invalid @enderror" id="occupation" name="occupation" value="{{ old('occupation') }}" placeholder="Cth: Wiraswasta, PNS">
                                    @error('occupation') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 2: Alamat & Kontak --}}
                <div class="step-panel d-none" id="step-2">
                    <div class="card border-0 shadow-sm" style="border-radius:16px;">
                        <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
                            <h5 class="fw-bold text-success mb-0"><i class="bi bi-geo-alt-fill me-2"></i>Langkah 2: Informasi Kontak & Alamat</h5>
                            <p class="text-muted small mt-1 mb-0">Masukkan alamat lengkap dan nomor kontak yang bisa dihubungi.</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="phone" class="form-label fw-semibold">Nomor Telepon / HP <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-telephone text-success"></i></span>
                                        <input type="text" class="form-control border-start-0 @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
                                    </div>
                                    @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="email" class="form-label fw-semibold">Alamat Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-success"></i></span>
                                        <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com">
                                    </div>
                                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="rt_rw" class="form-label fw-semibold">RT / RW</label>
                                    <input type="text" class="form-control @error('rt_rw') is-invalid @enderror" id="rt_rw" name="rt_rw" value="{{ old('rt_rw') }}" placeholder="001/002">
                                    @error('rt_rw') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="address" class="form-label fw-semibold">Alamat Lengkap (Jalan, No. Rumah) <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2" placeholder="Jl. Contoh No. 123, Gang Melati" required>{{ old('address') }}</textarea>
                                    @error('address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="kelurahan" class="form-label fw-semibold">Kelurahan / Desa</label>
                                    <input type="text" class="form-control @error('kelurahan') is-invalid @enderror" id="kelurahan" name="kelurahan" value="{{ old('kelurahan') }}">
                                    @error('kelurahan') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="kecamatan" class="form-label fw-semibold">Kecamatan</label>
                                    <input type="text" class="form-control @error('kecamatan') is-invalid @enderror" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}">
                                    @error('kecamatan') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="kabupaten" class="form-label fw-semibold">Kabupaten / Kota</label>
                                    <input type="text" class="form-control @error('kabupaten') is-invalid @enderror" id="kabupaten" name="kabupaten" value="{{ old('kabupaten') }}">
                                    @error('kabupaten') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="provinsi" class="form-label fw-semibold">Provinsi</label>
                                    <input type="text" class="form-control @error('provinsi') is-invalid @enderror" id="provinsi" name="provinsi" value="{{ old('provinsi') }}">
                                    @error('provinsi') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 3: Kontak Darurat --}}
                <div class="step-panel d-none" id="step-3">
                    <div class="card border-0 shadow-sm" style="border-radius:16px;">
                        <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
                            <h5 class="fw-bold text-danger mb-0"><i class="bi bi-telephone-plus-fill me-2"></i>Langkah 3: Kontak Darurat / Penanggung Jawab</h5>
                            <p class="text-muted small mt-1 mb-0">Data keluarga atau penanggung jawab yang bisa dihubungi dalam keadaan darurat.</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="alert alert-warning border-0 bg-warning bg-opacity-10 mb-4">
                                <i class="bi bi-info-circle me-2"></i>Data kontak darurat sangat penting jika terjadi kondisi gawat darurat pada pasien.
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="emergency_contact_name" class="form-label fw-semibold">Nama Penanggung Jawab / Kontak Darurat</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-heart text-danger"></i></span>
                                        <input type="text" class="form-control border-start-0 @error('emergency_contact_name') is-invalid @enderror" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" placeholder="Nama lengkap">
                                    </div>
                                    @error('emergency_contact_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="emergency_contact_phone" class="form-label fw-semibold">Nomor HP Kontak Darurat</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-telephone-fill text-danger"></i></span>
                                        <input type="text" class="form-control border-start-0 @error('emergency_contact_phone') is-invalid @enderror" id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}" placeholder="08xxxxxxxxxx">
                                    </div>
                                    @error('emergency_contact_phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="emergency_contact_relation" class="form-label fw-semibold">Hubungan dengan Pasien</label>
                                    <select class="form-select @error('emergency_contact_relation') is-invalid @enderror" id="emergency_contact_relation" name="emergency_contact_relation">
                                        <option value="">-- Pilih Hubungan --</option>
                                        @foreach(['Suami', 'Istri', 'Ayah', 'Ibu', 'Anak', 'Kakak', 'Adik', 'Paman', 'Bibi', 'Kakek', 'Nenek', 'Teman', 'Lainnya'] as $rel)
                                            <option value="{{ $rel }}" {{ old('emergency_contact_relation') == $rel ? 'selected' : '' }}>{{ $rel }}</option>
                                        @endforeach
                                    </select>
                                    @error('emergency_contact_relation') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 4: Data Medis --}}
                <div class="step-panel d-none" id="step-4">
                    <div class="card border-0 shadow-sm" style="border-radius:16px;">
                        <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
                            <h5 class="fw-bold text-info mb-0"><i class="bi bi-file-medical-fill me-2"></i>Langkah 4: Data Medis & Berkas</h5>
                            <p class="text-muted small mt-1 mb-0">Informasi medis awal dan upload dokumen pendukung.</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="allergy_notes" class="form-label fw-semibold"><i class="bi bi-exclamation-triangle text-warning me-1"></i>Riwayat Alergi</label>
                                    <textarea class="form-control @error('allergy_notes') is-invalid @enderror" id="allergy_notes" name="allergy_notes" rows="3" placeholder="Cth: Alergi Amoxicillin, Alergi Seafood, Alergi Debu...&#10;Tulis 'Tidak Ada' jika tidak memiliki alergi.">{{ old('allergy_notes') }}</textarea>
                                    @error('allergy_notes') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="notes" class="form-label fw-semibold"><i class="bi bi-journal-medical text-info me-1"></i>Riwayat Penyakit / Catatan Medis</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Cth: Riwayat Asma, Diabetes, Hipertensi...&#10;Tulis 'Tidak Ada' jika tidak ada riwayat.">{{ old('notes') }}</textarea>
                                    @error('notes') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="photo" class="form-label fw-semibold"><i class="bi bi-camera text-primary me-1"></i>Upload Foto Pasien / Scan KTP</label>
                                    <input class="form-control @error('photo') is-invalid @enderror" type="file" id="photo" name="photo" accept="image/*">
                                    <div class="form-text">Format: JPG, PNG. Maksimal 2MB.</div>
                                    @error('photo') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    <div id="photo-preview" class="mt-2 d-none">
                                        <img id="photo-preview-img" src="" alt="Preview" class="rounded shadow-sm" style="max-height:120px;object-fit:cover;">
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex align-items-center">
                                    <div class="p-3 bg-light rounded-3 w-100">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                            <label class="form-check-label fw-semibold" for="is_active">Pasien Aktif</label>
                                        </div>
                                        <div class="text-muted small mt-1">Centang jika pasien ini masih aktif terdaftar di rumah sakit.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 5: Konfirmasi --}}
                <div class="step-panel d-none" id="step-5">
                    <div class="card border-0 shadow-sm" style="border-radius:16px;">
                        <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
                            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-clipboard-check me-2 text-success"></i>Langkah 5: Konfirmasi & Simpan</h5>
                            <p class="text-muted small mt-1 mb-0">Periksa kembali seluruh data di bawah sebelum disimpan ke sistem.</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                {{-- Ringkasan Identitas --}}
                                <div class="col-md-6">
                                    <div class="p-3 bg-primary bg-opacity-10 rounded-3 h-100">
                                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-person-vcard me-1"></i> Identitas Pasien</h6>
                                        <table class="table table-sm table-borderless small mb-0">
                                            <tr><td class="text-muted" width="40%">Nama</td><td class="fw-medium" id="conf-name">-</td></tr>
                                            <tr><td class="text-muted">NIK</td><td class="fw-medium" id="conf-nik">-</td></tr>
                                            <tr><td class="text-muted">No. BPJS</td><td class="fw-medium text-success" id="conf-bpjs">-</td></tr>
                                            <tr><td class="text-muted">TTL</td><td class="fw-medium" id="conf-ttl">-</td></tr>
                                            <tr><td class="text-muted">Jenis Kelamin</td><td class="fw-medium" id="conf-gender">-</td></tr>
                                            <tr><td class="text-muted">Gol. Darah</td><td class="fw-medium text-danger" id="conf-blood">-</td></tr>
                                            <tr><td class="text-muted">Agama</td><td class="fw-medium" id="conf-religion">-</td></tr>
                                            <tr><td class="text-muted">Status</td><td class="fw-medium" id="conf-marital">-</td></tr>
                                            <tr><td class="text-muted">Pendidikan</td><td class="fw-medium" id="conf-education">-</td></tr>
                                            <tr><td class="text-muted">Pekerjaan</td><td class="fw-medium" id="conf-occupation">-</td></tr>
                                        </table>
                                    </div>
                                </div>
                                {{-- Ringkasan Kontak --}}
                                <div class="col-md-6">
                                    <div class="p-3 bg-success bg-opacity-10 rounded-3 mb-3">
                                        <h6 class="fw-bold text-success mb-3"><i class="bi bi-geo-alt me-1"></i> Kontak & Alamat</h6>
                                        <table class="table table-sm table-borderless small mb-0">
                                            <tr><td class="text-muted" width="40%">Telepon</td><td class="fw-medium" id="conf-phone">-</td></tr>
                                            <tr><td class="text-muted">Email</td><td class="fw-medium" id="conf-email">-</td></tr>
                                            <tr><td class="text-muted">Alamat</td><td class="fw-medium" id="conf-address">-</td></tr>
                                            <tr><td class="text-muted">Kel/Kec</td><td class="fw-medium" id="conf-keldesa">-</td></tr>
                                            <tr><td class="text-muted">Kab/Prov</td><td class="fw-medium" id="conf-kabprov">-</td></tr>
                                        </table>
                                    </div>
                                    <div class="p-3 bg-danger bg-opacity-10 rounded-3">
                                        <h6 class="fw-bold text-danger mb-3"><i class="bi bi-telephone-plus me-1"></i> Kontak Darurat</h6>
                                        <table class="table table-sm table-borderless small mb-0">
                                            <tr><td class="text-muted" width="40%">Nama</td><td class="fw-medium" id="conf-ec-name">-</td></tr>
                                            <tr><td class="text-muted">Telepon</td><td class="fw-medium" id="conf-ec-phone">-</td></tr>
                                            <tr><td class="text-muted">Hubungan</td><td class="fw-medium" id="conf-ec-rel">-</td></tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info border-0 bg-info bg-opacity-10 mt-4 mb-0">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-info-circle-fill fs-4 text-info me-3"></i>
                                    <div>
                                        <strong>Pastikan seluruh data sudah benar.</strong><br>
                                        <span class="small">Setelah disimpan, data masih bisa diedit melalui menu Data Pasien. Klik tombol <strong>"Simpan Data Pasien"</strong> untuk menyelesaikan pendaftaran.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Navigation Buttons --}}
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-light border px-4 rounded-pill d-none" id="btn-prev">
                        <i class="bi bi-arrow-left me-2"></i>Sebelumnya
                    </button>
                    <div class="ms-auto d-flex gap-2">
                        <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary px-4 rounded-pill">Batal</a>
                        <button type="button" class="btn btn-primary px-5 rounded-pill" id="btn-next">
                            Selanjutnya<i class="bi bi-arrow-right ms-2"></i>
                        </button>
                        <button type="submit" class="btn btn-success px-5 rounded-pill d-none" id="btn-submit">
                            <i class="bi bi-check-circle me-2"></i>Simpan Data Pasien
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 5;
    const panels = document.querySelectorAll('.step-panel');
    const stepItems = document.querySelectorAll('.step-item');
    const btnPrev = document.getElementById('btn-prev');
    const btnNext = document.getElementById('btn-next');
    const btnSubmit = document.getElementById('btn-submit');
    const lineProgress = document.getElementById('stepLineProgress');

    function showStep(step) {
        panels.forEach(p => p.classList.add('d-none'));
        document.getElementById('step-' + step).classList.remove('d-none');

        // Update step circles
        stepItems.forEach((item, idx) => {
            const circle = item.querySelector('.step-circle');
            const label = item.querySelector('.step-label');
            const n = idx + 1;
            if (n < step) {
                circle.style.border = '3px solid #198754';
                circle.style.background = '#198754';
                circle.style.color = 'white';
                circle.innerHTML = '<i class="bi bi-check-lg"></i>';
                label.className = 'step-label small fw-bold text-success';
            } else if (n === step) {
                circle.style.border = '3px solid #0d6efd';
                circle.style.background = '#0d6efd';
                circle.style.color = 'white';
                circle.textContent = n;
                label.className = 'step-label small fw-bold text-primary';
            } else {
                circle.style.border = '3px solid #e9ecef';
                circle.style.background = 'white';
                circle.style.color = '#adb5bd';
                circle.textContent = n;
                label.className = 'step-label small fw-bold text-muted';
            }
        });

        // Progress line
        lineProgress.style.width = ((step - 1) / (totalSteps - 1) * 100) + '%';

        // Button visibility
        btnPrev.classList.toggle('d-none', step === 1);
        btnNext.classList.toggle('d-none', step === totalSteps);
        btnSubmit.classList.toggle('d-none', step !== totalSteps);

        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });

        // Populate confirmation on step 5
        if (step === 5) populateConfirmation();
    }

    function validateStep(step) {
        const panel = document.getElementById('step-' + step);
        const requiredFields = panel.querySelectorAll('[required]');
        let valid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                valid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!valid) {
            const firstInvalid = panel.querySelector('.is-invalid');
            if (firstInvalid) firstInvalid.focus();
        }

        return valid;
    }

    btnNext.addEventListener('click', function() {
        if (validateStep(currentStep)) {
            currentStep++;
            showStep(currentStep);
        }
    });

    btnPrev.addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    // Allow clicking on completed step circles
    stepItems.forEach((item, idx) => {
        item.style.cursor = 'pointer';
        item.addEventListener('click', function() {
            const targetStep = idx + 1;
            if (targetStep < currentStep) {
                currentStep = targetStep;
                showStep(currentStep);
            }
        });
    });

    // Auto-calculate age from birth_date
    const birthDateInput = document.getElementById('birth_date');
    const ageDisplay = document.getElementById('age-display');
    birthDateInput.addEventListener('change', function() {
        if (this.value) {
            const today = new Date();
            const birth = new Date(this.value);
            let age = today.getFullYear() - birth.getFullYear();
            const m = today.getMonth() - birth.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
            ageDisplay.innerHTML = '<i class="bi bi-info-circle me-1"></i>Usia: <strong>' + age + ' tahun</strong>';
        }
    });
    // Trigger on load if value exists
    if (birthDateInput.value) birthDateInput.dispatchEvent(new Event('change'));

    // Photo preview
    const photoInput = document.getElementById('photo');
    const photoPreview = document.getElementById('photo-preview');
    const photoPreviewImg = document.getElementById('photo-preview-img');
    photoInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreviewImg.src = e.target.result;
                photoPreview.classList.remove('d-none');
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Populate confirmation step
    function populateConfirmation() {
        const val = id => {
            const el = document.getElementById(id);
            if (!el) return '-';
            if (el.tagName === 'SELECT') return el.options[el.selectedIndex]?.text || '-';
            return el.value || '-';
        };

        document.getElementById('conf-name').textContent = val('name');
        document.getElementById('conf-nik').textContent = val('nik');
        document.getElementById('conf-bpjs').textContent = val('bpjs_number') || 'Tidak ada';
        document.getElementById('conf-ttl').textContent = (val('birth_place') !== '-' ? val('birth_place') + ', ' : '') + val('birth_date');
        document.getElementById('conf-gender').textContent = val('gender');
        document.getElementById('conf-blood').textContent = val('blood_type');
        document.getElementById('conf-religion').textContent = val('religion');
        document.getElementById('conf-marital').textContent = val('marital_status');
        document.getElementById('conf-education').textContent = val('education');
        document.getElementById('conf-occupation').textContent = val('occupation');

        document.getElementById('conf-phone').textContent = val('phone');
        document.getElementById('conf-email').textContent = val('email') || '-';
        document.getElementById('conf-address').textContent = val('address');

        const kel = val('kelurahan');
        const kec = val('kecamatan');
        document.getElementById('conf-keldesa').textContent = (kel !== '-' ? kel : '') + (kec !== '-' ? ' / ' + kec : '');

        const kab = val('kabupaten');
        const prov = val('provinsi');
        document.getElementById('conf-kabprov').textContent = (kab !== '-' ? kab : '') + (prov !== '-' ? ', ' + prov : '');

        document.getElementById('conf-ec-name').textContent = val('emergency_contact_name');
        document.getElementById('conf-ec-phone').textContent = val('emergency_contact_phone');
        document.getElementById('conf-ec-rel').textContent = val('emergency_contact_relation');
    }

    showStep(1);
});
</script>
@endpush