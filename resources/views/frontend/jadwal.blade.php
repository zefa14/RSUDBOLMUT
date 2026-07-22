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

        /* â”€â”€â”€ NAVBAR â”€â”€â”€ */
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

        /* â”€â”€â”€ HERO â”€â”€â”€ */
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

        /* â”€â”€â”€ QUICK LINKS â”€â”€â”€ */
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

        /* â”€â”€â”€ SECTIONS â”€â”€â”€ */
        .section-header { text-align: center; margin-bottom: 50px; }
        .section-subtitle { color: var(--primary); font-weight: 700; text-transform: uppercase; letter-spacing: 2px; font-size: 0.8rem; margin-bottom: 10px; display: block; }
        .section-title { font-weight: 800; font-size: 2.4rem; color: var(--dark); letter-spacing: -0.5px; }

        .welcome-section { padding: 90px 0; background: white; }
        .img-overlap { border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); position: relative; z-index: 2; width: 100%; border: 8px solid white; }
        .decor-box { position: absolute; top: -15px; right: 10px; width: 100%; height: 100%; border: 2px dashed var(--primary); border-radius: var(--radius-lg); z-index: 1; opacity: 0.4; }

        /* â”€â”€â”€ BED â”€â”€â”€ */
        .bed-section { padding: 90px 0; background: var(--dark); position: relative; overflow: hidden; }
        .bed-section::before { content: ''; position: absolute; width: 100%; height: 100%; background: radial-gradient(circle at 20% 50%, rgba(13,148,136,0.08) 0%, transparent 50%); }
        .bed-card {
            background: rgba(255,255,255,0.04); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08);
            border-radius: var(--radius); padding: 28px 20px; text-align: center; transition: 0.3s;
        }
        .bed-card:hover { transform: translateY(-6px); background: rgba(255,255,255,0.08); }
        .bed-number { font-size: 3rem; font-weight: 900; background: linear-gradient(135deg, #fff 0%, #94a3b8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; line-height: 1; margin: 12px 0; }
        .glow-green { box-shadow: 0 0 20px rgba(13, 148, 136, 0.15); border-color: rgba(13, 148, 136, 0.25); }
        .glow-red { box-shadow: 0 0 20px rgba(239, 68, 68, 0.15); border-color: rgba(239, 68, 68, 0.25); }

        /* â”€â”€â”€ DOCTORS â”€â”€â”€ */
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

        /* â”€â”€â”€ SEARCH & FILTER â”€â”€â”€ */
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

        /* â”€â”€â”€ ARTICLES â”€â”€â”€ */
        .article-card { background: white; border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--border); box-shadow: var(--shadow-sm); transition: 0.35s; height: 100%; display: flex; flex-direction: column; }
        .article-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }
        .article-img { width: 100%; height: 200px; object-fit: cover; }
        .article-content { padding: 24px; flex: 1; display: flex; flex-direction: column; }
        .article-date { font-size: 0.8rem; color: var(--primary); font-weight: 600; margin-bottom: 8px; display: block; }
        .article-title { font-weight: 700; color: var(--dark); margin-bottom: 12px; font-size: 1.05rem; line-height: 1.5; }
        .article-link { color: var(--primary); font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 5px; margin-top: auto; font-size: 0.9rem; }
        .article-link:hover { gap: 10px; }

        /* â”€â”€â”€ PARTNERS â”€â”€â”€ */
        .partner-scroll { overflow: hidden; white-space: nowrap; padding: 35px 0; border-top: 1px solid var(--border); background: white; }
        .partner-scroll-inner { display: inline-block; animation: scroll 25s linear infinite; }
        .partner-scroll h5 { display: inline; margin: 0 40px; font-weight: 700; color: #cbd5e1; font-size: 1rem; transition: 0.3s; }
        .partner-scroll h5:hover { color: var(--primary); }
        @keyframes scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

        /* â”€â”€â”€ FOOTER â”€â”€â”€ */
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

        /* â”€â”€â”€ RESPONSIVE â”€â”€â”€ */
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
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#hero-top">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('frontend.about') }}">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('frontend.galeri') }}">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('frontend.jadwal') }}">Jadwal</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="infoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Informasi
                        </a>
                        <ul class="dropdown-menu shadow-sm" aria-labelledby="infoDropdown">
                            <li><a class="dropdown-item" href="{{ route('frontend.doctors') }}">Tim Dokter</a></li>
                            <li><a class="dropdown-item" href="{{ url('/') }}#kamar">Fasilitas Kamar</a></li>
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
                    <a href="{{ url('/') }}#kontak" class="btn btn-portal"><i class="bi bi-telephone-fill me-1"></i> Hubungi Kami</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Jadwal Poliklinik -->
    <section id="jadwal" class="welcome-section" style="background: var(--light); padding-top: 140px;">
        <div class="container" data-aos="fade-up">
            <div class="section-header text-center">
                <span class="fw-bold text-uppercase" style="color: #0d9488; font-size: 0.85rem; letter-spacing: 1px;">RSUD MARIA WALANDA MARAMIS</span>
                <h2 class="section-title mt-2 mb-2">Jadwal Pelayanan Poliklinik</h2>
                <div style="width: 60px; height: 3px; background-color: #0d9488; margin: 15px auto;"></div>
            </div>
            
            <!-- Filter Section -->
            <div class="d-flex flex-wrap align-items-center justify-content-between p-3 bg-white rounded-4 shadow-sm mb-5 border border-light">
                <div class="position-relative flex-grow-1 me-lg-4 mb-3 mb-lg-0" style="max-width: 400px;">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" id="searchJadwal" class="form-control border-0 bg-light ps-5 py-2 rounded-pill" placeholder="Cari nama dokter atau poliklinik..." style="font-size: 0.95rem;">
                </div>
                <div class="d-flex flex-wrap gap-2" id="dayFilterContainer">
                    <button class="btn px-4 py-2 rounded-pill fw-bold text-white shadow-sm filter-day-btn active" data-day="Semua" style="background-color: #0d9488; font-size: 0.9rem;">Semua</button>
                    <button class="btn px-4 py-2 rounded-pill fw-bold text-dark border-0 filter-day-btn" data-day="Senin" style="background-color: #f1f5f9; font-size: 0.9rem;">Senin</button>
                    <button class="btn px-4 py-2 rounded-pill fw-bold text-dark border-0 filter-day-btn" data-day="Selasa" style="background-color: #f1f5f9; font-size: 0.9rem;">Selasa</button>
                    <button class="btn px-4 py-2 rounded-pill fw-bold text-dark border-0 filter-day-btn" data-day="Rabu" style="background-color: #f1f5f9; font-size: 0.9rem;">Rabu</button>
                    <button class="btn px-4 py-2 rounded-pill fw-bold text-dark border-0 filter-day-btn" data-day="Kamis" style="background-color: #f1f5f9; font-size: 0.9rem;">Kamis</button>
                    <button class="btn px-4 py-2 rounded-pill fw-bold text-dark border-0 filter-day-btn" data-day="Jumat" style="background-color: #f1f5f9; font-size: 0.9rem;">Jumat</button>
                    <button class="btn px-4 py-2 rounded-pill fw-bold text-dark border-0 filter-day-btn" data-day="Sabtu" style="background-color: #f1f5f9; font-size: 0.9rem;">Sabtu</button>
                </div>
            </div>

            <div class="row g-4" id="jadwalContainer">
                @forelse($doctors as $doctor)
                <div class="col-lg-4 col-md-6 jadwal-card">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-4" style="transition: all 0.3s ease; cursor: pointer; border: 1px solid rgba(0,0,0,0.03) !important;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.06)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)';">
                        <div class="d-flex align-items-start mb-4">
                            <div class="me-3">
                                <div style="width: 50px; height: 50px; border-radius: 50%; background-color: #f0fdfa; color: #0d9488; display: flex; align-items: center; justify-content: center; border: 2px solid #ccfbf1;">
                                    <i class="bi bi-stethoscope fs-4"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1" style="font-size: 1.05rem; color: #0f172a; line-height: 1.4;">{{ $doctor->name }}</h5>
                                <span class="fw-bold" style="color: #0d9488; font-size: 0.75rem; text-transform: uppercase;">{{ $doctor->department->name ?? 'POLI UMUM' }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-auto">
                            <span class="text-muted fw-bold d-block mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">JADWAL PRAKTEK</span>
                            @forelse($doctor->schedules as $schedule)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $schedule->day_name }}</span>
                                <span class="text-muted" style="font-size: 0.9rem;">{{ $schedule->time_range }}</span>
                            </div>
                            @empty
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="text-muted small fst-italic">Jadwal belum tersedia</span>
                            </div>
                            @endforelse
                            <div class="mb-4"></div>
                            
                            @php
                                $deptName = strtolower($doctor->department->name ?? '');
                                $isNonBooking = in_array($deptName, ['ugd', 'kamar operasi (ok)']);
                            @endphp

                            @if(!$isNonBooking)
                            <div class="text-center mt-3 pt-3" style="border-top: 1px solid rgba(0,0,0,0.05);">
                                <a href="{{ route('frontend.register') }}" class="fw-bold text-decoration-none" style="color: #0d9488; font-size: 0.95rem;">Buat Janji Temu <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                            @else
                            <div class="text-center mt-3 pt-3" style="border-top: 1px solid rgba(0,0,0,0.05);">
                                <span class="fw-bold text-danger" style="font-size: 0.95rem;"><i class="bi bi-info-circle me-1"></i> Layanan Khusus (Tanpa Janji)</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center text-muted py-4">Data dokter belum tersedia.</div>
                @endforelse
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
                        <a href="{{ url('/') }}#profil">Tentang Kami</a>
                        <a href="{{ url('/') }}#layanan">Layanan Medis</a>
                        <a href="{{ route('frontend.jadwal') }}">Jadwal Dokter</a>
                        <a href="{{ url('/') }}#kamar">Informasi Kamar</a>
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

            // Handle URL parameters from Homepage search widget
            const urlParams = new URLSearchParams(window.location.search);
            const searchParam = urlParams.get('search');
            const poliParam = urlParams.get('poli');
            
            if(searchParam || poliParam) {
                currentSearch = ((searchParam || '') + " " + (poliParam || '')).trim().toLowerCase();
                if(searchInput) searchInput.value = currentSearch;
                filterJadwal();
            }
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
                        <p class="text-white-50 mb-0 small">BLUD UPTD RSUD Bolaang Mongondow Utara â€” Tahun 2026</p>
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
