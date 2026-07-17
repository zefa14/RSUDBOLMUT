<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Online Pasien - RSUD Bolmong Utara</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --rsud-primary: #0f766e;
            --rsud-primary-dark: #0d5c56;
            --rsud-primary-light: #14b8a6;
            --rsud-accent: #f59e0b;
            --rsud-bg: #f0fdf9;
            --rsud-card: #ffffff;
            --rsud-border: #d1d5db;
            --rsud-text: #1f2937;
            --rsud-text-muted: #6b7280;
            --rsud-danger: #ef4444;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Roboto', sans-serif;
            background: var(--rsud-bg);
            min-height: 100vh;
            color: var(--rsud-text);
        }
        
        /* ─── Navbar ──────────────────────────────────── */
        .navbar-custom {
            background: linear-gradient(135deg, var(--rsud-primary) 0%, var(--rsud-primary-dark) 100%);
            padding: 14px 0;
            box-shadow: 0 4px 20px rgba(15, 118, 110, 0.3);
        }
        .navbar-custom .navbar-brand {
            color: white !important;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .navbar-custom .brand-subtitle {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.75);
            font-weight: 400;
        }
        .navbar-custom .btn-back {
            background: rgba(255,255,255,0.15);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
            font-weight: 600;
            border-radius: 8px;
            padding: 8px 16px;
            transition: all 0.3s;
        }
        .navbar-custom .btn-back:hover {
            background: rgba(255,255,255,0.25);
            color: white;
        }

        /* ─── Progress Steps ──────────────────────────── */
        .progress-steps {
            display: flex;
            justify-content: center;
            gap: 0;
            margin: 30px auto 10px;
            max-width: 700px;
        }
        .step-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: white;
            border: 2px solid var(--rsud-border);
            color: var(--rsud-text-muted);
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s;
            position: relative;
        }
        .step-item:first-child { border-radius: 10px 0 0 10px; }
        .step-item:last-child { border-radius: 0 10px 10px 0; }
        .step-item.active {
            background: var(--rsud-primary);
            border-color: var(--rsud-primary);
            color: white;
        }
        .step-item.completed {
            background: #d1fae5;
            border-color: #6ee7b7;
            color: var(--rsud-primary-dark);
        }
        .step-number {
            width: 26px; height: 26px;
            border-radius: 50%;
            background: var(--rsud-border);
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; font-weight: 700;
        }
        .step-item.active .step-number { background: white; color: var(--rsud-primary); }
        .step-item.completed .step-number { background: var(--rsud-primary); color: white; }

        /* ─── Card ─────────────────────────────────────── */
        .register-card {
            background: var(--rsud-card);
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.06);
            overflow: hidden;
            margin-top: 20px;
            margin-bottom: 40px;
            border: 1px solid #e5e7eb;
        }
        .register-header {
            background: linear-gradient(135deg, var(--rsud-primary) 0%, var(--rsud-primary-dark) 100%);
            color: white;
            padding: 28px 35px;
            display: flex;
            align-items: center;
            gap: 18px;
        }
        .register-header .icon-circle {
            width: 56px; height: 56px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .register-body { padding: 35px 40px; }

        /* ─── Section Headers ──────────────────────────── */
        .section-title {
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--rsud-primary-dark);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #d1fae5;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title i {
            font-size: 1.2rem;
            color: var(--rsud-primary);
        }
        .section-title .badge-section {
            background: var(--rsud-primary);
            color: white;
            font-size: 0.7rem;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        /* ─── Form Controls ───────────────────────────── */
        .form-label {
            font-weight: 600;
            color: #374151;
            font-size: 0.88rem;
            margin-bottom: 5px;
        }
        .form-label .required {
            color: var(--rsud-danger);
            margin-left: 2px;
        }
        .form-control, .form-select {
            padding: 11px 15px;
            border-radius: 10px;
            border: 1.5px solid #d1d5db;
            background-color: #fafbfc;
            font-size: 0.92rem;
            transition: all 0.25s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--rsud-primary-light);
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.15);
            background-color: white;
        }
        .form-control::placeholder { color: #9ca3af; }
        .form-text { font-size: 0.78rem; color: var(--rsud-text-muted); }

        textarea.form-control { resize: vertical; min-height: 70px; }

        /* ─── File Upload ─────────────────────────────── */
        .file-upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            background: #f8fafc;
            transition: all 0.3s;
            cursor: pointer;
        }
        .file-upload-area:hover {
            border-color: var(--rsud-primary-light);
            background: #f0fdfa;
        }
        .file-upload-area i { font-size: 2rem; color: var(--rsud-primary-light); }

        /* ─── Submit Button ───────────────────────────── */
        .btn-submit {
            background: linear-gradient(135deg, var(--rsud-primary) 0%, var(--rsud-primary-dark) 100%);
            color: white;
            font-weight: 700;
            padding: 15px;
            border-radius: 12px;
            border: none;
            width: 100%;
            font-size: 1.1rem;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(15, 118, 110, 0.3);
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(15, 118, 110, 0.4);
            color: white;
        }
        .btn-submit:active { transform: translateY(0); }

        /* ─── Alerts ──────────────────────────────────── */
        .alert-info-custom {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 12px;
            padding: 16px 20px;
            color: #0c4a6e;
            font-size: 0.88rem;
        }
        .alert-info-custom i { color: #0ea5e9; }

        /* ─── Responsive ──────────────────────────────── */
        @media (max-width: 768px) {
            .register-body { padding: 20px 18px; }
            .register-header { padding: 20px; }
            .progress-steps { flex-wrap: wrap; gap: 4px; padding: 0 10px; }
            .step-item { font-size: 0.75rem; padding: 8px 12px; }
        }
    </style>
</head>
<body>

    <!-- ─── Navbar ─────────────────────────────────────── -->
    <nav class="navbar-custom">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand d-flex align-items-center text-decoration-none" href="{{ route('home') }}">
                <div style="width: 42px; height: 46px; background: rgba(255,255,255,0.2); border-radius: 8px; margin-right: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-hospital text-white fs-4"></i>
                </div>
                <div>
                    <div style="font-size: 1.15rem; line-height: 1.2;">RSUD BOLMONG UTARA</div>
                    <div class="brand-subtitle">Pendaftaran Online Pasien Mandiri</div>
                </div>
            </a>
            <a href="{{ route('home') }}" class="btn btn-back btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
            </a>
        </div>
    </nav>

    <!-- ─── Progress Steps ─────────────────────────────── -->
    <div class="container">
        <div class="progress-steps">
            <div class="step-item active" id="step-indicator-1">
                <span class="step-number">1</span> Isi Formulir
            </div>
            <div class="step-item" id="step-indicator-2">
                <span class="step-number">2</span> Konfirmasi
            </div>
            <div class="step-item" id="step-indicator-3">
                <span class="step-number">3</span> Tiket Antrian
            </div>
        </div>
    </div>

    <!-- ─── Form Content ───────────────────────────────── -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="register-card">
                    <div class="register-header">
                        <div class="icon-circle">
                            <i class="bi bi-clipboard2-pulse fs-3"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">Formulir Pendaftaran Online</h4>
                            <p class="mb-0 opacity-75 small">Lengkapi semua data dengan benar sesuai KTP/identitas yang berlaku.</p>
                        </div>
                    </div>
                    
                    <div class="register-body">
                        @if($errors->any())
                            <div class="alert alert-danger rounded-3 mb-4">
                                <h6 class="fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill me-1"></i> Formulir belum lengkap:</h6>
                                <ul class="mb-0 small">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('frontend.register.submit') }}" method="POST" enctype="multipart/form-data" id="registrationForm">
                            @csrf

                            <!-- ═══════════ BAGIAN A: IDENTITAS PASIEN ═══════════ -->
                            <div class="section-title">
                                <i class="bi bi-person-vcard-fill"></i>
                                <span>Data Identitas Pasien</span>
                                <span class="badge-section">A</span>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Nomor Induk Kependudukan (NIK) <span class="required">*</span></label>
                                    <input type="text" name="nik" class="form-control" placeholder="Masukkan 16 digit NIK" required maxlength="16" value="{{ old('nik') }}">
                                    <div class="form-text">Wajib 16 digit sesuai KTP</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Nama lengkap sesuai KTP" required value="{{ old('name') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tempat Lahir <span class="required">*</span></label>
                                    <input type="text" name="birth_place" class="form-control" placeholder="Cth: Manado" required value="{{ old('birth_place') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tanggal Lahir <span class="required">*</span></label>
                                    <input type="date" name="birth_date" class="form-control" required value="{{ old('birth_date') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Jenis Kelamin <span class="required">*</span></label>
                                    <select name="gender" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Golongan Darah</label>
                                    <select name="blood_type" class="form-select">
                                        <option value="">-- Tidak Tahu --</option>
                                        <option value="A" {{ old('blood_type') == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ old('blood_type') == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="AB" {{ old('blood_type') == 'AB' ? 'selected' : '' }}>AB</option>
                                        <option value="O" {{ old('blood_type') == 'O' ? 'selected' : '' }}>O</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Agama <span class="required">*</span></label>
                                    <select name="religion" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen Protestan" {{ old('religion') == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                                        <option value="Katolik" {{ old('religion') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ old('religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                        <option value="Konghucu" {{ old('religion') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Status Perkawinan <span class="required">*</span></label>
                                    <select name="marital_status" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Belum Menikah" {{ old('marital_status') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                        <option value="Menikah" {{ old('marital_status') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                        <option value="Cerai Hidup" {{ old('marital_status') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                        <option value="Cerai Mati" {{ old('marital_status') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pendidikan Terakhir</label>
                                    <select name="education" class="form-select">
                                        <option value="">-- Pilih --</option>
                                        <option value="Tidak Sekolah" {{ old('education') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                        <option value="SD/Sederajat" {{ old('education') == 'SD/Sederajat' ? 'selected' : '' }}>SD / Sederajat</option>
                                        <option value="SMP/Sederajat" {{ old('education') == 'SMP/Sederajat' ? 'selected' : '' }}>SMP / Sederajat</option>
                                        <option value="SMA/Sederajat" {{ old('education') == 'SMA/Sederajat' ? 'selected' : '' }}>SMA / Sederajat</option>
                                        <option value="D1-D3" {{ old('education') == 'D1-D3' ? 'selected' : '' }}>Diploma (D1-D3)</option>
                                        <option value="D4/S1" {{ old('education') == 'D4/S1' ? 'selected' : '' }}>Sarjana (D4/S1)</option>
                                        <option value="S2" {{ old('education') == 'S2' ? 'selected' : '' }}>Magister (S2)</option>
                                        <option value="S3" {{ old('education') == 'S3' ? 'selected' : '' }}>Doktor (S3)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan</label>
                                    <input type="text" name="occupation" class="form-control" placeholder="Cth: PNS, Wiraswasta, Petani, Ibu Rumah Tangga" value="{{ old('occupation') }}">
                                </div>
                            </div>

                            <!-- ═══════════ BAGIAN B: ALAMAT LENGKAP ═══════════ -->
                            <div class="section-title">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>Alamat Lengkap Sesuai KTP</span>
                                <span class="badge-section">B</span>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-12">
                                    <label class="form-label">Alamat (Jalan/Dusun/Kampung) <span class="required">*</span></label>
                                    <textarea name="address" class="form-control" rows="2" placeholder="Cth: Jl. Trans Sulawesi No. 12, Dusun Molibagu" required>{{ old('address') }}</textarea>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">RT / RW</label>
                                    <input type="text" name="rt_rw" class="form-control" placeholder="Cth: 001/003" value="{{ old('rt_rw') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Kelurahan / Desa <span class="required">*</span></label>
                                    <input type="text" name="kelurahan" class="form-control" placeholder="Cth: Bintauna" required value="{{ old('kelurahan') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Kecamatan <span class="required">*</span></label>
                                    <input type="text" name="kecamatan" class="form-control" placeholder="Cth: Bintauna" required value="{{ old('kecamatan') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Kode Pos</label>
                                    <input type="text" name="postal_code" class="form-control" placeholder="Cth: 95753" maxlength="5" value="{{ old('postal_code') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kabupaten / Kota <span class="required">*</span></label>
                                    <input type="text" name="kabupaten" class="form-control" placeholder="Cth: Bolaang Mongondow Utara" required value="{{ old('kabupaten') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Provinsi <span class="required">*</span></label>
                                    <input type="text" name="provinsi" class="form-control" placeholder="Cth: Sulawesi Utara" required value="{{ old('provinsi') }}">
                                </div>
                            </div>

                            <!-- ═══════════ BAGIAN C: KONTAK ═══════════ -->
                            <div class="section-title">
                                <i class="bi bi-telephone-fill"></i>
                                <span>Informasi Kontak</span>
                                <span class="badge-section">C</span>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Nomor HP / WhatsApp Aktif <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text" style="border-radius: 10px 0 0 10px; background: #f3f4f6;">+62</span>
                                        <input type="text" name="phone" class="form-control" placeholder="812xxxxxxxx" required value="{{ old('phone') }}" style="border-radius: 0 10px 10px 0;">
                                    </div>
                                    <div class="form-text">Digunakan untuk pemberitahuan antrian via WhatsApp</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Alamat Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="contoh@email.com" value="{{ old('email') }}">
                                </div>
                            </div>

                            <!-- ═══════════ BAGIAN D: KONTAK DARURAT ═══════════ -->
                            <div class="section-title">
                                <i class="bi bi-person-lines-fill"></i>
                                <span>Penanggung Jawab / Kontak Darurat</span>
                                <span class="badge-section">D</span>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="form-label">Nama Penanggung Jawab <span class="required">*</span></label>
                                    <input type="text" name="emergency_contact_name" class="form-control" placeholder="Nama lengkap keluarga" required value="{{ old('emergency_contact_name') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">No. HP Penanggung Jawab <span class="required">*</span></label>
                                    <input type="text" name="emergency_contact_phone" class="form-control" placeholder="0812xxxxxxxx" required value="{{ old('emergency_contact_phone') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Hubungan dengan Pasien <span class="required">*</span></label>
                                    <select name="emergency_contact_relation" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Suami" {{ old('emergency_contact_relation') == 'Suami' ? 'selected' : '' }}>Suami</option>
                                        <option value="Istri" {{ old('emergency_contact_relation') == 'Istri' ? 'selected' : '' }}>Istri</option>
                                        <option value="Ayah" {{ old('emergency_contact_relation') == 'Ayah' ? 'selected' : '' }}>Ayah</option>
                                        <option value="Ibu" {{ old('emergency_contact_relation') == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                                        <option value="Anak" {{ old('emergency_contact_relation') == 'Anak' ? 'selected' : '' }}>Anak</option>
                                        <option value="Saudara" {{ old('emergency_contact_relation') == 'Saudara' ? 'selected' : '' }}>Saudara Kandung</option>
                                        <option value="Kerabat" {{ old('emergency_contact_relation') == 'Kerabat' ? 'selected' : '' }}>Kerabat Lain</option>
                                        <option value="Teman" {{ old('emergency_contact_relation') == 'Teman' ? 'selected' : '' }}>Teman</option>
                                    </select>
                                </div>
                            </div>

                            <!-- ═══════════ BAGIAN E: RENCANA PEMERIKSAAN ═══════════ -->
                            <div class="section-title">
                                <i class="bi bi-clipboard2-pulse-fill"></i>
                                <span>Rencana Pemeriksaan</span>
                                <span class="badge-section">E</span>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Poliklinik Tujuan <span class="required">*</span></label>
                                    <select name="department_id" id="department" class="form-select" required>
                                        <option value="">-- Pilih Poliklinik --</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pilih Dokter <span class="required">*</span></label>
                                    <select name="doctor_id" id="doctor" class="form-select" required>
                                        <option value="">-- Pilih Poliklinik Terlebih Dahulu --</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Keluhan Utama <span class="required">*</span></label>
                                    <textarea name="complaint" class="form-control" rows="3" placeholder="Jelaskan keluhan utama Anda secara singkat, termasuk sejak kapan keluhan dirasakan.&#10;Contoh: Demam sejak 3 hari yang lalu disertai batuk pilek." required>{{ old('complaint') }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Riwayat Alergi Obat / Makanan</label>
                                    <input type="text" name="allergy_notes" class="form-control" placeholder="Cth: Alergi Amoxicillin, Alergi Seafood. Kosongkan jika tidak ada." value="{{ old('allergy_notes') }}">
                                    <div class="form-text"><i class="bi bi-info-circle"></i> Penting untuk keselamatan pasien. Kosongkan jika tidak ada alergi yang diketahui.</div>
                                </div>
                            </div>

                            <!-- ═══════════ BAGIAN F: METODE PEMBAYARAN ═══════════ -->
                            <div class="section-title">
                                <i class="bi bi-credit-card-2-front-fill"></i>
                                <span>Metode Pembayaran</span>
                                <span class="badge-section">F</span>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-12">
                                    <label class="form-label">Pilih Cara Bayar <span class="required">*</span></label>
                                    <select name="payment_method" id="payment_method" class="form-select" required>
                                        <option value="umum" {{ old('payment_method') == 'umum' ? 'selected' : '' }}>Umum / Pembayaran Mandiri</option>
                                        <option value="bpjs" {{ old('payment_method') == 'bpjs' ? 'selected' : '' }}>BPJS Kesehatan / JKN-KIS</option>
                                        <option value="asuransi" {{ old('payment_method') == 'asuransi' ? 'selected' : '' }}>Asuransi Swasta Lainnya</option>
                                    </select>
                                </div>

                                <!-- BPJS Fields (Hidden by default) -->
                                <div class="col-md-6 referral-fields" style="display: none;">
                                    <label class="form-label">Nomor Kartu BPJS <span class="required">*</span></label>
                                    <input type="text" name="bpjs_number" id="bpjs_number" class="form-control" placeholder="Masukkan 13 digit nomor BPJS" maxlength="13" value="{{ old('bpjs_number') }}">
                                    <div class="form-text">Wajib diisi untuk peserta BPJS</div>
                                </div>
                                <div class="col-md-6 referral-fields" style="display: none;">
                                    <label class="form-label">Nomor Rujukan (Faskes 1 / RS Lain) <span class="required">*</span></label>
                                    <input type="text" name="referral_number" id="referral_number" class="form-control" placeholder="Masukkan 19 digit nomor rujukan" value="{{ old('referral_number') }}">
                                    <div class="form-text">Wajib diisi untuk pasien BPJS</div>
                                </div>
                                <div class="col-md-12 referral-fields" style="display: none;">
                                    <label class="form-label">Upload Surat Rujukan / Surat Kontrol</label>
                                    <div class="file-upload-area" onclick="document.getElementById('referral_file').click()">
                                        <i class="bi bi-cloud-arrow-up"></i>
                                        <p class="mb-1 fw-semibold text-muted small" id="file-label">Klik untuk mengunggah file</p>
                                        <p class="mb-0 text-muted" style="font-size: 0.75rem;">Format: JPG, PNG, PDF — Maks. 2MB</p>
                                        <input type="file" name="referral_file" id="referral_file" class="d-none" accept=".jpg,.jpeg,.png,.pdf">
                                    </div>
                                </div>
                            </div>

                            <!-- ═══════════ PERSETUJUAN ═══════════ -->
                            <div class="alert-info-custom mb-4">
                                <div class="d-flex gap-3 align-items-start">
                                    <i class="bi bi-shield-check fs-4"></i>
                                    <div>
                                        <strong>Informasi Penting</strong>
                                        <ul class="mb-0 mt-1 small" style="padding-left: 18px;">
                                            <li>Hadir paling lambat <strong>30 menit sebelum</strong> jadwal praktik dokter dimulai.</li>
                                            <li>Bawa <strong>KTP asli, Kartu BPJS</strong> (jika menggunakan BPJS), dan <strong>Surat Rujukan asli</strong>.</li>
                                            <li>Pendaftaran yang tidak dikonfirmasi kehadiran akan <strong>hangus otomatis</strong>.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input type="checkbox" class="form-check-input" id="agree" required style="width: 20px; height: 20px; margin-top: 2px;">
                                <label class="form-check-label text-muted small ms-2" for="agree" style="line-height: 1.5;">
                                    Saya menyatakan bahwa <strong>seluruh data</strong> yang diisikan di atas adalah <strong>benar dan sesuai identitas resmi</strong>. 
                                    Saya bersedia hadir minimal 30 menit sebelum jadwal praktik dimulai dan menerima konsekuensi jika data yang diberikan tidak valid.
                                </label>
                            </div>

                            <button type="submit" class="btn btn-submit shadow" id="submitBtn">
                                <i class="bi bi-send-fill me-2"></i> Kirim Pendaftaran & Ambil Nomor Antrian
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="text-center text-muted small pb-4">
                    &copy; {{ date('Y') }} RSUD Bolaang Mongondow Utara &mdash; Sistem Informasi Rumah Sakit Terpadu.
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ─── AJAX: Load Dokter berdasarkan Poliklinik ────────────
        document.getElementById('department').addEventListener('change', function() {
            let deptId = this.value;
            let doctorSelect = document.getElementById('doctor');
            doctorSelect.innerHTML = '<option value="">Sedang memuat dokter...</option>';
            
            if(deptId) {
                fetch('/get-doctors/' + deptId)
                    .then(response => response.json())
                    .then(data => {
                        doctorSelect.innerHTML = '<option value="">-- Pilih Dokter Spesialis --</option>';
                        data.forEach(doctor => {
                            let option = document.createElement('option');
                            option.value = doctor.id;
                            let spec = doctor.specialization ? ` (${doctor.specialization})` : '';
                            option.text = doctor.name + spec;
                            doctorSelect.appendChild(option);
                        });
                    });
            } else {
                doctorSelect.innerHTML = '<option value="">-- Pilih Poliklinik Terlebih Dahulu --</option>';
            }
        });

        // ─── Toggle BPJS Fields ──────────────────────────────────
        document.getElementById('payment_method').addEventListener('change', function() {
            let method = this.value;
            let referralFields = document.querySelectorAll('.referral-fields');
            let refNumber = document.getElementById('referral_number');
            let bpjsNumber = document.getElementById('bpjs_number');

            if (method === 'bpjs') {
                referralFields.forEach(el => el.style.display = 'block');
                refNumber.setAttribute('required', 'required');
                bpjsNumber.setAttribute('required', 'required');
            } else {
                referralFields.forEach(el => el.style.display = 'none');
                refNumber.removeAttribute('required');
                bpjsNumber.removeAttribute('required');
            }
        });

        // ─── File Upload Label ───────────────────────────────────
        document.getElementById('referral_file').addEventListener('change', function() {
            let label = document.getElementById('file-label');
            if (this.files.length > 0) {
                label.innerHTML = '<i class="bi bi-check-circle-fill text-success me-1"></i> ' + this.files[0].name;
                label.classList.add('text-success');
            } else {
                label.textContent = 'Klik untuk mengunggah file';
                label.classList.remove('text-success');
            }
        });

        // ─── Trigger BPJS on load (for old() repopulation) ──────
        window.addEventListener('DOMContentLoaded', function() {
            let pm = document.getElementById('payment_method');
            if (pm.value === 'bpjs') {
                pm.dispatchEvent(new Event('change'));
            }
        });
    </script>
</body>
</html>
