<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RSUD - Sistem Informasi Layanan Rumah Sakit</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8fafc;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #0f766e 0%, #064e3b 100%);
            color: white;
            padding: 100px 0;
            border-bottom-left-radius: 40px;
            border-bottom-right-radius: 40px;
            margin-bottom: 40px;
        }

        .hero-title {
            font-weight: 800;
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .bg-teal-light { background: #ccfbf1; color: #0f766e; }
        .bg-blue-light { background: #dbeafe; color: #1d4ed8; }
        .bg-orange-light { background: #ffedd5; color: #c2410c; }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-teal" href="/" style="color: #0f766e;">
                <i class="bi bi-hospital-fill me-2"></i>RSUD Bolmong Utara
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="#">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="#">Jadwal Dokter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="#">Fasilitas</a>
                    </li>
                    @auth
                        <li class="nav-item ms-3">
                            <a class="btn btn-primary rounded-pill px-4" style="background-color: #0f766e; border: none;" href="{{ route('home') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item ms-3">
                            <a class="btn btn-outline-primary rounded-pill px-4" style="color: #0f766e; border-color: #0f766e;" href="{{ route('login') }}">Login Portal</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="hero-title">Kesehatan Anda, Prioritas Kami</h1>
            <p class="lead mb-5 opacity-75 max-w-2xl mx-auto">Kami memberikan layanan kesehatan terbaik dengan fasilitas modern, tenaga medis profesional, dan sistem pendaftaran yang mudah. Tanyakan jadwal dokter dan kamar melalui AI Asisten kami!</p>
            
            <a href="#" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-teal" style="color: #0f766e;">
                <i class="bi bi-calendar2-check me-2"></i>Pendaftaran Online
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="container mb-5 pb-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon-box bg-teal-light">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Dokter Spesialis</h4>
                    <p class="text-muted mb-0">Didukung oleh tenaga medis spesialis yang berpengalaman dan tersertifikasi di bidangnya masing-masing.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon-box bg-blue-light">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Fasilitas Modern</h4>
                    <p class="text-muted mb-0">Dilengkapi dengan peralatan medis berteknologi terkini untuk menunjang diagnosa yang akurat.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon-box bg-orange-light">
                        <i class="bi bi-robot"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Asisten Cerdas 24/7</h4>
                    <p class="text-muted mb-0">Tanyakan jadwal dokter dan ketersediaan kamar secara real-time kapan saja melalui Chatbot kami.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Location / Map Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-teal" style="color: #0f766e;">Lokasi Kami</h2>
                <p class="text-muted">Kunjungi Rumah Sakit Umum Daerah Bolaang Mongondow Utara</p>
            </div>
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
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
            <div class="row mt-4 text-center">
                <div class="col-md-4 mb-3">
                    <div class="d-flex flex-column align-items-center">
                        <div class="icon-box bg-teal-light mb-2 mx-auto" style="width: 50px; height: 50px; font-size: 20px;">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <h6 class="fw-bold mb-1">Alamat</h6>
                        <p class="text-muted small mb-0">Kabupaten Bolaang Mongondow Utara,<br>Sulawesi Utara, Indonesia</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="d-flex flex-column align-items-center">
                        <div class="icon-box bg-blue-light mb-2 mx-auto" style="width: 50px; height: 50px; font-size: 20px;">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <h6 class="fw-bold mb-1">Kontak</h6>
                        <p class="text-muted small mb-0">(0434) 1234567<br>info@rsud-bolmut.go.id</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="d-flex flex-column align-items-center">
                        <div class="icon-box bg-orange-light mb-2 mx-auto" style="width: 50px; height: 50px; font-size: 20px;">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                        <h6 class="fw-bold mb-1">Jam Operasional</h6>
                        <p class="text-muted small mb-0">IGD 24 Jam<br>Poliklinik: Senin - Sabtu (08.00 - 14.00)</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white py-4 border-top text-center text-muted">
        <div class="container">
            <small>&copy; 2026 RSUD Bolmong Utara - Powered by Antigravity SIRS</small>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- INJECT CHATBOT WIDGET COMPONENT HERE -->
    <x-chatbot-widget />

</body>
</html>
