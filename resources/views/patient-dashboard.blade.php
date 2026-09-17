<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien – Medika Centra</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* ── Design Tokens ─────────────────────────────── */
        :root {
            --teal:        #0d7a6b;
            --teal-dark:   #095c50;
            --teal-mid:    #148f7d;
            --teal-light:  #e6f4f1;
            --teal-xlight: #f2faf8;
            --blue:        #1d6fa4;
            --blue-light:  #e8f2fa;
            --amber:       #b45309;
            --amber-light: #fef3c7;
            --red:         #b91c1c;
            --red-light:   #fee2e2;
            --green:       #15803d;
            --green-light: #dcfce7;
            --gray-50:     #f9fafb;
            --gray-100:    #f3f4f6;
            --gray-200:    #e5e7eb;
            --gray-300:    #d1d5db;
            --gray-400:    #9ca3af;
            --gray-500:    #6b7280;
            --gray-700:    #374151;
            --gray-900:    #111827;
            --white:       #ffffff;
            --radius-sm:   6px;
            --radius-md:   12px;
            --radius-lg:   18px;
            --shadow-sm:   0 1px 3px rgba(0,0,0,.08);
            --shadow-md:   0 4px 16px rgba(0,0,0,.1);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--gray-50);
            color: var(--gray-900);
            min-height: 100vh;
            display: flex;
        }

        h1,h2,h3,.display { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── Sidebar ──────────────────────────────────── */
        .sidebar {
            width: 240px;
            min-width: 240px;
            background: var(--white);
            border-right: 1px solid var(--gray-200);
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: sticky;
            top: 0;
            padding: 0;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 22px 20px 18px;
            border-bottom: 1px solid var(--gray-200);
        }

        .logo-mark {
            width: 34px; height: 34px;
            background: var(--teal);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .logo-mark svg { width: 18px; height: 18px; stroke: white; }

        .logo-text { font-size: .95rem; font-weight: 700; color: var(--gray-900); line-height: 1.2; }
        .logo-sub  { font-size: .7rem; color: var(--gray-400); font-weight: 500; }

        .nav-section { padding: 18px 12px 6px; font-size: .67rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .07em; color: var(--gray-400); }

        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 14px;
            margin: 1px 8px;
            border-radius: var(--radius-sm);
            font-size: .88rem; font-weight: 600;
            color: var(--gray-500);
            cursor: pointer;
            transition: all .15s;
            border: none; background: none; width: calc(100% - 16px); text-align: left;
        }

        .nav-item svg { width: 16px; height: 16px; flex-shrink: 0; }
        .nav-item:hover  { background: var(--gray-100); color: var(--gray-900); }
        .nav-item.active { background: var(--teal-light); color: var(--teal-dark); }

        .sidebar-footer {
            margin-top: auto;
            padding: 12px 8px 16px;
            border-top: 1px solid var(--gray-200);
        }

        /* ── Main ────────────────────────────────────── */
        .main { flex: 1; min-width: 0; display: flex; flex-direction: column; }

        .topbar {
            height: 60px;
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px;
            position: sticky; top: 0; z-index: 20;
        }

        .topbar-title { font-size: 1rem; font-weight: 700; color: var(--gray-900); }

        .user-chip {
            display: flex; align-items: center; gap: 9px;
            padding: 6px 12px 6px 6px;
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: 999px;
        }

        .user-avatar {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: var(--teal);
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-size: .75rem; font-weight: 700;
        }

        .user-name { font-size: .82rem; font-weight: 600; }

        .content { padding: 28px; max-width: 960px; }

        /* ── Pages ───────────────────────────────────── */
        .page { display: none; }
        .page.active { display: block; }

        /* ── Cards / Surfaces ────────────────────────── */
        .card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
        }

        .card-header {
            padding: 18px 22px 0;
            display: flex; align-items: center; justify-content: space-between;
        }

        .card-title { font-size: .95rem; font-weight: 700; color: var(--gray-900); }
        .card-body  { padding: 18px 22px; }

        /* ── Queue Card (hero) ───────────────────────── */
        .queue-hero {
            border: 1.5px solid var(--teal);
            border-radius: var(--radius-lg);
            background: var(--white);
            overflow: hidden;
        }

        .queue-hero-top {
            background: var(--teal);
            padding: 16px 24px;
            display: flex; align-items: center; justify-content: space-between;
        }

        .queue-hero-top .label { font-size: .75rem; font-weight: 600;
            color: rgba(255,255,255,.75); text-transform: uppercase; letter-spacing: .05em; }

        .queue-hero-top .status-pill {
            font-size: .72rem; font-weight: 700; padding: 3px 10px;
            border-radius: 999px; border: 1px solid rgba(255,255,255,.35);
            color: white;
        }

        .queue-hero-body { padding: 24px; }

        .queue-number-display {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 3.8rem;
            font-weight: 800;
            color: var(--teal-dark);
            line-height: 1;
            letter-spacing: -.03em;
        }

        .queue-number-display.is-called {
            color: var(--red);
        }

        .queue-meta { display: flex; gap: 24px; margin-top: 16px; flex-wrap: wrap; }

        .queue-meta-item { display: flex; flex-direction: column; gap: 2px; }
        .queue-meta-item .qm-label { font-size: .72rem; color: var(--gray-400); font-weight: 600;
            text-transform: uppercase; letter-spacing: .04em; }
        .queue-meta-item .qm-value { font-size: .9rem; font-weight: 600; color: var(--gray-700); }

        .queue-divider { width: 1px; background: var(--gray-200); align-self: stretch; }

        /* Called alert */
        .call-alert {
            display: none;
            margin: 0 24px 20px;
            background: var(--red-light);
            border: 1.5px solid #fca5a5;
            border-radius: var(--radius-md);
            padding: 14px 18px;
            gap: 12px;
            align-items: flex-start;
        }

        .call-alert.visible { display: flex; }

        .call-alert-icon { font-size: 1.4rem; line-height: 1; flex-shrink: 0; }

        .call-alert h3 { font-size: .9rem; font-weight: 700; color: var(--red); margin-bottom: 2px; }
        .call-alert p  { font-size: .82rem; color: #991b1b; }

        /* Progress bar */
        .progress-wrap { margin-top: 16px; }
        .progress-label { font-size: .78rem; color: var(--gray-500); margin-bottom: 6px;
            display: flex; justify-content: space-between; }
        .progress-track { height: 6px; background: var(--gray-200); border-radius: 999px; overflow: hidden; }
        .progress-fill  { height: 100%; background: var(--teal); border-radius: 999px;
            transition: width .8s ease; }

        /* Now serving ticker */
        .serving-ticker {
            background: var(--teal-xlight);
            border-top: 1px solid var(--teal-light);
            padding: 10px 24px;
            display: flex; align-items: center; gap: 10px;
            font-size: .82rem;
        }

        .serving-ticker .ticker-label { color: var(--gray-500); font-weight: 500; }
        .serving-ticker .ticker-num   { font-weight: 800; color: var(--teal-dark); font-size: .95rem;
            font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── Badges ──────────────────────────────────── */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: .72rem; font-weight: 700;
        }

        .badge-pending   { background: var(--amber-light); color: var(--amber); }
        .badge-arrived   { background: var(--blue-light);  color: var(--blue);  }
        .badge-called    { background: var(--red-light);   color: var(--red);   }
        .badge-progress  { background: var(--red-light);   color: var(--red);   }
        .badge-completed { background: var(--green-light); color: var(--green); }
        .badge-cancelled { background: var(--gray-100);    color: var(--gray-500); }

        /* ── Buttons ─────────────────────────────────── */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: .85rem; font-weight: 600;
            font-family: inherit;
            cursor: pointer; border: none;
            transition: all .15s;
        }

        .btn svg { width: 15px; height: 15px; }

        .btn-primary { background: var(--teal); color: white; }
        .btn-primary:hover { background: var(--teal-dark); }

        .btn-outline { background: white; color: var(--gray-700); border: 1px solid var(--gray-300); }
        .btn-outline:hover { background: var(--gray-50); }

        .btn-danger { background: var(--red-light); color: var(--red); border: 1px solid #fca5a5; }
        .btn-danger:hover { background: #fee2e2; }

        .btn-sm { padding: 5px 11px; font-size: .78rem; }

        /* ── History list ────────────────────────────── */
        .history-item {
            display: flex; align-items: center; gap: 16px;
            padding: 14px 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .history-item:last-child { border-bottom: none; }

        .hist-icon {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: var(--teal-light);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .hist-icon svg { width: 17px; height: 17px; stroke: var(--teal-dark); }

        .hist-info { flex: 1; min-width: 0; }
        .hist-title { font-size: .875rem; font-weight: 600; margin-bottom: 2px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .hist-sub   { font-size: .78rem; color: var(--gray-400); }

        /* ── Notification item ───────────────────────── */
        .notif-item {
            display: flex; gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .notif-item:last-child { border-bottom: none; }

        .notif-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--teal);
            flex-shrink: 0;
            margin-top: 5px;
        }

        .notif-dot.read { background: var(--gray-300); }

        .notif-title { font-size: .84rem; font-weight: 600; margin-bottom: 2px; }
        .notif-body  { font-size: .78rem; color: var(--gray-500); }

        /* ── Stats grid ──────────────────────────────── */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 24px; }

        .stat-box {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-md);
            padding: 16px 18px;
        }

        .stat-box .sv  { font-size: 1.6rem; font-weight: 800; font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--teal-dark); line-height: 1; margin-bottom: 4px; }
        .stat-box .sl  { font-size: .75rem; color: var(--gray-400); font-weight: 600; }

        /* ── Grid layouts ────────────────────────────── */
        .grid-2 { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }

        /* ── Empty state ─────────────────────────────── */
        .empty { text-align: center; padding: 40px 20px; color: var(--gray-400); }
        .empty svg { width: 36px; height: 36px; margin-bottom: 10px; opacity: .4; }
        .empty p { font-size: .88rem; }

        /* ── Skeleton ────────────────────────────────── */
        .sk { background: linear-gradient(90deg,#f0f0f0 25%,#e8e8e8 50%,#f0f0f0 75%);
            background-size: 200% 100%; animation: sk 1.4s infinite; border-radius: 6px; }
        @keyframes sk { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

        /* ── Step indicator ──────────────────────────── */
        .step-dot { width:28px;height:28px;border-radius:50%;background:var(--gray-200);
            color:var(--gray-400);display:flex;align-items:center;justify-content:center;
            font-size:.78rem;font-weight:700;flex-shrink:0;transition:all .2s; }
        .step-dot.active { background:var(--teal);color:white; }
        .step-dot.done   { background:var(--green);color:white; }
        .step-line { flex:1;height:2px;background:var(--gray-200);transition:background .2s; }
        .step-line.done  { background:var(--green); }

        /* ── Poli card ───────────────────────────────── */
        .poli-card { background:var(--white);border:1.5px solid var(--gray-200);
            border-radius:var(--radius-md);padding:16px;cursor:pointer;transition:all .15s;
            text-align:left;font-family:inherit;display:flex;align-items:center;gap:12px;width:100%; }
        .poli-card:hover  { border-color:var(--teal);background:var(--teal-xlight); }
        .poli-card.chosen { border-color:var(--teal);background:var(--teal-xlight);
            box-shadow:0 0 0 3px rgba(13,122,107,.15); }
        .poli-icon { width:40px;height:40px;border-radius:10px;background:var(--teal-light);
            display:flex;align-items:center;justify-content:center;flex-shrink:0; }
        .poli-icon svg { width:18px;height:18px;stroke:var(--teal-dark); }

        /* ── Schedule card ───────────────────────────── */
        .sched-card { background:var(--white);border:1.5px solid var(--gray-200);
            border-radius:var(--radius-md);padding:14px 16px;cursor:pointer;transition:all .15s;
            display:flex;align-items:center;gap:14px;width:100%;font-family:inherit; }
        .sched-card:hover  { border-color:var(--teal); }
        .sched-card.chosen { border-color:var(--teal);background:var(--teal-xlight);
            box-shadow:0 0 0 3px rgba(13,122,107,.15); }
        .sched-card.full   { opacity:.45;cursor:not-allowed;pointer-events:none; }

        /* ── Ticket Grid ─────────────────────────────── */
        .ticket-wrap {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            padding: 20px 22px;
        }

        .ticket-legend {
            display: flex; align-items: center; gap: 18px;
            margin-bottom: 16px; flex-wrap: wrap;
        }
        .legend-item { display: flex; align-items: center; gap: 6px; font-size: .78rem; font-weight: 600; color: var(--gray-500); }
        .legend-dot  { width:14px; height:14px; border-radius:4px; flex-shrink:0; }
        .legend-dot.avail  { background:var(--white);   border:2px solid var(--teal); }
        .legend-dot.booked { background:var(--gray-200); border:2px solid var(--gray-300); }
        .legend-dot.mine   { background:var(--teal);    border:2px solid var(--teal-dark); }
        .legend-dot.sel    { background:#fef3c7;        border:2px solid var(--amber); }

        .ticket-grid {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            gap: 7px;
        }

        .ticket-slot {
            aspect-ratio: 1;
            border-radius: 7px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .72rem;
            font-weight: 800;
            cursor: pointer;
            border: 2px solid var(--teal);
            background: var(--white);
            color: var(--teal-dark);
            transition: all .14s;
            user-select: none;
            line-height: 1;
            padding: 4px 2px;
        }
        .ticket-slot:hover { background: var(--teal-light); transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(13,122,107,.2); }

        .ticket-slot.booked {
            background: var(--gray-100); border-color: var(--gray-300);
            color: var(--gray-400); cursor: not-allowed;
        }
        .ticket-slot.booked:hover { transform: none; box-shadow: none; background: var(--gray-100); }

        .ticket-slot.mine {
            background: var(--teal); border-color: var(--teal-dark);
            color: white; cursor: default;
        }
        .ticket-slot.mine:hover { transform: none; }

        .ticket-slot.selected {
            background: #fef3c7; border-color: var(--amber);
            color: var(--amber); transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(180,83,9,.25);
        }

        .ticket-slot .snum { font-size: .82rem; font-weight: 800; }
        .ticket-slot .slbl { font-size: .56rem; font-weight: 600; opacity: .7; margin-top: 1px; }

        .ticket-counter {
            display: flex; align-items: center; gap: 14px;
            margin-top: 16px; padding-top: 14px;
            border-top: 1px solid var(--gray-200);
            flex-wrap: wrap;
        }
        .counter-pill {
            display: flex; align-items: center; gap: 6px;
            padding: 5px 12px; border-radius: 999px;
            font-size: .76rem; font-weight: 700;
        }
        .counter-pill.avail { background: var(--teal-light);  color: var(--teal-dark); }
        .counter-pill.taken { background: var(--gray-100);    color: var(--gray-500); }

        @media (max-width: 580px) {
            .ticket-grid { grid-template-columns: repeat(5, 1fr); gap: 6px; }
            .ticket-slot { font-size: .65rem; }
        }

        /* ── Form input ──────────────────────────────── */
        .form-input { width:100%;padding:9px 12px;border:1.5px solid var(--gray-200);
            border-radius:var(--radius-sm);font-family:inherit;font-size:.875rem;
            color:var(--gray-900);outline:none;transition:border-color .15s; }
        .form-input:focus { border-color:var(--teal); }

        /* ── Toast ───────────────────────────────────── */
        #toast { position: fixed; bottom: 20px; right: 20px; z-index: 999;
            display: flex; flex-direction: column; gap: 8px; }

        .toast-item {
            background: var(--gray-900); color: white;
            padding: 11px 16px; border-radius: 10px;
            font-size: .84rem; font-weight: 600;
            display: flex; align-items: center; gap: 9px;
            box-shadow: var(--shadow-md);
            animation: slideUp .2s ease;
            max-width: 280px;
        }

        .toast-item.success { background: var(--teal-dark); }
        .toast-item.error   { background: var(--red); }

        @keyframes slideUp { from{transform:translateY(12px);opacity:0} to{transform:translateY(0);opacity:1} }

        /* ── Ringing animation ───────────────────────── */
        @keyframes ring { 0%,100%{transform:rotate(0)} 20%{transform:rotate(-15deg)}
            40%{transform:rotate(12deg)} 60%{transform:rotate(-8deg)} 80%{transform:rotate(4deg)} }

        .bell-ring { display: inline-block; animation: ring 1s ease-in-out infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Sound button ────────────────────────────── */
        .sound-btn {
            display: flex; align-items: center; gap: 7px;
            padding: 7px 14px;
            border-radius: 999px;
            font-size: .78rem; font-weight: 600;
            font-family: inherit;
            cursor: pointer; border: 1px solid var(--gray-300);
            background: var(--white); color: var(--gray-500);
            transition: all .15s;
        }

        .sound-btn.on { border-color: var(--teal); color: var(--teal-dark);
            background: var(--teal-xlight); }

        .sound-btn svg { width: 13px; height: 13px; }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; height: auto; position: relative; flex-direction: row;
                overflow-x: auto; padding: 10px; gap: 4px; }
            .sidebar-logo { display: none; }
            .nav-section { display: none; }
            .nav-item { flex-direction: column; gap: 4px; font-size: .7rem;
                padding: 8px 10px; min-width: 64px; text-align: center; }
            .sidebar-footer { margin-top: 0; padding: 0; border: none; }
            .grid-2 { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(3, 1fr); }
            .content { padding: 16px; }
        }
    </style>
</head>
<body>

<!-- ═══════════════ SIDEBAR ═══════════════ -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-mark"><i data-lucide="heart-pulse"></i></div>
        <div>
            <div class="logo-text">Medika Centra</div>
            <div class="logo-sub">Portal Pasien</div>
        </div>
    </div>

    <div class="nav-section">Menu</div>
    <button class="nav-item active" onclick="showPage('dashboard')" id="nav-dashboard">
        <i data-lucide="layout-dashboard"></i>Dashboard
    </button>
    <button class="nav-item" onclick="showPage('antrian')" id="nav-antrian">
        <i data-lucide="ticket"></i>Antrian Saya
    </button>
    <button class="nav-item" onclick="showPage('riwayat')" id="nav-riwayat">
        <i data-lucide="clock"></i>Riwayat
    </button>
    <button class="nav-item" onclick="showPage('profil')" id="nav-profil">
        <i data-lucide="user"></i>Data Diri
    </button>

    <div class="sidebar-footer">
        <button class="nav-item" onclick="logout()" style="color:var(--red);">
            <i data-lucide="log-out"></i>Keluar
        </button>
    </div>
</aside>


<!-- ═══════════════ MAIN ═══════════════ -->
<div class="main">

    <header class="topbar">
        <div class="topbar-title" id="topbar-title">Dashboard</div>
        <div style="display:flex;align-items:center;gap:10px;">
            <button class="sound-btn" id="sound-btn" onclick="toggleSound()">
                <i data-lucide="volume-x"></i><span id="sound-label">Aktifkan Suara</span>
            </button>
            <div class="user-chip">
                <div class="user-avatar" id="user-avatar">?</div>
                <span class="user-name" id="user-name">Memuat…</span>
            </div>
        </div>
    </header>

    <div class="content">

        <!-- ══ PAGE: DASHBOARD ══ -->
        <div class="page active" id="page-dashboard">

            <!-- Stats row -->
            <div class="stats-grid" id="stats-grid">
                <div class="stat-box"><div class="sk" style="height:28px;width:40px;margin-bottom:6px;"></div><div class="sk" style="height:13px;width:80px;"></div></div>
                <div class="stat-box"><div class="sk" style="height:28px;width:40px;margin-bottom:6px;"></div><div class="sk" style="height:13px;width:80px;"></div></div>
                <div class="stat-box"><div class="sk" style="height:28px;width:40px;margin-bottom:6px;"></div><div class="sk" style="height:13px;width:80px;"></div></div>
            </div>

            <!-- Active queue hero -->
            <div id="queue-hero-wrap" style="margin-bottom:24px;"></div>

            <!-- CTA booking jika tidak ada antrian aktif -->
            <div id="cta-booking" style="display:none;margin-bottom:24px;">
                <div class="card" style="padding:22px 24px;display:flex;align-items:center;
                    justify-content:space-between;gap:16px;flex-wrap:wrap;
                    border-left:4px solid var(--teal);">
                    <div>
                        <div style="font-weight:700;font-size:.95rem;margin-bottom:3px;">Belum ada antrian hari ini</div>
                        <div style="font-size:.82rem;color:var(--gray-400);">Daftar antrian sekarang untuk mendapatkan nomor urut.</div>
                    </div>
                    <button onclick="showPage('antrian');switchAntrian('daftar')"
                        class="btn btn-primary" style="white-space:nowrap;">
                        <i data-lucide="plus-circle"></i>Daftar Antrian
                    </button>
                </div>
            </div>

            <div class="grid-2">
                <!-- Riwayat -->
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Riwayat Kunjungan</span>
                        <button class="btn btn-outline btn-sm" onclick="showPage('riwayat')">Lihat semua</button>
                    </div>
                    <div class="card-body" id="history-preview">
                        <div class="sk" style="height:50px;margin-bottom:10px;"></div>
                        <div class="sk" style="height:50px;"></div>
                    </div>
                </div>

                <!-- Notifikasi -->
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Notifikasi</span>
                        <span id="notif-badge" style="font-size:.72rem;font-weight:700;background:var(--red-light);color:var(--red);padding:2px 8px;border-radius:999px;display:none;">0</span>
                    </div>
                    <div class="card-body" id="notif-list">
                        <div class="sk" style="height:42px;margin-bottom:8px;"></div>
                        <div class="sk" style="height:42px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ══ PAGE: ANTRIAN ══ -->
        <div class="page" id="page-antrian">
            <!-- Tab: Antrian Aktif vs Daftar Antrian Baru -->
            <div style="display:flex;gap:0;margin-bottom:24px;border-bottom:2px solid var(--gray-200);">
                <button id="tab-aktif" onclick="switchAntrian('aktif')"
                    style="padding:10px 22px;font-size:.88rem;font-weight:700;font-family:inherit;
                           border:none;background:none;cursor:pointer;color:var(--teal-dark);
                           border-bottom:2px solid var(--teal);margin-bottom:-2px;">
                    Antrian Aktif
                </button>
                <button id="tab-daftar" onclick="switchAntrian('daftar')"
                    style="padding:10px 22px;font-size:.88rem;font-weight:700;font-family:inherit;
                           border:none;background:none;cursor:pointer;color:var(--gray-400);
                           border-bottom:2px solid transparent;margin-bottom:-2px;">
                    + Daftar Antrian Baru
                </button>
            </div>

            <!-- Sub-panel: Antrian Aktif -->
            <div id="sub-aktif">
                <div style="margin-bottom:16px;">
                    <p style="font-size:.85rem;color:var(--gray-400);">Status antrian Anda hari ini. Diperbarui otomatis.</p>
                </div>
                <div id="queue-detail-wrap"></div>
            </div>

            <!-- Sub-panel: Daftar Antrian Baru -->
            <div id="sub-daftar" style="display:none;">
                <p style="font-size:.85rem;color:var(--gray-400);margin-bottom:20px;">Pilih poli dan nomor antrian yang Anda inginkan.</p>

                <!-- Step indicator -->
                <div style="display:flex;align-items:center;gap:0;margin-bottom:28px;" id="step-indicator">
                    <div class="step-dot active" id="sdot-1">1</div>
                    <div class="step-line" id="sline-1"></div>
                    <div class="step-dot" id="sdot-2">2</div>
                    <div class="step-line" id="sline-2"></div>
                    <div class="step-dot" id="sdot-3">3</div>
                </div>

                <!-- ═══ STEP 1: Pilih Poli ═══ -->
                <div id="step-1">
                    <h3 style="font-size:.95rem;font-weight:700;margin-bottom:14px;">Pilih Poli Tujuan</h3>
                    <div id="poli-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px;">
                        <div class="sk" style="height:76px;border-radius:12px;"></div>
                        <div class="sk" style="height:76px;border-radius:12px;"></div>
                        <div class="sk" style="height:76px;border-radius:12px;"></div>
                    </div>
                </div>

                <!-- ═══ STEP 2: Grid Nomor Antrian ═══ -->
                <div id="step-2" style="display:none;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:18px;flex-wrap:wrap;">
                        <button onclick="goStep(1)" class="btn btn-outline btn-sm">
                            <i data-lucide="arrow-left"></i>Kembali
                        </button>
                        <div>
                            <div style="font-size:.95rem;font-weight:800;" id="s2-poli-name">–</div>
                            <div style="font-size:.75rem;color:var(--gray-400);" id="s2-date-label">Antrian Hari Ini</div>
                        </div>
                        <div style="margin-left:auto;">
                            <button onclick="refreshSlots()" class="btn btn-outline btn-sm">
                                <i data-lucide="refresh-cw"></i>Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Ticket Grid -->
                    <div class="ticket-wrap">
                        <div class="ticket-legend">
                            <div class="legend-item"><div class="legend-dot avail"></div>Tersedia</div>
                            <div class="legend-item"><div class="legend-dot sel"></div>Dipilih</div>
                            <div class="legend-item"><div class="legend-dot booked"></div>Sudah diambil</div>
                            <div class="legend-item"><div class="legend-dot mine"></div>Milik Anda</div>
                        </div>

                        <div class="ticket-grid" id="ticket-grid">
                            <!-- diisi JS -->
                            <div class="sk" style="aspect-ratio:1;border-radius:7px;"></div>
                            <div class="sk" style="aspect-ratio:1;border-radius:7px;"></div>
                            <div class="sk" style="aspect-ratio:1;border-radius:7px;"></div>
                            <div class="sk" style="aspect-ratio:1;border-radius:7px;"></div>
                            <div class="sk" style="aspect-ratio:1;border-radius:7px;"></div>
                            <div class="sk" style="aspect-ratio:1;border-radius:7px;"></div>
                            <div class="sk" style="aspect-ratio:1;border-radius:7px;"></div>
                            <div class="sk" style="aspect-ratio:1;border-radius:7px;"></div>
                            <div class="sk" style="aspect-ratio:1;border-radius:7px;"></div>
                            <div class="sk" style="aspect-ratio:1;border-radius:7px;"></div>
                        </div>

                        <div class="ticket-counter">
                            <span class="counter-pill avail">
                                <i data-lucide="ticket" style="width:13px;height:13px;"></i>
                                <span id="slot-avail-count">–</span> tersedia
                            </span>
                            <span class="counter-pill taken">
                                <i data-lucide="x-circle" style="width:13px;height:13px;"></i>
                                <span id="slot-taken-count">–</span> diambil
                            </span>
                            <span id="slot-selected-label"
                                style="margin-left:auto;font-size:.8rem;font-weight:700;
                                       color:var(--amber);display:none;">
                                Dipilih: <strong id="slot-selected-num">–</strong>
                            </span>
                        </div>
                    </div>

                    <!-- Pilih dokter (opsional, muncul jika ada jadwal) -->
                    <div id="doctor-picker-wrap" style="display:none;margin-top:20px;">
                        <div style="font-size:.85rem;font-weight:700;margin-bottom:10px;color:var(--gray-700);">
                            <i data-lucide="stethoscope" style="width:14px;height:14px;display:inline;vertical-align:-2px;"></i>
                            Pilih Dokter <span style="font-size:.75rem;font-weight:500;color:var(--gray-400);">(opsional, jika ada jadwal)</span>
                        </div>
                        <div id="doctor-list" style="display:flex;flex-direction:column;gap:9px;"></div>
                    </div>

                    <!-- Tombol lanjut -->
                    <div style="margin-top:20px;">
                        <button onclick="goToConfirm()" class="btn btn-primary" id="btn-to-confirm" disabled
                            style="opacity:.4;transition:.15s;">
                            <i data-lucide="arrow-right"></i>Lanjut ke Konfirmasi
                        </button>
                        <div style="font-size:.76rem;color:var(--gray-400);margin-top:6px;"
                             id="slot-hint">Pilih nomor antrian terlebih dahulu.</div>
                    </div>
                </div>

                <!-- ═══ STEP 3: Konfirmasi ═══ -->
                <div id="step-3" style="display:none;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
                        <button onclick="goStep(2)" class="btn btn-outline btn-sm">
                            <i data-lucide="arrow-left"></i>Kembali
                        </button>
                        <h3 style="font-size:.95rem;font-weight:700;">Konfirmasi Pendaftaran</h3>
                    </div>

                    <div class="card" style="max-width:480px;overflow:hidden;">
                        <div style="background:var(--teal);padding:14px 20px;">
                            <div style="font-size:.7rem;font-weight:700;color:rgba(255,255,255,.7);
                                text-transform:uppercase;letter-spacing:.05em;">Tiket Antrian</div>
                        </div>

                        <!-- Preview tiket -->
                        <div style="padding:22px;display:flex;gap:18px;align-items:flex-start;
                            border-bottom:1px dashed var(--gray-200);">
                            <div style="background:var(--teal-dark);color:white;border-radius:12px;
                                padding:12px 16px;text-align:center;flex-shrink:0;min-width:80px;">
                                <div style="font-size:.65rem;font-weight:700;opacity:.7;
                                    text-transform:uppercase;letter-spacing:.05em;margin-bottom:3px;">No. Antrian</div>
                                <div id="confirm-qnum" style="font-family:'Plus Jakarta Sans',sans-serif;
                                    font-size:1.8rem;font-weight:800;line-height:1;">–</div>
                            </div>
                            <div id="confirm-detail" style="flex:1;"></div>
                        </div>

                        <div style="padding:16px 22px 20px;display:flex;gap:10px;">
                            <button onclick="goStep(2)" class="btn btn-outline" style="flex:1;">Batal</button>
                            <button onclick="submitBooking()" class="btn btn-primary" id="btn-book" style="flex:2;">
                                <i data-lucide="check-circle"></i>Ambil Nomor Ini
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ══ PAGE: RIWAYAT ══ -->
        <div class="page" id="page-riwayat">
            <div style="margin-bottom:20px;">
                <h2 style="font-size:1.15rem;font-weight:800;margin-bottom:4px;">Riwayat Kunjungan</h2>
                <p style="font-size:.85rem;color:var(--gray-400);">Semua riwayat kunjungan Anda di Medika Centra.</p>
            </div>
            <div class="card"><div class="card-body" id="history-full">
                <div class="sk" style="height:54px;margin-bottom:10px;"></div>
                <div class="sk" style="height:54px;"></div>
            </div></div>
        </div>

        <!-- ══ PAGE: PROFIL ══ -->
        <div class="page" id="page-profil">
            <div style="margin-bottom:20px;">
                <h2 style="font-size:1.15rem;font-weight:800;margin-bottom:4px;">Data Diri</h2>
                <p style="font-size:.85rem;color:var(--gray-400);">Informasi akun dan profil medis Anda.</p>
            </div>
            <div class="card"><div class="card-body" id="profil-body">
                <div class="sk" style="height:120px;"></div>
            </div></div>
        </div>

    </div><!-- /content -->
</div><!-- /main -->

<div id="toast"></div>

<script>
lucide.createIcons();

/* ── Config ─────────────────────────── */
const API     = '/api';
const token   = localStorage.getItem('auth_token');
if (!token) window.location.href = '/login';

let soundEnabled      = false;
let lastCalledAt      = null;   // deteksi perubahan untuk TTS
let queuePollInterval = null;
let dashPollInterval  = null;

/* ── Navigation ─────────────────────── */
function showPage(name) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    document.getElementById('page-' + name).classList.add('active');
    const nav = document.getElementById('nav-' + name);
    if (nav) nav.classList.add('active');
    const titles = { dashboard:'Dashboard', antrian:'Antrian Saya', riwayat:'Riwayat Kunjungan', profil:'Data Diri' };
    document.getElementById('topbar-title').textContent = titles[name] || name;
    if (name === 'antrian')  { refreshQueue(); switchAntrian('aktif'); }
    if (name === 'riwayat')  loadHistory(true);
    if (name === 'profil')   loadProfile();
    lucide.createIcons();
}

/* ── Antrian sub-tabs ────────────────── */
function switchAntrian(tab) {
    const isAktif = tab === 'aktif';
    document.getElementById('sub-aktif').style.display  = isAktif ? 'block' : 'none';
    document.getElementById('sub-daftar').style.display = isAktif ? 'none'  : 'block';

    const tAktif  = document.getElementById('tab-aktif');
    const tDaftar = document.getElementById('tab-daftar');
    if (tAktif && tDaftar) {
        tAktif.style.color        = isAktif ? 'var(--teal-dark)' : 'var(--gray-400)';
        tAktif.style.borderBottom = isAktif ? '2px solid var(--teal)' : '2px solid transparent';
        tDaftar.style.color        = !isAktif ? 'var(--teal-dark)' : 'var(--gray-400)';
        tDaftar.style.borderBottom = !isAktif ? '2px solid var(--teal)' : '2px solid transparent';
    }
    if (!isAktif && !bookingState.polisLoaded) loadPoliForBooking();
    lucide.createIcons();
}

/* ── API Helper ─────────────────────── */
async function req(path, opts = {}) {
    const res = await fetch(API + path, {
        headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json',
            ...(opts.json ? {'Content-Type':'application/json'} : {}) },
        ...opts
    });
    if (res.status === 401) { logout(); return null; }
    return res;
}

