<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papan Antrian – Medika Centra</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --teal:       #0d7a6b;
            --teal-dark:  #095c50;
            --teal-light: #e6f4f1;
            --paper:      #f4f7f6;
            --white:      #ffffff;
            --gray-100:   #f0f4f2;
            --gray-200:   #dde5e2;
            --gray-400:   #94a9a3;
            --gray-700:   #2d4039;
            --red:        #c8321a;
            --red-light:  #fff0ed;
            --amber:      #b45309;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--paper);
            color: var(--gray-700);
            min-height: 100vh;
        }

        /* ═══ TV BOARD MODE ═══ */
        .board-page { display: none; }
        .board-page.active { display: flex; flex-direction: column; min-height: 100vh; }

        .board-header {
            background: var(--teal-dark);
            color: white;
            padding: 18px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .board-header .clinic-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
        }

        .board-header .clock {
            font-size: 1.7rem;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: .02em;
        }

        .board-header .date-str {
            font-size: .85rem;
            opacity: .7;
            text-align: right;
            margin-top: 2px;
        }

        .board-body {
            flex: 1;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 24px;
            padding: 28px 32px;
        }

        .poli-panel {
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--gray-200);
            display: flex;
            flex-direction: column;
        }

        .poli-panel-header {
            background: var(--teal);
            color: white;
            padding: 14px 20px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1rem;
            font-weight: 800;
        }

        .poli-panel-header .poli-code {
            font-size: .75rem;
            opacity: .75;
            font-weight: 600;
            margin-top: 2px;
        }

        .now-serving-box {
            padding: 20px 24px 16px;
            border-bottom: 1px solid var(--gray-100);
        }

        .ns-label {
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--gray-400);
            margin-bottom: 6px;
        }

        .ns-number {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1;
            color: var(--teal-dark);
            letter-spacing: -.03em;
        }

        .ns-number.ringing {
            color: var(--red);
            animation: pulse-num 1.2s ease-in-out infinite;
        }

        @keyframes pulse-num {
            0%,100% { opacity: 1; }
            50%      { opacity: .45; }
        }

        .ns-patient {
            font-size: .9rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-top: 6px;
        }

        .ns-count {
            font-size: .75rem;
            color: var(--gray-400);
            margin-top: 2px;
        }

        .waiting-section {
            padding: 12px 20px 16px;
            flex: 1;
        }

        .waiting-label {
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--gray-400);
            margin-bottom: 8px;
        }

        .waiting-row {
            display: flex;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid var(--gray-100);
            gap: 10px;
        }

        .waiting-row:last-child { border-bottom: none; }

        .wr-num {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            width: 64px;
            color: var(--teal-dark);
        }

        .wr-name {
            flex: 1;
            font-size: .83rem;
            font-weight: 500;
            color: var(--gray-700);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wr-time {
            font-size: .75rem;
            color: var(--gray-400);
            font-weight: 500;
        }

        .board-footer {
            background: var(--teal-dark);
            color: rgba(255,255,255,.65);
            padding: 10px 32px;
            font-size: .78rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* ═══ ADMIN CALL PANEL MODE ═══ */
        .admin-page { display: none; }
        .admin-page.active {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .admin-topbar {
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .admin-topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .back-link {
            display: flex; align-items: center; gap: 6px;
            font-size: .83rem; font-weight: 600; color: var(--teal-dark);
            cursor: pointer; text-decoration: none;
            background: var(--teal-light); padding: 6px 12px; border-radius: 8px;
            border: none; font-family: inherit;
        }

        .page-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.1rem;
            font-weight: 800;
        }

        .admin-main {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 24px;
            padding: 24px 28px;
            flex: 1;
            align-items: start;
        }

        /* Left: poli selector + board */
        .panel-left { display: flex; flex-direction: column; gap: 16px; }

        .poli-select-wrap {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 14px;
            padding: 18px 20px;
        }

        .poli-select-wrap label {
            display: block;
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--gray-400);
            margin-bottom: 8px;
        }

        .poli-select {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid var(--gray-200);
            border-radius: 9px;
            font-family: inherit;
            font-size: .9rem;
            font-weight: 600;
            color: var(--gray-700);
            outline: none;
            cursor: pointer;
        }

        .poli-select:focus { border-color: var(--teal); }

        .board-mini {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 14px;
            overflow: hidden;
        }

        .board-mini-header {
            background: var(--teal);
            color: white;
            padding: 12px 18px;
            font-size: .82rem;
            font-weight: 700;
        }

        .board-mini-body { padding: 14px 18px; }

        .mini-serving-label {
            font-size: .67rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--gray-400);
            margin-bottom: 4px;
        }

        .mini-serving-num {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--teal-dark);
            line-height: 1;
        }

        .mini-serving-num.ringing { color: var(--red); }

        .mini-info {
            font-size: .8rem;
            color: var(--gray-400);
            margin-top: 6px;
        }

        /* Right: queue list */
        .panel-right {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 14px;
            overflow: hidden;
        }

        .qlist-header {
            padding: 16px 22px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .qlist-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .95rem;
            font-weight: 800;
        }

        .qlist-count {
            font-size: .78rem;
            background: var(--teal-light);
            color: var(--teal-dark);
            padding: 3px 10px;
            border-radius: 999px;
            font-weight: 700;
        }

        .qlist-body { padding: 8px 0; }

        .qrow {
            display: flex;
            align-items: center;
            padding: 13px 22px;
            gap: 16px;
            border-bottom: 1px solid var(--gray-100);
            transition: background .12s;
        }

        .qrow:last-child { border-bottom: none; }
        .qrow:hover { background: var(--gray-100); }

        .qrow.is-active {
            background: #fff8f6;
            border-left: 3px solid var(--red);
        }

        .qrow-num {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            width: 76px;
            color: var(--teal-dark);
            flex-shrink: 0;
        }

        .qrow.is-active .qrow-num { color: var(--red); }

        .qrow-info { flex: 1; min-width: 0; }

        .qrow-name {
            font-size: .88rem;
            font-weight: 600;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .qrow-meta { font-size: .75rem; color: var(--gray-400); }

        .qrow-badge {
            font-size: .7rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .qrow-badge.arrived   { background: #e8f4ff; color: #1d6fa4; }
        .qrow-badge.active    { background: #ffeeea; color: var(--red); }

        .qrow-actions {
            display: flex;
            gap: 6px;
            flex-shrink: 0;
        }

        /* Buttons */
        .btn {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 7px 13px;
            border-radius: 8px;
            font-size: .8rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            border: none;
            transition: all .14s;
            white-space: nowrap;
        }

        .btn svg { width: 14px; height: 14px; }
        .btn:disabled { opacity: .45; cursor: not-allowed; }

        .btn-call    { background: var(--teal); color: white; }
        .btn-call:hover:not(:disabled)   { background: var(--teal-dark); }

        .btn-recall  { background: var(--amber-light, #fef3c7); color: var(--amber); border: 1px solid #fde68a; }
        .btn-recall:hover:not(:disabled) { background: #fef3c7; }

        .btn-done    { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .btn-done:hover:not(:disabled)   { background: #bbf7d0; }

        .btn-skip    { background: var(--gray-100); color: var(--gray-400); border: 1px solid var(--gray-200); }
        .btn-skip:hover:not(:disabled)   { background: var(--gray-200); }

        .btn-sm { padding: 5px 10px; font-size: .75rem; }

        /* Sound + Mode buttons */
        .mode-bar {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .mode-btn {
            display: flex; align-items: center; gap: 6px;
            padding: 7px 14px;
            border-radius: 999px;
            font-size: .78rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            border: 1.5px solid var(--gray-200);
            background: var(--white);
            color: var(--gray-700);
            transition: all .14s;
        }

        .mode-btn.active { border-color: var(--teal); background: var(--teal-light); color: var(--teal-dark); }
        .mode-btn svg { width: 14px; height: 14px; }

        /* Toast */
        #toast {
            position: fixed; bottom: 20px; right: 20px; z-index: 999;
            display: flex; flex-direction: column; gap: 8px;
        }

        .t-item {
            background: var(--gray-700); color: white;
            padding: 10px 16px; border-radius: 10px;
            font-size: .83rem; font-weight: 600;
            animation: sUp .2s ease;
            max-width: 280px;
        }

        .t-item.ok  { background: var(--teal-dark); }
        .t-item.err { background: var(--red); }

        @keyframes sUp { from{transform:translateY(10px);opacity:0} to{opacity:1;transform:none} }

        /* Empty */
        .qlist-empty {
            padding: 48px 20px;
            text-align: center;
            color: var(--gray-400);
            font-size: .88rem;
        }

        /* Spinner */
        @keyframes spin { to { transform: rotate(360deg); } }
        .spin { animation: spin .8s linear infinite; display: inline-block; }
    </style>
</head>
<body>

<!-- ══════════════════════════════════
     PAGE 1: PAPAN TV (tampilan layar)
══════════════════════════════════ -->
<div class="board-page" id="page-board">
    <header class="board-header">
        <div>
            <div class="clinic-name">🏥 Medika Centra</div>
            <div style="font-size:.8rem;opacity:.65;margin-top:3px;">Sistem Antrian Digital</div>
        </div>
        <div style="text-align:right;">
            <div class="clock" id="clock">00:00:00</div>
            <div class="date-str" id="date-str">–</div>
        </div>
    </header>

    <main class="board-body" id="board-grid">
        <!-- diisi JS -->
        <div style="grid-column:1/-1;text-align:center;padding:60px;color:var(--gray-400);font-size:1rem;">
            Memuat data antrian…
        </div>
    </main>

    <footer class="board-footer">
        <span>Silakan tunggu hingga nomor Anda dipanggil</span>
        <span id="board-updated">Diperbarui: –</span>
    </footer>
</div>


<!-- ══════════════════════════════════
     PAGE 2: PANEL ADMIN PANGGIL NOMOR
══════════════════════════════════ -->
<div class="admin-page" id="page-admin">
    <div class="admin-topbar">
        <div class="admin-topbar-left">
            <a class="back-link" href="/admin-dashboard">← Admin Panel</a>
            <div class="page-title">Sistem Pemanggilan Antrian</div>
        </div>
        <div class="mode-bar">
            <button class="mode-btn" id="btn-tv-mode" onclick="switchToBoard()">
                <i data-lucide="monitor"></i>Mode Layar TV
            </button>
            <button class="mode-btn active" id="btn-sound" onclick="toggleSound()">
                <i data-lucide="volume-x" id="sound-icon"></i>
                <span id="sound-label">Aktifkan Suara</span>
            </button>
        </div>
    </div>

    <div class="admin-main">
        <!-- LEFT PANEL -->
        <div class="panel-left">
            <div class="poli-select-wrap">
                <label>Pilih Poli</label>
                <select class="poli-select" id="poli-selector" onchange="onPoliChange()">
                    <option value="">Memuat…</option>
                </select>
            </div>

            <div class="board-mini">
                <div class="board-mini-header">Status Papan Antrian</div>
                <div class="board-mini-body">
                    <div class="mini-serving-label">Sedang Dipanggil / Dilayani</div>
                    <div class="mini-serving-num" id="mini-serving">–</div>
                    <div class="mini-info" id="mini-info">Pilih poli untuk memulai</div>

                    <div style="margin-top:16px;padding-top:14px;border-top:1px solid var(--gray-200);">
                        <div style="display:flex;justify-content:space-between;font-size:.78rem;margin-bottom:4px;">
                            <span style="color:var(--gray-400);font-weight:600;">Menunggu</span>
                            <span id="mini-waiting-count" style="font-weight:800;color:var(--teal-dark);">–</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next in queue -->
            <div class="board-mini" id="next-up-box" style="display:none;">
                <div class="board-mini-header" style="background:#fef3c7;color:var(--amber);">Berikutnya</div>
                <div class="board-mini-body">
                    <div class="mini-serving-num" id="next-num" style="color:var(--amber);font-size:2rem;">–</div>
                    <div class="mini-info" id="next-name">–</div>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL: queue list -->
        <div class="panel-right">
            <div class="qlist-header">
                <span class="qlist-title">Antrian Hari Ini</span>
                <span class="qlist-count" id="qlist-count">0 pasien</span>
            </div>
            <div class="qlist-body" id="qlist-body">
                <div class="qlist-empty">Pilih poli untuk memulai.</div>
            </div>
        </div>
    </div>
</div>

<div id="toast"></div>

<!-- Lucide icons -->
<script src="https://unpkg.com/lucide@latest"></script>

<script>
lucide.createIcons();

/* ══════════════════════════════
   CONFIG
══════════════════════════════ */
const API      = '/api';
const token    = localStorage.getItem('auth_token');
const role     = localStorage.getItem('user_role');

// Mode: 'board' = TV display (no auth), 'admin' = admin panel (auth required)
let currentMode = 'admin';
let soundEnabled = false;
let selectedPoliId = null;
let pollInterval = null;
let lastServing = {};  // poli_id → queue_number (untuk deteksi perubahan TTS)

/* ══════════════════════════════
   INIT — decide mode
══════════════════════════════ */
(function init() {
    const params = new URLSearchParams(location.search);
    if (params.get('mode') === 'board') {
        switchToBoard(false);
    } else {
        if (!token || role !== 'admin') {
            window.location.href = '/login';
            return;
        }
        switchToAdmin();
    }
})();

function switchToBoard(pushState = true) {
    currentMode = 'board';
    document.getElementById('page-board').classList.add('active');
    document.getElementById('page-admin').classList.remove('active');
    if (pushState) history.replaceState(null, '', '?mode=board');
    startClock();
    startBoardPoll();
}

function switchToAdmin() {
    currentMode = 'admin';
    document.getElementById('page-admin').classList.add('active');
    document.getElementById('page-board').classList.remove('active');
    if (pollInterval) clearInterval(pollInterval);
    history.replaceState(null, '', location.pathname);
    loadPolis();
}

/* ══════════════════════════════
   CLOCK
══════════════════════════════ */
function startClock() {
    function tick() {
        const now = new Date();
        document.getElementById('clock').textContent =
            now.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit', second:'2-digit' });
        document.getElementById('date-str').textContent =
            now.toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long', year:'numeric' });
    }
    tick();
    setInterval(tick, 1000);
}

/* ══════════════════════════════
   API HELPER
══════════════════════════════ */
async function api(method, path, body = null) {
    const headers = { 'Accept': 'application/json', 'Content-Type': 'application/json' };
    if (token) headers['Authorization'] = 'Bearer ' + token;
    const opts = { method, headers };
    if (body) opts.body = JSON.stringify(body);
    try {
        const res = await fetch(API + path, opts);
        const json = await res.json().catch(() => ({}));
        return { ok: res.ok, status: res.status, data: json };
    } catch (e) {
        return { ok: false, data: {} };
    }
}

/* ══════════════════════════════
   SOUND / TTS
══════════════════════════════ */
function toggleSound() {
    soundEnabled = !soundEnabled;
    const icon  = document.getElementById('sound-icon');
    const label = document.getElementById('sound-label');
    const btn   = document.getElementById('btn-sound');

    if (soundEnabled) {
        icon.setAttribute('data-lucide', 'volume-2');
        label.textContent = 'Suara Aktif';
        btn.classList.add('active');
        speak('Sistem suara antrian diaktifkan.');
    } else {
        icon.setAttribute('data-lucide', 'volume-x');
        label.textContent = 'Aktifkan Suara';
        btn.classList.remove('active');
    }
    lucide.createIcons();
}

function speak(text) {
    if (!soundEnabled || !('speechSynthesis' in window)) return;
    window.speechSynthesis.cancel();
    const make = () => {
        const u = new SpeechSynthesisUtterance(text);
        u.lang = 'id-ID'; u.rate = 0.88; u.pitch = 1;
        return u;
    };
    window.speechSynthesis.speak(make());
    window.speechSynthesis.speak(make()); // 2x seperti pengumuman RS
}

/* ══════════════════════════════
   TOAST
══════════════════════════════ */
function toast(msg, type = '') {
    const el = document.createElement('div');
    el.className = 't-item ' + type;
    el.textContent = msg;
    document.getElementById('toast').appendChild(el);
    setTimeout(() => el.remove(), 3500);
}

/* ══════════════════════════════
   BOARD (TV) MODE
══════════════════════════════ */
function startBoardPoll() {
    renderBoard();
    if (pollInterval) clearInterval(pollInterval);
    pollInterval = setInterval(renderBoard, 5000);
}

async function renderBoard() {
    const res = await api('GET', '/queue/board');
    if (!res.ok) return;

    const { data, timestamp } = res.data;
    const grid = document.getElementById('board-grid');

    if (!data || !data.length) {
        grid.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:60px;color:var(--gray-400);">Belum ada data antrian.</div>';
        return;
    }

    grid.innerHTML = data.map(poli => {
        const s = poli.now_serving;
        const w = poli.waiting_list || [];

        // Deteksi perubahan → TTS untuk papan (mode board aktif & sound on)
        if (s && lastServing[poli.poli_id] !== s.queue_number) {
            lastServing[poli.poli_id] = s.queue_number;
            if (soundEnabled) {
                speak(`Nomor antrian ${s.queue_number}, silakan menuju ${poli.poli_name}.`);
            }
        }

        return `
        <div class="poli-panel">
            <div class="poli-panel-header">
                ${poli.poli_name}
                <div class="poli-code">Kode: ${poli.poli_code}</div>
            </div>
            <div class="now-serving-box">
                <div class="ns-label">Sedang Dipanggil</div>
                <div class="ns-number ${s ? 'ringing' : ''}">${s ? s.queue_number : '–'}</div>
                ${s ? `
                <div class="ns-patient">${s.patient_name}</div>
                <div class="ns-count">Panggilan ke-${s.called_count} · ${s.called_at}</div>` : ''}
            </div>
            <div class="waiting-section">
                <div class="waiting-label">${poli.waiting_count} Menunggu</div>
                ${w.length ? w.slice(0, 5).map(a => `
                <div class="waiting-row">
                    <span class="wr-num">${a.queue_number}</span>
                    <span class="wr-name">${a.patient_name}</span>
                    <span class="wr-time">${a.estimated_time ? a.estimated_time.substring(0,5) : ''}</span>
                </div>`).join('') : '<div style="color:var(--gray-400);font-size:.83rem;padding:8px 0;">Tidak ada pasien menunggu</div>'}
            </div>
        </div>`;
    }).join('');

    const upd = document.getElementById('board-updated');
    if (upd) upd.textContent = 'Diperbarui: ' + new Date(timestamp).toLocaleTimeString('id-ID');
}

/* ══════════════════════════════
   ADMIN MODE — Poli
══════════════════════════════ */
async function loadPolis() {
    const res = await api('GET', '/admin/polis');
    if (!res.ok) return;

    const polis = res.data.data.filter(p => p.is_active);
    const sel = document.getElementById('poli-selector');
    sel.innerHTML = '<option value="">Pilih Poli…</option>' +
        polis.map(p => `<option value="${p.id}">${p.name}</option>`).join('');

    if (polis.length === 1) {
        sel.value = polis[0].id;
        onPoliChange();
    }
}

function onPoliChange() {
    selectedPoliId = document.getElementById('poli-selector').value || null;
    if (!selectedPoliId) {
        document.getElementById('qlist-body').innerHTML = '<div class="qlist-empty">Pilih poli untuk memulai.</div>';
        return;
    }
    refreshAdminQueue();
    if (pollInterval) clearInterval(pollInterval);
    pollInterval = setInterval(refreshAdminQueue, 5000);
}

async function refreshAdminQueue() {
    if (!selectedPoliId) return;

    const [boardRes, listRes] = await Promise.all([
        api('GET', `/admin/queue/board?poli_id=${selectedPoliId}`),
        api('GET', `/admin/queue/list?poli_id=${selectedPoliId}`),
    ]);

    // Update mini board
    if (boardRes.ok) {
        const poliData = boardRes.data.data?.find(p => p.poli_id == selectedPoliId);
        if (poliData) {
            const s = poliData.now_serving;
            const miniNum = document.getElementById('mini-serving');
            miniNum.textContent    = s ? s.queue_number : '–';
            miniNum.className      = 'mini-serving-num' + (s ? ' ringing' : '');
            document.getElementById('mini-info').textContent =
                s ? `Pasien: ${s.patient_name} · Panggilan ke-${s.called_count}` : 'Belum ada panggilan';
            document.getElementById('mini-waiting-count').textContent = poliData.waiting_count;

            // Next up
            const next = poliData.waiting_list?.[0];
            const box  = document.getElementById('next-up-box');
            if (next) {
                box.style.display = 'block';
                document.getElementById('next-num').textContent  = next.queue_number;
                document.getElementById('next-name').textContent = next.patient_name;
            } else {
                box.style.display = 'none';
            }

            // TTS saat ada perubahan nomor
            if (s && lastServing[selectedPoliId] !== s.queue_number) {
                lastServing[selectedPoliId] = s.queue_number;
                speak(`Nomor antrian ${s.queue_number}, silakan menuju ${poliData.poli_name}.`);
            }
        }
    }

    // Render queue list
    if (listRes.ok) renderQueueList(listRes.data.data || []);
}

function renderQueueList(items) {
    const body = document.getElementById('qlist-body');
    document.getElementById('qlist-count').textContent = items.length + ' pasien';

    if (!items.length) {
        body.innerHTML = '<div class="qlist-empty">Tidak ada antrian aktif hari ini.</div>';
        return;
    }

    body.innerHTML = items.map(a => {
        const isActive = a.status === 'in_progress';
        return `
        <div class="qrow${isActive ? ' is-active' : ''}" id="qrow-${a.appointment_id}">
            <div class="qrow-num">${a.queue_number}</div>
            <div class="qrow-info">
                <div class="qrow-name">${a.patient_name}</div>
                <div class="qrow-meta">
                    ${a.estimated_time ? 'Est. ' + a.estimated_time.substring(0,5) : ''}
                    ${a.called_count > 0 ? ` · Dipanggil ${a.called_count}×` : ''}
                    ${a.called_at ? ` · ${a.called_at}` : ''}
                </div>
            </div>
            <span class="qrow-badge ${isActive ? 'active' : 'arrived'}">${isActive ? 'Dipanggil' : 'Menunggu'}</span>
            <div class="qrow-actions">
                ${!isActive ? `
                <button class="btn btn-call" onclick="callQueue(${a.appointment_id}, '${a.queue_number}', '${a.patient_name.replace(/'/g,'')}')" title="Panggil">
                    📢 Panggil
                </button>` : `
                <button class="btn btn-recall" onclick="recallQueue(${a.appointment_id}, '${a.queue_number}')" title="Ulang Panggil">
                    🔁 Ulang
                </button>
                <button class="btn btn-done" onclick="completeQueue(${a.appointment_id}, '${a.queue_number}')" title="Selesai">
                    ✓ Selesai
                </button>
                <button class="btn btn-skip btn-sm" onclick="skipQueue(${a.appointment_id}, '${a.queue_number}')" title="Lewati">
                    Lewati
                </button>`}
            </div>
        </div>`;
    }).join('');
}

/* ══════════════════════════════
   ADMIN ACTIONS
══════════════════════════════ */
async function callQueue(id, num, name) {
    const res = await api('POST', `/admin/queue/${id}/call`);
    if (res.ok) {
        toast(`📢 Memanggil ${num} — ${name}`, 'ok');
        speak(`Nomor antrian ${num}, ${name}, silakan menuju ruang pemeriksaan.`);
        refreshAdminQueue();
    } else {
        toast(res.data.message || 'Gagal memanggil', 'err');
    }
}

async function recallQueue(id, num) {
    const res = await api('POST', `/admin/queue/${id}/recall`);
    if (res.ok) {
        toast(`🔁 Panggilan ulang ${num}`, 'ok');
        speak(`Panggilan ulang. Nomor antrian ${num}, silakan segera menuju ruang pemeriksaan.`);
        refreshAdminQueue();
    } else {
        toast(res.data.message || 'Gagal', 'err');
    }
}

async function completeQueue(id, num) {
    const res = await api('POST', `/admin/queue/${id}/complete`);
    if (res.ok) {
        toast(`✓ Nomor ${num} selesai dilayani`, 'ok');
        refreshAdminQueue();
    } else {
        toast(res.data.message || 'Gagal', 'err');
    }
}

async function skipQueue(id, num) {
    if (!confirm(`Lewati pasien ${num}? Status akan menjadi "tidak hadir".`)) return;
    const res = await api('POST', `/admin/queue/${id}/skip`);
    if (res.ok) {
        toast(`Nomor ${num} dilewati (no show)`);
        refreshAdminQueue();
    } else {
        toast(res.data.message || 'Gagal', 'err');
    }
}
</script>
</body>
</html>
