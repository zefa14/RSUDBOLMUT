<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — SIRS RSUD</title>
    <meta name="description" content="Daftar akun baru di Sistem Informasi Rumah Sakit RSUD">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0a1628 0%, #0d3b6e 40%, #0f5498 70%, #1a73c2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 30px 0;
        }

        .bg-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.12;
            animation: floatBlob 8s ease-in-out infinite;
        }

        .bg-blob-1 { width: 400px; height: 400px; background: #4fc3f7; top: -100px; left: -100px; }
        .bg-blob-2 { width: 350px; height: 350px; background: #0d6efd; bottom: -80px; right: -50px; animation-delay: 3s; }

        @keyframes floatBlob {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .register-card {
            background: rgba(255,255,255,0.97);
            border-radius: 24px;
            padding: 48px 44px;
            width: 520px;
            max-width: 95vw;
            box-shadow: 0 40px 80px rgba(0,0,0,0.35);
            position: relative;
            z-index: 10;
        }

        .register-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .register-logo {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #0d6efd, #0b3d91);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
            margin: 0 auto 16px;
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
        }

        .register-header h4 {
            font-size: 24px;
            font-weight: 800;
            color: #0f1923;
            margin-bottom: 4px;
        }

        .register-header p {
            color: #6c757d;
            font-size: 14px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .input-group-modern {
            position: relative;
            margin-bottom: 18px;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 15px;
            z-index: 2;
            pointer-events: none;
        }

        .form-control-modern {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: #1f2937;
            background: #f9fafb;
            transition: all 0.2s;
            outline: none;
        }

        .form-control-modern:focus {
            border-color: #0d6efd;
            background: white;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        }

        .form-control-modern.is-invalid {
            border-color: #dc3545;
            background: #fff8f8;
        }

        .form-control-modern::placeholder { color: #9ca3af; }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            cursor: pointer;
            z-index: 2;
            font-size: 15px;
            border: none;
            background: none;
            padding: 0;
            transition: color 0.2s;
        }

        .password-toggle:hover { color: #0d6efd; }

        .error-msg {
            font-size: 12px;
            color: #dc3545;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .btn-register {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #0d6efd, #0b3d91);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 4px;
        }

        .btn-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.4);
        }

        .password-strength {
            margin-top: 6px;
        }

        .strength-bar {
            height: 3px;
            border-radius: 2px;
            background: #e5e7eb;
            overflow: hidden;
            margin-bottom: 4px;
        }

        .strength-fill {
            height: 100%;
            border-radius: 2px;
            transition: all 0.3s;
            width: 0%;
        }

        .strength-text {
            font-size: 11px;
            font-weight: 500;
        }

        .login-link {
            text-align: center;
            font-size: 13px;
            color: #6c757d;
            margin-top: 20px;
        }

        .login-link a {
            color: #0d6efd;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover { text-decoration: underline; }

        .info-note {
            background: #f0f7ff;
            border: 1px solid #bfdbfe;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 12px;
            color: #1e40af;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }
    </style>
</head>
<body>

    <div class="bg-blob bg-blob-1"></div>
    <div class="bg-blob bg-blob-2"></div>

    <div class="register-card">
        <div class="register-header">
            <div class="register-logo">
                <i class="bi bi-hospital-fill"></i>
            </div>
            <h4>Buat Akun Baru</h4>
            <p>Daftar untuk mengakses Sistem Informasi RS</p>
        </div>

        {{-- Info note --}}
        <div class="info-note">
            <i class="bi bi-info-circle-fill" style="margin-top: 1px; flex-shrink: 0;"></i>
            <span>Akun baru akan mendapatkan role <strong>Petugas</strong> secara default. Hubungi Admin untuk perubahan role.</span>
        </div>

        {{-- Error alert --}}
        @if ($errors->any())
            <div style="background: #fff5f5; border-left: 3px solid #fc8181; border-radius: 10px; padding: 10px 14px; font-size: 13px; color: #c53030; margin-bottom: 16px;">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                Mohon periksa kembali data yang Anda isi.
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            {{-- Nama Lengkap --}}
            <label class="form-label">Nama Lengkap <span style="color:#dc3545">*</span></label>
            <div class="input-group-modern">
                <i class="bi bi-person-fill input-icon"></i>
                <input type="text" name="name" class="form-control-modern {{ $errors->has('name') ? 'is-invalid' : '' }}"
                    placeholder="Nama lengkap Anda" value="{{ old('name') }}" required>
            </div>
            @error('name')
                <div class="error-msg"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
            @enderror

            {{-- Email --}}
            <label class="form-label">Alamat Email <span style="color:#dc3545">*</span></label>
            <div class="input-group-modern">
                <i class="bi bi-envelope-fill input-icon"></i>
                <input type="email" name="email" class="form-control-modern {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    placeholder="nama@email.com" value="{{ old('email') }}" required>
            </div>
            @error('email')
                <div class="error-msg"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
            @enderror

            {{-- Nomor HP --}}
            <label class="form-label">Nomor Telepon</label>
            <div class="input-group-modern">
                <i class="bi bi-telephone-fill input-icon"></i>
                <input type="text" name="phone" class="form-control-modern"
                    placeholder="08xxxxxxxxxx" value="{{ old('phone') }}">
            </div>

            {{-- Password --}}
            <label class="form-label">Password <span style="color:#dc3545">*</span></label>
            <div class="input-group-modern" style="margin-bottom: 6px;">
                <i class="bi bi-lock-fill input-icon"></i>
                <input type="password" name="password" id="password" class="form-control-modern {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="Minimal 8 karakter" style="padding-right: 44px;" required oninput="checkStrength(this.value)">
                <button type="button" class="password-toggle" onclick="togglePass('password', this)">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            <div class="password-strength">
                <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                <span class="strength-text" id="strengthText" style="color: #9ca3af;">Masukkan password</span>
            </div>
            @error('password')
                <div class="error-msg" style="margin-top: 6px;"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
            @enderror

            {{-- Konfirmasi Password --}}
            <label class="form-label" style="margin-top: 14px;">Konfirmasi Password <span style="color:#dc3545">*</span></label>
            <div class="input-group-modern">
                <i class="bi bi-lock-fill input-icon"></i>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="form-control-modern" placeholder="Ulangi password" style="padding-right: 44px;" required>
                <button type="button" class="password-toggle" onclick="togglePass('password_confirmation', this)">
                    <i class="bi bi-eye"></i>
                </button>
            </div>

            <button type="submit" class="btn-register">
                <i class="bi bi-person-plus-fill me-2"></i>Buat Akun
            </button>
        </form>

        <p class="login-link">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk Sekarang</a>
        </p>
    </div>

    <script>
        function togglePass(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon  = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }

        function checkStrength(val) {
            const fill = document.getElementById('strengthFill');
            const text = document.getElementById('strengthText');

            let score  = 0;
            if (val.length >= 8)  score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const levels = [
                { pct: '0%',   color: '#e5e7eb', label: 'Masukkan password',  textColor: '#9ca3af' },
                { pct: '25%',  color: '#ef4444', label: 'Lemah',              textColor: '#ef4444' },
                { pct: '50%',  color: '#f59e0b', label: 'Sedang',             textColor: '#f59e0b' },
                { pct: '75%',  color: '#3b82f6', label: 'Kuat',               textColor: '#3b82f6' },
                { pct: '100%', color: '#10b981', label: 'Sangat Kuat ✓',      textColor: '#10b981' },
            ];

            const level = val.length === 0 ? 0 : score;
            fill.style.width      = levels[level].pct;
            fill.style.background = levels[level].color;
            text.textContent      = levels[level].label;
            text.style.color      = levels[level].textColor;
        }
    </script>

</body>
</html>