/* ── Toast ──────────────────────────── */
function toast(msg, type = '') {
    const el = document.createElement('div');
    el.className = 'toast-item ' + type;
    el.innerHTML = msg;
    document.getElementById('toast').appendChild(el);
    setTimeout(() => el.remove(), 3800);
}

/* ── Sound ──────────────────────────── */
function toggleSound() {
    soundEnabled = !soundEnabled;
    const btn = document.getElementById('sound-btn');
    btn.className = 'sound-btn' + (soundEnabled ? ' on' : '');
    document.getElementById('sound-label').textContent = soundEnabled ? 'Suara Aktif' : 'Aktifkan Suara';
    btn.innerHTML = `<i data-lucide="${soundEnabled?'volume-2':'volume-x'}"></i><span id="sound-label">${soundEnabled?'Suara Aktif':'Aktifkan Suara'}</span>`;
    lucide.createIcons();
    if (soundEnabled) {
        speak('Suara notifikasi antrian diaktifkan.');
    }
}

function speak(text) {
    if (!soundEnabled || !('speechSynthesis' in window)) return;
    window.speechSynthesis.cancel();
    const makeU = () => { const u = new SpeechSynthesisUtterance(text); u.lang='id-ID'; u.rate=0.9; u.pitch=1; return u; };
    window.speechSynthesis.speak(makeU());
    window.speechSynthesis.speak(makeU()); // ucap 2x seperti di klinik/RS
}

