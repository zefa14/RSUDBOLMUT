@extends('layouts.app')

@section('title', 'Pengaturan Web')
@section('page-title', 'Pengaturan Web')
@section('page-subtitle', 'Kelola seluruh konten website publik RSUD')

@section('content')
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Tab Navigation --}}
        <ul class="nav nav-pills mb-4 gap-2 flex-wrap" id="settingsTabs" role="tablist">
            <li class="nav-item"><a class="nav-link active rounded-pill px-4 fw-semibold" data-bs-toggle="pill" href="#tab-hero"><i class="bi bi-image me-1"></i> Hero & Banner</a></li>
            <li class="nav-item"><a class="nav-link rounded-pill px-4 fw-semibold" data-bs-toggle="pill" href="#tab-profil"><i class="bi bi-building me-1"></i> Profil</a></li>
            <li class="nav-item"><a class="nav-link rounded-pill px-4 fw-semibold" data-bs-toggle="pill" href="#tab-visi"><i class="bi bi-bullseye me-1"></i> Visi Misi</a></li>
            <li class="nav-item"><a class="nav-link rounded-pill px-4 fw-semibold" data-bs-toggle="pill" href="#tab-layanan"><i class="bi bi-heart-pulse me-1"></i> Layanan</a></li>
            <li class="nav-item"><a class="nav-link rounded-pill px-4 fw-semibold" data-bs-toggle="pill" href="#tab-berita"><i class="bi bi-newspaper me-1"></i> Berita</a></li>
            <li class="nav-item"><a class="nav-link rounded-pill px-4 fw-semibold" data-bs-toggle="pill" href="#tab-galeri"><i class="bi bi-images me-1"></i> Galeri</a></li>
            <li class="nav-item"><a class="nav-link rounded-pill px-4 fw-semibold" data-bs-toggle="pill" href="#tab-tarif"><i class="bi bi-cash-coin me-1"></i> Tarif & Biaya</a></li>
            <li class="nav-item"><a class="nav-link rounded-pill px-4 fw-semibold" data-bs-toggle="pill" href="#tab-kontak"><i class="bi bi-telephone me-1"></i> Kontak</a></li>
        </ul>

        <div class="tab-content" id="settingsTabContent">

            {{-- ═══ TAB 1: HERO & BANNER ═══ --}}
            <div class="tab-pane fade show active" id="tab-hero">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-1"><i class="bi bi-image text-primary me-2"></i>Hero Section & Banner</h5>
                        <p class="text-muted small mb-0">Atur tampilan utama halaman depan website</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Foto Banner</label>
                                @if(isset($settings['banner_image']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($settings['banner_image']))
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $settings['banner_image']) }}" alt="Banner" class="img-fluid rounded-3 shadow-sm" style="max-height: 200px; object-fit: cover; width: 100%;">
                                    </div>
                                @endif
                                <input class="form-control" type="file" name="banner_image" accept="image/*">
                                <div class="form-text">Format: JPG, PNG, WEBP. Maks: 5MB.</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Badge Teks</label>
                                <input type="text" name="hero_badge" class="form-control" value="{{ $settings['hero_badge'] ?? 'Rumah Sakit Terakreditasi Paripurna' }}" placeholder="Contoh: Rumah Sakit Terakreditasi Paripurna">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Judul Hero</label>
                                <input type="text" name="hero_title" class="form-control" value="{{ $settings['hero_title'] ?? 'Kesehatan Anda, Prioritas Utama Kami' }}" placeholder="Contoh: Kesehatan Anda, Prioritas Utama Kami">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Sub-Judul Hero</label>
                                <textarea name="hero_subtitle" class="form-control" rows="3">{{ $settings['hero_subtitle'] ?? 'RSUD menghadirkan pelayanan medis terbaik dengan teknologi terkini, tim ahli berpengalaman, dan sentuhan kemanusiaan yang hangat.' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ TAB 2: PROFIL ═══ --}}
            <div class="tab-pane fade" id="tab-profil">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-1"><i class="bi bi-building text-primary me-2"></i>Profil Instansi</h5>
                        <p class="text-muted small mb-0">Atur informasi profil rumah sakit</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Foto Profil / Gedung</label>
                                @if(isset($settings['profile_image']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($settings['profile_image']))
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $settings['profile_image']) }}" alt="Profil" class="img-fluid rounded-3 shadow-sm" style="max-height: 200px;">
                                    </div>
                                @endif
                                <input class="form-control" type="file" name="profile_image" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Sub-Judul</label>
                                <input type="text" name="profile_subtitle" class="form-control" value="{{ $settings['profile_subtitle'] ?? 'Profil Instansi' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Judul</label>
                                <input type="text" name="profile_title" class="form-control" value="{{ $settings['profile_title'] ?? 'Mengabdi Sepenuh Hati Untuk Negeri' }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Deskripsi Profil</label>
                                <textarea name="profile_description" class="form-control" rows="4">{{ $settings['profile_description'] ?? 'Rumah Sakit Umum Daerah Bolaang Mongondow Utara (RSUD Bolmut) merupakan fasilitas pelayanan kesehatan tipe Kelas D milik Pemerintah Kabupaten Bolaang Mongondow Utara.' }}</textarea>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Statistik 1 — Angka</label>
                                <input type="text" name="stat_1_value" class="form-control" value="{{ $settings['stat_1_value'] ?? '12.062' }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Statistik 1 — Label</label>
                                <input type="text" name="stat_1_label" class="form-control" value="{{ $settings['stat_1_label'] ?? 'Pasien Dilayani (2025)' }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Statistik 2 — Angka</label>
                                <input type="text" name="stat_2_value" class="form-control" value="{{ $settings['stat_2_value'] ?? 'Lulus Perdana' }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Statistik 2 — Label</label>
                                <input type="text" name="stat_2_label" class="form-control" value="{{ $settings['stat_2_label'] ?? 'Status Akreditasi KARS' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ TAB 3: VISI MISI ═══ --}}
            <div class="tab-pane fade" id="tab-visi">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-1"><i class="bi bi-bullseye text-primary me-2"></i>Visi, Misi & Motto</h5>
                        <p class="text-muted small mb-0">Atur visi, misi, dan motto rumah sakit</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Visi</label>
                                <textarea name="visi" class="form-control" rows="3">{{ $settings['visi'] ?? 'Menjadi Rumah Sakit Rujukan Utama yang Memberikan Pelayanan Kesehatan Paripurna, Profesional, Inovatif, dan Berpusat pada Keselamatan Pasien di Tahun 2030.' }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Motto Pelayanan</label>
                                <input type="text" name="motto" class="form-control" value="{{ $settings['motto'] ?? 'Kesembuhan Anda Adalah Kebahagiaan Kami' }}">
                            </div>
                            <hr>
                            <h6 class="fw-bold text-muted">Misi (3 Poin)</h6>
                            @for($i = 1; $i <= 3; $i++)
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Misi {{ $i }} — Judul</label>
                                <input type="text" name="misi_{{ $i }}_title" class="form-control" value="{{ $settings['misi_'.$i.'_title'] ?? '' }}">
                                <label class="form-label fw-semibold mt-2">Misi {{ $i }} — Deskripsi</label>
                                <textarea name="misi_{{ $i }}_desc" class="form-control" rows="3">{{ $settings['misi_'.$i.'_desc'] ?? '' }}</textarea>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ TAB 4: LAYANAN UNGGULAN ═══ --}}
            <div class="tab-pane fade" id="tab-layanan">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-1"><i class="bi bi-heart-pulse text-primary me-2"></i>Layanan Unggulan</h5>
                        <p class="text-muted small mb-0">Atur 3 layanan unggulan rumah sakit</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            @for($i = 1; $i <= 3; $i++)
                            <div class="col-md-4">
                                <div class="border rounded-3 p-3">
                                    <h6 class="fw-bold mb-3">Layanan {{ $i }}</h6>
                                    <label class="form-label fw-semibold">Icon Bootstrap</label>
                                    <input type="text" name="layanan_{{ $i }}_icon" class="form-control mb-2" value="{{ $settings['layanan_'.$i.'_icon'] ?? '' }}" placeholder="bi-heart-pulse">
                                    <div class="form-text mb-2">Contoh: bi-heart-pulse, bi-bandaid, bi-person-hearts</div>
                                    <label class="form-label fw-semibold">Judul</label>
                                    <input type="text" name="layanan_{{ $i }}_title" class="form-control mb-2" value="{{ $settings['layanan_'.$i.'_title'] ?? '' }}">
                                    <label class="form-label fw-semibold">Deskripsi</label>
                                    <textarea name="layanan_{{ $i }}_desc" class="form-control" rows="3">{{ $settings['layanan_'.$i.'_desc'] ?? '' }}</textarea>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ TAB 5: BERITA ═══ --}}
            <div class="tab-pane fade" id="tab-berita">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-1"><i class="bi bi-newspaper text-primary me-2"></i>Berita & Edukasi Kesehatan</h5>
                        <p class="text-muted small mb-0">Atur 3 artikel yang tampil di halaman utama</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            @for($i = 1; $i <= 3; $i++)
                            <div class="col-md-4">
                                <div class="border rounded-3 p-3">
                                    <h6 class="fw-bold mb-3">Berita {{ $i }}</h6>
                                    <label class="form-label fw-semibold">Judul</label>
                                    <input type="text" name="berita_{{ $i }}_title" class="form-control mb-2" value="{{ $settings['berita_'.$i.'_title'] ?? '' }}">
                                    <label class="form-label fw-semibold">Tanggal</label>
                                    <input type="text" name="berita_{{ $i }}_date" class="form-control mb-2" value="{{ $settings['berita_'.$i.'_date'] ?? '' }}" placeholder="14 Mei 2026">
                                    <label class="form-label fw-semibold">Deskripsi Singkat</label>
                                    <textarea name="berita_{{ $i }}_desc" class="form-control mb-2" rows="2">{{ $settings['berita_'.$i.'_desc'] ?? '' }}</textarea>
                                    <label class="form-label fw-semibold">URL Gambar</label>
                                    <input type="text" name="berita_{{ $i }}_img" class="form-control" value="{{ $settings['berita_'.$i.'_img'] ?? '' }}" placeholder="https://...">
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ TAB GALERI ═══ --}}
            <div class="tab-pane fade" id="tab-galeri">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-1"><i class="bi bi-images text-primary me-2"></i>Galeri Foto RSUD</h5>
                        <p class="text-muted small mb-0">Atur 6 foto kegiatan yang tampil di halaman utama</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            @for($i = 1; $i <= 6; $i++)
                            <div class="col-md-4">
                                <div class="border rounded-3 p-3">
                                    <h6 class="fw-bold mb-3">Foto {{ $i }}</h6>
                                    @if(isset($settings['galeri_'.$i.'_img']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($settings['galeri_'.$i.'_img']))
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $settings['galeri_'.$i.'_img']) }}" alt="Galeri {{ $i }}" class="img-fluid rounded-3 shadow-sm" style="height: 150px; width: 100%; object-fit: cover;">
                                        </div>
                                    @endif
                                    <label class="form-label fw-semibold">Upload Foto</label>
                                    <input type="file" name="galeri_{{ $i }}_img" class="form-control mb-2" accept="image/*">
                                    <label class="form-label fw-semibold mt-2">Caption Singkat</label>
                                    <input type="text" name="galeri_{{ $i }}_caption" class="form-control" value="{{ $settings['galeri_'.$i.'_caption'] ?? '' }}" placeholder="Contoh: Gedung Utama RSUD">
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ TAB TARIF & BIAYA ═══ --}}
            <div class="tab-pane fade" id="tab-tarif">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-1"><i class="bi bi-cash-coin text-primary me-2"></i>Tarif & Biaya Konsultasi</h5>
                        <p class="text-muted small mb-0">Atur harga layanan untuk Modul Kasir & Pembayaran</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Biaya Konsultasi Poli Umum (Rp)</label>
                                <input type="number" name="fee_dokter_umum" class="form-control" value="{{ $settings['fee_dokter_umum'] ?? '150000' }}">
                                <div class="form-text">Biaya default untuk pendaftaran poli biasa.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Biaya Konsultasi Poli Spesialis (Rp)</label>
                                <input type="number" name="fee_dokter_spesialis" class="form-control" value="{{ $settings['fee_dokter_spesialis'] ?? '200000' }}">
                                <div class="form-text">Biaya default jika nama poli mengandung kata 'spesialis'.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ TAB 6: KONTAK & SOSMED ═══ --}}
            <div class="tab-pane fade" id="tab-kontak">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-1"><i class="bi bi-telephone text-primary me-2"></i>Kontak & Media Sosial</h5>
                        <p class="text-muted small mb-0">Atur informasi kontak dan link media sosial</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Alamat Lengkap</label>
                                <textarea name="contact_address" class="form-control" rows="2">{{ $settings['contact_address'] ?? 'Desa Talaga Tomoagu, Kec. Bolangitang Barat, Kab. Bolaang Mongondow Utara, Sulawesi Utara 95764' }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nomor Telepon</label>
                                <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '0853-4364-3434 / 0822-2912-3385' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="text" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? 'febyantolumoto9@gmail.com' }}">
                            </div>
                            <hr>
                            <h6 class="fw-bold text-muted">Media Sosial</h6>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold"><i class="bi bi-facebook me-1"></i> Facebook URL</label>
                                <input type="text" name="social_facebook" class="form-control" value="{{ $settings['social_facebook'] ?? '' }}" placeholder="https://facebook.com/...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold"><i class="bi bi-instagram me-1"></i> Instagram URL</label>
                                <input type="text" name="social_instagram" class="form-control" value="{{ $settings['social_instagram'] ?? '' }}" placeholder="https://instagram.com/...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold"><i class="bi bi-youtube me-1"></i> YouTube URL</label>
                                <input type="text" name="social_youtube" class="form-control" value="{{ $settings['social_youtube'] ?? '' }}" placeholder="https://youtube.com/...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Tombol Simpan --}}
        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow-sm">
                <i class="bi bi-save me-2"></i> Simpan Semua Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
