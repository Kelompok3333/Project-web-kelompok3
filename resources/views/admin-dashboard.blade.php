<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel – Medika Centra</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary:       #10B981;
            --primary-dark:  #047857;
            --primary-light: #D1FAE5;
            --sidebar-bg:    #0f172a;
            --sidebar-hover: #1e293b;
            --bg:            #F0FDF4;
            --white:         #ffffff;
            --border:        #E5E7EB;
            --text-main:     #111827;
            --text-muted:    #6B7280;
            --danger:        #ef4444;
            --warning:       #f59e0b;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text-main); min-height: 100vh; display: flex; }

        /* SIDEBAR */
        .sidebar { width: 256px; min-width: 256px; background: var(--sidebar-bg); color: white; height: 100vh; position: sticky; top: 0; display: flex; flex-direction: column; z-index: 40; overflow-y: auto; }
        .sidebar-brand { padding: 22px 20px 18px; border-bottom: 1px solid rgba(255,255,255,0.07); display: flex; align-items: center; gap: 10px; }
        .brand-icon { width: 36px; height: 36px; background: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .brand-text { font-size: 1rem; font-weight: 800; line-height: 1.2; }
        .brand-sub { font-size: 0.68rem; color: #94a3b8; font-weight: 500; }
        .sidebar-section-label { padding: 18px 20px 5px; font-size: 0.63rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #475569; }
        .nav-item { margin: 2px 10px; padding: 10px 14px; border-radius: 10px; color: #94a3b8; display: flex; align-items: center; gap: 10px; cursor: pointer; transition: all 0.18s; font-size: 0.875rem; font-weight: 600; user-select: none; }
        .nav-item svg { width: 17px; height: 17px; flex-shrink: 0; }
        .nav-item:hover { background: var(--sidebar-hover); color: #e2e8f0; }
        .nav-item.active { background: var(--primary); color: white; }
        .sidebar-footer { margin-top: auto; padding: 14px 10px; border-top: 1px solid rgba(255,255,255,0.07); }

        /* MAIN */
        .main-area { flex: 1; overflow-y: auto; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar { background: white; border-bottom: 1px solid var(--border); padding: 0 32px; height: 64px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 30; }
        .topbar-title { font-size: 1.2rem; font-weight: 800; }
        .topbar-sub { font-size: 0.78rem; color: var(--text-muted); margin-top: 1px; }
        .admin-badge { display: flex; align-items: center; gap: 7px; background: var(--primary-light); padding: 6px 14px; border-radius: 999px; font-size: 0.82rem; font-weight: 700; color: var(--primary-dark); }
        .page-content { padding: 28px 32px; flex: 1; }

        /* STAT CARDS */
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 18px; margin-bottom: 28px; }
        .stat-card { background: white; border-radius: 16px; padding: 18px 20px; border: 1px solid var(--border); display: flex; align-items: center; gap: 14px; transition: 0.2s; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.07); }
        .stat-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .stat-icon.green  { background: var(--primary-light); color: var(--primary-dark); }
        .stat-icon.blue   { background: #dbeafe; color: #1d4ed8; }
        .stat-icon.orange { background: #ffedd5; color: #c2410c; }
        .stat-icon.purple { background: #ede9fe; color: #7c3aed; }
        .stat-value { font-size: 1.7rem; font-weight: 800; line-height: 1; }
        .stat-label { font-size: 0.78rem; color: var(--text-muted); font-weight: 600; margin-top: 3px; }

        /* SECTION HEADER */
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
        .section-title { font-size: 1.1rem; font-weight: 800; }
        .section-sub { font-size: 0.8rem; color: var(--text-muted); margin-top: 2px; }

        /* BUTTONS */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 17px; border-radius: 10px; font-family: inherit; font-size: 0.875rem; font-weight: 700; cursor: pointer; border: none; transition: 0.18s; white-space: nowrap; }
        .btn svg { width: 16px; height: 16px; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-outline { background: white; color: var(--text-main); border: 1px solid var(--border); }
        .btn-outline:hover { background: #f8fafc; border-color: #cbd5e1; }
        .btn-danger { background: #fef2f2; color: var(--danger); border: 1px solid #fecaca; }
        .btn-danger:hover { background: #fee2e2; }
        .btn-warning { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .btn-warning:hover { background: #fef3c7; }
        .btn-sm { padding: 6px 11px; font-size: 0.8rem; border-radius: 8px; }

        /* DOCTOR CARDS */
        .card-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 18px; }
        .doctor-card { background: white; border: 1.5px solid var(--border); border-radius: 16px; padding: 18px; display: flex; align-items: center; gap: 14px; transition: 0.2s; }
        .doctor-card:hover { border-color: var(--primary); transform: translateY(-3px); box-shadow: 0 10px 28px rgba(16,185,129,0.12); }
        .doc-photo { width: 70px; height: 70px; border-radius: 12px; object-fit: cover; background: #f1f5f9; border: 1px solid var(--border); flex-shrink: 0; }
        .doc-name { font-weight: 700; font-size: 0.95rem; margin-bottom: 3px; }
        .doc-spec { color: var(--primary-dark); font-size: 0.8rem; font-weight: 700; margin-bottom: 4px; }
        .doc-meta { color: var(--text-muted); font-size: 0.76rem; display: flex; align-items: center; gap: 4px; margin-bottom: 6px; }

        /* BADGE */
        .badge { display: inline-flex; align-items: center; padding: 2px 10px; border-radius: 999px; font-size: 0.71rem; font-weight: 700; }
        .badge-green  { background: var(--primary-light); color: var(--primary-dark); }
        .badge-red    { background: #fee2e2; color: #b91c1c; }
        .badge-blue   { background: #dbeafe; color: #1d4ed8; }
        .badge-orange { background: #ffedd5; color: #c2410c; }
        .badge-gray   { background: #f1f5f9; color: #475569; }

        /* TABLE */
        .table-wrap { background: white; border: 1px solid var(--border); border-radius: 16px; overflow: hidden; }
        .data-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        .data-table thead tr { background: #f8fafc; border-bottom: 1px solid var(--border); }
        .data-table th { padding: 11px 16px; text-align: left; font-weight: 700; font-size: 0.74rem; text-transform: uppercase; letter-spacing: 0.04em; color: var(--text-muted); }
        .data-table td { padding: 13px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .data-table tbody tr:last-child td { border-bottom: none; }
        .data-table tbody tr:hover { background: #fafffe; }

        /* MODAL */
        .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.45); display: none; align-items: center; justify-content: center; z-index: 100; backdrop-filter: blur(4px); padding: 20px; }
        .modal-overlay.open { display: flex; }
        .modal-box { background: white; width: 100%; max-width: 540px; border-radius: 20px; padding: 28px; box-shadow: 0 24px 48px rgba(0,0,0,0.15); max-height: 92vh; overflow-y: auto; }
        .modal-box.modal-lg { max-width: 660px; }
        .modal-box.modal-sm { max-width: 400px; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; }
        .modal-title { font-size: 1.1rem; font-weight: 800; }
        .btn-close { width: 30px; height: 30px; border-radius: 8px; border: 1px solid var(--border); background: white; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.18s; }
        .btn-close:hover { background: #f1f5f9; }

        /* FORM */
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-group { margin-bottom: 14px; }
        .form-label { display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 5px; }
        .form-input, .form-select, .form-textarea { width: 100%; padding: 9px 12px; border: 1.5px solid var(--border); border-radius: 10px; font-family: inherit; font-size: 0.875rem; color: var(--text-main); outline: none; transition: border-color 0.18s; background: white; }
        .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: var(--primary); }
        .form-textarea { resize: vertical; min-height: 80px; }
        .form-hint { font-size: 0.74rem; color: var(--text-muted); margin-top: 3px; }
        .form-actions { display: flex; gap: 10px; margin-top: 22px; justify-content: flex-end; }

        /* ARTICLE CARD */
        .article-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: 18px; }
        .article-card { background: white; border: 1.5px solid var(--border); border-radius: 16px; overflow: hidden; transition: 0.2s; }
        .article-card:hover { border-color: var(--primary); transform: translateY(-3px); box-shadow: 0 10px 24px rgba(16,185,129,0.1); }
        .article-img { width: 100%; height: 150px; object-fit: cover; background: #f1f5f9; display: block; }
        .article-body { padding: 15px; }
        .article-title { font-weight: 700; font-size: 0.92rem; margin-bottom: 6px; line-height: 1.4; }
        .article-meta { font-size: 0.76rem; color: var(--text-muted); display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 12px; }

        /* STATES */
        .empty-state { padding: 52px 20px; text-align: center; color: var(--text-muted); }
        .skeleton { background: linear-gradient(90deg,#e2e8f0 25%,#f1f5f9 50%,#e2e8f0 75%); background-size: 200% 100%; animation: shimmer 1.4s infinite; border-radius: 8px; }
        @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }

        /* PAGES */
        .page { display: none; }
        .page.active { display: block; }

        /* TOAST */
        #toast-container { position: fixed; bottom: 24px; right: 24px; z-index: 200; display: flex; flex-direction: column; gap: 8px; }
        .toast { display: flex; align-items: center; gap: 10px; padding: 13px 16px; border-radius: 12px; background: white; box-shadow: 0 8px 24px rgba(0,0,0,0.12); font-size: 0.875rem; font-weight: 600; animation: slideIn 0.22s ease; max-width: 300px; }
        .toast.success { border-left: 4px solid var(--primary); }
        .toast.error   { border-left: 4px solid var(--danger); }
        .toast.warning { border-left: 4px solid var(--warning); }
        @keyframes slideIn { from { transform: translateX(110%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        /* SEARCH */
        .search-box { position: relative; }
        .search-box svg { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); width: 15px; height: 15px; color: var(--text-muted); pointer-events: none; }
        .search-box input { padding-left: 34px; }

        /* REPORT BAR */
        .bar-wrap { background: #f1f5f9; border-radius: 999px; height: 7px; overflow: hidden; flex: 1; }
        .bar-fill { height: 100%; background: var(--primary); border-radius: 999px; transition: width 0.5s ease; }

        /* SPIN */
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>
</head>
<body>

<!-- ═══════════════ SIDEBAR ═══════════════ -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i data-lucide="shield-check" style="width:17px;height:17px;stroke:white;"></i></div>
        <div>
            <div class="brand-text">Admin Panel</div>
            <div class="brand-sub">Medika Centra</div>
        </div>
    </div>

    <div class="sidebar-section-label">Utama</div>
    <div class="nav-item active" onclick="showPage('dashboard')" id="nav-dashboard"><i data-lucide="layout-dashboard"></i>Dashboard</div>

    <div class="sidebar-section-label">Manajemen SDM</div>
    <div class="nav-item" onclick="showPage('doctors')"   id="nav-doctors"><i data-lucide="stethoscope"></i>Kelola Dokter</div>
    <div class="nav-item" onclick="showPage('staff')"     id="nav-staff"><i data-lucide="users"></i>Kelola Petugas</div>

    <div class="sidebar-section-label">Data Master</div>
    <div class="nav-item" onclick="showPage('polis')"     id="nav-polis"><i data-lucide="building-2"></i>Kelola Poli</div>
    <div class="nav-item" onclick="showPage('schedules')" id="nav-schedules"><i data-lucide="calendar-days"></i>Jadwal Praktik</div>

    <div class="sidebar-section-label">Konten</div>
    <div class="nav-item" onclick="showPage('articles')"  id="nav-articles"><i data-lucide="file-text"></i>Artikel Kesehatan</div>

    <div class="sidebar-section-label">Antrian</div>
    <div class="nav-item" onclick="showPage('queue')"     id="nav-queue"><i data-lucide="megaphone"></i>Panggil Antrian</div>
    <a href="/queue-display?mode=board" target="_blank" class="nav-item" id="nav-qboard" style="text-decoration:none;"><i data-lucide="monitor"></i>Papan TV</a>

    <div class="sidebar-section-label">Monitoring</div>
    <div class="nav-item" onclick="showPage('reports')"   id="nav-reports"><i data-lucide="bar-chart-2"></i>Laporan Kunjungan</div>

    <div class="sidebar-footer">
        <div class="nav-item" onclick="logout()" style="color:#f87171;"><i data-lucide="log-out"></i>Keluar</div>
    </div>
</aside>


<!-- ═══════════════ MAIN ═══════════════ -->
<div class="main-area">

    <header class="topbar">
        <div>
            <div class="topbar-title" id="topbar-title">Dashboard</div>
            <div class="topbar-sub" id="topbar-sub">Selamat datang di Admin Panel Medika Centra</div>
        </div>
        <div class="admin-badge">
            <i data-lucide="shield-check" style="width:14px;height:14px;"></i>
            <span id="admin-name">Administrator</span>
        </div>
    </header>

    <div class="page-content">

        <!-- PAGE: DASHBOARD -->
        <div class="page active" id="page-dashboard">
            <div class="stat-grid" id="stat-grid">
                <div class="stat-card"><div class="skeleton" style="width:46px;height:46px;border-radius:12px;"></div><div style="flex:1"><div class="skeleton" style="height:26px;width:55px;margin-bottom:7px;"></div><div class="skeleton" style="height:12px;width:80px;"></div></div></div>
                <div class="stat-card"><div class="skeleton" style="width:46px;height:46px;border-radius:12px;"></div><div style="flex:1"><div class="skeleton" style="height:26px;width:55px;margin-bottom:7px;"></div><div class="skeleton" style="height:12px;width:80px;"></div></div></div>
                <div class="stat-card"><div class="skeleton" style="width:46px;height:46px;border-radius:12px;"></div><div style="flex:1"><div class="skeleton" style="height:26px;width:55px;margin-bottom:7px;"></div><div class="skeleton" style="height:12px;width:80px;"></div></div></div>
                <div class="stat-card"><div class="skeleton" style="width:46px;height:46px;border-radius:12px;"></div><div style="flex:1"><div class="skeleton" style="height:26px;width:55px;margin-bottom:7px;"></div><div class="skeleton" style="height:12px;width:80px;"></div></div></div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:22px;">
                <div>
                    <h3 style="font-size:0.95rem;font-weight:800;margin-bottom:14px;">Aksi Cepat</h3>
                    <div style="display:flex;flex-direction:column;gap:9px;">
                        <button class="btn btn-primary"  onclick="showPage('doctors')"><i data-lucide="plus-circle"></i>Tambah Dokter Baru</button>
                        <button class="btn btn-outline"  onclick="showPage('staff')"><i data-lucide="user-plus"></i>Tambah Petugas</button>
                        <button class="btn btn-outline"  onclick="showPage('schedules')"><i data-lucide="calendar-plus"></i>Buat Jadwal Praktik</button>
                        <button class="btn btn-outline"  onclick="showPage('articles')"><i data-lucide="file-plus"></i>Tulis Artikel Baru</button>
                    </div>
                </div>
                <div>
                    <h3 style="font-size:0.95rem;font-weight:800;margin-bottom:14px;">Top Dokter Bulan Ini</h3>
                    <div id="top-doctors-list" style="display:flex;flex-direction:column;gap:8px;">
                        <div class="skeleton" style="height:38px;border-radius:10px;"></div>
                        <div class="skeleton" style="height:38px;border-radius:10px;"></div>
                        <div class="skeleton" style="height:38px;border-radius:10px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PAGE: DOCTORS -->
        <div class="page" id="page-doctors">
            <div class="section-header">
                <div><div class="section-title">Manajemen Dokter</div><div class="section-sub">Kelola data dokter, spesialisasi, poli, dan akun login.</div></div>
                <div style="display:flex;gap:10px;align-items:center;">
                    <div class="search-box"><i data-lucide="search"></i><input type="text" class="form-input" id="search-doctor" placeholder="Cari dokter…" oninput="filterDoctors()" style="width:210px;"></div>
                    <button class="btn btn-primary" onclick="openDoctorModal('add')"><i data-lucide="plus-circle"></i>Tambah Dokter</button>
                </div>
            </div>
            <div class="card-grid" id="doctor-grid">
                <div class="doctor-card"><div class="skeleton" style="width:70px;height:70px;border-radius:12px;"></div><div style="flex:1"><div class="skeleton" style="height:18px;margin-bottom:7px;"></div><div class="skeleton" style="height:13px;width:55%;"></div></div></div>
                <div class="doctor-card"><div class="skeleton" style="width:70px;height:70px;border-radius:12px;"></div><div style="flex:1"><div class="skeleton" style="height:18px;margin-bottom:7px;"></div><div class="skeleton" style="height:13px;width:55%;"></div></div></div>
                <div class="doctor-card"><div class="skeleton" style="width:70px;height:70px;border-radius:12px;"></div><div style="flex:1"><div class="skeleton" style="height:18px;margin-bottom:7px;"></div><div class="skeleton" style="height:13px;width:55%;"></div></div></div>
            </div>
        </div>

        <!-- PAGE: STAFF -->
        <div class="page" id="page-staff">
            <div class="section-header">
                <div><div class="section-title">Manajemen Petugas</div><div class="section-sub">Kelola akun petugas, status aktif, dan reset password.</div></div>
                <button class="btn btn-primary" onclick="openStaffModal('add')"><i data-lucide="user-plus"></i>Tambah Petugas</button>
            </div>
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>Nama</th><th>Email</th><th>Status</th><th>Terdaftar</th><th style="text-align:right;">Aksi</th></tr></thead>
                    <tbody id="staff-tbody">
                        <tr><td colspan="5"><div class="skeleton" style="height:38px;margin:8px;border-radius:8px;"></div></td></tr>
                        <tr><td colspan="5"><div class="skeleton" style="height:38px;margin:8px;border-radius:8px;"></div></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PAGE: POLIS -->
        <div class="page" id="page-polis">
            <div class="section-header">
                <div><div class="section-title">Manajemen Poli</div><div class="section-sub">Kelola nama poli, kode antrian, dan kuota harian.</div></div>
                <button class="btn btn-primary" onclick="openPoliModal('add')"><i data-lucide="plus-circle"></i>Tambah Poli</button>
            </div>
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>Nama Poli</th><th>Kode</th><th>Kuota/Hari</th><th>Status</th><th style="text-align:right;">Aksi</th></tr></thead>
                    <tbody id="poli-tbody"><tr><td colspan="5"><div class="skeleton" style="height:38px;margin:8px;border-radius:8px;"></div></td></tr></tbody>
                </table>
            </div>
        </div>

        <!-- PAGE: SCHEDULES -->
        <div class="page" id="page-schedules">
            <div class="section-header">
                <div><div class="section-title">Jadwal Praktik Dokter</div><div class="section-sub">Atur jadwal praktik dokter per hari dan per poli.</div></div>
                <button class="btn btn-primary" onclick="openScheduleModal('add')"><i data-lucide="calendar-plus"></i>Tambah Jadwal</button>
            </div>
            <div style="display:flex;gap:10px;margin-bottom:18px;flex-wrap:wrap;align-items:center;">
                <select class="form-select" id="filter-sched-poli" style="width:auto;" onchange="loadSchedules()"><option value="">Semua Poli</option></select>
                <input type="date" class="form-input" id="filter-sched-date" style="width:auto;" onchange="loadSchedules()">
                <button class="btn btn-outline btn-sm" onclick="resetScheduleFilter()"><i data-lucide="rotate-ccw"></i>Reset</button>
            </div>
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>Dokter</th><th>Poli</th><th>Tanggal</th><th>Jam Praktik</th><th>Kuota</th><th>Status</th><th style="text-align:right;">Aksi</th></tr></thead>
                    <tbody id="schedule-tbody"><tr><td colspan="7"><div class="skeleton" style="height:38px;margin:8px;border-radius:8px;"></div></td></tr></tbody>
                </table>
            </div>
        </div>

        <!-- PAGE: ARTICLES -->
        <div class="page" id="page-articles">
            <div class="section-header">
                <div><div class="section-title">Artikel Kesehatan</div><div class="section-sub">Kelola konten artikel yang tampil di halaman publik.</div></div>
                <button class="btn btn-primary" onclick="openArticleModal('add')"><i data-lucide="file-plus"></i>Tulis Artikel</button>
            </div>
            <div class="article-grid" id="article-grid">
                <div class="article-card"><div class="skeleton article-img"></div><div class="article-body"><div class="skeleton" style="height:16px;margin-bottom:7px;"></div><div class="skeleton" style="height:12px;width:65%;"></div></div></div>
                <div class="article-card"><div class="skeleton article-img"></div><div class="article-body"><div class="skeleton" style="height:16px;margin-bottom:7px;"></div><div class="skeleton" style="height:12px;width:65%;"></div></div></div>
                <div class="article-card"><div class="skeleton article-img"></div><div class="article-body"><div class="skeleton" style="height:16px;margin-bottom:7px;"></div><div class="skeleton" style="height:12px;width:65%;"></div></div></div>
            </div>
        </div>

        <!-- PAGE: REPORTS -->
        <div class="page" id="page-reports">
            <div class="section-header">
                <div><div class="section-title">Laporan Kunjungan</div><div class="section-sub">Statistik kunjungan pasien berdasarkan rentang tanggal.</div></div>
                <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                    <input type="date" class="form-input" id="report-start" style="width:auto;">
                    <span style="color:var(--text-muted);font-weight:700;">–</span>
                    <input type="date" class="form-input" id="report-end" style="width:auto;">
                    <button class="btn btn-primary btn-sm" onclick="loadReports()"><i data-lucide="search"></i>Tampilkan</button>
                </div>
            </div>
            <div class="stat-grid" id="report-stats" style="margin-bottom:24px;">
                <div class="stat-card"><div class="skeleton" style="width:46px;height:46px;border-radius:12px;"></div><div style="flex:1"><div class="skeleton" style="height:24px;width:50px;margin-bottom:6px;"></div><div class="skeleton" style="height:12px;width:75px;"></div></div></div>
                <div class="stat-card"><div class="skeleton" style="width:46px;height:46px;border-radius:12px;"></div><div style="flex:1"><div class="skeleton" style="height:24px;width:50px;margin-bottom:6px;"></div><div class="skeleton" style="height:12px;width:75px;"></div></div></div>
                <div class="stat-card"><div class="skeleton" style="width:46px;height:46px;border-radius:12px;"></div><div style="flex:1"><div class="skeleton" style="height:24px;width:50px;margin-bottom:6px;"></div><div class="skeleton" style="height:12px;width:75px;"></div></div></div>
                <div class="stat-card"><div class="skeleton" style="width:46px;height:46px;border-radius:12px;"></div><div style="flex:1"><div class="skeleton" style="height:24px;width:50px;margin-bottom:6px;"></div><div class="skeleton" style="height:12px;width:75px;"></div></div></div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:22px;">
                <div>
                    <h3 style="font-size:0.95rem;font-weight:800;margin-bottom:14px;">Kunjungan Per Poli</h3>
                    <div id="report-poli" style="display:flex;flex-direction:column;gap:9px;">
                        <div class="skeleton" style="height:34px;border-radius:8px;"></div>
                        <div class="skeleton" style="height:34px;border-radius:8px;"></div>
                    </div>
                </div>
                <div>
                    <h3 style="font-size:0.95rem;font-weight:800;margin-bottom:14px;">Top Dokter Bulan Ini</h3>
                    <div id="report-doctors" style="display:flex;flex-direction:column;gap:9px;">
                        <div class="skeleton" style="height:34px;border-radius:8px;"></div>
                        <div class="skeleton" style="height:34px;border-radius:8px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PAGE: QUEUE CALL -->
        <div class="page" id="page-queue">
            <div class="section-header">
                <div>
                    <div class="section-title">Sistem Pemanggilan Antrian</div>
                    <div class="section-sub">Panggil nomor antrian pasien per poli. Diperbarui otomatis setiap 5 detik.</div>
                </div>
                <div style="display:flex;gap:8px;align-items:center;">
                    <button id="q-sound-btn" onclick="qToggleSound()" class="btn btn-outline btn-sm">
                        <i data-lucide="volume-x" id="q-sound-icon"></i><span id="q-sound-label">Aktifkan Suara</span>
                    </button>
                    <a href="/queue-display?mode=board" target="_blank" class="btn btn-outline btn-sm">
                        <i data-lucide="monitor"></i>Buka Papan TV
                    </a>
                </div>
            </div>

            <!-- Poli tabs -->
            <div id="q-poli-tabs" style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px;"></div>

            <!-- Layout: left = mini board, right = list -->
            <div style="display:grid;grid-template-columns:280px 1fr;gap:20px;align-items:start;">

                <!-- Mini board -->
                <div style="display:flex;flex-direction:column;gap:14px;">
                    <div class="table-wrap" style="padding:18px;">
                        <div style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--text-muted);margin-bottom:6px;">Sedang Dipanggil</div>
                        <div id="q-now-serving" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:3rem;font-weight:800;color:var(--primary-dark);line-height:1;">–</div>
                        <div id="q-serving-name" style="font-size:.82rem;color:var(--text-muted);margin-top:4px;">–</div>
                        <div id="q-serving-count" style="font-size:.75rem;color:#94a3b8;margin-top:2px;"></div>
                    </div>

                    <div class="table-wrap" id="q-next-box" style="padding:18px;display:none;">
                        <div style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#b45309;margin-bottom:6px;">Berikutnya</div>
                        <div id="q-next-num" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.8rem;font-weight:800;color:#b45309;line-height:1;">–</div>
                        <div id="q-next-name" style="font-size:.8rem;color:var(--text-muted);margin-top:3px;"></div>
                    </div>

                    <div class="table-wrap" style="padding:14px 18px;">
                        <div style="display:flex;justify-content:space-between;font-size:.8rem;">
                            <span style="color:var(--text-muted);font-weight:600;">Menunggu</span>
                            <span id="q-waiting-count" style="font-weight:800;color:var(--primary-dark);">–</span>
                        </div>
                    </div>
                </div>

                <!-- Antrian list -->
                <div class="table-wrap">
                    <div style="padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:.9rem;font-weight:800;">Antrian Aktif</span>
                        <span id="q-list-count" style="font-size:.75rem;background:var(--primary-light);color:var(--primary-dark);padding:2px 10px;border-radius:999px;font-weight:700;">0 pasien</span>
                    </div>
                    <div id="q-list-body" style="padding:6px 0;">
                        <div style="padding:40px;text-align:center;color:var(--text-muted);font-size:.875rem;">Pilih poli di atas untuk memulai.</div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /page-content -->
</div><!-- /main-area -->


<!-- ═════════════════════ MODALS ═════════════════════ -->

<!-- MODAL: DOCTOR -->
<div class="modal-overlay" id="modal-doctor">
    <div class="modal-box">
        <div class="modal-header">
            <span class="modal-title" id="modal-doctor-title">Tambah Dokter Baru</span>
            <button class="btn-close" onclick="closeModal('modal-doctor')"><i data-lucide="x" style="width:15px;height:15px;"></i></button>
        </div>
        <form id="form-doctor" onsubmit="submitDoctor(event)">
            <input type="hidden" id="doc-id">
            <div class="form-row">
                <div class="form-group"><label class="form-label">Nama Lengkap *</label><input type="text" id="doc-name" class="form-input" required placeholder="dr. Budi Santoso"></div>
                <div class="form-group"><label class="form-label">Spesialisasi *</label><input type="text" id="doc-spec" class="form-input" required placeholder="Sp.PD"></div>
            </div>
            <div id="doc-auth-fields">
                <div class="form-row">
                    <div class="form-group"><label class="form-label">Email *</label><input type="email" id="doc-email" class="form-input" placeholder="dokter@medika.com"></div>
                    <div class="form-group"><label class="form-label">Password *</label><input type="password" id="doc-pass" class="form-input" placeholder="Min. 8 karakter"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Poli *</label><select id="doc-poli" class="form-select" required><option value="">Pilih Poli…</option></select></div>
                <div class="form-group"><label class="form-label">Pengalaman (tahun)</label><input type="number" id="doc-exp" class="form-input" min="0" placeholder="0"></div>
            </div>
            <div class="form-group"><label class="form-label">Foto Profil</label><input type="file" id="doc-photo" class="form-input" accept="image/*"><div class="form-hint">JPG/PNG, maks 2MB</div></div>
            <div class="form-group"><label class="form-label">Bio Singkat</label><textarea id="doc-bio" class="form-textarea" placeholder="Deskripsi singkat dokter…"></textarea></div>
            <div id="doc-active-wrap" class="form-group" style="display:none;">
                <label class="form-label">Status</label>
                <select id="doc-active" class="form-select"><option value="1">Aktif</option><option value="0">Nonaktif</option></select>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-doctor')">Batal</button>
                <button type="submit" id="btn-doctor-submit" class="btn btn-primary"><i data-lucide="save"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: STAFF -->
<div class="modal-overlay" id="modal-staff">
    <div class="modal-box">
        <div class="modal-header">
            <span class="modal-title" id="modal-staff-title">Tambah Petugas Baru</span>
            <button class="btn-close" onclick="closeModal('modal-staff')"><i data-lucide="x" style="width:15px;height:15px;"></i></button>
        </div>
        <form id="form-staff" onsubmit="submitStaff(event)">
            <input type="hidden" id="staff-id">
            <div class="form-group"><label class="form-label">Nama Lengkap *</label><input type="text" id="staff-name" class="form-input" required placeholder="Siti Rahayu"></div>
            <div class="form-group"><label class="form-label">Email *</label><input type="email" id="staff-email" class="form-input" required placeholder="petugas@medika.com"></div>
            <div id="staff-pass-wrap">
                <div class="form-group"><label class="form-label">Password *</label><input type="password" id="staff-pass" class="form-input" placeholder="Min. 8 karakter"></div>
                <div class="form-group"><label class="form-label">Konfirmasi Password *</label><input type="password" id="staff-pass2" class="form-input" placeholder="Ulangi password"></div>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-staff')">Batal</button>
                <button type="submit" id="btn-staff-submit" class="btn btn-primary"><i data-lucide="save"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: RESET PASSWORD -->
<div class="modal-overlay" id="modal-reset-pass">
    <div class="modal-box modal-sm">
        <div class="modal-header">
            <span class="modal-title">Reset Password Petugas</span>
            <button class="btn-close" onclick="closeModal('modal-reset-pass')"><i data-lucide="x" style="width:15px;height:15px;"></i></button>
        </div>
        <p style="font-size:0.875rem;color:var(--text-muted);margin-bottom:18px;">Password baru untuk <strong id="reset-staff-name"></strong>.</p>
        <form onsubmit="submitResetPassword(event)">
            <input type="hidden" id="reset-staff-id">
            <div class="form-group"><label class="form-label">Password Baru *</label><input type="password" id="new-pass" class="form-input" required placeholder="Min. 8 karakter"></div>
            <div class="form-group"><label class="form-label">Konfirmasi *</label><input type="password" id="new-pass2" class="form-input" required placeholder="Ulangi password"></div>
            <div class="form-actions">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-reset-pass')">Batal</button>
                <button type="submit" class="btn btn-warning"><i data-lucide="key"></i>Reset</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: POLI -->
<div class="modal-overlay" id="modal-poli">
    <div class="modal-box" style="max-width:460px;">
        <div class="modal-header">
            <span class="modal-title" id="modal-poli-title">Tambah Poli Baru</span>
            <button class="btn-close" onclick="closeModal('modal-poli')"><i data-lucide="x" style="width:15px;height:15px;"></i></button>
        </div>
        <form id="form-poli" onsubmit="submitPoli(event)">
            <input type="hidden" id="poli-id">
            <div class="form-row">
                <div class="form-group"><label class="form-label">Nama Poli *</label><input type="text" id="poli-name" class="form-input" required placeholder="Poli Umum"></div>
                <div class="form-group"><label class="form-label">Kode Antrian *</label><input type="text" id="poli-code" class="form-input" required placeholder="PU" maxlength="10" style="text-transform:uppercase;"></div>
            </div>
            <div class="form-group"><label class="form-label">Deskripsi</label><textarea id="poli-desc" class="form-textarea" rows="2" placeholder="Keterangan singkat…"></textarea></div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Kuota Per Hari *</label><input type="number" id="poli-quota" class="form-input" required min="1" placeholder="50"></div>
                <div class="form-group"><label class="form-label">Status</label><select id="poli-active" class="form-select"><option value="1">Aktif</option><option value="0">Nonaktif</option></select></div>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-poli')">Batal</button>
                <button type="submit" class="btn btn-primary"><i data-lucide="save"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: SCHEDULE -->
<div class="modal-overlay" id="modal-schedule">
    <div class="modal-box">
        <div class="modal-header">
            <span class="modal-title" id="modal-schedule-title">Tambah Jadwal Praktik</span>
            <button class="btn-close" onclick="closeModal('modal-schedule')"><i data-lucide="x" style="width:15px;height:15px;"></i></button>
        </div>
        <form id="form-schedule" onsubmit="submitSchedule(event)">
            <input type="hidden" id="sched-id">
            <div class="form-row">
                <div class="form-group"><label class="form-label">Dokter *</label><select id="sched-doctor" class="form-select" required><option value="">Pilih Dokter…</option></select></div>
                <div class="form-group"><label class="form-label">Poli *</label><select id="sched-poli" class="form-select" required><option value="">Pilih Poli…</option></select></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Tanggal *</label><input type="date" id="sched-date" class="form-input" required></div>
                <div class="form-group"><label class="form-label">Kuota Pasien *</label><input type="number" id="sched-quota" class="form-input" required min="1" max="100" placeholder="20"></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Jam Mulai *</label><input type="time" id="sched-start" class="form-input" required></div>
                <div class="form-group"><label class="form-label">Jam Selesai *</label><input type="time" id="sched-end" class="form-input" required></div>
            </div>
            <div id="sched-avail-wrap" class="form-group" style="display:none;">
                <label class="form-label">Ketersediaan</label>
                <select id="sched-avail" class="form-select"><option value="1">Tersedia</option><option value="0">Libur / Tutup</option></select>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-schedule')">Batal</button>
                <button type="submit" class="btn btn-primary"><i data-lucide="save"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: ARTICLE -->
<div class="modal-overlay" id="modal-article">
    <div class="modal-box modal-lg">
        <div class="modal-header">
            <span class="modal-title" id="modal-article-title">Tulis Artikel Baru</span>
            <button class="btn-close" onclick="closeModal('modal-article')"><i data-lucide="x" style="width:15px;height:15px;"></i></button>
        </div>
        <form id="form-article" onsubmit="submitArticle(event)">
            <input type="hidden" id="article-id">
            <div class="form-group"><label class="form-label">Judul Artikel *</label><input type="text" id="article-title" class="form-input" required placeholder="Tips Hidup Sehat…"></div>
            <div class="form-group"><label class="form-label">Ringkasan</label><textarea id="article-excerpt" class="form-textarea" rows="2" placeholder="Deskripsi singkat artikel…"></textarea></div>
            <div class="form-group"><label class="form-label">Isi Artikel *</label><textarea id="article-content" class="form-textarea" rows="7" required placeholder="Tulis konten artikel di sini…"></textarea></div>
            <div class="form-row">
                <div class="form-group"><label class="form-label">Gambar Utama</label><input type="file" id="article-img" class="form-input" accept="image/*"><div class="form-hint">JPG/PNG/WebP, maks 3MB</div></div>
                <div class="form-group"><label class="form-label">Status Publikasi</label><select id="article-publish" class="form-select"><option value="0">Draft (Tersembunyi)</option><option value="1">Publikasikan Sekarang</option></select></div>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-article')">Batal</button>
                <button type="submit" class="btn btn-primary"><i data-lucide="save"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: CONFIRM DELETE -->
<div class="modal-overlay" id="modal-confirm">
    <div class="modal-box modal-sm">
        <div class="modal-header">
            <span class="modal-title" style="color:var(--danger);"><i data-lucide="alert-triangle" style="width:18px;height:18px;display:inline;vertical-align:-3px;margin-right:6px;"></i>Konfirmasi Hapus</span>
            <button class="btn-close" onclick="closeModal('modal-confirm')"><i data-lucide="x" style="width:15px;height:15px;"></i></button>
        </div>
        <p id="confirm-msg" style="font-size:0.875rem;color:var(--text-muted);margin-bottom:22px;">Apakah Anda yakin ingin menghapus data ini?</p>
        <div class="form-actions">
            <button class="btn btn-outline" onclick="closeModal('modal-confirm')">Batal</button>
            <button class="btn btn-danger" id="btn-confirm-ok"><i data-lucide="trash-2"></i>Hapus</button>
        </div>
    </div>
</div>

<div id="toast-container"></div>


<!-- ═════════════════════ JAVASCRIPT ═════════════════════ -->
<script>
lucide.createIcons();

const API  = '/api';
let token  = localStorage.getItem('auth_token');
let role   = localStorage.getItem('user_role');
if (!token || role !== 'admin') window.location.href = '/login';

let allDoctors = [];
let allPolis   = [];

/* ─── NAVIGATION ──────────────────────── */
const pages = {
    dashboard: { title:'Dashboard',              sub:'Ringkasan data klinik hari ini',               load: loadDashboard },
    doctors:   { title:'Manajemen Dokter',       sub:'Kelola data dokter dan akun login',            load: loadDoctors   },
    staff:     { title:'Manajemen Petugas',      sub:'Kelola akun petugas dan status aktif',         load: loadStaff     },
    polis:     { title:'Manajemen Poli',         sub:'Kelola poli, kode antrian, dan kuota harian',  load: loadPolis     },
    schedules: { title:'Jadwal Praktik',         sub:'Atur jadwal dokter per hari',                  load: loadSchedules },
    articles:  { title:'Artikel Kesehatan',      sub:'Kelola konten artikel yang tampil di publik',  load: loadArticles  },
    reports:   { title:'Laporan Kunjungan',      sub:'Statistik kunjungan pasien',                   load: loadReports   },
    queue:     { title:'Pemanggilan Antrian',    sub:'Panggil nomor antrian pasien per poli',        load: initQueuePage },
};

function showPage(name) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    document.getElementById('page-' + name).classList.add('active');
    document.getElementById('nav-'  + name).classList.add('active');
    const cfg = pages[name];
    document.getElementById('topbar-title').textContent = cfg.title;
    document.getElementById('topbar-sub').textContent   = cfg.sub;
    cfg.load && cfg.load();
    lucide.createIcons();
}

/* ─── API HELPER ──────────────────────── */
async function api(method, path, body = null, isForm = false) {
    const headers = { 'Authorization': 'Bearer ' + token };
    if (!isForm) headers['Content-Type'] = 'application/json';
    const opts = { method, headers };
    if (body) opts.body = isForm ? body : JSON.stringify(body);
    const res  = await fetch(API + path, opts);
    const json = await res.json().catch(() => ({}));
    if (res.status === 401) { logout(); return null; }
    return { ok: res.ok, status: res.status, data: json };
}

/* ─── TOAST ───────────────────────────── */
function toast(msg, type = 'success') {
    const icon = { success:'check-circle', error:'x-circle', warning:'alert-triangle' }[type];
    const color= { success:'var(--primary)', error:'var(--danger)', warning:'var(--warning)' }[type];
    const el   = document.createElement('div');
    el.className = 'toast ' + type;
    el.innerHTML = `<i data-lucide="${icon}" style="width:17px;height:17px;color:${color};flex-shrink:0;"></i><span>${msg}</span>`;
    document.getElementById('toast-container').appendChild(el);
    lucide.createIcons();
    setTimeout(() => el.remove(), 3600);
}

/* ─── MODALS ──────────────────────────── */
function openModal(id)  { document.getElementById(id).classList.add('open');    lucide.createIcons(); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

function confirmDelete(msg, fn) {
    document.getElementById('confirm-msg').textContent = msg;
    document.getElementById('btn-confirm-ok').onclick  = () => { closeModal('modal-confirm'); fn(); };
    openModal('modal-confirm');
}

/* ─── UTILS ───────────────────────────── */
function formatDate(str) {
    if (!str) return '–';
    return new Date(str).toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' });
}
function btnLoad(id, loading) {
    const b = document.getElementById(id);
    if (!b) return;
    if (loading) {
        b._orig    = b.innerHTML;
        b.disabled = true;
        b.innerHTML= '<i data-lucide="loader-2" style="width:15px;height:15px;animation:spin 1s linear infinite;"></i> Menyimpan…';
        lucide.createIcons();
    } else {
        b.disabled = false;
        b.innerHTML= b._orig || 'Simpan';
        lucide.createIcons();
    }
}

/* ═══════════════ DASHBOARD ═══════════════ */
async function loadDashboard() {
    const [sum, top] = await Promise.all([
        api('GET', '/admin/summary'),
        api('GET', '/admin/reports/top-doctors?limit=5'),
    ]);
    if (sum?.ok) {
        const d = sum.data.data;
        document.getElementById('stat-grid').innerHTML = `
            <div class="stat-card"><div class="stat-icon green"><i data-lucide="stethoscope" style="width:21px;height:21px;"></i></div><div><div class="stat-value">${d.total_doctors}</div><div class="stat-label">Dokter Aktif</div></div></div>
            <div class="stat-card"><div class="stat-icon blue"><i data-lucide="users" style="width:21px;height:21px;"></i></div><div><div class="stat-value">${d.total_staff}</div><div class="stat-label">Petugas Aktif</div></div></div>
            <div class="stat-card"><div class="stat-icon purple"><i data-lucide="user-round" style="width:21px;height:21px;"></i></div><div><div class="stat-value">${d.total_patients}</div><div class="stat-label">Total Pasien</div></div></div>
            <div class="stat-card"><div class="stat-icon orange"><i data-lucide="calendar-check" style="width:21px;height:21px;"></i></div><div><div class="stat-value">${d.today_appointments}</div><div class="stat-label">Antrian Hari Ini</div></div></div>
        `;
        lucide.createIcons();
    }
    if (top?.ok) {
        const list = top.data.data;
        if (!list.length) {
            document.getElementById('top-doctors-list').innerHTML = '<p style="font-size:0.85rem;color:var(--text-muted);">Belum ada data kunjungan bulan ini.</p>';
            return;
        }
        const max = list[0]?.total_visits || 1;
        document.getElementById('top-doctors-list').innerHTML = list.map((d,i) => `
            <div style="display:flex;align-items:center;gap:10px;padding:8px 12px;background:white;border:1px solid var(--border);border-radius:10px;">
                <span style="width:22px;font-size:0.75rem;font-weight:800;color:var(--text-muted);">#${i+1}</span>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:0.83rem;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${d.doctor_name}</div>
                    <div style="display:flex;align-items:center;gap:8px;margin-top:3px;">
                        <div class="bar-wrap"><div class="bar-fill" style="width:${(d.total_visits/max*100).toFixed(0)}%"></div></div>
                        <span style="font-size:0.75rem;font-weight:700;color:var(--primary-dark);white-space:nowrap;">${d.total_visits}x</span>
                    </div>
                </div>
            </div>`).join('');
    }
}

/* ═══════════════ DOCTORS ═══════════════ */
async function loadDoctors() {
    const res = await api('GET', '/admin/doctors');
    if (!res?.ok) { toast('Gagal memuat data dokter','error'); return; }
    allDoctors = res.data.data;
    renderDoctors(allDoctors);
}

function renderDoctors(list) {
    const grid = document.getElementById('doctor-grid');
    if (!list.length) {
        grid.innerHTML = '<div class="empty-state" style="grid-column:1/-1"><p>Belum ada data dokter.</p></div>';
        return;
    }
    grid.innerHTML = list.map(doc => {
        const photo = doc.photo
            ? `/storage/${doc.photo}`
            : `https://ui-avatars.com/api/?name=${encodeURIComponent(doc.user?.name||'DR')}&background=D1FAE5&color=047857&size=70`;
        return `
        <div class="doctor-card">
            <img src="${photo}" class="doc-photo" alt="${doc.user?.name||''}"
                onerror="this.src='https://ui-avatars.com/api/?name=DR&background=D1FAE5&color=047857&size=70'">
            <div style="flex:1;min-width:0;">
                <div class="doc-name">${doc.user?.name||'–'}</div>
                <div class="doc-spec">${doc.specialization||''}</div>
                <div class="doc-meta"><i data-lucide="building-2" style="width:11px;height:11px;"></i>${doc.poli?.name||'Poli Umum'}</div>
                <span class="badge ${doc.is_active?'badge-green':'badge-red'}">${doc.is_active?'Aktif':'Nonaktif'}</span>
            </div>
            <div style="display:flex;flex-direction:column;gap:6px;">
                <button onclick='openDoctorModal("edit",${JSON.stringify(doc).replace(/'/g,"&#39;")})' class="btn btn-outline btn-sm" title="Edit"><i data-lucide="pencil"></i></button>
                <button onclick="deleteDoctor(${doc.id},'${(doc.user?.name||'').replace(/'/g,'')}')" class="btn btn-danger btn-sm" title="Hapus"><i data-lucide="trash-2"></i></button>
            </div>
        </div>`;
    }).join('');
    lucide.createIcons();
}

function filterDoctors() {
    const q = document.getElementById('search-doctor').value.toLowerCase();
    renderDoctors(allDoctors.filter(d =>
        (d.user?.name||'').toLowerCase().includes(q) ||
        (d.specialization||'').toLowerCase().includes(q) ||
        (d.poli?.name||'').toLowerCase().includes(q)
    ));
}

async function openDoctorModal(mode, data = null) {
    if (!allPolis.length) await refreshPolis();
    const sel = document.getElementById('doc-poli');
    sel.innerHTML = '<option value="">Pilih Poli…</option>' +
        allPolis.map(p => `<option value="${p.id}">${p.name}</option>`).join('');
    document.getElementById('form-doctor').reset();
    document.getElementById('doc-id').value = '';

    const isAdd = mode === 'add';
    document.getElementById('modal-doctor-title').textContent = isAdd ? 'Tambah Dokter Baru' : 'Edit Data Dokter';
    document.getElementById('doc-auth-fields').style.display  = isAdd ? 'block' : 'none';
    document.getElementById('doc-active-wrap').style.display  = isAdd ? 'none'  : 'block';
    document.getElementById('doc-email').required = isAdd;
    document.getElementById('doc-pass').required  = isAdd;

    if (!isAdd && data) {
        document.getElementById('doc-id').value     = data.id;
        document.getElementById('doc-name').value   = data.user?.name  || '';
        document.getElementById('doc-spec').value   = data.specialization || '';
        document.getElementById('doc-poli').value   = data.poli_id || '';
        document.getElementById('doc-exp').value    = data.experience_years || 0;
        document.getElementById('doc-bio').value    = data.bio || '';
        document.getElementById('doc-active').value = data.is_active ? '1' : '0';
    }
    openModal('modal-doctor');
}

async function submitDoctor(e) {
    e.preventDefault();
    const id = document.getElementById('doc-id').value;
    const isEdit = !!id;
    btnLoad('btn-doctor-submit', true);

    const fd = new FormData();
    fd.append('name',             document.getElementById('doc-name').value);
    fd.append('poli_id',          document.getElementById('doc-poli').value);
    fd.append('specialization',   document.getElementById('doc-spec').value);
    fd.append('experience_years', document.getElementById('doc-exp').value || 0);
    fd.append('bio',              document.getElementById('doc-bio').value);
    const photo = document.getElementById('doc-photo').files[0];
    if (photo) fd.append('photo', photo);

    if (!isEdit) {
        fd.append('email',    document.getElementById('doc-email').value);
        fd.append('password', document.getElementById('doc-pass').value);
    } else {
        fd.append('is_active', document.getElementById('doc-active').value);
        fd.append('_method', 'PUT');
    }

    const res = await api('POST', isEdit ? `/admin/doctors/${id}` : '/admin/doctors', fd, true);
    btnLoad('btn-doctor-submit', false);

    if (res?.ok) {
        toast(isEdit ? 'Data dokter berhasil diperbarui' : 'Dokter baru berhasil ditambahkan');
        closeModal('modal-doctor'); loadDoctors();
    } else {
        toast(res?.data?.message || Object.values(res?.data?.errors||{}).flat().join(' | ') || 'Terjadi kesalahan', 'error');
    }
}

async function deleteDoctor(id, name) {
    confirmDelete(`Hapus dokter "${name}"? Akun login terkait juga akan dihapus.`, async () => {
        const res = await api('DELETE', `/admin/doctors/${id}`);
        if (res?.ok) { toast('Dokter berhasil dihapus'); loadDoctors(); }
        else toast('Gagal menghapus dokter','error');
    });
}

/* ═══════════════ STAFF ═══════════════ */
async function loadStaff() {
    const res = await api('GET', '/admin/staff');
    if (!res?.ok) { toast('Gagal memuat data petugas','error'); return; }
    const list = res.data.data;
    const tbody = document.getElementById('staff-tbody');

    if (!list.length) {
        tbody.innerHTML = '<tr><td colspan="5"><div class="empty-state"><p>Belum ada data petugas.</p></div></td></tr>';
        return;
    }
    tbody.innerHTML = list.map(s => `
        <tr>
            <td><strong>${s.name}</strong></td>
            <td style="color:var(--text-muted);">${s.email}</td>
            <td><span class="badge ${s.is_active?'badge-green':'badge-red'}">${s.is_active?'Aktif':'Nonaktif'}</span></td>
            <td style="color:var(--text-muted);font-size:0.8rem;">${formatDate(s.created_at)}</td>
            <td style="text-align:right;">
                <div style="display:flex;gap:5px;justify-content:flex-end;">
                    <button onclick='openStaffModal("edit",${JSON.stringify(s).replace(/'/g,"&#39;")})' class="btn btn-outline btn-sm" title="Edit"><i data-lucide="pencil"></i></button>
                    <button onclick="openResetPass(${s.id},'${s.name.replace(/'/g,'')}')" class="btn btn-warning btn-sm" title="Reset Password"><i data-lucide="key"></i></button>
                    <button onclick="toggleStaffActive(${s.id},${s.is_active})" class="btn ${s.is_active?'btn-warning':'btn-outline'} btn-sm" title="${s.is_active?'Nonaktifkan':'Aktifkan'}"><i data-lucide="${s.is_active?'toggle-right':'toggle-left'}"></i></button>
                    <button onclick="deleteStaff(${s.id},'${s.name.replace(/'/g,'')}')" class="btn btn-danger btn-sm" title="Hapus"><i data-lucide="trash-2"></i></button>
                </div>
            </td>
        </tr>`).join('');
    lucide.createIcons();
}

function openStaffModal(mode, data = null) {
    document.getElementById('form-staff').reset();
    document.getElementById('staff-id').value = '';
    const isAdd = mode === 'add';
    document.getElementById('modal-staff-title').textContent  = isAdd ? 'Tambah Petugas Baru' : 'Edit Data Petugas';
    document.getElementById('staff-pass-wrap').style.display  = isAdd ? 'block' : 'none';
    document.getElementById('staff-pass').required  = isAdd;
    document.getElementById('staff-pass2').required = isAdd;
    if (!isAdd && data) {
        document.getElementById('staff-id').value    = data.id;
        document.getElementById('staff-name').value  = data.name;
        document.getElementById('staff-email').value = data.email;
    }
    openModal('modal-staff');
}

async function submitStaff(e) {
    e.preventDefault();
    const id     = document.getElementById('staff-id').value;
    const isEdit = !!id;
    btnLoad('btn-staff-submit', true);

    const body = {
        name:  document.getElementById('staff-name').value,
        email: document.getElementById('staff-email').value,
    };
    if (!isEdit) {
        body.password              = document.getElementById('staff-pass').value;
        body.password_confirmation = document.getElementById('staff-pass2').value;
    }

    const res = await api(isEdit ? 'PUT' : 'POST', isEdit ? `/admin/staff/${id}` : '/admin/staff', body);
    btnLoad('btn-staff-submit', false);

    if (res?.ok) {
        toast(isEdit ? 'Data petugas diperbarui' : 'Petugas berhasil ditambahkan');
        closeModal('modal-staff'); loadStaff();
    } else {
        toast(res?.data?.message || Object.values(res?.data?.errors||{}).flat().join(' | '), 'error');
    }
}

async function toggleStaffActive(id, current) {
    const res = await api('PATCH', `/admin/staff/${id}/toggle-active`);
    if (res?.ok) { toast(current ? 'Petugas dinonaktifkan' : 'Petugas diaktifkan', current ? 'warning' : 'success'); loadStaff(); }
    else toast('Gagal mengubah status','error');
}

function openResetPass(id, name) {
    document.getElementById('reset-staff-id').value         = id;
    document.getElementById('reset-staff-name').textContent = name;
    document.getElementById('new-pass').value  = '';
    document.getElementById('new-pass2').value = '';
    openModal('modal-reset-pass');
}

async function submitResetPassword(e) {
    e.preventDefault();
    const id   = document.getElementById('reset-staff-id').value;
    const pass = document.getElementById('new-pass').value;
    const conf = document.getElementById('new-pass2').value;
    if (pass !== conf) { toast('Konfirmasi password tidak cocok','error'); return; }

    const res = await api('POST', `/admin/staff/${id}/reset-password`, { password: pass, password_confirmation: conf });
    if (res?.ok) { toast('Password berhasil direset'); closeModal('modal-reset-pass'); }
    else toast(res?.data?.message || 'Gagal reset password','error');
}

async function deleteStaff(id, name) {
    confirmDelete(`Hapus petugas "${name}"? Tindakan ini tidak dapat dibatalkan.`, async () => {
        const res = await api('DELETE', `/admin/staff/${id}`);
        if (res?.ok) { toast('Petugas berhasil dihapus'); loadStaff(); }
        else toast('Gagal menghapus petugas','error');
    });
}

/* ═══════════════ POLIS ═══════════════ */
async function refreshPolis() {
    const res = await api('GET', '/admin/polis');
    if (res?.ok) allPolis = res.data.data;
}

async function loadPolis() {
    await refreshPolis();
    const tbody = document.getElementById('poli-tbody');
    if (!allPolis.length) {
        tbody.innerHTML = '<tr><td colspan="5"><div class="empty-state"><p>Belum ada data poli.</p></div></td></tr>';
        return;
    }
    tbody.innerHTML = allPolis.map(p => `
        <tr>
            <td><strong>${p.name}</strong><div style="font-size:0.76rem;color:var(--text-muted);margin-top:1px;">${p.description||''}</div></td>
            <td><span class="badge badge-blue">${p.code}</span></td>
            <td>${p.max_queue_per_day??'–'} pasien</td>
            <td><span class="badge ${p.is_active?'badge-green':'badge-red'}">${p.is_active?'Aktif':'Nonaktif'}</span></td>
            <td style="text-align:right;">
                <div style="display:flex;gap:5px;justify-content:flex-end;">
                    <button onclick='openPoliModal("edit",${JSON.stringify(p).replace(/'/g,"&#39;")})' class="btn btn-outline btn-sm"><i data-lucide="pencil"></i></button>
                    <button onclick="deletePoli(${p.id},'${p.name.replace(/'/g,'')}')" class="btn btn-danger btn-sm"><i data-lucide="trash-2"></i></button>
                </div>
            </td>
        </tr>`).join('');
    lucide.createIcons();
}

function openPoliModal(mode, data = null) {
    document.getElementById('form-poli').reset();
    document.getElementById('poli-id').value = '';
    document.getElementById('modal-poli-title').textContent = mode === 'add' ? 'Tambah Poli Baru' : 'Edit Data Poli';
    if (data) {
        document.getElementById('poli-id').value    = data.id;
        document.getElementById('poli-name').value  = data.name;
        document.getElementById('poli-code').value  = data.code;
        document.getElementById('poli-desc').value  = data.description || '';
        document.getElementById('poli-quota').value = data.max_queue_per_day || '';
        document.getElementById('poli-active').value= data.is_active ? '1' : '0';
    }
    openModal('modal-poli');
}

async function submitPoli(e) {
    e.preventDefault();
    const id = document.getElementById('poli-id').value;
    const body = {
        name:              document.getElementById('poli-name').value,
        code:              document.getElementById('poli-code').value.toUpperCase(),
        description:       document.getElementById('poli-desc').value,
        max_queue_per_day: parseInt(document.getElementById('poli-quota').value),
        is_active:         document.getElementById('poli-active').value === '1',
    };
    const res = await api(id ? 'PUT' : 'POST', id ? `/admin/polis/${id}` : '/admin/polis', body);
    if (res?.ok) { toast(id ? 'Poli berhasil diperbarui' : 'Poli berhasil ditambahkan'); closeModal('modal-poli'); loadPolis(); }
    else toast(res?.data?.message || Object.values(res?.data?.errors||{}).flat().join(' | '),'error');
}

async function deletePoli(id, name) {
    confirmDelete(`Hapus poli "${name}"?`, async () => {
        const res = await api('DELETE', `/admin/polis/${id}`);
        if (res?.ok) { toast('Poli berhasil dihapus'); loadPolis(); }
        else toast('Gagal menghapus poli','error');
    });
}

/* ═══════════════ SCHEDULES ═══════════════ */
function resetScheduleFilter() {
    document.getElementById('filter-sched-poli').value = '';
    document.getElementById('filter-sched-date').value = '';
    loadSchedules();
}

async function loadSchedules() {
    if (!allPolis.length) await refreshPolis();

    // Populate poli filter
    const filterSel = document.getElementById('filter-sched-poli');
    if (filterSel.options.length <= 1) {
        allPolis.forEach(p => {
            const o = document.createElement('option');
            o.value = p.id; o.textContent = p.name;
            filterSel.appendChild(o);
        });
    }

    const params = new URLSearchParams();
    const poli = filterSel.value;
    const date = document.getElementById('filter-sched-date').value;
    if (poli) params.set('poli_id', poli);
    if (date) params.set('date', date);

    const res = await api('GET', '/admin/schedules' + (params.toString() ? '?' + params : ''));
    if (!res?.ok) { toast('Gagal memuat jadwal','error'); return; }

    const tbody = document.getElementById('schedule-tbody');
    const list  = res.data.data;

    if (!list.length) {
        tbody.innerHTML = '<tr><td colspan="7"><div class="empty-state"><p>Tidak ada jadwal ditemukan.</p></div></td></tr>';
        return;
    }
    tbody.innerHTML = list.map(s => `
        <tr>
            <td><strong>${s.doctor_name||'–'}</strong></td>
            <td>${s.poli_name||'–'}</td>
            <td>${formatDate(s.schedule_date)}</td>
            <td style="font-weight:600;">${s.start_time} – ${s.end_time}</td>
            <td>${s.max_patients} pasien</td>
            <td><span class="badge ${s.is_available?'badge-green':'badge-red'}">${s.is_available?'Tersedia':'Libur'}</span></td>
            <td style="text-align:right;">
                <div style="display:flex;gap:5px;justify-content:flex-end;">
                    <button onclick='openScheduleModal("edit",${JSON.stringify(s).replace(/'/g,"&#39;")})' class="btn btn-outline btn-sm"><i data-lucide="pencil"></i></button>
                    <button onclick="deleteSchedule(${s.id})" class="btn btn-danger btn-sm"><i data-lucide="trash-2"></i></button>
                </div>
            </td>
        </tr>`).join('');
    lucide.createIcons();
}

async function openScheduleModal(mode, data = null) {
    if (!allPolis.length) await refreshPolis();
    const docRes = await api('GET', '/admin/doctors');
    const docs   = docRes?.ok ? docRes.data.data : [];

    const docSel  = document.getElementById('sched-doctor');
    const poliSel = document.getElementById('sched-poli');
    docSel.innerHTML  = '<option value="">Pilih Dokter…</option>' +
        docs.map(d => `<option value="${d.id}">${d.user?.name||'?'} – ${d.specialization}</option>`).join('');
    poliSel.innerHTML = '<option value="">Pilih Poli…</option>' +
        allPolis.map(p => `<option value="${p.id}">${p.name}</option>`).join('');

    document.getElementById('form-schedule').reset();
    document.getElementById('sched-id').value = '';
    const isEdit = mode === 'edit' && data;
    document.getElementById('modal-schedule-title').textContent = isEdit ? 'Edit Jadwal Praktik' : 'Tambah Jadwal Praktik';
    document.getElementById('sched-avail-wrap').style.display   = isEdit ? 'block' : 'none';

    if (isEdit) {
        document.getElementById('sched-id').value     = data.id;
        document.getElementById('sched-doctor').value = data.doctor_id;
        document.getElementById('sched-poli').value   = data.poli_id;
        document.getElementById('sched-date').value   = data.schedule_date;
        document.getElementById('sched-start').value  = data.start_time;
        document.getElementById('sched-end').value    = data.end_time;
        document.getElementById('sched-quota').value  = data.max_patients;
        document.getElementById('sched-avail').value  = data.is_available ? '1' : '0';
    }
    openModal('modal-schedule');
}

async function submitSchedule(e) {
    e.preventDefault();
    const id     = document.getElementById('sched-id').value;
    const isEdit = !!id;
    const body   = {
        doctor_id:     document.getElementById('sched-doctor').value,
        poli_id:       document.getElementById('sched-poli').value,
        schedule_date: document.getElementById('sched-date').value,
        start_time:    document.getElementById('sched-start').value,
        end_time:      document.getElementById('sched-end').value,
        max_patients:  parseInt(document.getElementById('sched-quota').value),
    };
    if (isEdit) body.is_available = document.getElementById('sched-avail').value === '1';

    const res = await api(isEdit ? 'PUT' : 'POST', isEdit ? `/admin/schedules/${id}` : '/admin/schedules', body);
    if (res?.ok) { toast(isEdit ? 'Jadwal berhasil diperbarui' : 'Jadwal berhasil ditambahkan'); closeModal('modal-schedule'); loadSchedules(); }
    else toast(res?.data?.message || Object.values(res?.data?.errors||{}).flat().join(' | '),'error');
}

async function deleteSchedule(id) {
    confirmDelete('Hapus jadwal ini? Appointment yang terkait juga akan terpengaruh.', async () => {
        const res = await api('DELETE', `/admin/schedules/${id}`);
        if (res?.ok) { toast('Jadwal berhasil dihapus'); loadSchedules(); }
        else toast(res?.data?.message || 'Gagal menghapus jadwal','error');
    });
}

/* ═══════════════ ARTICLES ═══════════════ */
async function loadArticles() {
    const res = await api('GET', '/admin/articles');
    if (!res?.ok) { toast('Gagal memuat artikel','error'); return; }
    const list = res.data.data;
    const grid = document.getElementById('article-grid');

    if (!list.length) {
        grid.innerHTML = '<div class="empty-state" style="grid-column:1/-1"><p>Belum ada artikel. Tulis artikel pertama Anda!</p></div>';
        return;
    }
    grid.innerHTML = list.map(a => {
        const img = a.featured_image || null;
        return `
        <div class="article-card">
            ${img ? `<img src="${img}" class="article-img" alt="${a.title}" onerror="this.style.display='none'">` : `<div class="article-img skeleton"></div>`}
            <div class="article-body">
                <div class="article-title">${a.title}</div>
                <div class="article-meta">
                    <span>${a.author?.name||'Admin'}</span>
                    <span>${formatDate(a.published_at||a.created_at)}</span>
                    <span class="badge ${a.is_published?'badge-green':'badge-gray'}">${a.is_published?'Publikasi':'Draft'}</span>
                </div>
                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                    <button onclick='openArticleModal("edit",${JSON.stringify(a).replace(/'/g,"&#39;")})' class="btn btn-outline btn-sm"><i data-lucide="pencil"></i>Edit</button>
                    <button onclick="toggleArticle(${a.id},${a.is_published})" class="btn ${a.is_published?'btn-warning':'btn-outline'} btn-sm">
                        <i data-lucide="${a.is_published?'eye-off':'eye'}"></i>${a.is_published?'Sembunyikan':'Publikasikan'}
                    </button>
                    <button onclick="deleteArticle(${a.id},'${a.title.replace(/'/g,'').substring(0,30)}')" class="btn btn-danger btn-sm"><i data-lucide="trash-2"></i></button>
                </div>
            </div>
        </div>`;
    }).join('');
    lucide.createIcons();
}

function openArticleModal(mode, data = null) {
    document.getElementById('form-article').reset();
    document.getElementById('article-id').value = '';
    document.getElementById('modal-article-title').textContent = mode === 'add' ? 'Tulis Artikel Baru' : 'Edit Artikel';
    if (data) {
        document.getElementById('article-id').value      = data.id;
        document.getElementById('article-title').value   = data.title;
        document.getElementById('article-excerpt').value = data.excerpt || '';
        document.getElementById('article-content').value = data.content;
        document.getElementById('article-publish').value = data.is_published ? '1' : '0';
    }
    openModal('modal-article');
}

async function submitArticle(e) {
    e.preventDefault();
    const id     = document.getElementById('article-id').value;
    const isEdit = !!id;

    const fd = new FormData();
    fd.append('title',        document.getElementById('article-title').value);
    fd.append('excerpt',      document.getElementById('article-excerpt').value);
    fd.append('content',      document.getElementById('article-content').value);
    fd.append('is_published', document.getElementById('article-publish').value);
    const img = document.getElementById('article-img').files[0];
    if (img) fd.append('featured_image', img);

    const res = await api('POST', isEdit ? `/admin/articles/${id}` : '/admin/articles', fd, true);
    if (res?.ok) { toast(isEdit ? 'Artikel berhasil diperbarui' : 'Artikel berhasil dibuat'); closeModal('modal-article'); loadArticles(); }
    else toast(res?.data?.message || Object.values(res?.data?.errors||{}).flat().join(' | '),'error');
}

async function toggleArticle(id, current) {
    const res = await api('PATCH', `/admin/articles/${id}/toggle-publish`);
    if (res?.ok) { toast(current ? 'Artikel disembunyikan' : 'Artikel dipublikasikan', current ? 'warning' : 'success'); loadArticles(); }
    else toast('Gagal mengubah status artikel','error');
}

async function deleteArticle(id, title) {
    confirmDelete(`Hapus artikel "${title}…"?`, async () => {
        const res = await api('DELETE', `/admin/articles/${id}`);
        if (res?.ok) { toast('Artikel berhasil dihapus'); loadArticles(); }
        else toast('Gagal menghapus artikel','error');
    });
}

/* ═══════════════ REPORTS ═══════════════ */
async function loadReports() {
    const start = document.getElementById('report-start').value;
    const end   = document.getElementById('report-end').value;
    const params = new URLSearchParams();
    if (start) params.set('start_date', start);
    if (end)   params.set('end_date', end);

    const [visitRes, topRes] = await Promise.all([
        api('GET', '/admin/reports/visits' + (params.toString() ? '?' + params : '')),
        api('GET', '/admin/reports/top-doctors?limit=5'),
    ]);

    if (visitRes?.ok) {
        const d = visitRes.data.data;
        const t = d.totals;
        document.getElementById('report-stats').innerHTML = `
            <div class="stat-card"><div class="stat-icon blue"><i data-lucide="calendar" style="width:21px;height:21px;"></i></div><div><div class="stat-value">${t.total}</div><div class="stat-label">Total Kunjungan</div></div></div>
            <div class="stat-card"><div class="stat-icon green"><i data-lucide="check-circle" style="width:21px;height:21px;"></i></div><div><div class="stat-value">${t.completed}</div><div class="stat-label">Selesai</div></div></div>
            <div class="stat-card"><div class="stat-icon orange"><i data-lucide="x-circle" style="width:21px;height:21px;"></i></div><div><div class="stat-value">${t.cancelled}</div><div class="stat-label">Dibatalkan</div></div></div>
            <div class="stat-card"><div class="stat-icon purple"><i data-lucide="clock" style="width:21px;height:21px;"></i></div><div><div class="stat-value">${t.pending}</div><div class="stat-label">Menunggu</div></div></div>
        `;
        lucide.createIcons();

        const maxPoli = d.by_poli[0]?.total || 1;
        document.getElementById('report-poli').innerHTML = d.by_poli.length
            ? d.by_poli.map(p => `
                <div style="display:flex;align-items:center;gap:10px;padding:8px 12px;background:white;border:1px solid var(--border);border-radius:10px;">
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:0.83rem;font-weight:700;margin-bottom:3px;">${p.poli_name}</div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div class="bar-wrap"><div class="bar-fill" style="width:${(p.total/maxPoli*100).toFixed(0)}%"></div></div>
                            <span style="font-size:0.75rem;font-weight:700;color:var(--primary-dark);white-space:nowrap;">${p.total}x</span>
                        </div>
                    </div>
                </div>`).join('')
            : '<p style="font-size:0.85rem;color:var(--text-muted);">Tidak ada data.</p>';
    }

    if (topRes?.ok) {
        const docs = topRes.data.data;
        const maxD = docs[0]?.total_visits || 1;
        document.getElementById('report-doctors').innerHTML = docs.length
            ? docs.map((d,i) => `
                <div style="display:flex;align-items:center;gap:10px;padding:8px 12px;background:white;border:1px solid var(--border);border-radius:10px;">
                    <span style="width:20px;font-size:0.73rem;font-weight:800;color:var(--text-muted);">#${i+1}</span>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:0.83rem;font-weight:700;margin-bottom:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${d.doctor_name}</div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div class="bar-wrap"><div class="bar-fill" style="width:${(d.total_visits/maxD*100).toFixed(0)}%"></div></div>
                            <span style="font-size:0.75rem;font-weight:700;color:var(--primary-dark);white-space:nowrap;">${d.total_visits}x</span>
                        </div>
                    </div>
                </div>`).join('')
            : '<p style="font-size:0.85rem;color:var(--text-muted);">Belum ada data kunjungan.</p>';
    }
}

/* ─── AUTH ──────────────────────────── */
function logout() {
    if (!confirm('Keluar dari Admin Panel?')) return;
    localStorage.clear();
    window.location.href = '/login';
}

/* ═══════════════ QUEUE CALL SYSTEM ═══════════════ */
let qPoliId       = null;
let qPollInterval = null;
let qSoundOn      = false;
let qLastServing  = {};

function qToggleSound() {
    qSoundOn = !qSoundOn;
    const icon  = document.getElementById('q-sound-icon');
    const label = document.getElementById('q-sound-label');
    const btn   = document.getElementById('q-sound-btn');
    if (qSoundOn) {
        icon.setAttribute('data-lucide','volume-2');
        label.textContent = 'Suara Aktif';
        btn.style.borderColor = 'var(--primary)';
        btn.style.color = 'var(--primary-dark)';
        qSpeak('Sistem suara antrian diaktifkan.');
    } else {
        icon.setAttribute('data-lucide','volume-x');
        label.textContent = 'Aktifkan Suara';
        btn.style.borderColor = '';
        btn.style.color = '';
    }
    lucide.createIcons();
}

function qSpeak(text) {
    if (!qSoundOn || !('speechSynthesis' in window)) return;
    window.speechSynthesis.cancel();
    const make = () => { const u = new SpeechSynthesisUtterance(text); u.lang='id-ID'; u.rate=0.88; return u; };
    window.speechSynthesis.speak(make());
    window.speechSynthesis.speak(make()); // 2× seperti pengumuman klinik
}

async function initQueuePage() {
    // Load poli tabs
    const res = await api('GET', '/admin/polis');
    if (!res?.ok) return;
    const polis = res.data.data.filter(p => p.is_active);

    const tabs = document.getElementById('q-poli-tabs');
    tabs.innerHTML = polis.map((p, i) => `
        <button onclick="qSelectPoli(${p.id},'${p.name.replace(/'/g,'')}')"
            id="qtab-${p.id}"
            style="padding:8px 18px;border-radius:999px;border:1.5px solid var(--border);
                   background:white;font-size:.83rem;font-weight:700;cursor:pointer;
                   font-family:inherit;transition:.15s;"
            ${i===0 ? 'class="qtab-active"' : ''}>
            ${p.name}
        </button>`).join('');

    if (polis.length > 0) qSelectPoli(polis[0].id, polis[0].name);
}

function qSelectPoli(id, name) {
    qPoliId = id;
    // Visual active tab
    document.querySelectorAll('[id^="qtab-"]').forEach(b => {
        b.style.background = '';
        b.style.borderColor = 'var(--border)';
        b.style.color = '';
    });
    const active = document.getElementById('qtab-' + id);
    if (active) {
        active.style.background = 'var(--primary)';
        active.style.borderColor = 'var(--primary)';
        active.style.color = 'white';
    }
    // Start polling
    if (qPollInterval) clearInterval(qPollInterval);
    qRefresh();
    qPollInterval = setInterval(qRefresh, 5000);
}

async function qRefresh() {
    if (!qPoliId) return;
    const [boardRes, listRes] = await Promise.all([
        api('GET', `/admin/queue/board?poli_id=${qPoliId}`),
        api('GET', `/admin/queue/list?poli_id=${qPoliId}`),
    ]);

    if (boardRes?.ok) {
        const pd = boardRes.data.data?.find(p => p.poli_id == qPoliId);
        if (pd) {
            const s = pd.now_serving;
            const servEl = document.getElementById('q-now-serving');
            servEl.textContent = s ? s.queue_number : '–';
            servEl.style.color  = s ? 'var(--primary-dark)' : '#94a3b8';
            document.getElementById('q-serving-name').textContent  = s ? s.patient_name : '–';
            document.getElementById('q-serving-count').textContent = s ? `Panggilan ke-${s.called_count} · ${s.called_at}` : '';
            document.getElementById('q-waiting-count').textContent = pd.waiting_count;

            const next = pd.waiting_list?.[0];
            const nb = document.getElementById('q-next-box');
            if (next) {
                nb.style.display = 'block';
                document.getElementById('q-next-num').textContent  = next.queue_number;
                document.getElementById('q-next-name').textContent = next.patient_name;
            } else {
                nb.style.display = 'none';
            }

            // TTS saat ada perubahan nomor
            if (s && qLastServing[qPoliId] !== s.queue_number) {
                qLastServing[qPoliId] = s.queue_number;
                qSpeak(`Nomor antrian ${s.queue_number}, silakan menuju ruang pemeriksaan.`);
            }
        }
    }

    if (listRes?.ok) qRenderList(listRes.data.data || []);
}

function qRenderList(items) {
    const body = document.getElementById('q-list-body');
    document.getElementById('q-list-count').textContent = items.length + ' pasien';

    if (!items.length) {
        body.innerHTML = '<div style="padding:40px;text-align:center;color:var(--text-muted);font-size:.875rem;">Tidak ada antrian aktif hari ini.</div>';
        return;
    }

    body.innerHTML = items.map(a => {
        const isActive = a.status === 'in_progress';
        return `
        <div style="display:flex;align-items:center;padding:13px 20px;gap:14px;border-bottom:1px solid #f1f5f9;
                    ${isActive ? 'background:#fff8f6;border-left:3px solid var(--primary-dark);' : ''}
                    transition:.15s;">
            <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.2rem;font-weight:800;
                        width:72px;flex-shrink:0;color:${isActive ? 'var(--primary-dark)' : 'var(--text-main)'};">
                ${a.queue_number}
            </div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:.88rem;font-weight:700;margin-bottom:2px;
                            white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${a.patient_name}</div>
                <div style="font-size:.75rem;color:var(--text-muted);">
                    ${a.estimated_time ? 'Est. ' + a.estimated_time.substring(0,5) : ''}
                    ${a.called_count > 0 ? ' · Dipanggil ' + a.called_count + '×' : ''}
                </div>
            </div>
            <span style="font-size:.7rem;font-weight:700;padding:3px 9px;border-radius:999px;
                         background:${isActive ? '#ffeeea' : '#e8f4ff'};
                         color:${isActive ? 'var(--primary-dark)' : '#1d6fa4'};">
                ${isActive ? 'Dipanggil' : 'Menunggu'}
            </span>
            <div style="display:flex;gap:5px;flex-shrink:0;">
                ${!isActive ? `
                <button onclick="qCall(${a.appointment_id},'${a.queue_number}','${a.patient_name.replace(/'/g,'')}')"
                    class="btn btn-primary btn-sm">📢 Panggil</button>` : `
                <button onclick="qRecall(${a.appointment_id},'${a.queue_number}')"
                    class="btn btn-outline btn-sm">🔁 Ulang</button>
                <button onclick="qComplete(${a.appointment_id},'${a.queue_number}')"
                    class="btn btn-outline btn-sm" style="color:var(--green,#15803d);border-color:#86efac;">✓ Selesai</button>
                <button onclick="qSkip(${a.appointment_id},'${a.queue_number}')"
                    class="btn btn-outline btn-sm" style="font-size:.72rem;">Lewati</button>`}
            </div>
        </div>`;
    }).join('');
    lucide.createIcons();
}

async function qCall(id, num, name) {
    const res = await api('POST', `/admin/queue/${id}/call`);
    if (res?.ok) { toast(`📢 Memanggil ${num} — ${name}`, 'success'); qSpeak(`Nomor antrian ${num}, ${name}, silakan menuju ruang pemeriksaan.`); qRefresh(); }
    else toast(res?.data?.message || 'Gagal memanggil', 'error');
}

async function qRecall(id, num) {
    const res = await api('POST', `/admin/queue/${id}/recall`);
    if (res?.ok) { toast(`🔁 Panggilan ulang ${num}`, 'success'); qSpeak(`Panggilan ulang. Nomor antrian ${num}, silakan segera menuju ruang pemeriksaan.`); qRefresh(); }
    else toast(res?.data?.message || 'Gagal', 'error');
}

async function qComplete(id, num) {
    const res = await api('POST', `/admin/queue/${id}/complete`);
    if (res?.ok) { toast(`✓ ${num} selesai dilayani`); qRefresh(); }
    else toast(res?.data?.message || 'Gagal', 'error');
}

async function qSkip(id, num) {
    if (!confirm(`Lewati pasien ${num}?`)) return;
    const res = await api('POST', `/admin/queue/${id}/skip`);
    if (res?.ok) { toast(`${num} dilewati (no show)`); qRefresh(); }
    else toast(res?.data?.message || 'Gagal', 'error');
}

/* ─── INIT ──────────────────────────── */
(function init() {
    // Set default report date range: last 30 days
    const today = new Date();
    const from  = new Date(); from.setDate(today.getDate() - 30);
    document.getElementById('report-start').value = from.toISOString().slice(0,10);
    document.getElementById('report-end').value   = today.toISOString().slice(0,10);

    loadDashboard();
})();
</script>
</body>
</html>