function vibrate() {
    if ('vibrate' in navigator) navigator.vibrate([600, 250, 600, 250, 800]);
}

/* ── DASHBOARD INIT ─────────────────── */
async function loadDashboard() {
    const res = await req('/dashboard');
    if (!res) return;
    const { data } = await res.json();

    // Update user info
    const name = data.user?.name || '–';
    document.getElementById('user-name').textContent = name;
    document.getElementById('user-avatar').textContent = name.charAt(0).toUpperCase();

    // Stats
    const active    = (data.active_appointments || []).length;
    const total     = (data.recent_history || []).length;
    const unread    = data.unread_notifications || 0;
    document.getElementById('stats-grid').innerHTML = `
        <div class="stat-box"><div class="sv">${active}</div><div class="sl">Antrian Aktif</div></div>
        <div class="stat-box"><div class="sv">${total}</div><div class="sl">Kunjungan Selesai</div></div>
        <div class="stat-box"><div class="sv">${unread}</div><div class="sl">Notifikasi Baru</div></div>
    `;

    if (unread > 0) {
        const nb = document.getElementById('notif-badge');
        nb.textContent = unread; nb.style.display = 'inline';
    }

    // History preview (3 item)
    renderHistoryItems(data.recent_history || [], 'history-preview', 3);

    // Notifications preview
    renderNotifs(data.unread_notifications);
}

