<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — RSUD Bolmut</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e8f0f2;
            overflow: hidden;
            position: relative;
        }

        /* Hospital themed animated background */
        .bg-scene {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: 0;
            background: linear-gradient(170deg, #e0f2f1 0%, #e8f5e9 40%, #e3f2fd 100%);
            overflow: hidden;
        }

        /* Floating medical icons */
        .bg-scene .float-icon {
            position: absolute;
            color: rgba(0, 95, 115, 0.06);
            font-size: 2.5rem;
            animation: floatUp linear infinite;
        }

        @keyframes floatUp {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% {
                transform: translateY(-10vh) rotate(30deg);
                opacity: 0;
            }
        }

        /* Subtle pulse circles */
        .pulse-circle {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(10, 147, 150, 0.08);
            animation: pulse 6s ease-in-out infinite;
        }

        .pulse-circle:nth-child(1) {
            width: 400px; height: 400px;
            top: 10%; left: -5%;
            animation-delay: 0s;
        }

        .pulse-circle:nth-child(2) {
            width: 300px; height: 300px;
            bottom: 5%; right: -3%;
            animation-delay: 2s;
        }

        .pulse-circle:nth-child(3) {
            width: 200px; height: 200px;
            top: 50%; left: 60%;
            animation-delay: 4s;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.4; }
            50% { transform: scale(1.15); opacity: 0.8; }
        }

        /* Heartbeat line */
        .heartbeat-line {
            position: absolute;
            bottom: 15%;
            left: 0;
            width: 200%;
            height: 80px;
            opacity: 0.04;
            animation: slideLeft 12s linear infinite;
        }

        @keyframes slideLeft {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Login card */
        .login-card {
            position: relative;
            z-index: 10;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 440px;
            padding: 2.5rem;
            margin: 0 1rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header img {
            height: 52px;
            margin-bottom: 14px;
        }

        .login-header h1 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .login-header p {
            font-size: 0.82rem;
            color: #64748b;
        }

        .form-label {
            font-size: 0.82rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 5px;
        }

        .form-control {
            padding: 0.65rem 0.85rem;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            font-size: 0.88rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: #0a9396;
            box-shadow: 0 0 0 3px rgba(10, 147, 150, 0.1);
        }

        .btn-login {
            background: #0a9396;
            border: none;
            border-radius: 10px;
            padding: 0.65rem;
            font-weight: 600;
            font-size: 0.92rem;
            color: white;
            width: 100%;
            transition: background 0.2s;
        }

        .btn-login:hover {
            background: #005f73;
            color: white;
        }

        .form-check-input:checked {
            background-color: #0a9396;
            border-color: #0a9396;
        }

        .demo-box {
            background: #f0fdfa;
            border: 1px solid #ccfbf1;
            border-radius: 8px;
            padding: 0.7rem;
            margin-top: 1.25rem;
            font-size: 0.78rem;
            color: #0f766e;
            text-align: center;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            border-radius: 10px;
            padding: 0.65rem 0.85rem;
            font-size: 0.82rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .divider {
            height: 1px;
            background: #e2e8f0;
            margin: 1.5rem 0;
        }

        @media (max-width: 480px) {
            .login-card { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>

    <!-- Animated background -->
    <div class="bg-scene">
        <!-- Pulse circles -->
        <div class="pulse-circle"></div>
        <div class="pulse-circle"></div>
        <div class="pulse-circle"></div>

        <!-- Heartbeat line -->
        <svg class="heartbeat-line" viewBox="0 0 1200 80" preserveAspectRatio="none">
            <polyline fill="none" stroke="#0a9396" stroke-width="2"
                points="0,40 50,40 60,40 70,10 80,70 90,40 100,40 150,40 200,40 210,40 220,10 230,70 240,40 250,40 300,40 350,40 360,40 370,10 380,70 390,40 400,40 450,40 500,40 510,40 520,10 530,70 540,40 550,40 600,40" />
        </svg>

        <!-- Floating medical icons (generated by JS) -->
    </div>

    <!-- Login Card -->
    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('img/logo-rsud.jpg') }}" alt="Logo RSUD">
            <h1>RSUD Bolmut</h1>
            <p>Sistem Informasi Rumah Sakit</p>
        </div>

        @if($errors->any())
            <div class="alert-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <div class="input-group">
                    <span class="input-group-text" style="border-radius: 10px 0 0 10px; background: #f8fafc; border-color: #d1d5db; color: #94a3b8;"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" id="email" placeholder="nama@rsud.com" value="{{ old('email') }}" required style="border-radius: 0 10px 10px 0;">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text" style="border-radius: 10px 0 0 10px; background: #f8fafc; border-color: #d1d5db; color: #94a3b8;"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan kata sandi" required style="border-radius: 0 10px 10px 0;">
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                    <label class="form-check-label" for="rememberMe" style="font-size: 0.82rem; color: #64748b;">Ingat sesi saya</label>
                </div>
                <a href="#" onclick="showForgotPasswordAlert(event)" style="font-size: 0.82rem; color: #0a9396; text-decoration: none; font-weight: 500;">Lupa Sandi?</a>
            </div>

            <button class="btn btn-login" type="submit">
                Masuk ke Dashboard
            </button>
        </form>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showForgotPasswordAlert(e) {
        e.preventDefault();
        Swal.fire({
            icon: 'info',
            title: 'Lupa Kata Sandi?',
            text: 'Untuk keamanan data medis, pengaturan ulang kata sandi dilakukan secara internal. Silakan hubungi Tim IT di Ext. 123 atau datang ke ruang IT.',
            confirmButtonColor: '#0a9396',
            confirmButtonText: 'Tutup'
        });
    }

    // Generate floating medical icons
    const icons = ['bi-heart-pulse', 'bi-capsule', 'bi-bandaid', 'bi-clipboard2-pulse', 'bi-hospital', 'bi-lungs', 'bi-thermometer-half', 'bi-droplet', 'bi-activity'];
    const scene = document.querySelector('.bg-scene');

    for (let i = 0; i < 18; i++) {
        const el = document.createElement('i');
        const icon = icons[Math.floor(Math.random() * icons.length)];
        el.className = `bi ${icon} float-icon`;
        el.style.left = Math.random() * 100 + '%';
        el.style.fontSize = (1.5 + Math.random() * 2) + 'rem';
        el.style.animationDuration = (15 + Math.random() * 20) + 's';
        el.style.animationDelay = -(Math.random() * 30) + 's';
        scene.appendChild(el);
    }
</script>
</body>
</html>
