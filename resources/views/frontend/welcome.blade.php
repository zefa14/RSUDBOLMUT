<!DOCTYPE html>
<html lang="id" style="scroll-behavior: smooth;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Rumah Sakit - Melayani Dengan Sepenuh Hati</title>
    <!-- Premium Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;700;900&display=swap" rel="stylesheet">
    <!-- CSS Framework -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #0d9488;
            --primary-dark: #0f766e;
            --primary-light: #ccfbf1;
            --secondary: #0284c7;
            --secondary-dark: #0369a1;
            --accent: #f0fdfa;
            --dark: #0f172a;
            --navy: #1e293b;
            --light: #f8fafc;
            --text-gray: #64748b;
            --border: rgba(0,0,0,0.06);
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.04);
            --shadow-md: 0 8px 24px rgba(0,0,0,0.06);
            --shadow-lg: 0 16px 48px rgba(0,0,0,0.08);
            --radius: 16px;
            --radius-lg: 24px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark);
            background-color: var(--light);
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        h1, h2, h3, h4, h5, .hero-title {
            font-family: 'Outfit', sans-serif;
        }

        ::selection { background: var(--primary-light); color: var(--primary-dark); }

        /* ─── NAVBAR ─── */
        .navbar-glass {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            transition: all 0.4s ease;
            padding: 12px 0;
        }
        .navbar-glass.scrolled {
            background: rgba(15, 23, 42, 0.95);
            padding: 8px 0;
            box-shadow: 0 4px 30px rgba(0,0,0,0.15);
        }
        
        .brand-icon-box {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--primary) 0%, #2dd4bf 100%);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.3);
        }

        .navbar-brand-text {
            font-weight: 800; font-size: 1.2rem; line-height: 1.1; color: white;
            letter-spacing: -0.5px;
        }
        
        .nav-link { font-weight: 500; font-size: 0.9rem; color: rgba(255,255,255,0.8) !important; margin: 0 6px; transition: 0.3s; padding: 8px 12px !important; border-radius: 8px; }
        .nav-link:hover { color: white !important; background: rgba(255,255,255,0.08); }
        
        .navbar-nav .dropdown-menu { border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow-lg); padding: 8px; margin-top: 8px; min-width: 220px; }
        .navbar-nav .dropdown-item { font-weight: 500; color: var(--dark); padding: 10px 14px; border-radius: 10px; transition: 0.2s; display: flex; align-items: center; justify-content: space-between; font-size: 0.9rem; }
        .navbar-nav .dropdown-item:hover { background-color: var(--accent); color: var(--primary-dark); }
        .navbar-nav .dropdown-item i { font-size: 1rem; color: var(--text-gray); }
        .navbar-nav .dropdown-item:hover i { color: var(--primary); }

        .btn-portal {
            background: var(--primary);
            color: white; border: none; padding: 9px 24px; border-radius: 50px; font-weight: 600; font-size: 0.9rem;
            box-shadow: 0 4px 14px rgba(13, 148, 136, 0.35); transition: 0.3s;
        }
        .btn-portal:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(13, 148, 136, 0.4); color: white; background: var(--primary-dark); }

        /* ─── HERO ─── */
        .hero-section {
            position: relative;
            padding: 200px 0 160px;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            overflow: hidden;
            color: white;
        }
        .hero-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.92) 0%, rgba(13, 148, 136, 0.6) 100%);
            z-index: 1;
        }
        .hero-content { position: relative; z-index: 2; }
        .hero-title { font-size: 3.8rem; font-weight: 900; line-height: 1.15; letter-spacing: -1.5px; margin-bottom: 20px; color: white; }
        .hero-title span { color: #5eead4; }
        .hero-text { font-size: 1.1rem; color: rgba(255,255,255,0.8); margin-bottom: 35px; max-width: 85%; line-height: 1.8; }
        .hero-stat { text-align: center; padding: 0 15px; }
        .hero-stat h3 { font-size: 2rem; font-weight: 800; color: #5eead4; margin-bottom: 4px; }
        .hero-stat p { font-size: 0.85rem; color: rgba(255,255,255,0.6); margin: 0; font-weight: 500; }

        .wave-bottom { position: absolute; bottom: 0; left: 0; width: 100%; overflow: hidden; line-height: 0; transform: rotate(180deg); z-index: 2; }
        .wave-bottom svg { position: relative; display: block; width: calc(100% + 1.3px); height: 70px; }
        .wave-bottom .shape-fill { fill: var(--light); }

        /* ─── QUICK LINKS ─── */
        .quick-link-card {
            background: white; border-radius: var(--radius-lg); padding: 32px 24px; text-align: center; height: 100%;
            box-shadow: var(--shadow-sm); transition: all 0.35s ease;
            border: 1px solid var(--border); text-decoration: none; display: block; position: relative; overflow: hidden;
        }
        .quick-link-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-lg); border-color: var(--primary-light); }
        .icon-wrapper {
            width: 72px; height: 72px; margin: 0 auto 18px; border-radius: 18px;
            display: flex; align-items: center; justify-content: center; font-size: 2.2rem; transition: 0.3s;
        }
        .icon-blue { background: #e0f2fe; color: var(--secondary); }
        .icon-green { background: var(--primary-light); color: var(--primary); }
        .quick-link-card:hover .icon-blue { background: var(--secondary); color: white; }
        .quick-link-card:hover .icon-green { background: var(--primary); color: white; }
        .quick-link-card h4 { font-weight: 700; color: var(--dark); font-size: 1.05rem; margin-bottom: 6px; }
        .quick-link-card p { color: var(--text-gray); margin: 0; font-size: 0.85rem; }

        /* ─── SECTIONS ─── */
        .section-header { text-align: center; margin-bottom: 50px; }
        .section-subtitle { color: var(--primary); font-weight: 700; text-transform: uppercase; letter-spacing: 2px; font-size: 0.8rem; margin-bottom: 10px; display: block; }
        .section-title { font-weight: 800; font-size: 2.4rem; color: var(--dark); letter-spacing: -0.5px; }

        .welcome-section { padding: 90px 0; background: white; }
        .img-overlap { border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); position: relative; z-index: 2; width: 100%; border: 8px solid white; }
        .decor-box { position: absolute; top: -15px; right: 10px; width: 100%; height: 100%; border: 2px dashed var(--primary); border-radius: var(--radius-lg); z-index: 1; opacity: 0.4; }

        /* ─── BED ─── */
        .bed-section { padding: 90px 0; background-size: cover; background-position: center; background-attachment: fixed; position: relative; overflow: hidden; }
        .bed-section::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.88); }
        .bed-card {
            background: rgba(255,255,255,0.06); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);
            border-radius: var(--radius); padding: 28px 20px; text-align: center; transition: 0.3s;
        }
        .bed-card:hover { transform: translateY(-6px); background: rgba(255,255,255,0.12); }
        .bed-number { font-size: 3rem; font-weight: 900; background: linear-gradient(135deg, #fff 0%, #94a3b8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; line-height: 1; margin: 12px 0; }
        .glow-green { box-shadow: 0 0 25px rgba(13, 148, 136, 0.15); border-color: rgba(13, 148, 136, 0.3); }
        .glow-red { box-shadow: 0 0 25px rgba(239, 68, 68, 0.15); border-color: rgba(239, 68, 68, 0.3); }

        /* ─── DOCTORS ─── */
        .doctor-card {
            background: white; border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--border);
            box-shadow: var(--shadow-sm); transition: 0.35s;
        }
        .doctor-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }
        .doctor-img-box { position: relative; overflow: hidden; background: linear-gradient(135deg, var(--accent) 0%, #e0f2fe 100%); padding: 24px; display: flex; justify-content: center; }
        .doctor-img-box img { width: 120px; height: 120px; border-radius: 50%; border: 4px solid white; box-shadow: var(--shadow-md); transition: 0.4s; object-fit: cover; }
        .doctor-card:hover .doctor-img-box img { transform: scale(1.05); }
        .doctor-info { padding: 20px; text-align: center; }
        .doctor-info h5 { font-weight: 700; color: var(--dark); margin-bottom: 4px; font-size: 1rem; }
        .dept-badge { background: var(--primary-light); color: var(--primary-dark); font-weight: 600; font-size: 0.72rem; padding: 4px 12px; border-radius: 20px; display: inline-block; margin-bottom: 10px; }

        /* ─── SEARCH & FILTER ─── */
        .search-widget { background: white; border-radius: var(--radius); padding: 12px; box-shadow: var(--shadow-lg); margin-top: -40px; position: relative; z-index: 10; display: flex; gap: 8px; border: 1px solid var(--border); }
        .search-widget select, .search-widget input { border: 1px solid #e2e8f0; background: var(--light); border-radius: 12px; padding: 14px 18px; font-weight: 500; width: 100%; outline: none; transition: 0.2s; font-size: 0.9rem; }
        .search-widget select:focus, .search-widget input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(13,148,136,0.1); }
        .search-widget .btn-search { background: var(--primary); color: white; border: none; border-radius: 12px; padding: 14px 28px; font-weight: 600; white-space: nowrap; transition: 0.2s; font-size: 0.9rem; }
        .search-widget .btn-search:hover { background: var(--primary-dark); }

        .timeline-box { display: flex; align-items: center; justify-content: space-between; position: relative; margin: 40px 0; }
        .timeline-box::before { content: ''; position: absolute; top: 50%; left: 0; width: 100%; height: 3px; background: linear-gradient(90deg, var(--primary-light) 0%, #e2e8f0 100%); z-index: 1; transform: translateY(-50%); }
        .timeline-step { position: relative; z-index: 2; text-align: center; background: white; padding: 18px; border-radius: 50%; width: 110px; height: 110px; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: var(--shadow-md); border: 4px solid #e2e8f0; transition: 0.3s; }
        .timeline-step:hover { border-color: var(--primary); transform: scale(1.08); }
        .timeline-step i { font-size: 1.8rem; color: var(--primary); margin-bottom: 4px; }
        .timeline-step span { font-weight: 700; font-size: 0.78rem; color: var(--dark); line-height: 1.2; }

        /* ─── ARTICLES ─── */
        .article-card { background: white; border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--border); box-shadow: var(--shadow-sm); transition: 0.35s; height: 100%; display: flex; flex-direction: column; }
        .article-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }
        .article-img { width: 100%; height: 200px; object-fit: cover; }
        .article-content { padding: 24px; flex: 1; display: flex; flex-direction: column; }
        .article-date { font-size: 0.8rem; color: var(--primary); font-weight: 600; margin-bottom: 8px; display: block; }
        .article-title { font-weight: 700; color: var(--dark); margin-bottom: 12px; font-size: 1.05rem; line-height: 1.5; }
        .article-link { color: var(--primary); font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 5px; margin-top: auto; font-size: 0.9rem; }
        .article-link:hover { gap: 10px; }

        /* ─── PARTNERS ─── */
        .partner-scroll { overflow: hidden; white-space: nowrap; padding: 35px 0; border-top: 1px solid var(--border); background: white; }
        .partner-scroll-inner { display: inline-block; animation: scroll 25s linear infinite; }
        .partner-scroll h5 { display: inline; margin: 0 40px; font-weight: 700; color: #cbd5e1; font-size: 1rem; transition: 0.3s; }
        .partner-scroll h5:hover { color: var(--primary); }
        @keyframes scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

        /* ─── FOOTER ─── */
        footer { background: var(--dark); padding: 70px 0 25px; color: rgba(255,255,255,0.7); }
        .footer-logo { font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 1.4rem; color: white; }
        .footer-logo i { color: var(--primary); }
        .footer-desc { color: rgba(255,255,255,0.5); line-height: 1.8; margin-top: 16px; font-size: 0.9rem; }
        .footer-title { font-family: 'Outfit', sans-serif; font-weight: 700; color: white; margin-bottom: 20px; font-size: 1.05rem; }
        .footer-links a { color: rgba(255,255,255,0.5); text-decoration: none; display: block; margin-bottom: 10px; transition: 0.3s; font-weight: 500; font-size: 0.9rem; }
        .footer-links a:hover { color: var(--primary); padding-left: 4px; }
        .social-btn { width: 38px; height: 38px; border-radius: 10px; background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.6); display: inline-flex; align-items: center; justify-content: center; margin-right: 8px; transition: 0.3s; text-decoration: none; border: 1px solid rgba(255,255,255,0.08); }
        .social-btn:hover { background: var(--primary); color: white; transform: translateY(-2px); border-color: var(--primary); }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.08); margin-top: 40px; padding-top: 20px; text-align: center; color: rgba(255,255,255,0.35); font-size: 0.85rem; font-weight: 500; }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            .hero-title { font-size: 2.4rem; letter-spacing: -1px; }
            .hero-text { font-size: 1rem; }
            .section-title { font-size: 1.8rem; }
            .search-widget { flex-direction: column; }
            .timeline-step { width: 90px; height: 90px; padding: 12px; }
            .timeline-step i { font-size: 1.4rem; }
            .timeline-step span { font-size: 0.7rem; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-glass fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="#">
                <div class="brand-icon-box" style="background: transparent; border: none; box-shadow: none;">
                    <img src="{{ asset('img/logo-rsud.jpg') }}" alt="Logo RSUD" style="height: 45px; width: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
                </div>
                <div class="d-flex flex-column">
                    <span class="navbar-brand-text">RSUD BOLMONG UTARA</span>
                    <span style="font-size: 0.75rem; color: rgba(255,255,255,0.7); font-weight: 600; letter-spacing: 1px;">Sistem Informasi Terpadu</span>
                </div>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <i class="bi bi-list fs-1 text-white"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#hero-top">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('frontend.about') }}">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('frontend.galeri') }}">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('frontend.jadwal') }}">Jadwal</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="infoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Informasi
                        </a>
                        <ul class="dropdown-menu shadow-sm" aria-labelledby="infoDropdown">
                            <li><a class="dropdown-item" href="{{ route('frontend.doctors') }}">Tim Dokter</a></li>
                            <li><a class="dropdown-item" href="#kamar">Fasilitas Kamar</a></li>
                            <li><a class="dropdown-item" href="{{ route('frontend.jadwal') }}">Jadwal Pelayanan <i class="bi bi-calendar-event"></i></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalStruktur">Struktur Organisasi <i class="bi bi-diagram-3"></i></a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalPPID">PPID <i class="bi bi-file-earmark-text"></i></a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalSPO">SPO RSUD <i class="bi bi-card-checklist"></i></a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalTarif">Tarif Rumah Sakit <i class="bi bi-cash-stack"></i></a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('frontend.pengaduan') }}">Pengaduan</a></li>
                </ul>
                <div class="d-flex gap-2 align-items-center">
                    <a href="{{ route('login') }}" class="btn btn-portal" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); box-shadow: none;"><i class="bi bi-box-arrow-in-right me-1"></i> Log In</a>
                    <a href="#kontak" class="btn btn-portal"><i class="bi bi-telephone-fill me-1"></i> Hubungi Kami</a>
                </div>
            </div>
        </div>
    </nav>

    @php
        $bannerSrc = (isset($settings['banner_image']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($settings['banner_image']))
            ? asset('storage/' . $settings['banner_image'])
            : 'https://images.unsplash.com/photo-1551076805-e18690c5e530?q=80&w=1920&auto=format&fit=crop';
    @endphp
    <!-- Hero Section -->
    <section id="hero-top" class="hero-section" style="background-image: url('{{ $bannerSrc }}');">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-5 mb-lg-0" data-aos="fade-right" data-aos-duration="1000">
                    <span class="badge bg-white bg-opacity-10 text-white px-4 py-2 rounded-pill fw-bold mb-4 border border-white border-opacity-25" style="font-size: 0.85rem; backdrop-filter: blur(5px);">
                        <i class="bi bi-patch-check-fill me-1 text-success"></i> {{ $settings['hero_badge'] ?? 'Rumah Sakit Terakreditasi Paripurna' }}
                    </span>
                    @php $heroTitle = $settings['hero_title'] ?? 'Kesehatan Anda, Prioritas Utama Kami'; $heroParts = explode(',', $heroTitle, 2); @endphp
                    <h1 class="hero-title">{{ trim($heroParts[0]) }},<br><span>{{ trim($heroParts[1] ?? '') }}</span></h1>
                    <p class="hero-text">{{ $settings['hero_subtitle'] ?? 'RSUD menghadirkan pelayanan medis terbaik dengan teknologi terkini, tim ahli berpengalaman, dan sentuhan kemanusiaan yang hangat.' }}</p>
                    
                    <div class="d-flex flex-wrap gap-3 mb-5">
                        <a href="{{ route('frontend.register') }}" class="btn btn-lg fw-bold text-white shadow-sm" style="background: var(--primary); border: none; padding: 14px 32px; border-radius: 50px; font-size: 0.95rem;">
                            <i class="bi bi-calendar-check me-2"></i>Daftar Online
                        </a>
                        <a href="{{ route('frontend.jadwal') }}" class="btn btn-lg fw-bold" style="padding: 14px 32px; border-radius: 50px; backdrop-filter: blur(5px); border: 1.5px solid rgba(255,255,255,0.3); color: white; font-size: 0.95rem;">
                            Lihat Jadwal <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>

                    <div class="d-flex flex-wrap gap-4 mt-4 pt-4" style="border-top: 1px solid rgba(255,255,255,0.15);">
                        <div class="hero-stat">
                            <h3>12k+</h3>
                            <p>Pasien Dilayani</p>
                        </div>
                        <div style="width: 1px; background: rgba(255,255,255,0.15); align-self: stretch;"></div>
                        <div class="hero-stat">
                            <h3>24/7</h3>
                            <p>IGD & Rawat Inap</p>
                        </div>
                        <div style="width: 1px; background: rgba(255,255,255,0.15); align-self: stretch;"></div>
                        <div class="hero-stat">
                            <h3>Kelas D</h3>
                            <p>RSU Daerah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Wave Separator -->
        <div class="wave-bottom">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
            </svg>
        </div>
    </section>

    <!-- Pencarian Pintar (Smart Search Widget) -->
    <div class="container mb-5" style="position: relative; z-index: 15;" data-aos="fade-up">
        <div class="search-widget flex-column flex-md-row">
            <div class="flex-grow-1">
                <input type="text" id="mainSearchInput" placeholder="🔍 Cari nama dokter spesialis atau layanan...">
            </div>
            <div class="flex-grow-1">
                <select id="mainSearchSelect">
                    <option value="">Semua Poliklinik</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <button id="mainSearchBtn" class="btn-search"><i class="bi bi-search me-2"></i>Temukan Jadwal</button>
        </div>
    </div>

    <!-- Layanan Cepat -->
    <div class="container pt-4" style="position: relative; z-index: 10;">
        <div class="row justify-content-center g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('frontend.register') }}" class="quick-link-card">
                    <div class="icon-wrapper icon-blue"><i class="bi bi-laptop"></i></div>
                    <h4>Pendaftaran Online</h4>
                    <p>Ambil tiket antrean dari rumah</p>
                </a>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('frontend.jadwal') }}" class="quick-link-card">
                    <div class="icon-wrapper icon-green"><i class="bi bi-file-medical"></i></div>
                    <h4>Jadwal Dokter</h4>
                    <p>Cek jam praktek spesialis</p>
                </a>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <a href="#kamar" class="quick-link-card">
                    <div class="icon-wrapper icon-blue"><i class="bi bi-hospital"></i></div>
                    <h4>Info Kamar</h4>
                    <p>Ketersediaan ruang rawat inap</p>
                </a>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <a href="tel:119" class="quick-link-card">
                    <div class="icon-wrapper" style="background: #fee2e2; color: #ef4444;"><i class="bi bi-truck-front-fill"></i></div>
                    <h4>Layanan Gawat Darurat</h4>
                    <p>Ambulans Siaga 24 Jam</p>
                </a>
            </div>
        </div>
    </div>

    <!-- Alur Pelayanan Pasien -->
    <section class="welcome-section pb-0" style="background: var(--light);">
        <div class="container" data-aos="fade-up">
            <div class="section-header text-center mb-5">
                <span class="section-subtitle">Patient Journey</span>
                <h2 class="section-title">Alur Pelayanan Modern</h2>
            </div>
            
            <div class="d-none d-lg-block">
                <div class="timeline-box">
                    <div class="timeline-step">
                        <i class="bi bi-phone"></i>
                        <span>1. Daftar<br>Online</span>
                    </div>
                    <div class="timeline-step">
                        <i class="bi bi-qr-code-scan"></i>
                        <span>2. Scan<br>Barcode</span>
                    </div>
                    <div class="timeline-step">
                        <i class="bi bi-heart-pulse"></i>
                        <span>3. Pemeriksaan<br>Medis</span>
                    </div>
                    <div class="timeline-step">
                        <i class="bi bi-capsule"></i>
                        <span>4. Ambil<br>Obat</span>
                    </div>
                    <div class="timeline-step">
                        <i class="bi bi-emoji-smile"></i>
                        <span>5. Pulang<br>Sehat</span>
                    </div>
                </div>
            </div>
            <div class="d-lg-none mt-4 text-center">
                <p class="text-muted" style="line-height: 1.8;">Proses pendaftaran dari awal hingga pengambilan obat dapat dilakukan dengan sangat mudah melalui sistem antrean terintegrasi kami.</p>
            </div>
        </div>
    </section>

    

    <!-- Layanan Unggulan -->
    <section id="layanan" style="padding: 100px 0; background: #f8fafc;">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-subtitle">Fasilitas & Layanan Utama</span>
                <h2 class="section-title mb-3">Layanan Unggulan Kami</h2>
                <p class="text-muted mx-auto" style="max-width: 700px; font-size: 1.1rem;">Berkomitmen memberikan perawatan holistik melalui fasilitas medis modern yang dirancang khusus untuk mempercepat proses pemulihan Anda.</p>
            </div>
            
            <div class="row g-4 mt-2">
                @php
                    $layananDefaults = [
                        ['icon' => 'bi-heart-pulse', 'title' => 'Jantung Terpadu', 'desc' => 'Penanganan penyakit jantung komprehensif didukung Cath Lab modern dan tim Kardiolog berpengalaman.', 'gradient' => 'linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%)', 'color' => 'text-primary'],
                        ['icon' => 'bi-bandaid', 'title' => 'Trauma Center', 'desc' => 'Penanganan kecelakaan dan darurat bedah 24 jam dengan respons cepat serta fasilitas operasi dan IGD darurat lengkap.', 'gradient' => 'linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%)', 'color' => 'text-success'],
                        ['icon' => 'bi-person-hearts', 'title' => 'Klinik Ibu & Anak', 'desc' => 'Pusat kesehatan ibu hamil, bersalin, dan perawatan neonatal dengan fasilitas NICU dan PICU mutakhir.', 'gradient' => 'linear-gradient(135deg, #fef3c7 0%, #fde68a 100%)', 'color' => 'text-warning'],
                    ];
                @endphp
                @for($i = 0; $i < 3; $i++)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($i+1) * 100 }}">
                    <div style="background: white; border-radius: 25px; padding: 40px; box-shadow: var(--shadow-sm); height: 100%; transition: all 0.4s ease; border: 1px solid var(--border);" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='var(--shadow-lg)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)';">
                        <div style="width: 70px; height: 70px; background: {{ $layananDefaults[$i]['gradient'] }}; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-bottom: 25px;">
                            <i class="bi {{ $settings['layanan_'.($i+1).'_icon'] ?? $layananDefaults[$i]['icon'] }} {{ $layananDefaults[$i]['color'] }} fs-2"></i>
                        </div>
                        <h4 style="font-family: 'Outfit', sans-serif; font-weight: 800; color: #0f172a; margin-bottom: 15px;">{{ $settings['layanan_'.($i+1).'_title'] ?? $layananDefaults[$i]['title'] }}</h4>
                        <p class="text-muted" style="line-height: 1.7; margin-bottom: 0;">{{ $settings['layanan_'.($i+1).'_desc'] ?? $layananDefaults[$i]['desc'] }}</p>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Info Kamar (Live) -->
    <section id="kamar" class="bed-section" style="background-image: url('{{ $bannerSrc }}');">
        <div class="container" style="position: relative; z-index: 2;">
            <div class="section-header text-center">
                <span class="section-subtitle text-white">Real-Time Data SIMRS</span>
                <h2 class="section-title text-white mb-3">Ketersediaan Kamar Rawat Inap</h2>
                <p class="text-white opacity-75 mx-auto" style="max-width: 600px;">Data di bawah ini tersinkronisasi otomatis dengan sistem sentral administrasi rumah sakit kami. Transparansi adalah komitmen kami.</p>
            </div>
            
            <div class="row g-4 justify-content-center">
                @forelse($wards as $ward)
                    <div class="col-12 mb-2">
                        <div class="text-center text-white mb-3">
                            <h4 class="fw-bold mb-0 text-white"><i class="bi bi-building me-2" style="color: var(--primary);"></i>{{ $ward->name }}</h4>
                            <small class="text-white opacity-75">{{ $ward->building }} - {{ $ward->floor }}</small>
                        </div>
                        <div class="row g-3 justify-content-center">
                            @foreach($ward->rooms as $room)
                            <div class="col-lg-2 col-md-3 col-6">
                                <div class="bed-card {{ $room->available_beds > 0 ? 'glow-green' : 'glow-red' }} h-100">
                                    <div class="badge bg-white text-dark mb-3 fw-bold rounded-pill">{{ $room->room_class }}</div>
                                    <div class="bed-number" style="font-size: 2.5rem;">{{ str_pad($room->available_beds, 2, '0', STR_PAD_LEFT) }}</div>
                                    <small class="d-block text-white opacity-75 mb-2">dari {{ $room->total_beds }} bed</small>
                                    
                                    @if($room->available_beds == 0)
                                        <div class="text-danger fw-bold mt-auto"><i class="bi bi-x-circle-fill me-1"></i> Penuh</div>
                                    @else
                                        <div class="text-success fw-bold mt-auto"><i class="bi bi-check-circle-fill me-1"></i> Kosong</div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-white opacity-50 py-5">
                        <i class="bi bi-hospital fs-1 d-block mb-3"></i>
                        <h5>Data kamar sedang dalam pemeliharaan.</h5>
                    </div>
                @endforelse
            </div>
        </div>
    </section>


    <!-- Jadwal Pelayanan dipindahkan ke halaman terpisah (jadwal.blade.php) -->




    <!-- Pengaduan Masyarakat dipindahkan ke halaman terpisah (pengaduan.blade.php) -->


    <!-- Instagram Feed Section -->
    <section class="welcome-section" style="background: #fafafa; padding-top: 60px; padding-bottom: 60px;">
        <div class="container" data-aos="fade-up">
            <div class="section-header text-center mb-4">
                <span class="section-subtitle" style="color: #e1306c; font-weight: 700;"><i class="bi bi-instagram me-2"></i>@officialrsudbolmongutara</span>
                <h2 class="section-title">Instagram Feed Kami</h2>
                <p class="text-muted mx-auto mt-3" style="max-width: 600px;">Dapatkan informasi kesehatan terbaru, jadwal pelayanan, dan kegiatan rumah sakit langsung dari genggaman Anda.</p>
            </div>
            
            <!-- Elfsight Instagram Feed | Untitled Instagram Feed -->
            <script src="https://elfsightcdn.com/platform.js" async></script>
            <div class="elfsight-app-b712f345-8273-42a6-a405-bf076ce11fbd"></div>
            
        </div>
    </section>


    <!-- Location / Map Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="text-center mb-4">
                <span class="section-subtitle">Lokasi Kami</span>
                <h2 class="section-title mb-3">Rumah Sakit Umum Daerah Bolaang Mongondow Utara</h2>
            </div>
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5">
                <div class="card-body p-0">
                    <iframe 
                        src="https://maps.google.com/maps?q=RSUD%20Bolaang%20Mongondow%20Utara&t=&z=14&ie=UTF8&iwloc=&output=embed" 
                        width="100%" 
                        height="450" 
                        style="border:0; display: block;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Premium Footer -->
    <footer id="kontak">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4 pe-lg-5">
                    <div class="footer-logo mb-4 d-flex align-items-center gap-2">
                        <img src="{{ asset('img/logo-rsud.jpg') }}" alt="Logo" style="height: 40px; width: auto;">
                        <span>RSUD BOLMUT</span>
                    </div>
                    <p class="footer-desc">Rumah Sakit Umum Daerah Bolaang Mongondow Utara yang berdedikasi memberikan pelayanan kesehatan paripurna dan inovatif untuk seluruh lapisan masyarakat.</p>
                    <div class="mt-4">
                        <a href="{{ $settings['social_facebook'] ?? '#' }}" class="social-btn" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="{{ $settings['social_instagram'] ?? '#' }}" class="social-btn" target="_blank"><i class="bi bi-instagram"></i></a>
                        <a href="{{ $settings['social_youtube'] ?? '#' }}" class="social-btn" target="_blank"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="footer-title">Pintasan</h5>
                    <div class="footer-links">
                        <a href="{{ route('frontend.about') }}">Tentang Kami</a>
                        <a href="#layanan">Layanan Medis</a>
                        <a href="{{ route('frontend.jadwal') }}">Jadwal Dokter</a>
                        <a href="#kamar">Informasi Kamar</a>
                        <a href="javascript:void(0)" onclick="alert('Saat ini belum ada lowongan karir yang tersedia. Terima kasih atas minat Anda.')">Karir</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h5 class="footer-title">Pusat Bantuan</h5>
                    <div class="footer-links">
                        <a href="{{ route('frontend.register') }}">Pendaftaran Mandiri</a>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalSPO">Panduan Rawat Inap</a>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalTarif">Tarif Layanan BPJS</a>
                        <a href="{{ route('frontend.pengaduan') }}">Saran & Pengaduan</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h5 class="footer-title">Hubungi Kami</h5>
                    <div class="d-flex mb-3">
                        <i class="bi bi-geo-alt-fill fs-5 me-3 mt-1" style="color: var(--primary);"></i>
                        <span style="color: rgba(255,255,255,0.5); font-size: 0.9rem;">{{ $settings['contact_address'] ?? 'Desa Talaga Tomoagu, Kec. Bolangitang Barat, Kab. Bolaang Mongondow Utara, Sulawesi Utara 95764' }}</span>
                    </div>
                    <div class="d-flex mb-3">
                        <i class="bi bi-telephone-fill fs-5 me-3" style="color: var(--primary);"></i>
                        <span style="color: rgba(255,255,255,0.5); font-size: 0.9rem;">{{ $settings['contact_phone'] ?? '0853-4364-3434 / 0822-2912-3385' }}</span>
                    </div>
                    <div class="d-flex">
                        <i class="bi bi-envelope-fill fs-5 me-3" style="color: var(--primary);"></i>
                        <span style="color: rgba(255,255,255,0.5); font-size: 0.9rem;">{{ $settings['contact_email'] ?? 'febyantolumoto9@gmail.com' }}</span>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} RSUD Bolaang Mongondow Utara &mdash; Melayani Dengan Sepenuh Hati
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 700,
            once: true,
            offset: 40,
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-glass');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Filter Logic for Jadwal Poliklinik
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchJadwal');
            const filterBtns = document.querySelectorAll('.filter-day-btn');
            const jadwalCards = document.querySelectorAll('.jadwal-card');

            // Smart Search Integration
            const mainSearchInput = document.getElementById('mainSearchInput');
            const mainSearchSelect = document.getElementById('mainSearchSelect');
            const mainSearchBtn = document.getElementById('mainSearchBtn');

            if (mainSearchBtn) {
                mainSearchBtn.addEventListener('click', function() {
                    let query = (mainSearchInput.value.trim() + " " + mainSearchSelect.value).trim();
                    
                    const targetJadwal = document.getElementById('jadwal');
                    if(targetJadwal) {
                        // Scroll offset to handle sticky navbar
                        const offset = 80;
                        const bodyRect = document.body.getBoundingClientRect().top;
                        const elementRect = targetJadwal.getBoundingClientRect().top;
                        const elementPosition = elementRect - bodyRect;
                        const offsetPosition = elementPosition - offset;
                        
                        window.scrollTo({
                             top: offsetPosition,
                             behavior: "smooth"
                        });
                        
                        if(searchInput) {
                            searchInput.value = query;
                            // Trigger filter
                            const event = new Event('input', { bubbles: true });
                            searchInput.dispatchEvent(event);
                        }
                    }
                });
            }

            let currentSearch = '';
            let currentDay = 'Semua';

            function filterJadwal() {
                jadwalCards.forEach(card => {
                    // Check search text
                    const nameElem = card.querySelector('h5');
                    const poliElem = card.querySelector('.fw-bold[style*="uppercase"]');
                    
                    const name = nameElem ? nameElem.innerText.toLowerCase() : '';
                    const poli = poliElem ? poliElem.innerText.toLowerCase() : '';
                    
                    const matchesSearch = currentSearch === '' || name.includes(currentSearch) || poli.includes(currentSearch);

                    // Check day filter
                    let matchesDay = false;
                    if (currentDay === 'Semua') {
                        matchesDay = true;
                    } else {
                        // Days are inside span tags with class text-dark
                        const daySpans = card.querySelectorAll('span.text-dark');
                        daySpans.forEach(span => {
                            if (span.innerText.trim().toLowerCase() === currentDay.toLowerCase()) {
                                matchesDay = true;
                            }
                        });
                    }

                    if (matchesSearch && matchesDay) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            if(searchInput) {
                searchInput.addEventListener('input', function(e) {
                    currentSearch = e.target.value.toLowerCase();
                    filterJadwal();
                });
            }

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Update Active Style
                    filterBtns.forEach(b => {
                        b.style.backgroundColor = '#f1f5f9';
                        b.classList.remove('text-white', 'shadow-sm', 'active');
                        b.classList.add('text-dark');
                    });
                    this.style.backgroundColor = '#0d9488';
                    this.classList.remove('text-dark');
                    this.classList.add('text-white', 'shadow-sm', 'active');

                    currentDay = this.getAttribute('data-day');
                    filterJadwal();
                });
            });
        });

        // Pengaduan Form AJAX Submit
        document.addEventListener('DOMContentLoaded', function() {
            const formPengaduan = document.getElementById('formPengaduan');
            if (formPengaduan) {
                formPengaduan.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const btn = document.getElementById('btnKirimPengaduan');
                    const successDiv = document.getElementById('pengaduanSuccess');
                    const errorDiv = document.getElementById('pengaduanError');
                    const originalText = btn.innerHTML;

                    // Disable button
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Mengirim...';
                    errorDiv.style.display = 'none';

                    const formData = new FormData(formPengaduan);

                    fetch('{{ route("complaints.store") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': formData.get('_token'),
                            'Accept': 'application/json',
                        },
                        body: formData,
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            formPengaduan.style.display = 'none';
                            successDiv.style.display = 'block';
                            successDiv.style.background = 'rgba(45,212,191,0.15)';
                            successDiv.style.color = '#5eead4';
                            successDiv.style.borderRadius = '14px';
                        } else {
                            throw new Error(data.message || 'Terjadi kesalahan.');
                        }
                    })
                    .catch(err => {
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                        if (err.message) {
                            errorDiv.style.display = 'block';
                            errorDiv.textContent = err.message;
                        } else {
                            errorDiv.style.display = 'block';
                            errorDiv.textContent = 'Gagal mengirim pengaduan. Pastikan semua field terisi dengan benar.';
                        }
                    });
                });
            }
        });
    </script>
    <!-- Modal Struktur Organisasi -->
    <div class="modal fade" id="modalStruktur" tabindex="-1" aria-labelledby="modalStrukturLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border: none; border-radius: 24px; overflow: hidden;">
                <div class="modal-header border-0" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0d9488 100%); padding: 28px 32px;">
                    <div>
                        <h5 class="modal-title text-white fw-bold mb-1" id="modalStrukturLabel"><i class="bi bi-diagram-3-fill me-2"></i>Struktur Organisasi</h5>
                        <p class="text-white-50 mb-0 small">BLUD UPTD RSUD Bolaang Mongondow Utara — Tahun 2026</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 p-md-5" style="background: linear-gradient(180deg, #f8fafc 0%, #f0fdfa 100%);">

                    <!-- Org Chart Container -->
                    <div class="org-chart">
                        <!-- Level 1: Direktur -->
                        <div class="org-level d-flex justify-content-center mb-0">
                            <div class="org-card org-card-director">
                                <div class="org-card-icon">
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <div class="org-card-title">Direktur</div>
                                <div class="org-card-subtitle">BLUD UPTD RSUD</div>
                                <div class="org-card-name">drg. Firlia Mokoagow</div>
                            </div>
                        </div>

                        <!-- Connector: Director to branches -->
                        <div class="org-connector-vertical" style="height: 40px;"></div>
                        <div class="org-connector-horizontal"></div>

                        <!-- Level 2: 3 Branches -->
                        <div class="org-level d-flex justify-content-center gap-3 gap-md-4 flex-wrap flex-md-nowrap mt-0">
                            <!-- Branch 1: Kepala Sub Bagian Tata Usaha -->
                            <div class="org-branch flex-fill" style="max-width: 320px;">
                                <div class="org-connector-vertical-sm"></div>
                                <div class="org-card org-card-branch org-card-tata-usaha">
                                    <div class="org-card-icon-sm"><i class="bi bi-briefcase-fill"></i></div>
                                    <div class="org-card-title">Kepala Sub Bagian</div>
                                    <div class="org-card-subtitle">Tata Usaha</div>
                                </div>

                                <!-- Sub-units under Tata Usaha -->
                                <div class="org-connector-vertical-sm"></div>
                                <div class="d-flex flex-column gap-2 mt-0">
                                    <div class="org-card-sub">
                                        <i class="bi bi-cash-coin text-success me-2"></i>
                                        <span>Bendahara Penerimaan Pembantu</span>
                                    </div>
                                    <div class="org-card-sub">
                                        <i class="bi bi-wallet2 text-primary me-2"></i>
                                        <span>Bendahara Pengeluaran Pembantu</span>
                                    </div>
                                    <div class="org-card-sub">
                                        <i class="bi bi-box-seam text-warning me-2"></i>
                                        <span>Pengurus Barang Pembantu</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Branch 2: Kepala Seksi Pelayanan Medik -->
                            <div class="org-branch flex-fill" style="max-width: 320px;">
                                <div class="org-connector-vertical-sm"></div>
                                <div class="org-card org-card-branch org-card-pelayanan">
                                    <div class="org-card-icon-sm"><i class="bi bi-heart-pulse-fill"></i></div>
                                    <div class="org-card-title">Kepala Seksi</div>
                                    <div class="org-card-subtitle">Pelayanan Medik dan Keperawatan</div>
                                </div>
                                <div class="org-connector-vertical-sm"></div>
                                <div class="d-flex flex-column gap-2 mt-0">
                                    <div class="org-card-sub">
                                        <i class="bi bi-hospital text-danger me-2"></i>
                                        <span>Unit Gawat Darurat (UGD)</span>
                                    </div>
                                    <div class="org-card-sub">
                                        <i class="bi bi-clipboard2-pulse text-info me-2"></i>
                                        <span>Rawat Jalan / Poliklinik</span>
                                    </div>
                                    <div class="org-card-sub">
                                        <i class="bi bi-bed text-secondary me-2"></i>
                                        <span>Rawat Inap</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Branch 3: Kepala Seksi Penunjang Medik -->
                            <div class="org-branch flex-fill" style="max-width: 320px;">
                                <div class="org-connector-vertical-sm"></div>
                                <div class="org-card org-card-branch org-card-penunjang">
                                    <div class="org-card-icon-sm"><i class="bi bi-gear-wide-connected"></i></div>
                                    <div class="org-card-title">Kepala Seksi</div>
                                    <div class="org-card-subtitle">Penunjang Medik dan Non Medik</div>
                                </div>
                                <div class="org-connector-vertical-sm"></div>
                                <div class="d-flex flex-column gap-2 mt-0">
                                    <div class="org-card-sub">
                                        <i class="bi bi-capsule text-success me-2"></i>
                                        <span>Instalasi Farmasi</span>
                                    </div>
                                    <div class="org-card-sub">
                                        <i class="bi bi-droplet-half text-danger me-2"></i>
                                        <span>Laboratorium</span>
                                    </div>
                                    <div class="org-card-sub">
                                        <i class="bi bi-truck text-warning me-2"></i>
                                        <span>Logistik & Sarana Prasarana</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Info -->
                    <div class="text-center mt-5 pt-4" style="border-top: 2px dashed #e2e8f0;">
                        <p class="text-muted small mb-1"><i class="bi bi-info-circle me-1"></i>Ditetapkan di Boroko, Tahun 2026</p>
                        <p class="fw-bold mb-0" style="color: #0f172a;">DIREKTUR BLUD UPTD RSUD BOLAANG MONGONDOW UTARA</p>
                        <p class="fw-bold" style="color: #0d9488;">drg. Firlia Mokoagow</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Org Chart CSS -->
    <style>
        .org-chart {
            position: relative;
        }
        .org-card-director {
            background: linear-gradient(135deg, #0f172a, #1e3a5f);
            color: white;
            border-radius: 20px;
            padding: 28px 40px;
            text-align: center;
            position: relative;
            box-shadow: 0 12px 40px rgba(15, 23, 42, 0.25);
            max-width: 340px;
            width: 100%;
        }
        .org-card-director .org-card-icon {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, #0d9488, #2dd4bf);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 6px 20px rgba(13, 148, 136, 0.35);
        }
        .org-card-director .org-card-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .org-card-director .org-card-subtitle {
            font-size: 0.85rem;
            opacity: 0.7;
            margin-bottom: 8px;
        }
        .org-card-director .org-card-name {
            font-size: 0.9rem;
            font-weight: 600;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 50px;
            padding: 6px 18px;
            display: inline-block;
            margin-top: 4px;
        }

        .org-connector-vertical {
            width: 3px;
            background: linear-gradient(180deg, #0f172a, #94a3b8);
            margin: 0 auto;
            border-radius: 4px;
        }
        .org-connector-vertical-sm {
            width: 2px;
            height: 24px;
            background: #cbd5e1;
            margin: 0 auto;
        }
        .org-connector-horizontal {
            height: 3px;
            background: linear-gradient(90deg, transparent 8%, #94a3b8 8%, #94a3b8 92%, transparent 92%);
            margin: 0 auto;
            max-width: 80%;
            border-radius: 4px;
        }

        .org-card-branch {
            background: white;
            border-radius: 16px;
            padding: 22px 20px;
            text-align: center;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
            position: relative;
        }
        .org-card-branch:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.1);
        }
        .org-card-branch .org-card-icon-sm {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 10px;
            font-size: 1.2rem;
            color: white;
        }
        .org-card-branch .org-card-title {
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f172a;
        }
        .org-card-branch .org-card-subtitle {
            font-size: 0.8rem;
            color: #64748b;
            line-height: 1.3;
        }

        .org-card-tata-usaha { border-color: #dbeafe; }
        .org-card-tata-usaha .org-card-icon-sm { background: linear-gradient(135deg, #3b82f6, #60a5fa); box-shadow: 0 4px 12px rgba(59,130,246,0.3); }
        .org-card-tata-usaha:hover { border-color: #93c5fd; }

        .org-card-pelayanan { border-color: #fce7f3; }
        .org-card-pelayanan .org-card-icon-sm { background: linear-gradient(135deg, #ec4899, #f472b6); box-shadow: 0 4px 12px rgba(236,72,153,0.3); }
        .org-card-pelayanan:hover { border-color: #f9a8d4; }

        .org-card-penunjang { border-color: #d1fae5; }
        .org-card-penunjang .org-card-icon-sm { background: linear-gradient(135deg, #10b981, #34d399); box-shadow: 0 4px 12px rgba(16,185,129,0.3); }
        .org-card-penunjang:hover { border-color: #6ee7b7; }

        .org-card-sub {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            font-weight: 500;
            color: #334155;
            transition: all 0.25s ease;
        }
        .org-card-sub:hover {
            background: #f0fdfa;
            border-color: #99f6e4;
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .org-card-sub i {
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        @media (max-width: 768px) {
            .org-connector-horizontal { display: none; }
            .org-card-director { padding: 20px 24px; }
            .org-level { gap: 12px !important; }
        }
    </style>

    <!-- Modal PPID -->
    <div class="modal fade" id="modalPPID" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 20px; overflow: hidden;">
                <div class="modal-header border-0" style="background: linear-gradient(135deg, #0f172a, #1e3a5f); padding: 24px 30px;">
                    <h5 class="modal-title text-white fw-bold"><i class="bi bi-file-earmark-text me-2"></i>PPID (Pejabat Pengelola Informasi & Dokumentasi)</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert border-0 mb-4" style="background: #f0fdfa; color: #0d9488; border-radius: 14px;">
                        <i class="bi bi-info-circle-fill me-2"></i> PPID RSUD Bolmong Utara bertugas mengelola dan menyediakan informasi publik sesuai UU No. 14 Tahun 2008.
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div style="background: #f8fafc; border-radius: 14px; padding: 20px;">
                                <h6 class="fw-bold mb-2"><i class="bi bi-folder-check text-primary me-2"></i>Informasi Berkala</h6>
                                <ul class="text-muted small mb-0" style="padding-left: 18px;">
                                    <li>Profil rumah sakit</li>
                                    <li>Laporan keuangan tahunan</li>
                                    <li>Rencana kerja</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="background: #f8fafc; border-radius: 14px; padding: 20px;">
                                <h6 class="fw-bold mb-2"><i class="bi bi-clock-history text-primary me-2"></i>Informasi Serta-Merta</h6>
                                <ul class="text-muted small mb-0" style="padding-left: 18px;">
                                    <li>Informasi darurat</li>
                                    <li>Ketersediaan tempat tidur</li>
                                    <li>Pengumuman penting</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 p-3 rounded-3" style="background: #fffbeb; border: 1px solid #fde68a;">
                        <p class="mb-0 small"><i class="bi bi-envelope-fill text-warning me-2"></i><strong>Permintaan Informasi:</strong> Hubungi PPID RSUD Bolmong Utara melalui email <strong>{{ $settings['contact_email'] ?? 'febyantolumoto9@gmail.com' }}</strong> atau datang langsung ke lobi informasi RSUD.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal SPO -->
    <div class="modal fade" id="modalSPO" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 20px; overflow: hidden;">
                <div class="modal-header border-0" style="background: linear-gradient(135deg, #0f172a, #1e3a5f); padding: 24px 30px;">
                    <h5 class="modal-title text-white fw-bold"><i class="bi bi-card-checklist me-2"></i>SPO (Standar Prosedur Operasional)</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted mb-4">Standar Prosedur Operasional RSUD Bolmong Utara disusun berdasarkan pedoman Kementerian Kesehatan RI untuk menjamin mutu pelayanan.</p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3 p-3" style="background: #f8fafc; border-radius: 14px;">
                                <div style="width: 40px; height: 40px; border-radius: 10px; background: #dbeafe; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="bi bi-clipboard2-pulse text-primary"></i></div>
                                <div><h6 class="fw-bold mb-1">SPO Pelayanan Medis</h6><small class="text-muted">Prosedur rawat jalan, rawat inap, dan IGD</small></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3 p-3" style="background: #f8fafc; border-radius: 14px;">
                                <div style="width: 40px; height: 40px; border-radius: 10px; background: #d1fae5; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="bi bi-heart-pulse text-success"></i></div>
                                <div><h6 class="fw-bold mb-1">SPO Keperawatan</h6><small class="text-muted">Asuhan keperawatan & monitoring pasien</small></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3 p-3" style="background: #f8fafc; border-radius: 14px;">
                                <div style="width: 40px; height: 40px; border-radius: 10px; background: #fef3c7; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="bi bi-capsule text-warning"></i></div>
                                <div><h6 class="fw-bold mb-1">SPO Farmasi</h6><small class="text-muted">Penyimpanan, distribusi, & pelayanan obat</small></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3 p-3" style="background: #f8fafc; border-radius: 14px;">
                                <div style="width: 40px; height: 40px; border-radius: 10px; background: #fce7f3; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="bi bi-shield-check" style="color: #ec4899;"></i></div>
                                <div><h6 class="fw-bold mb-1">SPO Keselamatan Pasien</h6><small class="text-muted">Patient safety & pengendalian infeksi</small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tarif -->
    <div class="modal fade" id="modalTarif" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 20px; overflow: hidden;">
                <div class="modal-header border-0" style="background: linear-gradient(135deg, #0f172a, #1e3a5f); padding: 24px 30px;">
                    <h5 class="modal-title text-white fw-bold"><i class="bi bi-cash-stack me-2"></i>Tarif Layanan Rumah Sakit</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert border-0 mb-4" style="background: #f0fdfa; color: #0d9488; border-radius: 14px;">
                        <i class="bi bi-info-circle-fill me-2"></i> Tarif berdasarkan Peraturan Bupati Bolaang Mongondow Utara. Pasien BPJS tidak dikenakan biaya tambahan.
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" style="border-radius: 12px; overflow: hidden;">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th class="fw-bold" style="padding: 14px 16px;">Jenis Layanan</th>
                                    <th class="fw-bold text-end" style="padding: 14px 16px;">Tarif (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td style="padding: 12px 16px;">Konsultasi Dokter Umum</td><td class="text-end fw-semibold" style="padding: 12px 16px;">50.000</td></tr>
                                <tr><td style="padding: 12px 16px;">Konsultasi Dokter Spesialis</td><td class="text-end fw-semibold" style="padding: 12px 16px;">100.000 - 150.000</td></tr>
                                <tr><td style="padding: 12px 16px;">IGD (Tindakan Darurat)</td><td class="text-end fw-semibold" style="padding: 12px 16px;">150.000 - 500.000</td></tr>
                                <tr><td style="padding: 12px 16px;">Rawat Inap Kelas III</td><td class="text-end fw-semibold" style="padding: 12px 16px;">150.000/hari</td></tr>
                                <tr><td style="padding: 12px 16px;">Rawat Inap Kelas II</td><td class="text-end fw-semibold" style="padding: 12px 16px;">250.000/hari</td></tr>
                                <tr><td style="padding: 12px 16px;">Rawat Inap Kelas I</td><td class="text-end fw-semibold" style="padding: 12px 16px;">350.000/hari</td></tr>
                                <tr><td style="padding: 12px 16px;">Rawat Inap VIP</td><td class="text-end fw-semibold" style="padding: 12px 16px;">500.000/hari</td></tr>
                                <tr><td style="padding: 12px 16px;">Laboratorium (Paket Dasar)</td><td class="text-end fw-semibold" style="padding: 12px 16px;">75.000 - 200.000</td></tr>
                                <tr><td style="padding: 12px 16px;">Radiologi (Rontgen)</td><td class="text-end fw-semibold" style="padding: 12px 16px;">100.000 - 300.000</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-muted small mt-3 mb-0"><i class="bi bi-exclamation-triangle me-1"></i> Tarif di atas bersifat indikatif dan dapat berubah sewaktu-waktu. Hubungi bagian informasi RSUD untuk tarif terbaru.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chatbot Widget Component -->
    <x-chatbot-widget />
    <!-- Sienna Accessibility Widget -->
    <script src="https://cdn.jsdelivr.net/npm/sienna-accessibility/dist/sienna-accessibility.umd.js" defer></script>
</body>
</html>