async function refreshQueue() {
    const res = await req('/queue/my-status');
    if (!res) return;
    const { data } = await res.json();
    renderQueueHero(data, 'queue-hero-wrap');
    renderQueueDetail(data, 'queue-detail-wrap');
}

/* ── Queue Render ───────────────────── */
function statusLabel(s) {
    const m = { pending:'Menunggu Konfirmasi', confirmed:'Terkonfirmasi',
        arrived:'Sudah Tiba — Menunggu Dipanggil', in_progress:'Sedang Dipanggil!',
        completed:'Selesai', cancelled:'Dibatalkan', no_show:'Tidak Hadir' };
    return m[s] || s;
}

function statusBadge(s) {
    const cls = { pending:'badge-pending', confirmed:'badge-arrived', arrived:'badge-arrived',
        in_progress:'badge-called', completed:'badge-completed',
        cancelled:'badge-cancelled', no_show:'badge-cancelled' };
    return `<span class="badge ${cls[s]||''}">${statusLabel(s)}</span>`;
}

function renderQueueHero(d, containerId) {
    const wrap = document.getElementById(containerId);
    if (!d) {
        // Tampilkan CTA booking di dashboard
        if (containerId === 'queue-hero-wrap') updateBookingCTA(false);
        wrap.innerHTML = '';
        lucide.createIcons();
        return;
    }

    // Ada antrian aktif → sembunyikan CTA
    if (containerId === 'queue-hero-wrap') updateBookingCTA(true);

    const isCalled   = d.is_being_called;
    const ahead      = d.people_ahead ?? 0;
    const progress   = ahead === 0 ? 100 : Math.max(10, Math.round(100 - (ahead / (ahead + 1)) * 90));

    // Deteksi panggilan baru → TTS + vibrate
    if (isCalled && d.called_at && d.called_at !== lastCalledAt) {
        lastCalledAt = d.called_at;
        const msg = `Nomor antrian ${d.queue_number}, silakan menuju ruang ${d.poli_name}.`;
        speak(msg);
        vibrate();
        toast(`🔔 Nomor Anda dipanggil! Segera menuju ${d.poli_name}.`, 'error');
    }

    wrap.innerHTML = `
    <div class="queue-hero">
        <div class="queue-hero-top">
            <div>
                <div class="label">Antrian Aktif Anda</div>
                <div style="font-weight:700;color:white;font-size:1.1rem;margin-top:2px;">${d.poli_name}</div>
            </div>
            <div class="status-pill">${statusLabel(d.status)}</div>
        </div>

        ${isCalled ? `
        <div class="call-alert visible">
            <div class="call-alert-icon"><span class="bell-ring">🔔</span></div>
            <div>
                <h3>Nomor Anda Dipanggil!</h3>
                <p>Silakan segera menuju <strong>${d.poli_name}</strong>. Panggilan ke-${d.called_count}.</p>
            </div>
        </div>` : ''}

        <div class="queue-hero-body">
            <div style="margin-bottom:4px;font-size:.72rem;color:var(--gray-400);font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Nomor Antrian</div>
            <div class="queue-number-display ${isCalled ? 'is-called' : ''}">${d.queue_number}</div>

            <div class="queue-meta">
                <div class="queue-meta-item">
                    <span class="qm-label">Dokter</span>
                    <span class="qm-value">${d.doctor_name || '–'}</span>
                </div>
                <div class="queue-divider"></div>
                <div class="queue-meta-item">
                    <span class="qm-label">Tanggal</span>
                    <span class="qm-value">${formatDate(d.appointment_date)}</span>
                </div>
                <div class="queue-divider"></div>
                <div class="queue-meta-item">
                    <span class="qm-label">Estimasi</span>
                    <span class="qm-value">${d.estimated_time ? d.estimated_time.substring(0,5) : '–'}</span>
                </div>
            </div>

            ${d.status === 'arrived' && ahead > 0 ? `
            <div class="progress-wrap">
                <div class="progress-label">
                    <span>${ahead} pasien sebelum Anda</span>
                    <span style="font-weight:700;color:var(--teal-dark);">${progress}%</span>
                </div>
                <div class="progress-track"><div class="progress-fill" style="width:${progress}%"></div></div>
            </div>` : ''}

            ${d.status === 'arrived' && ahead === 0 ? `
            <div style="margin-top:14px;padding:10px 14px;background:var(--amber-light);border-radius:var(--radius-sm);font-size:.83rem;color:var(--amber);font-weight:600;">
                ⚡ Anda berikutnya! Siap-siap dipanggil.
            </div>` : ''}
        </div>

        <div class="serving-ticker">
            <span class="ticker-label">Sedang dilayani:</span>
            <span class="ticker-num">${d.now_serving || '–'}</span>
        </div>
    </div>`;

    lucide.createIcons();
}

