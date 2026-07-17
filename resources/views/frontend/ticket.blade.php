<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Antrean - RSUD</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --rsud-blue: #0066cc;
            --rsud-dark: #003d7a;
            --rsud-gold: #00a65a;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: #f4f7f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .ticket-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
            position: relative;
        }

        .ticket-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 8px;
            background: var(--rsud-gold);
        }

        .ticket-header {
            text-align: center;
            padding: 30px 20px 20px;
            border-bottom: 2px dashed #eee;
        }

        .ticket-header img {
            width: 60px;
            margin-bottom: 10px;
        }

        .ticket-body {
            padding: 30px;
            text-align: center;
        }

        .queue-number {
            font-size: 5rem;
            font-weight: 900;
            color: var(--rsud-dark);
            line-height: 1;
            margin: 20px 0;
            text-shadow: 2px 2px 0px rgba(0,0,0,0.05);
        }

        .info-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            text-align: left;
            margin-top: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }
        .info-row:last-child { margin-bottom: 0; }
        .info-label { color: #666; }
        .info-value { font-weight: 700; color: #333; }

        .btn-action {
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
        }
    </style>
</head>
<body>

    <div class="ticket-card">
        <div class="ticket-header">
            <div style="width: 50px; height: 50px; background: var(--rsud-blue); border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-check-lg text-white fs-2"></i>
            </div>
            <h4 class="fw-bold mb-1">Pendaftaran Berhasil!</h4>
            <p class="text-muted mb-0 small">Tiket Antrean Digital RSUD Kota Kita</p>
        </div>

        <div class="ticket-body">
            <h6 class="text-uppercase fw-bold text-muted letter-spacing">Nomor Antrean Anda</h6>
            <div class="queue-number">{{ $registration->queue_number }}</div>
            
            <div class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill mb-4 border border-success border-opacity-25">
                <i class="bi bi-calendar2-check me-1"></i> {{ \Carbon\Carbon::parse($registration->registration_date)->translatedFormat('l, d F Y') }}
            </div>

            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">Nama Pasien</span>
                    <span class="info-value">{{ $registration->patient->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Nomor RM</span>
                    <span class="info-value">{{ $registration->patient->patient_code }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Poliklinik</span>
                    <span class="info-value text-primary">{{ $registration->department->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Dokter</span>
                    <span class="info-value">{{ $registration->doctor->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Metode Bayar</span>
                    <span class="info-value">{{ $registration->payment_method }}</span>
                </div>
            </div>

            <div class="alert alert-warning mt-4 small text-start rounded-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Perhatian:</strong> Harap tunjukkan layar ini (Screenshot) kepada petugas admisi minimal 30 menit sebelum jadwal praktek dokter dimulai.
            </div>

            <div class="d-flex gap-2 mt-4">
                <button onclick="window.print()" class="btn btn-outline-secondary w-50 btn-action"><i class="bi bi-printer me-1"></i> Cetak</button>
                <a href="{{ route('home') }}" class="btn btn-primary w-50 btn-action" style="background-color: var(--rsud-blue);"><i class="bi bi-house me-1"></i> Beranda</a>
            </div>
        </div>
    </div>

</body>
</html>
