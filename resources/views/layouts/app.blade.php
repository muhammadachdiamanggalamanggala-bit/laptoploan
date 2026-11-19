<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Peminjaman Laptop') | LaptopLoan</title>
    <meta name="theme-color" content="#10243a">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    {{-- Anti-flash: set tema SEBELUM halaman digambar, biar tidak "kedip" putih dulu --}}
    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        })();
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        /* =====================================================
           VARIABEL WARNA — LIGHT (default) & DARK (natural, bukan hitam pekat)
           ===================================================== */
        :root {
            --bg-page: #f4f6f9;
            --bg-surface: #ffffff;
            --bg-surface-soft: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-soft: #eef1f5;
            --shadow-color: rgba(0,0,0,0.08);
        }

        [data-bs-theme="dark"] {
            /* navy/slate lembut, bukan hitam pekat */
            --bg-page: #0f1725;
            --bg-surface: #16202f;
            --bg-surface-soft: #1c2739;
            --text-main: #e2e8f0;
            --text-muted: #93a1b8;
            --border-soft: #253347;
            --shadow-color: rgba(0,0,0,0.35);

            --bs-body-bg: #0f1725;
            --bs-body-color: #e2e8f0;
            --bs-border-color: #253347;
        }

        * { transition: background-color .35s ease, color .35s ease, border-color .35s ease, box-shadow .35s ease; }

        body { background-color: var(--bg-page); color: var(--text-main); }

        .sidebar { background: linear-gradient(165deg, #112d46, #163c56 68%, #0f5367); box-shadow: 12px 0 35px rgba(15,45,70,.12); }
        .sidebar-brand { display:flex; align-items:center; gap:12px; min-height:82px; font-size:1.05rem; letter-spacing:0; }
        .brand-icon { display:grid; place-items:center; width:40px; height:40px; border-radius:12px; color:#fff; background:linear-gradient(145deg,#26b8c6,#167391); box-shadow:0 8px 20px #031c2c55; font-size:20px; }
        .sidebar a { margin:4px 12px; padding:11px 14px; border-radius:9px; color:#d1e0e8; }
        .sidebar a:hover,.sidebar a.active { background:#ffffff19; color:#fff; box-shadow:inset 3px 0 #53d8df; }
        .sidebar-section-label { padding:18px 20px 5px; color:#9ab1c0; font-size:.68rem; font-weight:700; letter-spacing:.09em; }
        .sidebar a .nav-icon { width:20px; text-align:center; }
        .sidebar a .nav-badge { margin-left:auto; border-radius:999px; padding:2px 7px; background:#ffffff1a; color:#d8f4f5; font-size:.68rem; font-weight:700; }
        .main-content { min-height:100vh; }
        .topbar { position:sticky; top:0; z-index:1010; border-bottom:1px solid var(--border-soft); backdrop-filter:blur(14px); }
        .content-wrap { max-width:1600px; margin:auto; }
        .laptop-card,.stat-card,.section-card { border:1px solid var(--border-soft); border-radius:14px; background:var(--bg-surface); box-shadow:0 8px 26px var(--shadow-color); transition:transform .2s ease,box-shadow .2s ease; }
        .laptop-card:hover,.stat-card:hover { transform:translateY(-4px); box-shadow:0 16px 34px var(--shadow-color); }
        .catalog-heading { display:flex; justify-content:space-between; align-items:end; gap:16px; }
        .catalog-count,.status-pill { border-radius:999px; padding:7px 12px; font-size:.8rem; font-weight:700; background:#e6f6f7; color:#126374; }
        .catalog-filters { display:grid; grid-template-columns:minmax(240px,1fr) minmax(150px,220px) auto auto; gap:10px; padding:14px; border:1px solid var(--border-soft); border-radius:14px; background:var(--bg-surface); }
        .filter-available { display:flex; align-items:center; gap:8px; white-space:nowrap; }
        .laptop-visual,.detail-visual { position:relative; display:grid; place-items:center; min-height:190px; overflow:hidden; color:#dffbff; background:radial-gradient(ellipse at 75% 20%,#28b9c333,transparent 34%),linear-gradient(140deg,#173b57,#102b40); }
        .laptop-visual img,.detail-visual img { width:100%; height:100%; min-height:inherit; object-fit:cover; }
        .laptop-placeholder { display:grid; place-items:center; gap:4px; color:#72d8dd; font-size:13px; }
        .laptop-placeholder i,.detail-visual>i { font-size:76px; filter:drop-shadow(0 12px 18px #061c2d88); }
        .laptop-visual .status-pill { position:absolute; top:13px; right:13px; }
        .status-pill.is-available { background:#d9f7e9; color:#176743; }
        .status-pill.is-unavailable { background:#ffedcf; color:#8a510d; }
        .empty-catalog { padding:70px 20px; border:1px dashed #adc0ca; border-radius:16px; text-align:center; color:#3e7183; }
        .empty-catalog i { display:block; margin-bottom:14px; font-size:36px; }
        .detail-visual { min-height:380px; border-radius:18px; }
        .detail-facts { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:10px; margin-top:24px; }
        .detail-facts div { display:grid; gap:4px; padding:14px; border:1px solid var(--border-soft); border-radius:11px; background:var(--bg-surface); }
        .detail-facts span { color:var(--text-muted); font-size:.83rem; }
        .loan-form { padding:20px; border:1px solid var(--border-soft); border-radius:15px; background:var(--bg-surface); }
        .btn { transition:transform .16s ease,box-shadow .16s ease; }
        .btn:hover { transform:translateY(-1px); }
        @media(max-width:760px) { .catalog-filters { grid-template-columns:1fr 1fr; } .catalog-filters .input-group { grid-column:1/-1; } .catalog-heading { align-items:start; } .catalog-count { display:none; } }
        @media(max-width:480px) { .catalog-filters { grid-template-columns:1fr; } .catalog-filters .input-group { grid-column:auto; } .detail-visual { min-height:250px; } }
        @media(prefers-reduced-motion:reduce) { *,*::before,*::after { animation-duration:.01ms!important; transition-duration:.01ms!important; } }

        .sidebar {
            min-height: 100vh;
            width: 250px;
            background-color: #1e293b;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1030;
            transition: transform 0.3s ease;
        }
        .sidebar a {
            color: #cbd5e1; text-decoration: none; display: block;
            padding: 12px 20px; border-radius: 8px; margin: 4px 10px; transition: 0.2s;
        }
        .sidebar a:hover, .sidebar a.active { background-color: #2563eb; color: #fff; }
        .sidebar-brand {
            color: #fff; font-weight: bold; font-size: 1.2rem;
            padding: 20px; border-bottom: 1px solid #334155;
        }

        .main-content {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        .card-shadow { box-shadow: 0 2px 8px var(--shadow-color); border: none; background-color: var(--bg-surface); }
        .topbar { background-color: var(--bg-surface); box-shadow: 0 1px 4px var(--shadow-color); }
        .card { background-color: var(--bg-surface); }
        table th { background: var(--bg-surface-soft); }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 1020;
        }

        /* Layar kecil (HP): sidebar disembunyikan, muncul saat tombol menu diklik */
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .sidebar-overlay.show { display: block; }
        }

        /* =====================================================
           TOMBOL TOGGLE TEMA — pill switch dengan bulatan geser
           ===================================================== */
        .theme-toggle {
            position: relative;
            width: 56px;
            height: 30px;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            padding: 3px;
            display: flex;
            align-items: center;
            transition: background 0.4s ease;
            flex-shrink: 0;
        }
        [data-bs-theme="dark"] .theme-toggle {
            background: linear-gradient(135deg, #334155, #1e293b);
        }
        .theme-toggle .knob {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            color: #f59e0b;
            transform: translateX(0);
            transition: transform 0.4s cubic-bezier(.68,-0.55,.27,1.55), color 0.3s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.25);
        }
        [data-bs-theme="dark"] .theme-toggle .knob {
            transform: translateX(26px);
            color: #93c5fd;
        }
        .theme-toggle .knob i {
            animation: spinIn 0.4s ease;
        }
        @keyframes spinIn {
            from { transform: rotate(-90deg) scale(0.5); opacity: 0; }
            to   { transform: rotate(0) scale(1); opacity: 1; }
        }

        @media (max-width: 575.98px) {
            .topbar { gap: .5rem; padding: .65rem .75rem !important; }
            .topbar > div:first-child { flex: 1 1 auto; min-width: 0; gap: .5rem !important; }
            .topbar h5 { overflow: hidden; min-width: 0; font-size: 1rem; text-overflow: ellipsis; white-space: nowrap; }
            .topbar > div:last-child { flex: 0 0 auto; gap: .4rem !important; }
            #btnToggleSidebar { display: grid; flex: 0 0 40px; place-items: center; width: 40px; height: 40px; padding: 0; }
            #installApp { width: 36px; height: 36px; padding: .375rem; }
            .theme-toggle { width: 46px; height: 28px; }
            .theme-toggle .knob { width: 22px; height: 22px; }
            [data-bs-theme="dark"] .theme-toggle .knob { transform: translateX(18px); }
            .content-wrap { padding: .75rem !important; }
            .sidebar { max-height: 100vh; max-height: 100dvh; overflow-y: auto; overscroll-behavior: contain; }
            .table-responsive { -webkit-overflow-scrolling: touch; }
        }

        @media (max-width: 380px) {
            .topbar > div:last-child { gap: .25rem !important; }
            .dashboard-hero { padding: 22px; }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('laptop-background.css') }}">

    @stack('styles')
</head>
<body>
<div class="laptop-backdrop" aria-hidden="true">
    <span class="backdrop-circuit backdrop-circuit-top"></span>
    <span class="backdrop-circuit backdrop-circuit-low"></span>
    <i class="bi bi-laptop backdrop-device"></i>
</div>

<nav class="sidebar" id="sidebar" aria-label="Navigasi utama">
    <div class="sidebar-brand">
        <span class="brand-icon"><i class="bi bi-laptop"></i></span> <span>LaptopLoan</span>
    </div>
    <div class="mt-3">
        @auth
        @if(auth()->user()->isAdmin())
            <div class="sidebar-section-label">DASHBOARD</div>
            <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}" @if(request()->is('dashboard')) aria-current="page" @endif>
                <i class="bi bi-speedometer2 nav-icon me-2"></i> Ringkasan
            </a>

            <div class="sidebar-section-label">MANAJEMEN DATA</div>
            <a href="{{ route('barang.index') }}" class="{{ request()->is('barang*') ? 'active' : '' }}" @if(request()->is('barang*')) aria-current="page" @endif><i class="bi bi-laptop nav-icon me-2"></i> Data Laptop</a>
            <a href="{{ route('siswa.index') }}" class="{{ request()->is('siswa*') ? 'active' : '' }}" @if(request()->is('siswa*')) aria-current="page" @endif><i class="bi bi-people nav-icon me-2"></i> Data Siswa</a>
            <a href="{{ route('katalog') }}" class="{{ request()->is('katalog*') ? 'active' : '' }}" @if(request()->is('katalog*')) aria-current="page" @endif><i class="bi bi-grid nav-icon me-2"></i> Katalog Laptop</a>

            <div class="sidebar-section-label">PERSETUJUAN</div>
            <a href="{{ route('peminjaman.index') }}" class="{{ request()->is('peminjaman*') ? 'active' : '' }}" @if(request()->is('peminjaman*')) aria-current="page" @endif><i class="bi bi-clipboard-check nav-icon me-2"></i> Kelola Peminjaman</a>
            <a href="{{ route('riwayat') }}" class="{{ request()->is('riwayat*') ? 'active' : '' }}" @if(request()->is('riwayat*')) aria-current="page" @endif><i class="bi bi-clock-history nav-icon me-2"></i> Riwayat Peminjaman</a>

            <div class="sidebar-section-label">PELAPORAN</div>
            <a href="{{ route('laporan.index') }}" class="{{ request()->is('laporan*') ? 'active' : '' }}" @if(request()->is('laporan*')) aria-current="page" @endif><i class="bi bi-life-preserver nav-icon me-2"></i> Laporan Masalah</a>

            <div class="sidebar-section-label">ADMINISTRATOR</div>
            <a href="{{ route('pengguna.index') }}" class="{{ request()->is('pengguna*') ? 'active' : '' }}" @if(request()->is('pengguna*')) aria-current="page" @endif><i class="bi bi-person-gear nav-icon me-2"></i> Kelola Pengguna</a>
        @else
            <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            <a href="{{ route('katalog') }}" class="{{ request()->is('katalog*') ? 'active' : '' }}">
                <i class="bi bi-grid me-2"></i> Katalog Laptop
            </a>
            <a href="{{ route('peminjaman.saya') }}" class="{{ request()->is('peminjaman-saya') ? 'active' : '' }}"><i class="bi bi-clipboard-check me-2"></i> Peminjaman Saya</a>
            <a href="{{ route('riwayat') }}" class="{{ request()->is('riwayat*') ? 'active' : '' }}"><i class="bi bi-clock-history me-2"></i> Riwayat Peminjaman</a>
            <a href="{{ route('laporan.index') }}" class="{{ request()->is('laporan*') ? 'active' : '' }}"><i class="bi bi-life-preserver me-2"></i> Laporan Masalah</a>
        @endif
        @else
        <a href="{{ route('welcome') }}"><i class="bi bi-house me-2"></i> Beranda</a>
        <a href="{{ route('katalog') }}" class="{{ request()->is('katalog*') ? 'active' : '' }}"><i class="bi bi-grid me-2"></i> Katalog Laptop</a>
        <a href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-2"></i> Login</a>
        <a href="{{ route('register') }}"><i class="bi bi-person-plus me-2"></i> Daftar</a>
        @endauth
    </div>
</nav>

<div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>

<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center px-4 py-3">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-outline-secondary d-lg-none" id="btnToggleSidebar" type="button" aria-label="Buka navigasi" aria-controls="sidebar" aria-expanded="false">
                <i class="bi bi-list"></i>
            </button>
            <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
        </div>

        <div class="d-flex align-items-center gap-3">
            @auth
            <button class="btn btn-sm btn-outline-primary d-none" id="installApp" aria-label="Install aplikasi"><i class="bi bi-download"></i><span class="d-none d-sm-inline"> Install</span></button>
            <span class="small text-secondary d-none d-md-inline">{{ auth()->user()->name }}</span>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary position-relative" data-bs-toggle="dropdown" aria-label="Notifikasi"><i class="bi bi-bell"></i>@if(auth()->user()->unreadNotifications->count())<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ auth()->user()->unreadNotifications->count() }}</span>@endif</button>
                <div class="dropdown-menu dropdown-menu-end p-2" style="width:min(340px,90vw)">
                    @forelse(auth()->user()->unreadNotifications()->latest()->take(5)->get() as $notification)<div class="small px-2 py-2 border-bottom fw-semibold"><a href="{{ route('notifications.show', $notification->id) }}" class="text-reset text-decoration-none d-block">{{ $notification->data['message'] ?? 'Notifikasi baru' }}<span class="d-block mt-1 text-primary">{{ ($notification->data['url'] ?? null) ? 'Lihat pengajuan' : 'Tandai sudah dibaca' }} <i class="bi bi-arrow-right"></i></span></a></div>@empty<div class="small text-secondary p-2">Belum ada notifikasi baru.</div>@endforelse
                    @if(auth()->user()->unreadNotifications->count())<form method="POST" action="{{ route('notifications.read') }}" class="p-2">@csrf @method('PATCH')<button class="btn btn-sm btn-link p-0">Tandai sudah dibaca</button></form>@endif
                </div>
            </div>
            {{-- Tombol ganti tema --}}
            <button type="button" class="theme-toggle" id="btnThemeToggle" title="Ganti mode terang/gelap" aria-label="Ganti mode terang atau gelap">
                <span class="knob" id="themeKnob"><i class="bi bi-sun-fill"></i></span>
            </button>

            <form action="{{ route('logout') }}" method="POST" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger" aria-label="Logout">
                    <i class="bi bi-box-arrow-right"></i><span class="d-none d-sm-inline"> Logout</span>
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Login</a>
            <a href="{{ route('register') }}" class="btn btn-sm btn-primary">Daftar</a>
            @endauth
        </div>
    </div>

    <div class="content-wrap p-3 p-md-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button></div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button></div>
        @endif
        @if($errors->any())<div class="alert alert-danger alert-dismissible fade show" role="alert">{{ $errors->first() }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button></div>@endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const btnToggle = document.getElementById('btnToggleSidebar');

    function toggleSidebar() {
        const isOpen = sidebar.classList.toggle('show');
        overlay.classList.toggle('show', isOpen);
        btnToggle.setAttribute('aria-expanded', String(isOpen));
        btnToggle.setAttribute('aria-label', isOpen ? 'Tutup navigasi' : 'Buka navigasi');
    }

    btnToggle.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);
    sidebar.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
        btnToggle.setAttribute('aria-expanded', 'false');
        btnToggle.setAttribute('aria-label', 'Buka navigasi');
    }));
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && sidebar.classList.contains('show')) toggleSidebar();
    });

    /* ==== Ganti Mode Terang / Gelap ==== */
    const btnThemeToggle = document.getElementById('btnThemeToggle');
    const themeKnob = document.getElementById('themeKnob');

    if (btnThemeToggle && themeKnob) {
        function renderThemeIcon(theme) {
            themeKnob.innerHTML = theme === 'dark'
                ? '<i class="bi bi-moon-stars-fill"></i>'
                : '<i class="bi bi-sun-fill"></i>';
        }

        renderThemeIcon(document.documentElement.getAttribute('data-bs-theme') || 'light');

        btnThemeToggle.addEventListener('click', function () {
            const current = document.documentElement.getAttribute('data-bs-theme') || 'light';
            const next = current === 'dark' ? 'light' : 'dark';

            document.documentElement.setAttribute('data-bs-theme', next);
            localStorage.setItem('theme', next);
            renderThemeIcon(next);
        });
    }

    let deferredInstallPrompt;
    const installButton = document.getElementById('installApp');
    window.addEventListener('beforeinstallprompt', event => {
        event.preventDefault();
        deferredInstallPrompt = event;
        installButton?.classList.remove('d-none');
    });
    installButton?.addEventListener('click', async () => {
        if (!deferredInstallPrompt) return;
        deferredInstallPrompt.prompt();
        await deferredInstallPrompt.userChoice;
        deferredInstallPrompt = null;
        installButton.classList.add('d-none');
    });
    if ('serviceWorker' in navigator) window.addEventListener('load', () => navigator.serviceWorker.register('{{ asset('service-worker.js') }}'));
</script>
@stack('scripts')
</body>
</html>