<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#10243a">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <title>@yield('title', 'Peminjaman Laptop') | LaptopLoan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --ink:#142b40; --muted:#647687; --cyan:#20bfd0; --line:#dce7ed; }
        * { box-sizing:border-box; }
        body { min-height:100vh; margin:0; color:var(--ink); background:radial-gradient(ellipse at 14% 8%,rgba(33,190,209,.2),transparent 32%),linear-gradient(135deg,#f2f8fa,#e7f0f4 55%,#f7fafb); font-family:Inter,"Segoe UI",sans-serif; }
        .guest-nav { height:76px; display:flex; align-items:center; justify-content:space-between; padding:0 clamp(20px,6vw,84px); }
        .brand { display:inline-flex; align-items:center; gap:11px; color:var(--ink); font-weight:800; text-decoration:none; letter-spacing:0; }
        .brand-mark { display:grid; place-items:center; width:42px; height:42px; border-radius:13px; color:#fff; background:linear-gradient(145deg,#193e5e,#087c9b); box-shadow:0 8px 20px #0d809a30; font-size:20px; }
        .guest-shell { width:min(1100px,calc(100% - 32px)); min-height:calc(100vh - 100px); margin:0 auto 24px; display:grid; grid-template-columns:1fr .86fr; overflow:hidden; border:1px solid #ffffffc2; border-radius:24px; background:#ffffffd9; box-shadow:0 24px 80px #18395118; animation:rise .55s ease both; }
        .guest-story { position:relative; display:flex; flex-direction:column; justify-content:space-between; min-height:620px; overflow:hidden; padding:clamp(34px,6vw,76px); color:#f4fbff; background:linear-gradient(145deg,#12324e,#155b76 64%,#0f788c); }
        .guest-story:after { position:absolute; right:-100px; bottom:-145px; width:430px; height:430px; border:1px solid #ffffff21; border-radius:50%; box-shadow:0 0 0 44px #ffffff08,0 0 0 92px #ffffff06; content:""; }
        .guest-story h1 { max-width:440px; margin:0 0 16px; font-size:clamp(2.3rem,4vw,4rem); line-height:1.03; font-weight:800; }
        .guest-story p { max-width:390px; color:#d3e9ef; line-height:1.7; }
        .story-icon { position:relative; z-index:1; align-self:flex-end; margin:0 5% 2% 0; color:#80e3e8; font-size:clamp(90px,15vw,178px); filter:drop-shadow(0 18px 18px #04182755); animation:float 5s ease-in-out infinite; }
        .guest-panel { display:flex; align-items:center; padding:clamp(28px,5vw,66px); }
        .guest-panel-inner { width:100%; max-width:440px; margin:auto; }
        .form-control,.form-select { min-height:48px; border-color:var(--line); border-radius:10px; }
        .form-control:focus,.form-select:focus { border-color:#21aabd; box-shadow:0 0 0 .22rem #20bfd022; }
        .btn-primary { --bs-btn-bg:#126e88; --bs-btn-border-color:#126e88; --bs-btn-hover-bg:#0d566e; --bs-btn-hover-border-color:#0d566e; min-height:48px; border-radius:10px; font-weight:700; }
        .alert { border:0; border-radius:10px; }
        @keyframes float { 50% { transform:translateY(-12px) rotate(-2deg); } }
        @keyframes rise { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        @media(max-width:760px) { .guest-shell { grid-template-columns:1fr; min-height:0; } .guest-story { min-height:220px; padding:30px; } .guest-story h1 { font-size:2.2rem; } .guest-story p { margin-bottom:0; } .story-icon { position:absolute; right:20px; bottom:6px; margin:0; font-size:86px; opacity:.45; } .guest-panel { padding:32px 24px 38px; } }
        @media(prefers-reduced-motion:reduce) { *,*::before,*::after { animation-duration:.01ms!important; transition-duration:.01ms!important; } }
    </style>
    <link rel="stylesheet" href="{{ asset('laptop-background.css') }}">
</head>
<body>
    <div class="laptop-backdrop" aria-hidden="true">
        <span class="backdrop-circuit backdrop-circuit-top"></span>
        <span class="backdrop-circuit backdrop-circuit-low"></span>
        <i class="bi bi-laptop backdrop-device"></i>
    </div>
    <header class="guest-nav">
        <a class="brand" href="{{ route('welcome') }}"><span class="brand-mark"><i class="bi bi-laptop"></i></span><span>LaptopLoan</span></a>
    </header>
    <main class="guest-shell">
        <section class="guest-story">
            <div>
                <a class="brand text-white mb-5" href="{{ route('welcome') }}"><span class="brand-mark"><i class="bi bi-laptop"></i></span><span>LaptopLoan</span></a>
                <h1>@yield('story-title', 'Teknologi sekolah, lebih mudah dipinjam.')</h1>
                <p>@yield('story-copy', 'Kelola peminjaman laptop sekolah dengan alur yang jelas, stok akurat, dan status yang mudah dipantau.')</p>
            </div>
            <i class="bi bi-laptop story-icon" aria-hidden="true"></i>
        </section>
        <section class="guest-panel"><div class="guest-panel-inner">@yield('content')</div></section>
    </main>
    <script>
        document.querySelectorAll('[data-toggle-password]').forEach(button => button.addEventListener('click', () => {
            const input = document.getElementById(button.dataset.togglePassword);
            const visible = input.type === 'password';
            input.type = visible ? 'text' : 'password';
            button.innerHTML = `<i class="bi bi-eye${visible ? '-slash' : ''}"></i>`;
            button.setAttribute('aria-label', visible ? 'Sembunyikan password' : 'Tampilkan password');
        }));
    </script>
</body>
</html>