function renderQueueDetail(d, containerId) {
    const wrap = document.getElementById(containerId);
    if (!d) {
        wrap.innerHTML = `
        <div class="card" style="padding:40px;text-align:center;">
            <div class="empty">
                <i data-lucide="ticket"></i>
                <p>Tidak ada antrian aktif hari ini.</p>
            </div>
        </div>`;
        lucide.createIcons();
        return;
    }

    wrap.innerHTML = `
    <div style="display:grid;gap:16px;">
        ${renderQueueHero(d, 'queue-detail-wrap') || ''}
    </div>`;

    // Reuse hero render untuk detail
    renderQueueHero(d, containerId);

    // Tambah tombol batalkan jika pending/confirmed
    if (['pending','confirmed'].includes(d.status)) {
        const extra = document.createElement('div');
        extra.style.marginTop = '12px';
        extra.innerHTML = `
        <button class="btn btn-danger" onclick="cancelQueue(${d.appointment_id})">
            <i data-lucide="x-circle"></i>Batalkan Antrian
        </button>`;
        document.getElementById(containerId).appendChild(extra);
        lucide.createIcons();
    }
}

/* ── History ────────────────────────── */
async function loadHistory(full = false) {
    const res = await req('/dashboard');
    if (!res) return;
    const { data } = await res.json();
    const list = data.recent_history || [];
    renderHistoryItems(list, full ? 'history-full' : 'history-preview', full ? 999 : 3);
}

function renderHistoryItems(list, containerId, limit) {
    const el = document.getElementById(containerId);
    if (!el) return;
    const items = list.slice(0, limit);

    if (!items.length) {
        el.innerHTML = `<div class="empty"><i data-lucide="clock"></i><p>Belum ada riwayat kunjungan.</p></div>`;
        lucide.createIcons();
        return;
    }

    el.innerHTML = items.map(a => `
    <div class="history-item">
        <div class="hist-icon"><i data-lucide="stethoscope"></i></div>
        <div class="hist-info">
            <div class="hist-title">${a.poli?.name || 'Poli'} — ${a.doctor?.user?.name || '–'}</div>
            <div class="hist-sub">${formatDate(a.appointment_date)} &nbsp;·&nbsp; Antrian ${a.queue_number}</div>
        </div>
        ${statusBadge(a.status)}
    </div>`).join('');

    lucide.createIcons();
}

/* ── Notifications ──────────────────── */
function renderNotifs(count) {
    const el = document.getElementById('notif-list');
    if (!el) return;
    if (!count) {
        el.innerHTML = `<div class="empty"><i data-lucide="bell"></i><p>Tidak ada notifikasi baru.</p></div>`;
        lucide.createIcons();
        return;
    }
    el.innerHTML = `<div class="notif-item"><div class="notif-dot"></div><div>
        <div class="notif-title">Anda punya ${count} notifikasi belum dibaca</div>
        <div class="notif-body">Buka halaman notifikasi untuk melihat detail.</div>
    </div></div>`;
    lucide.createIcons();
}

/* ── Profile ────────────────────────── */
async function loadProfile() {
    const res = await req('/profile');
    if (!res) return;
    const json = await res.json();
    const u = json.data;
    const el = document.getElementById('profil-body');
    if (!u) {
        el.innerHTML = `<div class="empty"><p>Profil belum dilengkapi.</p>
            <a href="{{ url('/') }}#profile" class="btn btn-primary" style="margin-top:14px;display:inline-flex;">Lengkapi Profil</a>
        </div>`; lucide.createIcons(); return;
    }
    const p = u.profile;
    el.innerHTML = `
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        ${field('Nama Lengkap', u.name)}
        ${field('Email', u.email)}
        ${p ? field('NIK', p.nik || '–') : ''}
        ${p ? field('No. HP', p.phone_number || '–') : ''}
        ${p ? field('Tanggal Lahir', p.date_of_birth || '–') : ''}
        ${p ? field('Golongan Darah', p.blood_type || '–') : ''}
        ${p ? field('Alergi', p.allergies || '–', true) : ''}
    </div>`;

    function field(label, value, full = false) {
        return `<div style="${full ? 'grid-column:1/-1;' : ''}">
            <div style="font-size:.72rem;color:var(--gray-400);font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-bottom:4px;">${label}</div>
            <div style="font-size:.88rem;font-weight:600;">${value}</div>
        </div>`;
    }
}

/* ── Cancel Queue ────────────────────── */
async function cancelQueue(id) {
    if (!confirm('Batalkan antrian ini?')) return;
    const res = await req(`/appointments/${id}/cancel`, { method:'POST' });
    if (res?.ok) {
        toast('Antrian berhasil dibatalkan.', 'success');
        refreshQueue();
    } else {
        const j = await res?.json();
        toast(j?.message || 'Gagal membatalkan antrian.', 'error');
    }
}

/* ── Helpers ─────────────────────────── */
function formatDate(str) {
    if (!str) return '–';
    return new Date(str).toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' });
}

/* ── Polling ─────────────────────────── */
function startPolling() {
    // Poll queue status tiap 5 detik
    queuePollInterval = setInterval(async () => {
        const res = await req('/queue/my-status');
        if (!res) return;
        const { data } = await res.json();
        renderQueueHero(data, 'queue-hero-wrap');
        // Update detail page jika sedang aktif
        if (document.getElementById('page-antrian').classList.contains('active')) {
            renderQueueDetail(data, 'queue-detail-wrap');
        }
    }, 5000);
}

/* ══════════════════════════════════════
   BOOKING FLOW
══════════════════════════════════════ */
const bookingState = {
    polisLoaded:  false,
    polis:        [],
    selectedPoli: null,
    selectedSlot: null,   // { number, label }
    selectedSched: null,  // jadwal dokter (opsional spesialis)
    currentStep:  1,
    slotsData:    null,   // data dari /api/queue-slots
};

/* ── Step navigation ─────────────────── */
function goStep(n) {
    [1, 2, 3].forEach(i => {
        document.getElementById('step-' + i).style.display = i === n ? 'block' : 'none';
    });
    bookingState.currentStep = n;
    updateStepIndicator(n);
    lucide.createIcons();
}

function updateStepIndicator(active) {
    [1, 2, 3].forEach(i => {
        const dot  = document.getElementById('sdot-' + i);
        const line = document.getElementById('sline-' + i);
        if (!dot) return;
        dot.className = 'step-dot' + (i < active ? ' done' : i === active ? ' active' : '');
        if (line) line.className = 'step-line' + (i < active ? ' done' : '');
    });
}

/* ══ STEP 1: Load & tampilkan daftar poli ══ */
async function loadPoliForBooking() {
    const res = await req('/poli');
    if (!res) return;
    const { data } = await res.json();
    bookingState.polis       = data;
    bookingState.polisLoaded = true;

    const grid = document.getElementById('poli-grid');
    if (!data.length) {
        grid.innerHTML = '<p style="color:var(--gray-400);font-size:.88rem;">Tidak ada poli aktif saat ini.</p>';
        return;
    }
    grid.innerHTML = data.map(p => `
    <button class="poli-card" id="pcard-${p.id}" onclick="selectPoli(${p.id})">
        <div class="poli-icon"><i data-lucide="building-2"></i></div>
        <div style="text-align:left;">
            <div style="font-size:.9rem;font-weight:700;">${p.name}</div>
            <div style="font-size:.75rem;color:var(--gray-400);margin-top:2px;">Kode antrian: ${p.code || '–'}</div>
        </div>
        <i data-lucide="arrow-right" style="width:16px;height:16px;color:var(--gray-400);margin-left:auto;"></i>
    </button>`).join('');
    lucide.createIcons();
}

function selectPoli(id) {
    bookingState.selectedPoli  = bookingState.polis.find(p => p.id === id);
    bookingState.selectedSlot  = null;
    bookingState.selectedSched = null;
    bookingState.slotsData     = null;

    document.querySelectorAll('[id^="pcard-"]').forEach(b => b.classList.remove('chosen'));
    document.getElementById('pcard-' + id)?.classList.add('chosen');

    const p = bookingState.selectedPoli;
    document.getElementById('s2-poli-name').textContent  = p.name;
    document.getElementById('s2-date-label').textContent = 'Antrian Hari Ini — ' + new Date().toLocaleDateString('id-ID',{day:'numeric',month:'long',year:'numeric'});

    // Reset tombol lanjut
    const btnConfirm = document.getElementById('btn-to-confirm');
    btnConfirm.disabled = true;
    btnConfirm.style.opacity = '.4';
    document.getElementById('slot-selected-label').style.display = 'none';
    document.getElementById('slot-hint').textContent = 'Pilih nomor antrian terlebih dahulu.';

    goStep(2);
    loadSlots();
    loadDoctorPicker();
}

/* ══ STEP 2: Load slot grid ══ */
async function loadSlots() {
    const p = bookingState.selectedPoli;
    if (!p) return;

    const grid = document.getElementById('ticket-grid');
    // Tampilkan skeleton 10 kotak
    grid.innerHTML = Array(10).fill('<div class="sk" style="aspect-ratio:1;border-radius:7px;"></div>').join('');

    const today = new Date().toISOString().slice(0, 10);
    const res   = await req(`/queue-slots?poli_id=${p.id}&date=${today}`);
    if (!res) { grid.innerHTML = '<div style="grid-column:1/-1;color:var(--red);font-size:.85rem;">Gagal memuat data. Coba refresh.</div>'; return; }

    const json = await res.json();
    const d    = json.data;
    bookingState.slotsData = d;

    renderSlotGrid(d);
}

function renderSlotGrid(d) {
    const grid = document.getElementById('ticket-grid');

    grid.innerHTML = d.slots.map(slot => {
        const cls = slot.status === 'mine' ? 'mine'
                  : slot.status === 'booked' ? 'booked'
                  : slot.number === bookingState.selectedSlot?.number ? 'selected' : '';
        const title = slot.status === 'mine' ? 'Nomor Anda'
                    : slot.status === 'booked' ? 'Sudah diambil' : `Pilih ${slot.label}`;
        return `<button
            class="ticket-slot ${cls}"
            onclick="selectSlot(${slot.number}, '${slot.label}', '${slot.status}')"
            title="${title}"
            ${slot.status !== 'available' ? 'data-disabled="1"' : ''}>
            <span class="snum">${slot.number}</span>
        </button>`;
    }).join('');

    // Update counter
    document.getElementById('slot-avail-count').textContent = d.available_count;
    document.getElementById('slot-taken-count').textContent = d.booked_count;

    // Kalau sudah ada slot terpilih, restore tampilan
    if (bookingState.selectedSlot) {
        const el = grid.children[bookingState.selectedSlot.number - 1];
        if (el && !el.dataset.disabled) el.classList.add('selected');
    }

    lucide.createIcons();
}

function selectSlot(number, label, status) {
    if (status !== 'available') return; // booked / mine tidak bisa diklik

    // Toggle: klik ulang = batalkan pilihan
    if (bookingState.selectedSlot?.number === number) {
        bookingState.selectedSlot = null;
        document.getElementById('slot-selected-label').style.display = 'none';
        document.getElementById('slot-hint').textContent = 'Pilih nomor antrian terlebih dahulu.';
        const btn = document.getElementById('btn-to-confirm');
        btn.disabled = true; btn.style.opacity = '.4';
        if (bookingState.slotsData) renderSlotGrid(bookingState.slotsData);
        return;
    }

    bookingState.selectedSlot = { number, label };

    // Visual: hapus selected lama, set yang baru
    document.querySelectorAll('.ticket-slot').forEach(el => el.classList.remove('selected'));
    const idx = number - 1;
    const grid = document.getElementById('ticket-grid');
    if (grid.children[idx]) grid.children[idx].classList.add('selected');

    // Update info
    document.getElementById('slot-selected-num').textContent = label;
    document.getElementById('slot-selected-label').style.display = 'inline-flex';
    document.getElementById('slot-hint').textContent = `Nomor ${label} dipilih. Klik "Lanjut" untuk konfirmasi.`;

    const btn = document.getElementById('btn-to-confirm');
    btn.disabled = false; btn.style.opacity = '1';
}

async function refreshSlots() {
    bookingState.selectedSlot  = null;
    bookingState.selectedSched = null;
    document.getElementById('slot-selected-label').style.display = 'none';
    document.getElementById('slot-hint').textContent = 'Pilih nomor antrian terlebih dahulu.';
    const btn = document.getElementById('btn-to-confirm');
    btn.disabled = true; btn.style.opacity = '.4';
    await loadSlots();
}

/* ── Load dokter picker (opsional) ──── */
async function loadDoctorPicker() {
    const p = bookingState.selectedPoli;
    if (!p) return;

    const today  = new Date().toISOString().slice(0, 10);
    const res    = await req(`/schedules?poli_id=${p.id}&date=${today}`);
    if (!res) return;
    const { data } = await res.json();

    const wrap = document.getElementById('doctor-picker-wrap');
    const list = document.getElementById('doctor-list');

    if (!data.length) { wrap.style.display = 'none'; return; }

    wrap.style.display = 'block';
    list.innerHTML = data.map(s => `
    <button class="sched-card ${s.is_full ? 'full' : ''}" id="dcard-${s.id}"
        onclick="${s.is_full ? '' : `pickDoctor(${s.id})`}"
        style="text-align:left;">
        <div style="width:38px;height:38px;border-radius:9px;
            background:${s.is_full ? 'var(--gray-100)' : 'var(--teal-light)'};
            display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i data-lucide="stethoscope" style="width:16px;height:16px;
                stroke:${s.is_full ? 'var(--gray-400)' : 'var(--teal-dark)'};"></i>
        </div>
        <div style="flex:1;">
            <div style="font-size:.875rem;font-weight:700;">${s.doctor_name || '–'}</div>
            <div style="font-size:.75rem;color:var(--gray-400);">${s.specialization || ''} · ${s.start_time}–${s.end_time}</div>
        </div>
        <span style="font-size:.75rem;font-weight:700;
            color:${s.is_full ? 'var(--red)' : s.remaining <= 3 ? 'var(--amber)' : 'var(--green)'};">
            ${s.is_full ? 'Penuh' : s.remaining + ' sisa'}
        </span>
    </button>`).join('');

    // Simpan data schedules ke state
    bookingState._schedules = data;
    lucide.createIcons();
}

function pickDoctor(id) {
    document.querySelectorAll('[id^="dcard-"]').forEach(b => b.classList.remove('chosen'));
    document.getElementById('dcard-' + id)?.classList.add('chosen');
    bookingState.selectedSched = (bookingState._schedules || []).find(s => s.id === id) || null;
}

/* ══ STEP 2 → 3: Konfirmasi ══ */
function goToConfirm() {
    const slot = bookingState.selectedSlot;
    const p    = bookingState.selectedPoli;
    const s    = bookingState.selectedSched; // nullable

    if (!slot || !p) return;

    // Update preview nomor di step 3
    document.getElementById('confirm-qnum').textContent = slot.label;

    const today = new Date().toLocaleDateString('id-ID', {weekday:'long',day:'numeric',month:'long',year:'numeric'});
    document.getElementById('confirm-detail').innerHTML = `
    <div style="display:flex;flex-direction:column;gap:10px;">
        ${cRow('Poli',    p.name)}
        ${cRow('Nomor',   slot.label)}
        ${cRow('Tanggal', today)}
        ${s ? cRow('Dokter', s.doctor_name + ' · ' + s.start_time + '–' + s.end_time) : ''}
    </div>
    <div style="margin-top:14px;padding:10px 13px;background:var(--teal-xlight);
        border-radius:8px;font-size:.8rem;color:var(--teal-dark);">
        ℹ️ Nomor ini akan dikonfirmasi setelah Anda tiba di loket klinik.
    </div>`;

    goStep(3);
}

function cRow(label, value) {
    if (!value) return '';
    return `<div style="display:flex;gap:12px;padding-bottom:9px;border-bottom:1px solid var(--gray-100);">
        <span style="font-size:.76rem;color:var(--gray-400);font-weight:600;min-width:80px;">${label}</span>
        <span style="font-size:.875rem;font-weight:700;">${value}</span>
    </div>`;
}

/* ══ Submit booking ══ */
async function submitBooking() {
    const slot = bookingState.selectedSlot;
    const p    = bookingState.selectedPoli;
    const s    = bookingState.selectedSched;
    if (!slot || !p) return;

    const btn = document.getElementById('btn-book');
    btn.disabled = true;
    btn.innerHTML = '<i data-lucide="loader-2" style="animation:spin .8s linear infinite;width:15px;height:15px;"></i> Mengambil nomor…';
    lucide.createIcons();

    const payload = {
        poli_id:     p.id,
        slot_number: slot.number,
    };
    if (s) payload.doctor_schedule_id = s.id;

    const res  = await req('/appointments', { method: 'POST', json: true, body: JSON.stringify(payload) });
    btn.disabled = false;
    btn.innerHTML = '<i data-lucide="check-circle"></i>Ambil Nomor Ini';
    lucide.createIcons();

    if (!res) return;
    const json = await res.json();

    if (res.ok) {
        const qnum = json.data?.queue_number || slot.label;
        toast(`🎉 Nomor antrian <strong>${qnum}</strong> berhasil diambil!`, 'success');
        // Reset state
        bookingState.selectedSlot  = null;
        bookingState.selectedSched = null;
        bookingState.selectedPoli  = null;
        bookingState.polisLoaded   = false;
        setTimeout(() => {
            switchAntrian('aktif');
            refreshQueue();
            loadDashboard();
        }, 700);
    } else if (json.slot_taken) {
        toast('❌ Nomor ini baru saja diambil orang lain. Pilih nomor lain.', 'error');
        // Refresh grid supaya status terbaru tampil
        goStep(2);
        refreshSlots();
    } else {
        const msg = json.message || Object.values(json.errors || {}).flat().join(' · ') || 'Gagal mendaftar.';
        toast('❌ ' + msg, 'error');
        if (json.needs_profile) setTimeout(() => showPage('profil'), 1500);
        if (json.is_full) goStep(2);
    }
}

/* ── Helpers ─────────────────────────── */
function formatDate(str) {
    if (!str) return '–';
    return new Date(str + 'T00:00:00').toLocaleDateString('id-ID', {
        weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
    });
}

/* ── Update dashboard CTA ────────────── */
function updateBookingCTA(hasActiveQueue) {
    const cta = document.getElementById('cta-booking');
    if (cta) cta.style.display = hasActiveQueue ? 'none' : 'block';
}

/* ── Logout ─────────────────────────── */
function logout() {
    localStorage.clear();
    window.location.href = '/login';
}

/* ── Init ────────────────────────────── */
(async function init() {
    await loadDashboard();
    await refreshQueue();
    startPolling();
})();
</script>
</body>
</html>
