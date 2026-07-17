<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SIRS RSUD' }} — Sistem Informasi Rumah Sakit</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    {{-- SweetAlert2 --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    @stack('styles')

    <style>
        /* ─── RESET & BASE ─────────────────────────────────────────────── */
        * { box-sizing: border-box; }

        body {
            background: #f0f4f8;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            color: #1f2d3d;
        }

        /* ─── SIDEBAR ──────────────────────────────────────────────────── */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #005f73 0%, #0a9396 50%, #0077b6 100%);
            color: white;
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow-x: hidden;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            transition: transform 0.3s ease, width 0.3s ease;
        }

        /* Brand */
        .sidebar-brand {
            padding: 22px 18px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            flex-shrink: 0;
        }

        .brand-icon {
            width: 46px;
            height: 46px;
            background: rgba(255,255,255,0.12);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            border: 1px solid rgba(255,255,255,0.15);
            flex-shrink: 0;
        }

        .brand-text { line-height: 1.3; }
        .brand-text h5 { margin: 0; font-size: 15px; font-weight: 700; letter-spacing: -0.3px; }
        .brand-text small { font-size: 11px; opacity: 0.6; }

        /* Nav */
        .sidebar-nav {
            flex: 1;
            padding: 12px 10px;
            overflow-y: auto;
        }

        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 4px; }

        .nav-section-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            opacity: 0.45;
            padding: 14px 10px 6px;
        }

        .nav-link-item {
            display: flex;
            align-items: center;
            gap: 11px;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            padding: 10px 12px;
            border-radius: 12px;
            margin-bottom: 2px;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.2s ease;
            position: relative;
        }

        .nav-link-item i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
            transition: transform 0.2s;
        }

        .nav-link-item:hover {
            color: white;
            background: rgba(255,255,255,0.1);
        }

        .nav-link-item.active {
            color: white;
            background: rgba(255,255,255,0.15);
            font-weight: 600;
        }

        .nav-link-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 25%;
            height: 50%;
            width: 3px;
            background: #4fc3f7;
            border-radius: 0 3px 3px 0;
        }

        .nav-badge {
            margin-left: auto;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
            background: rgba(255,255,255,0.15);
        }

        .nav-badge.danger { background: #ef4444; }

        /* Sidebar user footer */
        .sidebar-footer {
            padding: 12px 10px;
            border-top: 1px solid rgba(255,255,255,0.08);
            flex-shrink: 0;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            background: rgba(255,255,255,0.07);
        }

        .sidebar-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.2);
            flex-shrink: 0;
        }

        .sidebar-user-info { flex: 1; overflow: hidden; }
        .sidebar-user-info .uname {
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar-user-info .urole {
            font-size: 11px;
            opacity: 0.6;
        }

        /* ─── MAIN CONTENT ─────────────────────────────────────────────── */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        /* ─── TOPBAR ───────────────────────────────────────────────────── */
        .topbar {
            background: white;
            padding: 0 28px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e8ecf0;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 1px 10px rgba(0,0,0,0.04);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .page-title { font-size: 16px; font-weight: 700; color: #0f1923; margin: 0; }
        .page-subtitle { font-size: 12px; color: #8b9ab0; margin: 0; }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Topbar buttons */
        .topbar-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid #e8ecf0;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7a90;
            font-size: 17px;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            text-decoration: none;
        }

        .topbar-btn:hover {
            background: #f0f4f8;
            color: #0d6efd;
            border-color: #d0dcf0;
        }

        .notif-dot {
            position: absolute;
            top: 7px;
            right: 7px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid white;
        }

        /* User menu */
        .user-menu-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px 6px 6px;
            border-radius: 12px;
            border: 1px solid #e8ecf0;
            background: white;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .user-menu-btn:hover { background: #f0f4f8; border-color: #d0dcf0; }

        .user-menu-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-menu-info .u-name { font-size: 13px; font-weight: 600; color: #0f1923; line-height: 1.2; }
        .user-menu-info .u-role {
            font-size: 11px;
            font-weight: 600;
            padding: 1px 6px;
            border-radius: 20px;
            display: inline-block;
        }

        /* ─── CONTENT AREA ─────────────────────────────────────────────── */
        .content-area {
            flex: 1;
            padding: 24px 28px;
        }

        /* ─── CARDS ────────────────────────────────────────────────────── */
        .card-modern {
            background: white;
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 8px rgba(0,0,0,0.05), 0 4px 20px rgba(0,0,0,0.04);
        }

        .stat-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 8px rgba(0,0,0,0.05), 0 4px 20px rgba(0,0,0,0.04);
            padding: 20px;
            background: white;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* ─── TABLE ────────────────────────────────────────────────────── */
        .table {
            font-size: 13.5px;
        }

        .table thead th {
            background: #f8fafc;
            border: none;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #7b8fa1;
            padding: 12px 16px;
        }

        .table tbody tr { vertical-align: middle; }

        .table tbody td {
            padding: 12px 16px;
            border-color: #f0f4f8;
        }

        .table tbody tr:hover { background: #f8fafc; }

        /* ─── BADGES ───────────────────────────────────────────────────── */
        .badge-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        /* ─── ALERTS (Flash) ───────────────────────────────────────────── */
        .flash-alert {
            border: none;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ─── DROPDOWN override ────────────────────────────────────────── */
        .dropdown-menu {
            border: 1px solid #e8ecf0;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            padding: 6px;
        }

        .dropdown-item {
            border-radius: 8px;
            font-size: 13px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dropdown-item:hover { background: #f0f4f8; }
        .dropdown-divider { margin: 4px 0; border-color: #e8ecf0; }

        /* ─── RESPONSIVE ───────────────────────────────────────────────── */
        @media (min-width: 992px) {
            .sidebar.collapsed {
                transform: translateX(-100%);
            }
            .main-content.expanded {
                margin-left: 0;
            }
        }

        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    {{-- ═══════════════════════════════════════════════ SIDEBAR ══ --}}
    <div class="sidebar" id="sidebar">

        {{-- Brand --}}
        <div class="sidebar-brand">
            <div class="brand-icon" style="background: transparent; border: none;">
                <img src="{{ asset('img/logo-rsud.jpg') }}" alt="Logo" style="width: 32px; height: auto;">
            </div>
            <div class="brand-text">
                <h5>SIRS RSUD</h5>
                <small>Admin Panel</small>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav">
            <div class="nav-section-title">Menu Utama</div>

            <a href="{{ route('dashboard') }}" class="nav-link-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>

            {{-- ══ DATA MASTER: Hanya Admin, Petugas, Super Admin (bukan Kasir, Dokter, Farmasi) ══ --}}
            @if(!auth()->user()->isKasir() && !auth()->user()->isDoctor() && !auth()->user()->isFarmasi())
            <div class="nav-section-title">Data Master</div>

            <a href="{{ route('patients.index') }}" class="nav-link-item {{ request()->routeIs('patients.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Data Pasien</span>
            </a>

                @if(Auth::user()->isSuperAdmin())
                    <a class="nav-link-item {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <i class="bi bi-people-fill"></i>
                        <span>Data Pengguna</span>
                    </a>
                    <a class="nav-link-item {{ request()->routeIs('doctors.*') ? 'active' : '' }}" href="{{ route('doctors.index') }}">
                        <i class="bi bi-person-badge-fill"></i>
                        <span>Dokter</span>
                    </a>
                    <a class="nav-link-item {{ request()->routeIs('departments.*') ? 'active' : '' }}" href="{{ route('departments.index') }}">
                        <i class="bi bi-building"></i>
                        <span>Data Poliklinik</span>
                    </a>
                    <a class="nav-link-item {{ request()->routeIs('wards.*') ? 'active' : '' }}" href="{{ route('wards.index') }}">
                        <i class="bi bi-hospital"></i>
                        <span>Master Bangsal</span>
                    </a>
                @endif
            @endif

            {{-- ══ PELAYANAN: Admin, Petugas, Dokter (bukan Kasir, bukan Farmasi) ══ --}}
            @if(!auth()->user()->isKasir() && !auth()->user()->isFarmasi())
            <div class="nav-section-title">Pelayanan</div>

            <a href="{{ route('registrations.index') }}" class="nav-link-item {{ request()->routeIs('registrations.*') ? 'active' : '' }}">
                <i class="bi bi-clipboard2-check-fill"></i>
                <span>Pendaftaran</span>
            </a>

            <a href="{{ route('medical_records.index') }}" class="nav-link-item {{ request()->routeIs('medical_records.*') ? 'active' : '' }}">
                <i class="bi bi-folder2-open"></i>
                <span>Rekam Medis</span>
            </a>

            @if(!auth()->user()->isDoctor())
            <a href="{{ route('rooms.index') }}" class="nav-link-item {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                <i class="bi bi-hospital"></i>
                <span>Rawat Inap & Kamar</span>
            </a>
            @endif
            @endif

            {{-- ══ FARMASI: Admin, Petugas, Kasir, Farmasi (bukan Dokter) ══ --}}
            @if(!auth()->user()->isDoctor())
            <div class="nav-section-title">Farmasi</div>

            <a href="{{ route('pharmacy.index') }}" class="nav-link-item {{ request()->routeIs('pharmacy.*') ? 'active' : '' }}">
                <i class="bi bi-capsule-pill"></i>
                <span>Farmasi</span>
            </a>

            @if(!auth()->user()->isKasir())
            <a href="{{ route('medicines.index') }}" class="nav-link-item {{ request()->routeIs('medicines.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam-fill"></i>
                <span>Data Obat</span>
            </a>

            <a href="{{ route('suppliers.index') }}" class="nav-link-item {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                <i class="bi bi-truck-front-fill"></i>
                <span>Supplier</span>
            </a>
            @endif
            @endif

            {{-- ══ KASIR & PEMBAYARAN: Admin, Petugas, Kasir (bukan Dokter, bukan Farmasi) ══ --}}
            @if(!auth()->user()->isDoctor() && !auth()->user()->isFarmasi())
            <div class="nav-section-title">Kasir & Pembayaran</div>

            <a href="{{ route('payments.index') }}" class="nav-link-item {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                <i class="bi bi-receipt-cutoff"></i>
                <span>Pembayaran</span>
            </a>
            @endif

            {{-- ══ LAINNYA: Hanya Admin & Super Admin (bukan Kasir, Dokter, Farmasi) ══ --}}
            @if(!auth()->user()->isKasir() && !auth()->user()->isDoctor() && !auth()->user()->isFarmasi())
            <div class="nav-section-title">Lainnya</div>

            <a href="{{ route('reports.index') }}" class="nav-link-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span>Laporan</span>
            </a>

            <a href="{{ route('settings.index') }}" class="nav-link-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>
                <span>Pengaturan Web</span>
            </a>

            @if(auth()->user()->isSuperAdmin())
            <a href="{{ route('users.index') }}" class="nav-link-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Manajemen Pengguna</span>
            </a>
            @endif

            <a href="{{ route('complaints.index') }}" class="nav-link-item {{ request()->routeIs('complaints.*') ? 'active' : '' }}">
                <i class="bi bi-megaphone"></i>
                <span>Pengaduan</span>
                @php
                    $newComplaintCount = \App\Models\Complaint::where('status', 'baru')->count();
                @endphp
                @if($newComplaintCount > 0)
                <span class="badge bg-danger rounded-pill ms-auto">{{ $newComplaintCount }}</span>
                @endif
            </a>

            <a href="{{ url('/') }}" target="_blank" class="nav-link-item">
                <i class="bi bi-globe2"></i>
                <span>Website Publik</span>
            </a>
            @endif
        </nav>

        {{-- Sidebar Footer: User Info --}}
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=0d6efd&color=fff' }}"
                     alt="{{ auth()->user()->name }}"
                     class="sidebar-user-avatar">
                <div class="sidebar-user-info">
                    <div class="uname">{{ auth()->user()->name }}</div>
                    <div class="urole">{{ auth()->user()->role_label }}</div>
                </div>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════ MAIN CONTENT ══ --}}
    <div class="main-content">

        {{-- ── TOPBAR ────────────────────────────────────────────────── --}}
        <div class="topbar">
            <div class="topbar-left">
                {{-- Sidebar toggle --}}
                <button class="topbar-btn" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>

                <div>
                    <h6 class="page-title">{{ $pageTitle ?? 'Dashboard' }}</h6>
                    <p class="page-subtitle">{{ $pageSubtitle ?? 'Sistem Informasi Rumah Sakit RSUD' }}</p>
                </div>
            </div>

            <div class="topbar-right">
                {{-- Notifikasi --}}
                <div class="dropdown">
                    <a href="#" class="topbar-btn" data-bs-toggle="dropdown" id="notifBtn">
                        <i class="bi bi-bell-fill"></i>
                        <span class="notif-dot"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="width: 300px; padding: 10px;">
                        <li>
                            <h6 style="font-size: 13px; font-weight: 700; padding: 4px 8px; margin-bottom: 8px; color: #0f1923;">
                                Notifikasi
                            </h6>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="text-center py-3" style="color: #9ca3af; font-size: 13px;">
                            <i class="bi bi-bell-slash d-block fs-3 mb-1"></i>
                            Belum ada notifikasi baru
                        </li>
                    </ul>
                </div>

                {{-- User dropdown --}}
                <div class="dropdown">
                    <button class="user-menu-btn" data-bs-toggle="dropdown" id="userMenuBtn">
                        <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=0d6efd&color=fff' }}"
                             alt="{{ auth()->user()->name }}"
                             class="user-menu-avatar">
                        <div class="user-menu-info">
                            <div class="u-name">{{ Str::limit(auth()->user()->name, 20) }}</div>
                            <span class="u-role bg-{{ auth()->user()->role_color }}-subtle text-{{ auth()->user()->role_color }}">
                                {{ auth()->user()->role_label }}
                            </span>
                        </div>
                        <i class="bi bi-chevron-down" style="font-size: 11px; color: #9ca3af; margin-left: 4px;"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end" style="min-width: 200px;">
                        <li>
                            <div style="padding: 10px 14px; border-bottom: 1px solid #e8ecf0; margin-bottom: 4px;">
                                <div style="font-weight: 600; font-size: 13px;">{{ auth()->user()->name }}</div>
                                <div style="font-size: 12px; color: #9ca3af;">{{ auth()->user()->email }}</div>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                <i class="bi bi-person-fill text-primary"></i> Profil Saya
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('settings.index') }}">
                                <i class="bi bi-gear-fill text-secondary"></i> Pengaturan
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                                @csrf
                                <button type="button" class="dropdown-item text-danger" onclick="confirmLogout()">
                                    <i class="bi bi-box-arrow-right"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- ── CONTENT AREA ──────────────────────────────────────────── --}}
        <div class="content-area">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="flash-alert alert-success bg-success-subtle text-success">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <div>
                        <strong>Berhasil!</strong> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="flash-alert alert-danger bg-danger-subtle text-danger">
                    <i class="bi bi-exclamation-circle-fill fs-5"></i>
                    <div>
                        <strong>Error!</strong> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('warning'))
                <div class="flash-alert alert-warning bg-warning-subtle text-warning">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    <div>
                        <strong>Peringatan!</strong> {{ session('warning') }}
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════ SCRIPTS ══ --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // ── Sidebar Toggle ───────────────────────────────────────
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar       = document.getElementById('sidebar');
        const mainContent   = document.querySelector('.main-content');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                if (window.innerWidth >= 992) {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');
                } else {
                    sidebar.classList.toggle('show');
                }
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (e) => {
                if (window.innerWidth < 992) {
                    if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                }
            });
        }

        // ── Logout Confirmation ─────────────────────────────────────────
        function confirmLogout() {
            Swal.fire({
                title: 'Keluar dari sistem?',
                text: 'Anda akan diarahkan ke halaman login.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-box-arrow-right me-1"></i>Ya, Keluar',
                cancelButtonText: 'Batal',
                borderRadius: '16px',
                customClass: {
                    popup: 'rounded-4',
                    confirmButton: 'btn btn-primary rounded-pill px-4',
                    cancelButton: 'btn btn-secondary rounded-pill px-4',
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        }

        // ── Auto dismiss flash alert ────────────────────────────────────
        document.querySelectorAll('.flash-alert').forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity    = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });

        // ── SweetAlert dari session (via JS) ────────────────────────────
        @if (session('swal_success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("swal_success") }}',
                timer: 2500,
                showConfirmButton: false,
                customClass: { popup: 'rounded-4' },
            });
        @endif

        @if (session('swal_error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session("swal_error") }}',
                customClass: { popup: 'rounded-4' },
            });
        @endif
    </script>

    @stack('scripts')

</body>
</html>