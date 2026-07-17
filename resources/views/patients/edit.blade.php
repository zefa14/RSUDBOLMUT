@extends('layouts.app')

@section('title', 'Edit Data Pasien')
@section('page-title', 'Edit Pasien')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil-square text-primary me-2"></i>Form Edit Data Pasien</h5>
                    <p class="text-muted small mt-1">Perbarui informasi pasien No. RM: <span class="badge bg-primary">{{ $patient->patient_code }}</span></p>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('patients.update', $patient) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            <!-- Section 1: Identitas Utama -->
                            <div class="col-12">
                                <h6 class="fw-bold text-primary mb-3 border-bottom border-primary border-opacity-25 pb-2">
                                    <i class="bi bi-person-vcard me-2"></i>Identitas Utama
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label fw-semibold">Nama Lengkap Pasien <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $patient->name) }}" required>
                                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="nik" class="form-label fw-semibold">Nomor NIK (KTP) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $patient->nik) }}" required>
                                        @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="bpjs_number" class="form-label fw-semibold">Nomor BPJS <span class="text-muted fw-normal">(Opsional)</span></label>
                                        <input type="text" class="form-control @error('bpjs_number') is-invalid @enderror" id="bpjs_number" name="bpjs_number" value="{{ old('bpjs_number', $patient->bpjs_number) }}">
                                        @error('bpjs_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="birth_place" class="form-label fw-semibold">Tempat Lahir</label>
                                        <input type="text" class="form-control @error('birth_place') is-invalid @enderror" id="birth_place" name="birth_place" value="{{ old('birth_place', $patient->birth_place) }}">
                                        @error('birth_place') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="birth_date" class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date', $patient->birth_date ? $patient->birth_date->format('Y-m-d') : '') }}" required>
                                        @error('birth_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="gender" class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="L" {{ old('gender', $patient->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('gender', $patient->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="blood_type" class="form-label fw-semibold">Golongan Darah</label>
                                        <select class="form-select @error('blood_type') is-invalid @enderror" id="blood_type" name="blood_type">
                                            <option value="">-- Pilih --</option>
                                            @foreach(['A', 'B', 'AB', 'O', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bt)
                                                <option value="{{ $bt }}" {{ old('blood_type', $patient->blood_type) == $bt ? 'selected' : '' }}>{{ $bt }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="religion" class="form-label fw-semibold">Agama</label>
                                        <select class="form-select @error('religion') is-invalid @enderror" id="religion" name="religion">
                                            <option value="">-- Pilih --</option>
                                            @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'] as $rel)
                                                <option value="{{ $rel }}" {{ old('religion', $patient->religion) == $rel ? 'selected' : '' }}>{{ $rel }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="marital_status" class="form-label fw-semibold">Status Pernikahan</label>
                                        <select class="form-select @error('marital_status') is-invalid @enderror" id="marital_status" name="marital_status">
                                            <option value="">-- Pilih --</option>
                                            @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                                                <option value="{{ $status }}" {{ old('marital_status', $patient->marital_status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="education" class="form-label fw-semibold">Pendidikan</label>
                                        <select class="form-select @error('education') is-invalid @enderror" id="education" name="education">
                                            <option value="">-- Pilih --</option>
                                            @foreach(['Tidak Sekolah', 'SD', 'SMP', 'SMA/SMK', 'D3', 'S1', 'S2', 'S3'] as $edu)
                                                <option value="{{ $edu }}" {{ old('education', $patient->education) == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="occupation" class="form-label fw-semibold">Pekerjaan</label>
                                        <input type="text" class="form-control @error('occupation') is-invalid @enderror" id="occupation" name="occupation" value="{{ old('occupation', $patient->occupation) }}" placeholder="Cth: Wiraswasta, PNS">
                                        @error('occupation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2: Informasi Kontak & Alamat -->
                            <div class="col-12 mt-5">
                                <h6 class="fw-bold text-success mb-3 border-bottom border-success border-opacity-25 pb-2">
                                    <i class="bi bi-geo-alt-fill me-2"></i>Informasi Kontak & Alamat Detail
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="phone" class="form-label fw-semibold">Nomor Telepon/HP <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $patient->phone) }}" required>
                                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="email" class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $patient->email) }}">
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="rt_rw" class="form-label fw-semibold">RT/RW</label>
                                        <input type="text" class="form-control @error('rt_rw') is-invalid @enderror" id="rt_rw" name="rt_rw" value="{{ old('rt_rw', $patient->rt_rw) }}" placeholder="Cth: 001/002">
                                        @error('rt_rw') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="provinsi" class="form-label fw-semibold">Provinsi</label>
                                        <input type="text" class="form-control @error('provinsi') is-invalid @enderror" id="provinsi" name="provinsi" value="{{ old('provinsi', $patient->provinsi) }}">
                                        @error('provinsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="kabupaten" class="form-label fw-semibold">Kabupaten/Kota</label>
                                        <input type="text" class="form-control @error('kabupaten') is-invalid @enderror" id="kabupaten" name="kabupaten" value="{{ old('kabupaten', $patient->kabupaten) }}">
                                        @error('kabupaten') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="kecamatan" class="form-label fw-semibold">Kecamatan</label>
                                        <input type="text" class="form-control @error('kecamatan') is-invalid @enderror" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $patient->kecamatan) }}">
                                        @error('kecamatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="kelurahan" class="form-label fw-semibold">Kelurahan/Desa</label>
                                        <input type="text" class="form-control @error('kelurahan') is-invalid @enderror" id="kelurahan" name="kelurahan" value="{{ old('kelurahan', $patient->kelurahan) }}">
                                        @error('kelurahan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-9">
                                        <label for="address" class="form-label fw-semibold">Alamat Jalan / Lengkap <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2" required>{{ old('address', $patient->address) }}</textarea>
                                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                </div>
                            </div>

                            <!-- Section 3: Kontak Darurat -->
                            <div class="col-12 mt-5">
                                <h6 class="fw-bold text-danger mb-3 border-bottom border-danger border-opacity-25 pb-2">
                                    <i class="bi bi-telephone-plus-fill me-2"></i>Kontak Darurat / Penanggung Jawab
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="emergency_contact_name" class="form-label fw-semibold">Nama Kontak Darurat</label>
                                        <input type="text" class="form-control @error('emergency_contact_name') is-invalid @enderror" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}">
                                        @error('emergency_contact_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="emergency_contact_phone" class="form-label fw-semibold">No. HP Kontak Darurat</label>
                                        <input type="text" class="form-control @error('emergency_contact_phone') is-invalid @enderror" id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}">
                                        @error('emergency_contact_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="emergency_contact_relation" class="form-label fw-semibold">Hubungan dengan Pasien</label>
                                        <input type="text" class="form-control @error('emergency_contact_relation') is-invalid @enderror" id="emergency_contact_relation" name="emergency_contact_relation" value="{{ old('emergency_contact_relation', $patient->emergency_contact_relation) }}" placeholder="Cth: Suami, Anak, Orang Tua">
                                        @error('emergency_contact_relation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Section 4: Data Medis & File -->
                            <div class="col-12 mt-5">
                                <h6 class="fw-bold text-info mb-3 border-bottom border-info border-opacity-25 pb-2">
                                    <i class="bi bi-file-medical-fill me-2"></i>Data Medis & Berkas
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="allergy_notes" class="form-label fw-semibold">Catatan Alergi</label>
                                        <textarea class="form-control @error('allergy_notes') is-invalid @enderror" id="allergy_notes" name="allergy_notes" rows="2" placeholder="Cth: Alergi Amoxicillin, Alergi Makanan Laut...">{{ old('allergy_notes', $patient->allergy_notes) }}</textarea>
                                        @error('allergy_notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="notes" class="form-label fw-semibold">Catatan Umum / Riwayat Penyakit</label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="2" placeholder="Cth: Memiliki riwayat Asma">{{ old('notes', $patient->notes) }}</textarea>
                                        @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="photo" class="form-label fw-semibold">Ubah Foto Pasien / Scan KTP (Opsional)</label>
                                        <input class="form-control @error('photo') is-invalid @enderror" type="file" id="photo" name="photo" accept="image/*">
                                        <div class="form-text">Biarkan kosong jika tidak ingin mengubah foto. Maksimal 2MB.</div>
                                        @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6 d-flex align-items-center">
                                        <div class="form-check form-switch mt-4">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $patient->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="is_active">Status Pasien Aktif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-5 pt-4 border-top">
                            <a href="{{ route('patients.index') }}" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-5"><i class="bi bi-save me-2"></i>Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection