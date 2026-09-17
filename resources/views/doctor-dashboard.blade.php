<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dokter – Medika Centra</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --teal:        #0d7a6b;
            --teal-dark:   #095c50;
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
            --gray-400:    #9ca3af;
            --gray-500:    #6b7280;
            --gray-700:    #374151;
            --gray-900:    #111827;
            --white:       #ffffff;
            --sidebar-bg:  #0f172a;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--gray-50); color: var(--gray-900); min-height: 100vh; display: flex; }
        h1,h2,h3 { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── Sidebar ── */
        .sidebar {
            width: 230px; min-width: 230px;
            background: var(--sidebar-bg); color: white;
            height: 100vh; position: sticky; top: 0;
            display: flex; flex-direction: column;
        }
        .sb-brand {
            padding: 20px 18px 16px;
            border-bottom: 1px solid rgba(255,255,255,.07);
            display: flex; align-items: center; gap: 10px;
        }
        .sb-mark {
            width: 34px; height: 34px; border-radius: 9px;
            background: var(--teal);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .sb-mark svg { width: 17px; height: 17px; stroke: white; }
        .sb-title { font-size: .92rem; font-weight: 800; }
        .sb-sub   { font-size: .67rem; color: #94a3b8; font-weight: 500; }
        .sb-section { padding: 16px 16px 4px; font-size: .63rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .07em; color: #475569; }
        .nav-item {
            margin: 2px 8px; padding: 9px 13px; border-radius: 8px;
            font-size: .84rem; font-weight: 600; color: #94a3b8;
            display: flex; align-items: center; gap: 9px;
            cursor: pointer; transition: .15s;
            border: none; background: none; width: calc(100% - 16px); text-align: left;
        }
        .nav-item svg { width: 15px; height: 15px; flex-shrink: 0; }
        .nav-item:hover  { background: #1e293b; color: #e2e8f0; }
        .nav-item.active { background: var(--teal); color: white; }
        .sb-footer { margin-top: auto; padding: 12px 8px 16px; border-top: 1px solid rgba(255,255,255,.07); }

        /* ── Main ── */
        .main { flex: 1; min-width: 0; display: flex; flex-direction: column; }
        .topbar {
            height: 60px; background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px; position: sticky; top: 0; z-index: 20;
        }
        .topbar-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: .98rem; font-weight: 800; }
        .doctor-chip {
            display: flex; align-items: center; gap: 8px;
            background: var(--teal-light); padding: 6px 14px;
            border-radius: 999px; font-size: .78rem; font-weight: 700; color: var(--teal-dark);
        }
        .doctor-chip svg { width: 14px; height: 14px; }

        .content { padding: 24px 28px; }

        /* ── Now Serving Banner ── */
        .serving-banner {
            background: var(--teal-dark); color: white;
            border-radius: 16px; padding: 20px 24px;
            display: flex; align-items: center; gap: 20px;
            margin-bottom: 24px;
        }
        .serving-banner.empty { background: var(--gray-100); color: var(--gray-500); }
        .serving-num {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 3rem; font-weight: 800; line-height: 1;
            letter-spacing: -.03em; flex-shrink: 0;
        }
        .serving-label { font-size: .72rem; opacity: .75; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 4px; }
        .serving-name  { font-size: 1.05rem; font-weight: 700; }
        .serving-meta  { font-size: .8rem; opacity: .7; margin-top: 2px; }

        /* ── Stats ── */
        .stats-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; margin-bottom: 22px; }
        .stat-box {
            background: var(--white); border: 1px solid var(--gray-200);
            border-radius: 12px; padding: 16px 18px;
        }
        .stat-box .sv { font-size: 1.7rem; font-weight: 800; font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--teal-dark); line-height: 1; }
        .stat-box .sl { font-size: .74rem; color: var(--gray-400); font-weight: 600; margin-top: 3px; }

        /* ── Queue Table ── */
        .card { background: var(--white); border: 1px solid var(--gray-200); border-radius: 14px; overflow: hidden; }
        .card-header {
            padding: 14px 20px; border-bottom: 1px solid var(--gray-200);
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-title { font-size: .9rem; font-weight: 800; }

        table { width: 100%; border-collapse: collapse; font-size: .875rem; }
        thead tr { background: var(--gray-50); }
        th { padding: 10px 18px; text-align: left; font-size: .7rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .04em; color: var(--gray-500);
            border-bottom: 1px solid var(--gray-200); }
        td { padding: 14px 18px; border-bottom: 1px solid var(--gray-100); vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: var(--teal-xlight); }
        tbody tr.is-active { background: #fff8f6; }

        /* ── Buttons ── */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 15px; border-radius: 8px; font-family: inherit;
            font-size: .82rem; font-weight: 700; cursor: pointer; border: none; transition: .14s;
        }
        .btn svg { width: 14px; height: 14px; }
        .btn-call     { background: var(--teal); color: white; }
        .btn-call:hover { background: var(--teal-dark); }
        .btn-finish   { background: var(--green-light); color: var(--green); border: 1px solid #86efac; }
        .btn-finish:hover { background: #bbf7d0; }
        .btn-recall   { background: var(--amber-light); color: var(--amber); border: 1px solid #fde68a; }
        .btn-recall:hover { background: #fef3c7; }
        .btn-outline  { background: var(--white); color: var(--gray-700); border: 1px solid var(--gray-300); }
        .btn-outline:hover { background: var(--gray-100); }
        .btn-sm { padding: 6px 11px; font-size: .76rem; }
        .btn:disabled { opacity: .45; cursor: not-allowed; }

        /* ── Badge ── */
        .badge { display: inline-flex; align-items: center; padding: 3px 10px;
            border-radius: 999px; font-size: .7rem; font-weight: 700; }
        .badge-arrived  { background: var(--blue-light);  color: var(--blue); }
        .badge-active   { background: var(--red-light);   color: var(--red); }
        .badge-done     { background: var(--green-light); color: var(--green); }

        /* ── Patient info in table ── */
        .p-name { font-weight: 700; font-size: .88rem; margin-bottom: 2px; }
        .p-meta { font-size: .74rem; color: var(--gray-400); }

        /* ── Queue number ── */
        .q-num {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.1rem; font-weight: 800; color: var(--teal-dark);
        }
        .q-num.active { color: var(--red); }

        /* ── Toast ── */
        #toast { position: fixed; bottom: 20px; right: 20px; z-index: 200;
            display: flex; flex-direction: column; gap: 8px; }
        .t-item { background: var(--gray-900); color: white;
            padding: 11px 16px; border-radius: 10px;
            font-size: .83rem; font-weight: 600; animation: sUp .2s ease; max-width: 280px; }
        .t-item.ok  { background: var(--teal-dark); }
        .t-item.err { background: var(--red); }
        @keyframes sUp { from{transform:translateY(10px);opacity:0} to{opacity:1;transform:none} }

        /* ── Skeleton ── */
        .sk { background: linear-gradient(90deg,#f0f0f0 25%,#e8e8e8 50%,#f0f0f0 75%);
            background-size: 200% 100%; animation: sk 1.4s infinite; border-radius: 6px; }
        @keyframes sk { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

        /* ── Empty state ── */
        .empty { text-align: center; padding: 48px 20px; color: var(--gray-400); }
        .empty svg { width: 38px; height: 38px; margin: 0 auto 12px; display: block; opacity: .3; }
        .empty p { font-size: .88rem; }

        /* Polling indicator */
        .poll-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--teal); display: inline-block; margin-right: 6px;
            animation: blink 2s ease-in-out infinite;
        }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; height: auto; position: relative; flex-direction: row;
                padding: 10px; overflow-x: auto; }
            .sb-brand { display: none; }
            .sb-section { display: none; }
            .nav-item { min-width: 80px; flex-direction: column; gap: 3px; font-size: .7rem; padding: 8px 10px; }
            .sb-footer { margin-top: 0; border: none; padding: 0; }
            .stats-row { grid-template-columns: repeat(3,1fr); }
            .content { padding: 14px; }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sb-brand">
        <div class="sb-mark"><i data-lucide="stethoscope"></i></div>
        <div>
            <div class="sb-title">Dokter</div>
            <div class="sb-sub">Medika Centra</div>
        </div>
    </div>

    <div class="sb-section">Menu</div>
    <button class="nav-item active" onclick="showPage('antrian')" id="nav-antrian">
        <i data-lucide="list-ordered"></i>Antrian Pasien
    </button>
    <button class="nav-item" onclick="showPage('selesai')" id="nav-selesai">
        <i data-lucide="check-circle-2"></i>Sudah Ditangani
    </button>

    <div class="sb-footer">
        <button class="nav-item" onclick="logout()" style="color:#f87171;">
            <i data-lucide="log-out"></i>Keluar
        </button>
    </div>
</aside>

<!-- Main -->
<div class="main">
    <header class="topbar">
        <div>
            <div class="topbar-title" id="topbar-title">Antrian Pasien Hari Ini</div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            <span style="font-size:.74rem;color:var(--gray-400);">
                <span class="poll-dot"></span>Live
            </span>
            <div class="doctor-chip">
                <i data-lucide="user-check"></i>
                <span id="doctor-name">Dokter</span>
            </div>
        </div>
    </header>

    <div class="content">

        <!-- PAGE: ANTRIAN -->
        <div class="page active" id="page-antrian">

            <!-- Now Serving Banner -->
            <div class="serving-banner empty" id="serving-banner">
                <div>
                    <div class="serving-num" id="serving-num">–</div>
                </div>
                <div>
                    <div class="serving-label">Sedang Dilayani</div>
                    <div class="serving-name" id="serving-name">Belum ada pasien dipanggil</div>
                    <div class="serving-meta" id="serving-meta"></div>
                </div>
            </div>

            <!-- Stats -->
            <div class="stats-row" id="stats-row">
                <div class="stat-box">
                    <div class="sk" style="height:26px;width:44px;margin-bottom:5px;"></div>
                    <div class="sk" style="height:13px;width:80px;"></div>
                </div>
                <div class="stat-box">
                    <div class="sk" style="height:26px;width:44px;margin-bottom:5px;"></div>
                    <div class="sk" style="height:13px;width:80px;"></div>
                </div>
                <div class="stat-box">
                    <div class="sk" style="height:26px;width:44px;margin-bottom:5px;"></div>
                    <div class="sk" style="height:13px;width:80px;"></div>
                </div>
            </div>

            <!-- Antrian Table -->
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Pasien Menunggu (Sudah Hadir)</span>
                    <button class="btn btn-outline btn-sm" onclick="loadQueue()">
                        <i data-lucide="refresh-cw"></i>Refresh
                    </button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Pasien</th>
                            <th>Info</th>
                            <th>Status</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="queue-tbody">
                        <tr><td colspan="5">
                            <div class="sk" style="height:40px;margin:10px 18px;"></div>
                        </td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PAGE: SELESAI -->
        <div class="page" id="page-selesai">
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Pasien Sudah Ditangani Hari Ini</span>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Pasien</th>
                            <th>Poli</th>
                            <th>Selesai Pukul</th>
                        </tr>
                    </thead>
                    <tbody id="done-tbody">
                        <tr><td colspan="4">
                            <div class="sk" style="height:40px;margin:10px 18px;"></div>
                        </td></tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div><!-- /content -->
</div><!-- /main -->

<div id="toast"></div>

<script>
lucide.createIcons();

const API   = '/api';
const token = localStorage.getItem('auth_token');
const role  = localStorage.getItem('user_role');

if (!token || role !== 'doctor') {
    window.location.href = '/login';
}

let pollInterval = null;
let doctorName   = '';

/* ── Navigation ── */
function showPage(name) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    document.getElementById('page-' + name).classList.add('active');
    document.getElementById('nav-'  + name)?.classList.add('active');
    const titles = { antrian: 'Antrian Pasien Hari Ini', selesai: 'Pasien Sudah Ditangani' };
    document.getElementById('topbar-title').textContent = titles[name] || name;
    if (name === 'selesai') loadDone();
    lucide.createIcons();
}

/* ── API ── */
async function api(method, path, body = null) {
    const headers = { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' };
    if (body) headers['Content-Type'] = 'application/json';
    const res = await fetch(API + path, {
        method, headers, body: body ? JSON.stringify(body) : null,
    });
    if (res.status === 401) { logout(); return null; }
    const json = await res.json().catch(() => ({}));
    return { ok: res.ok, status: res.status, data: json };
}

/* ── Toast ── */
function toast(msg, type = '') {
    const el   = document.createElement('div');
    el.className = 't-item ' + type;
    el.textContent = msg;
    document.getElementById('toast').appendChild(el);
    setTimeout(() => el.remove(), 3800);
}

/* ── Load Queue ── */
async function loadQueue() {
    const res = await api('GET', '/doctor/dashboard');
    if (!res) return;

    const items = Array.isArray(res.data) ? res.data : (res.data.data ?? []);

    /* ── Stats ── */
    const arrived    = items.filter(i => i.status === 'arrived').length;
    const inProgress = items.filter(i => i.status === 'in_progress').length;
    const total      = items.length;

    document.getElementById('stats-row').innerHTML = `
        <div class="stat-box">
            <div class="sv">${arrived}</div>
            <div class="sl">Menunggu Dipanggil</div>
        </div>
        <div class="stat-box">
            <div class="sv">${inProgress}</div>
            <div class="sl">Sedang Dilayani</div>
        </div>
        <div class="stat-box">
            <div class="sv">${total}</div>
            <div class="sl">Total Hari Ini</div>
        </div>
    `;

    /* ── Now Serving Banner ── */
    const active = items.find(i => i.status === 'in_progress');
    updateBanner(active);

    /* ── Table ── */
    const tbody = document.getElementById('queue-tbody');

    if (!items.length) {
        tbody.innerHTML = `<tr><td colspan="5">
            <div class="empty">
                <i data-lucide="inbox"></i>
                <p>Tidak ada pasien yang sudah hadir saat ini.</p>
            </div>
        </td></tr>`;
        lucide.createIcons();
        return;
    }

    tbody.innerHTML = items.map(item => {
        const prof     = item.user?.patient_profile ?? item.user?.patientProfile ?? {};
        const name     = prof.full_name ?? item.user?.name ?? '–';
        const gender   = prof.gender === 'male' ? 'Laki-laki' : (prof.gender === 'female' ? 'Perempuan' : '–');
        const dob      = prof.date_of_birth ? formatDate(prof.date_of_birth) : '–';
        const isActive = item.status === 'in_progress';

        return `
        <tr class="${isActive ? 'is-active' : ''}">
            <td><span class="q-num ${isActive ? 'active' : ''}">${item.queue_number}</span></td>
            <td>
                <div class="p-name">${name}</div>
                <div class="p-meta">${gender} · ${dob}</div>
            </td>
            <td>
                <div class="p-meta">
                    ${prof.blood_type ? '🩸 ' + prof.blood_type + ' &nbsp;' : ''}
                    ${prof.allergies  ? '⚠️ ' + prof.allergies.substring(0,30) : ''}
                </div>
                <div class="p-meta">${prof.phone_number ?? '–'}</div>
            </td>
            <td>
                <span class="badge ${isActive ? 'badge-active' : 'badge-arrived'}">
                    ${isActive ? 'Sedang Dilayani' : 'Menunggu'}
                </span>
            </td>
            <td style="text-align:right;">
                <div style="display:flex;gap:6px;justify-content:flex-end;flex-wrap:wrap;">
                    ${!isActive
                        ? `<button class="btn btn-call btn-sm" onclick="callPatient(${item.id}, '${item.queue_number}')">
                               <i data-lucide="megaphone"></i>Panggil
                           </button>`
                        : `<button class="btn btn-recall btn-sm" onclick="recallPatient(${item.id}, '${item.queue_number}')">
                               <i data-lucide="redo-2"></i>Ulang
                           </button>
                           <button class="btn btn-finish btn-sm" onclick="finishPatient(${item.id}, '${item.queue_number}')">
                               <i data-lucide="check-circle-2"></i>Selesai
                           </button>`
                    }
                </div>
            </td>
        </tr>`;
    }).join('');

    lucide.createIcons();
}

/* ── Banner ── */
function updateBanner(active) {
    const banner = document.getElementById('serving-banner');
    const numEl  = document.getElementById('serving-num');
    const nameEl = document.getElementById('serving-name');
    const metaEl = document.getElementById('serving-meta');

    if (active) {
        const prof = active.user?.patient_profile ?? active.user?.patientProfile ?? {};
        const name = prof.full_name ?? active.user?.name ?? '–';
        banner.classList.remove('empty');
        numEl.textContent  = active.queue_number;
        nameEl.textContent = name;
        metaEl.textContent = 'Sedang ditangani';
    } else {
        banner.classList.add('empty');
        numEl.textContent  = '–';
        nameEl.textContent = 'Belum ada pasien dipanggil';
        metaEl.textContent = '';
    }
}

/* ── Actions ── */
async function callPatient(id, num) {
    const res = await api('POST', `/admin/queue/${id}/call`);
    if (res?.ok) {
        toast(`📢 Memanggil ${num}`, 'ok');
        loadQueue();
    } else {
        // Fallback ke startExam jika route queue/call tidak tersedia untuk role ini
        const r2 = await api('POST', `/doctor/exam/${id}/start`);
        if (r2?.ok) { toast(`📢 ${num} dipanggil`, 'ok'); loadQueue(); }
        else toast(res?.data?.message || 'Gagal memanggil pasien', 'err');
    }
}

async function recallPatient(id, num) {
    const res = await api('POST', `/admin/queue/${id}/recall`);
    if (res?.ok) {
        toast(`🔁 Panggilan ulang ${num}`, 'ok');
        loadQueue();
    } else {
        toast(res?.data?.message || 'Gagal', 'err');
    }
}

async function finishPatient(id, num) {
    if (!confirm(`Tandai pasien ${num} selesai ditangani?`)) return;

    // Coba lewat admin/queue/complete dulu (tidak butuh body)
    const res = await api('POST', `/admin/queue/${id}/complete`);
    if (res?.ok) {
        toast(`✅ ${num} selesai`, 'ok');
        loadQueue();
        return;
    }

    // Fallback ke doctor/exam/finish
    const r2 = await api('POST', `/doctor/exam/${id}/finish`, {});
    if (r2?.ok) {
        toast(`✅ ${num} selesai`, 'ok');
        loadQueue();
    } else {
        toast(res?.data?.message || 'Gagal menyelesaikan', 'err');
    }
}

/* ── Load Done ── */
async function loadDone() {
    const tbody = document.getElementById('done-tbody');
    const res   = await api('GET', '/appointments');
    if (!res) return;

    const items = (res.data?.data ?? res.data ?? [])
        .filter(a => a.status === 'completed');

    if (!items.length) {
        tbody.innerHTML = `<tr><td colspan="4">
            <div class="empty"><i data-lucide="check-circle-2"></i>
            <p>Belum ada pasien yang selesai hari ini.</p></div>
        </td></tr>`;
        lucide.createIcons();
        return;
    }

    tbody.innerHTML = items.map(a => `
        <tr>
            <td><span class="q-num">${a.queue_number ?? a.data?.queue_number ?? '–'}</span></td>
            <td>${a.poli_name ?? '–'}</td>
            <td>${a.doctor_name ?? '–'}</td>
            <td style="font-size:.8rem;color:var(--gray-500);">
                ${a.appointment_date ?? '–'}
            </td>
        </tr>`).join('');
    lucide.createIcons();
}

/* ── Helpers ── */
function formatDate(str) {
    if (!str) return '–';
    return new Date(str + 'T00:00:00').toLocaleDateString('id-ID',
        { day: 'numeric', month: 'short', year: 'numeric' });
}

function logout() {
    localStorage.clear();
    window.location.href = '/login';
}

/* ── Init ── */
async function init() {
    // Ambil info dokter dari token
    const profileRes = await api('GET', '/profile');
    if (profileRes?.ok) {
        const u = profileRes.data?.data ?? profileRes.data ?? {};
        const name = u.name ?? u.user?.name ?? 'Dokter';
        document.getElementById('doctor-name').textContent = name;
    }

    await loadQueue();

    // Polling setiap 5 detik
    pollInterval = setInterval(loadQueue, 5000);
}

init();
</script>
</body>
</html>
