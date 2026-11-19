<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#10243a"><meta name="description" content="Sistem peminjaman laptop sekolah yang mudah, cepat, dan terorganisir.">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}"><link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <title>Peminjaman Laptop | LaptopLoan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root{--navy:#102b43;--cyan:#20bac7;--text:#16324a;--muted:#63798b}*{box-sizing:border-box}body{margin:0;color:var(--text);font-family:Inter,"Segoe UI",sans-serif;background:#f3f8fa}a{color:inherit}.site-nav{height:78px;display:flex;align-items:center;justify-content:space-between;padding:0 clamp(20px,7vw,100px)}.brand{display:flex;align-items:center;gap:11px;text-decoration:none;font-weight:800}.brand-icon{display:grid;place-items:center;width:42px;height:42px;border-radius:13px;background:linear-gradient(145deg,#1a4260,#087c9b);color:white;font-size:21px;box-shadow:0 8px 22px #147f9b32}.nav-actions{display:flex;align-items:center;gap:22px}.hero{position:relative;min-height:580px;display:grid;grid-template-columns:1.1fr .9fr;align-items:center;overflow:hidden;padding:70px clamp(24px,9vw,140px);color:#fff;background:radial-gradient(ellipse at 78% 22%,#25c0ca3e,transparent 35%),linear-gradient(115deg,#102a43,#15516c 70%,#117181)}.hero:after{position:absolute;right:-90px;bottom:-240px;width:610px;height:610px;border:1px solid #ffffff23;border-radius:50%;box-shadow:0 0 0 58px #ffffff08,0 0 0 120px #ffffff06;content:""}.hero-copy{position:relative;z-index:1;max-width:600px;animation:rise .65s ease both}.eyebrow{font-size:.76rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:#7ee4e6}.hero h1{margin:18px 0;font-size:clamp(3rem,6vw,5.4rem);line-height:.98;font-weight:850}.hero p{max-width:490px;color:#d0e5ec;line-height:1.7;font-size:1.08rem}.hero-actions{display:flex;flex-wrap:wrap;gap:12px;margin-top:30px}.hero-actions .btn{padding:12px 20px;border-radius:10px;font-weight:700}.btn-cyan{background:#36cad0;border-color:#36cad0;color:#102c43}.btn-cyan:hover{background:#75e2e1;border-color:#75e2e1}.hero-visual{position:relative;z-index:1;display:grid;place-items:center;min-height:330px}.hero-laptop{display:grid;place-items:center;width:min(100%,410px);height:275px;border:1px solid #d9fcff66;border-radius:20px;background:linear-gradient(145deg,#f5ffff,#acd6dd 46%,#3e8294);box-shadow:0 34px 60px #04172766;transform:perspective(700px) rotateY(-11deg) rotateX(5deg);animation:float 5s ease-in-out infinite}.hero-laptop i{font-size:150px;color:#19465b;filter:drop-shadow(0 15px 8px #0b354522)}.hero-laptop:after{position:absolute;right:14%;bottom:-17px;left:14%;height:17px;border-radius:2px 2px 50% 50%;background:linear-gradient(#a6c8cd,#547f89);content:""}.hero-note{position:absolute;right:3%;bottom:8%;z-index:2;padding:13px 17px;border:1px solid #ffffff55;border-radius:13px;background:#ffffff18;backdrop-filter:blur(12px);animation:rise .9s ease both}.hero-note strong{display:block;font-size:1.1rem}.hero-note span{color:#d6edf0;font-size:.82rem}.section{padding:76px clamp(24px,9vw,140px)}.section-heading{max-width:650px;margin:0 auto 38px;text-align:center}.section-heading h2{font-weight:800}.feature-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}.feature{padding:26px;border:1px solid #deeaee;border-radius:14px;background:#fff;transition:transform .2s,box-shadow .2s}.feature:hover{transform:translateY(-5px);box-shadow:0 16px 32px #183b5014}.feature-icon{display:grid;place-items:center;width:47px;height:47px;margin-bottom:19px;border-radius:13px;color:#11768a;background:#e2f6f7;font-size:21px}.steps{display:grid;grid-template-columns:repeat(3,1fr);gap:25px}.step{border-top:2px solid #9fdce0;padding-top:20px}.step-number{color:#11879b;font-size:.82rem;font-weight:800}.catalog-strip{display:flex;align-items:center;justify-content:space-between;gap:20px;padding:32px;border-radius:17px;background:linear-gradient(105deg,#e2f5f5,#edf4f9)}footer{padding:25px clamp(24px,9vw,140px);border-top:1px solid #dce8ec;color:var(--muted)}@keyframes float{50%{transform:perspective(700px) rotateY(-11deg) rotateX(5deg) translateY(-10px)}}@keyframes rise{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}@media(max-width:800px){.hero{grid-template-columns:1fr;gap:15px;padding-top:60px}.hero-visual{min-height:240px}.hero-laptop{height:210px;max-width:320px}.hero-laptop i{font-size:115px}.hero-note{right:4%;bottom:2%}.feature-grid,.steps{grid-template-columns:1fr}.section{padding-top:56px;padding-bottom:56px}.nav-actions{gap:12px}}@media(prefers-reduced-motion:reduce){*,*::before,*::after{animation-duration:.01ms!important;transition-duration:.01ms!important}}
        .hero-scene{position:relative;width:min(100%,500px);height:390px;perspective:1100px;transform-style:preserve-3d;cursor:grab}
        .hero-scene:active{cursor:grabbing}
        .hero-scene:focus-visible{outline:2px solid #73e8f1;outline-offset:7px;border-radius:16px}
        .scene-interactive{position:absolute;inset:0;transform-style:preserve-3d;transform:rotateX(var(--tilt-x,0deg)) rotateY(var(--tilt-y,0deg));transition:transform .18s ease-out}
        .hero-laptop{position:absolute;z-index:3;left:12%;top:17%;display:block;width:78%;height:67%;border:0;border-radius:0;background:none;box-shadow:none;transform:none;animation:laptop-spin 6s ease-in-out infinite}
        .hero-laptop:after{content:none}
        .hero-laptop i{font-size:inherit;color:inherit;filter:none}
        .laptop-screen{position:absolute;inset:0 2% 14%;overflow:hidden;border:8px solid #101923;border-bottom-width:12px;border-radius:15px 15px 5px 5px;background:linear-gradient(140deg,#1a2733,#0b1119 72%);box-shadow:0 0 0 1px #a9c8d455,0 22px 44px #04172790,inset 0 0 0 1px #566b7a;transform:rotateY(-9deg) rotateX(3deg);transform-origin:bottom center;transition:transform .25s ease}
        .screen-topbar{height:23px;display:flex;align-items:center;justify-content:space-between;padding:0 10px;background:linear-gradient(180deg,#253542,#121d27);color:#c5d8e1;font-size:8px;font-weight:700;letter-spacing:.04em}
        .screen-topbar span{display:flex;align-items:center;gap:4px;color:#75e5c2;font-size:7px}
        .screen-topbar span:before{width:5px;height:5px;border-radius:50%;background:#49e3ae;box-shadow:0 0 8px #49e3ae;content:""}
        .screen-dashboard{height:calc(100% - 23px);display:grid;grid-template-columns:22% 1fr;gap:7px;padding:8px;background:linear-gradient(130deg,#182631,#0c141d)}
        .screen-menu{display:grid;align-content:start;gap:7px;padding:7px 5px;border:1px solid #8199a72c;border-radius:4px;background:#111b25;color:#a8bec8;font-size:6px}
        .screen-menu b{padding-bottom:5px;border-bottom:1px solid #ffffff20;color:#e1edf1;font-size:7px}
        .screen-menu span{display:flex;align-items:center;gap:4px;opacity:.85}
        .screen-menu i{font-size:8px;color:#6fe0e4}
        .screen-content{display:grid;grid-template-rows:auto 1fr;gap:6px;min-width:0}
        .screen-title{color:#d7e4ea;font-size:9px;font-weight:800}
        .screen-title small{display:block;margin-top:2px;color:#718b99;font-size:6px;font-weight:500}
        .screen-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:5px}
        .screen-stat{display:grid;align-content:center;gap:3px;padding:6px;border:1px solid #9ab5c11f;border-radius:4px;background:#23313d;color:#9ab0bb;font-size:6px}
        .screen-stat strong{font-size:12px;color:#d7e8ee}
        .screen-stat em{color:#6bd9c4;font-size:6px;font-style:normal}
        .screen-chart{position:relative;display:flex;align-items:end;gap:5px;height:100%;min-height:53px;padding:8px;border:1px solid #9ab5c11f;border-radius:4px;background:linear-gradient(#1a2935,#111a23)}
        .screen-chart span{flex:1;height:var(--bar-height);border-radius:2px 2px 0 0;background:linear-gradient(#46cfe0,#2475a0);box-shadow:0 0 8px #1ecbd244;animation:chart-pulse 2.8s ease-in-out infinite alternate}
        .screen-chart span:nth-child(2n){animation-delay:.35s}
        .screen-chart span:nth-child(3n){animation-delay:.7s}
        .laptop-base{position:absolute;right:-5%;bottom:2%;left:-5%;height:20%;border:1px solid #94a7b574;border-radius:4px 4px 45% 45%;background:linear-gradient(180deg,#697984,#253440 18%,#111923 78%,#657681);box-shadow:0 18px 24px #04172799;transform:perspective(420px) rotateX(58deg);transform-origin:top center}
        .laptop-base:after{position:absolute;top:2px;left:41%;width:18%;height:3px;border-radius:0 0 6px 6px;background:#a0adb3;content:""}
        .keyboard-detail{position:absolute;top:10%;right:13%;left:13%;height:54%;border-radius:2px;background:repeating-linear-gradient(90deg,transparent 0 4.8%,#101820 4.8% 5.6%),repeating-linear-gradient(0deg,#9eabb5 0 10%,#111a22 10% 14%);box-shadow:0 1px 4px #0009}
        .trackpad{position:absolute;left:39%;bottom:8%;width:22%;height:22%;border:1px solid #bac7ce55;border-radius:2px;background:linear-gradient(145deg,#84939b,#4b5962)}
        .laptop-port{position:absolute;right:3%;bottom:42%;display:flex;gap:4px}.laptop-port i{width:8px;height:3px;border-radius:2px;background:#070c11;box-shadow:0 0 0 1px #8597a2}
        .scene-glow{position:absolute;z-index:0;inset:12% 3% 5%;border-radius:50%;background:radial-gradient(ellipse,#33d4e73b 0%,#2e94cd1f 40%,transparent 72%);filter:blur(14px);animation:glow-breathe 4s ease-in-out infinite}
        .scene-interactive .hero-laptop{position:absolute;z-index:5}
        .scene-interactive .hero-laptop,
        .scene-interactive .scene-code,
        .scene-interactive .scene-caption,
        .scene-interactive .hero-note{pointer-events:none}
        .scene-code{position:absolute;z-index:2;top:0;right:-1%;width:43%;padding:12px;border:1px solid #d4faff70;border-radius:12px;background:linear-gradient(135deg,#d6f5f52c,#16384b9c);box-shadow:0 15px 35px #04172735;backdrop-filter:blur(8px);color:#d5f5fa;font:600 8px/1.8 ui-monospace,Consolas,monospace;transform:rotateY(-12deg) rotateX(4deg);animation:panel-drift 5s ease-in-out infinite}
        .code-dots{display:flex;gap:4px;margin-bottom:7px}.code-dots i{width:5px;height:5px;border-radius:50%;background:#70e6ed}.code-dots i:nth-child(2){background:#f8d879}.code-dots i:nth-child(3){background:#ff8d9c}
        .code-line{display:block;overflow:hidden;white-space:nowrap;color:#a4d9e3}.code-line strong{color:#7de6c1}.code-line em{color:#f4ce82;font-style:normal}
        .scene-caption{position:absolute;z-index:4;left:5%;bottom:0;display:flex;align-items:center;gap:7px;color:#bdebf1;font-size:9px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;text-shadow:0 2px 8px #071d30}
        .scene-caption i{color:#56e4ca;font-size:13px;filter:drop-shadow(0 0 7px #56e4ca)}
        .hero-note{right:0;bottom:8%;animation:rise .9s ease both}
        @keyframes glow-breathe{50%{opacity:.55;transform:scale(1.08)}}
        @keyframes laptop-hover{0%,100%{transform:translateY(0)}50%{transform:translateY(-9px)}}
        @keyframes panel-drift{50%{transform:rotateY(-8deg) rotateX(2deg) translateY(-8px)}}
        @keyframes laptop-spin{0%{transform:perspective(1200px) rotateY(-18deg) rotateX(7deg) translateY(0)}25%{transform:perspective(1200px) rotateY(4deg) rotateX(2deg) translateY(-8px)}50%{transform:perspective(1200px) rotateY(18deg) rotateX(-4deg) translateY(-4px)}75%{transform:perspective(1200px) rotateY(4deg) rotateX(2deg) translateY(-8px)}100%{transform:perspective(1200px) rotateY(-18deg) rotateX(7deg) translateY(0)}}
        @keyframes chart-pulse{to{filter:brightness(1.3);transform:scaleY(.84);transform-origin:bottom}}
        @media(max-width:800px){.hero-scene{height:300px;max-width:430px}.hero-note{right:2%;bottom:3%}.scene-code{right:0;width:45%}}
        @media(max-width:480px){.hero-scene{height:265px}.scene-code{top:0;width:48%;padding:8px;font-size:6px}.scene-caption{font-size:7px}.hero-note{right:0;bottom:0;padding:9px 12px}}
        .hero{z-index:1;isolation:isolate;min-height:min(760px,calc(100svh - 78px));grid-template-columns:minmax(0,.9fr) minmax(0,1.1fr);padding:clamp(42px,6vh,76px) clamp(24px,7vw,108px);background:linear-gradient(90deg,rgba(8,27,44,.88),rgba(11,36,55,.72) 42%,rgba(12,42,60,.34)),linear-gradient(0deg,rgba(8,27,42,.52),transparent 44%),radial-gradient(ellipse at 78% 42%,rgba(57,178,202,.25),transparent 40%),linear-gradient(115deg,#182c3e,#436070 62%,#89969a)}
        .hero:before{position:absolute;z-index:-1;inset:0;background:linear-gradient(0deg,rgba(15,33,43,.38),transparent 45%),radial-gradient(ellipse at 30% 35%,rgba(160,185,194,.25),transparent 35%);content:""}
        .hero:after{right:-12%;bottom:-55%;width:65%;height:85%;border-color:#d2faff20;box-shadow:0 0 0 58px #ffffff06,0 0 0 120px #ffffff04;pointer-events:none}
        .hero-office{position:absolute;z-index:-1;inset:0;overflow:hidden;pointer-events:none;background:linear-gradient(0deg,rgba(19,35,43,.55) 0 18%,transparent 43%)}
        .hero-office:before{position:absolute;top:5%;left:10%;width:36%;height:52%;border:1px solid #d9f5ff38;border-radius:8px;background:linear-gradient(145deg,#102534d9,#1c394bc9 55%,#172733e8);box-shadow:0 0 0 14px #e5faff0b,0 18px 55px #071a2c77;filter:blur(2px);content:""}
        .hero-office:after{position:absolute;right:0;bottom:13%;left:0;height:20%;background:linear-gradient(180deg,#a6b3b633,#263b498c 35%,#122b3d);transform:perspective(500px) rotateX(12deg);transform-origin:bottom;filter:blur(3px);content:""}
        .hero-copy{z-index:2;max-width:620px}
        .hero h1{font-size:clamp(3.5rem,6.4vw,6.2rem);text-shadow:0 8px 30px #06182766}
        .hero p{color:#e0edf2}
        .hero-visual{min-height:480px;z-index:2}
        .hero-scene{width:min(100%,650px);height:clamp(350px,43vw,520px);perspective:1300px}
        .scene-interactive{transition:transform .3s ease-out}
        .hero-laptop{left:7%;top:19%;width:88%;height:70%;animation-duration:7s}
        .laptop-screen{inset:0 2% 14%;border-width:9px;border-bottom-width:13px;border-radius:17px 17px 6px 6px;box-shadow:0 0 0 1px #c9f4ff66,0 28px 55px #041727a8,inset 0 0 0 1px #566b7a}
        .screen-topbar{height:28px;font-size:9px}
        .screen-topbar span{font-size:8px}
        .screen-dashboard{height:calc(100% - 28px);grid-template-columns:23% 1fr;gap:9px;padding:10px}
        .screen-menu{gap:9px;font-size:7px}
        .screen-menu b{font-size:8px}
        .screen-menu i{font-size:9px}
        .screen-title{font-size:11px}
        .screen-title small{font-size:7px}
        .screen-stat{font-size:7px}
        .screen-stat strong{font-size:15px}
        .screen-stat em{font-size:7px}
        .hero-actions{margin-top:24px}
        .hero-actions .btn{min-width:112px;border:1px solid #e3f8ff99;background:#ffffff18;color:#fff;box-shadow:0 8px 24px #081b2d35;backdrop-filter:blur(8px)}
        .hero-actions .btn:hover{border-color:#9feefa;background:#ffffff30}
        .hero-actions .btn-cyan{border-color:#39d1d4;background:#39d1d4;color:#102c43}
        .hero-note{right:-2%;bottom:11%;padding:14px 18px;border-color:#c7efff77;background:#d9f8ff20}
        @media(max-width:800px){
            .hero{min-height:0;grid-template-columns:1fr;gap:10px;padding:60px 24px 120px}
            .hero-copy{max-width:680px}
            .hero h1{font-size:clamp(3rem,11vw,5rem)}
            .hero-visual{min-height:350px}
            .hero-scene{height:clamp(290px,68vw,410px);max-width:620px}
            .hero-laptop{left:7%;width:88%}
            .hero-note{right:2%;bottom:3%}
        }
        @media(max-width:520px){
            .hero{padding:44px 20px 138px}
            .hero-visual{min-height:280px}
            .hero-scene{height:275px}
            .hero-laptop{left:5%;top:21%;width:92%;height:66%}
            .scene-code{width:45%;padding:8px}
            .scene-caption{left:2%;font-size:7px}
            .hero-note{right:0;bottom:0;padding:9px 12px}
        }
    </style>
    <link rel="stylesheet" href="{{ asset('laptop-background.css') }}">
</head>
<body>
<div class="laptop-backdrop" aria-hidden="true">
    <span class="backdrop-circuit backdrop-circuit-top"></span>
    <span class="backdrop-circuit backdrop-circuit-low"></span>
    <i class="bi bi-laptop backdrop-device"></i>
</div>
<header class="site-nav"><a class="brand" href="{{ route('welcome') }}"><span class="brand-icon"><i class="bi bi-laptop"></i></span>LaptopLoan</a><nav class="nav-actions"><a class="text-decoration-none fw-semibold" href="{{ route('login') }}">Login</a><a class="btn btn-primary" href="{{ route('register') }}">Daftar Akun</a></nav></header>
<main>
<section class="hero"><div class="hero-office" aria-hidden="true"></div><div class="hero-copy"><div class="eyebrow">Peminjaman perangkat sekolah</div><h1>Peminjaman<br>Laptop.</h1><p>Kelola peminjaman laptop sekolah dengan mudah, cepat, dan terorganisir. Temukan perangkat, ajukan peminjaman, dan pantau status dalam satu tempat.</p><div class="hero-actions"><a href="{{ route('login') }}" class="btn">Login</a><a href="{{ route('register') }}" class="btn btn-cyan">Daftar Akun</a></div></div><div class="hero-visual"><div class="hero-scene" role="img" tabindex="0" aria-label="Ilustrasi laptop 3D.">
    <div class="scene-interactive">
    <div class="scene-glow"></div>
    <div class="scene-code" aria-hidden="true"><div class="code-dots"><i></i><i></i><i></i></div><span class="code-line">// sistem peminjaman</span><span class="code-line"><strong>perangkat</strong> = <em>"Laptop"</em>;</span><span class="code-line">status: <strong>terpantau</strong></span><span class="code-line">stok.update();</span></div>
    <div class="hero-laptop" aria-hidden="true"><div class="laptop-screen">
        <div class="screen-topbar"><span>LaptopLoan · Dashboard</span><span>ONLINE</span></div>
        <div class="screen-dashboard"><div class="screen-menu"><b>MENU</b><span><i class="bi bi-grid-1x2-fill"></i> Ringkasan</span><span><i class="bi bi-laptop"></i> Perangkat</span><span><i class="bi bi-arrow-left-right"></i> Peminjaman</span><span><i class="bi bi-clipboard-check"></i> Laporan</span></div>
            <div class="screen-content"><div class="screen-title">Ringkasan inventaris<small>Status perangkat sekolah secara langsung</small></div><div class="screen-stats"><div class="screen-stat">Tersedia<strong>24</strong><em>+4 minggu ini</em></div><div class="screen-stat">Dipinjam<strong>08</strong><em>6 peminjam</em></div><div class="screen-stat">Perlu cek<strong>02</strong><em>Perlu perhatian</em></div><div class="screen-chart"><span style="--bar-height:42%"></span><span style="--bar-height:68%"></span><span style="--bar-height:53%"></span><span style="--bar-height:83%"></span><span style="--bar-height:62%"></span><span style="--bar-height:96%"></span><span style="--bar-height:74%"></span><span style="--bar-height:88%"></span></div></div>
        </div>
    </div><div class="laptop-base"><div class="keyboard-detail"></div><div class="trackpad"></div><div class="laptop-port"><i></i><i></i><i></i></div></div></div>
    <div class="scene-caption"><i class="bi bi-activity"></i> Inventaris · Terpantau langsung</div>
    </div>    <div class="hero-note"><strong><i class="bi bi-shield-check me-1"></i>Terpantau</strong><span>Stok dan status tercatat</span></div>
</div></div></section>
<section class="section"><div class="section-heading"><div class="eyebrow text-info-emphasis">Satu alur, lebih tertata</div><h2 class="display-6 mt-2">Perangkat siap. Proses jelas.</h2><p class="text-secondary">Setiap pengajuan tercatat dan menunggu persetujuan petugas sebelum laptop diserahkan.</p></div><div class="feature-grid"><article class="feature"><span class="feature-icon"><i class="bi bi-search"></i></span><h3 class="h5 fw-bold">Katalog terarah</h3><p class="text-secondary mb-0">Cari laptop berdasarkan nama, merk, model, kode, dan kondisi.</p></article><article class="feature"><span class="feature-icon"><i class="bi bi-box-seam"></i></span><h3 class="h5 fw-bold">Stok akurat</h3><p class="text-secondary mb-0">Ketersediaan diperbarui saat pengajuan disetujui dan laptop dikembalikan.</p></article><article class="feature"><span class="feature-icon"><i class="bi bi-clipboard2-check"></i></span><h3 class="h5 fw-bold">Status transparan</h3><p class="text-secondary mb-0">Pantau pengajuan, masa peminjaman, dan riwayat dari akunmu.</p></article></div></section>
<section class="section pt-0"><div class="section-heading"><div class="eyebrow text-info-emphasis">Cara kerja</div><h2 class="display-6 mt-2">Dari pencarian ke peminjaman</h2></div><div class="steps"><div class="step"><div class="step-number">01 / PILIH</div><h3 class="h5 fw-bold mt-2">Temukan laptop</h3><p class="text-secondary">Pilih perangkat yang sesuai dari katalog.</p></div><div class="step"><div class="step-number">02 / AJUKAN</div><h3 class="h5 fw-bold mt-2">Kirim pengajuan</h3><p class="text-secondary">Tentukan tanggal, jumlah, dan kebutuhan charger.</p></div><div class="step"><div class="step-number">03 / PANTAU</div><h3 class="h5 fw-bold mt-2">Tunggu persetujuan</h3><p class="text-secondary">Lihat status dan tanggal kembali dari dashboard.</p></div></div></section>
<section class="section pt-0"><div class="catalog-strip"><div><div class="eyebrow text-info-emphasis">Siap memulai?</div><h2 class="h3 fw-bold mt-2 mb-1">Jelajahi laptop yang tersedia.</h2><p class="text-secondary mb-0">Katalog dapat dilihat tanpa masuk ke akun.</p></div></div></section>
</main><footer class="d-flex flex-wrap justify-content-between gap-2"><span><i class="bi bi-laptop me-1"></i>LaptopLoan · Sistem Peminjaman Laptop Sekolah</span><a href="{{ route('login') }}" class="text-decoration-none">Masuk admin</a></footer>
<script>if('serviceWorker'in navigator)window.addEventListener('load',()=>navigator.serviceWorker.register('{{ asset('service-worker.js') }}'));</script>
</body></html>
