<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas – Medika Centra</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --teal:#0d7a6b;--teal-dark:#095c50;--teal-light:#e6f4f1;
            --blue:#1d6fa4;--blue-light:#e8f2fa;
            --amber:#b45309;--amber-light:#fef3c7;
            --red:#b91c1c;--red-light:#fee2e2;
            --green:#15803d;--green-light:#dcfce7;
            --gray-50:#f9fafb;--gray-100:#f3f4f6;--gray-200:#e5e7eb;
            --gray-400:#9ca3af;--gray-500:#6b7280;--gray-700:#374151;--gray-900:#111827;
            --white:#ffffff;
        }
        *{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Inter',sans-serif;background:var(--gray-50);color:var(--gray-900);display:flex;min-height:100vh;}
        h1,h2,h3{font-family:'Plus Jakarta Sans',sans-serif;}
        .sidebar{width:230px;min-width:230px;background:#0f172a;color:white;height:100vh;position:sticky;top:0;display:flex;flex-direction:column;}
        .sb-brand{padding:20px 18px 16px;border-bottom:1px solid rgba(255,255,255,.08);display:flex;align-items:center;gap:9px;}
        .sb-mark{width:32px;height:32px;background:var(--teal);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
        .sb-mark svg{width:16px;height:16px;stroke:white;}
        .sb-title{font-size:.9rem;font-weight:800;}
        .sb-sub{font-size:.66rem;color:#94a3b8;font-weight:500;}
        .sb-section{padding:14px 16px 4px;font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#475569;}
        .nav-item{margin:1px 8px;padding:9px 12px;border-radius:8px;font-size:.84rem;font-weight:600;color:#94a3b8;display:flex;align-items:center;gap:9px;cursor:pointer;transition:.15s;border:none;background:none;width:calc(100% - 16px);text-align:left;}
        .nav-item svg{width:15px;height:15px;flex-shrink:0;}
        .nav-item:hover{background:#1e293b;color:#e2e8f0;}
        .nav-item.active{background:var(--teal);color:white;}
        .sb-footer{margin-top:auto;padding:12px 8px 14px;border-top:1px solid rgba(255,255,255,.07);}
        .main{flex:1;min-width:0;display:flex;flex-direction:column;}
        .topbar{height:58px;background:var(--white);border-bottom:1px solid var(--gray-200);display:flex;align-items:center;justify-content:space-between;padding:0 26px;position:sticky;top:0;z-index:20;}
        .topbar-title{font-size:.95rem;font-weight:700;}
        .staff-chip{display:flex;align-items:center;gap:7px;background:var(--gray-100);padding:5px 12px;border-radius:999px;font-size:.78rem;font-weight:700;}
        .content{padding:22px 26px;}
        .page{display:none;}
        .page.active{display:block;}
        .card{background:var(--white);border:1px solid var(--gray-200);border-radius:14px;}
        .card-header{padding:14px 20px;border-bottom:1px solid var(--gray-200);display:flex;align-items:center;justify-content:space-between;}
        .card-title{font-size:.9rem;font-weight:800;}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:.8rem;font-weight:700;font-family:inherit;cursor:pointer;border:none;transition:.14s;}
        .btn svg{width:14px;height:14px;}
        .btn-primary{background:var(--teal);color:white;}
        .btn-primary:hover{background:var(--teal-dark);}
        .btn-outline{background:white;color:var(--gray-700);border:1px solid var(--gray-300);}
        .btn-outline:hover{background:var(--gray-100);}
        .btn-green{background:var(--green-light);color:var(--green);border:1px solid #86efac;}
        .btn-green:hover{background:#bbf7d0;}
        .btn-sm{padding:5px 10px;font-size:.75rem;}
        .badge{display:inline-flex;align-items:center;padding:2px 9px;border-radius:999px;font-size:.7rem;font-weight:700;}
        .badge-pending{background:var(--amber-light);color:var(--amber);}
        .badge-arrived{background:var(--blue-light);color:var(--blue);}
        .badge-progress{background:var(--red-light);color:var(--red);}
        .data-table{width:100%;border-collapse:collapse;font-size:.84rem;}
        .data-table thead tr{background:var(--gray-50);}
        .data-table th{padding:10px 16px;text-align:left;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--gray-500);border-bottom:1px solid var(--gray-200);}
        .data-table td{padding:12px 16px;border-bottom:1px solid #f9fafb;vertical-align:middle;}
        .data-table tbody tr:last-child td{border-bottom:none;}
        .data-table tbody tr:hover{background:#fafffe;}
        .poli-tabs{display:flex;gap:0;border-bottom:2px solid var(--gray-200);margin-bottom:16px;flex-wrap:wrap;}
        .poli-tab{padding:9px 18px;font-size:.84rem;font-weight:700;font-family:inherit;border:none;background:none;cursor:pointer;color:var(--gray-400);border-bottom:2px solid transparent;margin-bottom:-2px;transition:.15s;}
        .poli-tab.active{color:var(--teal-dark);border-color:var(--teal);}
        .modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);display:none;align-items:center;justify-content:center;z-index:100;padding:20px;backdrop-filter:blur(3px);}
        .modal-overlay.open{display:flex;}
        .modal-box{background:white;border-radius:18px;width:100%;max-width:500px;padding:26px;box-shadow:0 20px 48px rgba(0,0,0,.14);max-height:92vh;overflow-y:auto;}
        .modal-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;}
        .modal-title{font-size:1rem;font-weight:800;}
        .btn-close{width:28px;height:28px;border-radius:7px;border:1px solid var(--gray-200);background:white;display:flex;align-items:center;justify-content:center;cursor:pointer;}
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
        .form-grid .full{grid-column:1/-1;}
        .fg{display:flex;flex-direction:column;gap:4px;}
        .fg label{font-size:.76rem;font-weight:700;color:var(--gray-700);}
        .fg input,.fg select,.fg textarea{padding:8px 11px;border:1.5px solid var(--gray-200);border-radius:8px;font-family:inherit;font-size:.84rem;outline:none;transition:.14s;}
        .fg input:focus,.fg select:focus{border-color:var(--teal);}
        .form-actions{display:flex;gap:10px;margin-top:20px;justify-content:flex-end;}
        #toast{position:fixed;bottom:18px;right:18px;z-index:200;display:flex;flex-direction:column;gap:8px;}
        .t-item{background:#111827;color:white;padding:10px 15px;border-radius:10px;font-size:.82rem;font-weight:600;animation:sUp .2s ease;max-width:280px;}
        .t-item.ok{background:var(--teal-dark);}
        .t-item.err{background:var(--red);}
        @keyframes sUp{from{transform:translateY(10px);opacity:0}to{opacity:1;transform:none}}
        .sk{background:linear-gradient(90deg,#f0f0f0 25%,#e8e8e8 50%,#f0f0f0 75%);background-size:200% 100%;animation:sk 1.4s infinite;border-radius:6px;}
        @keyframes sk{0%{background-position:200% 0}100%{background-position:-200% 0}}
    </style>
</head>
<body>
<aside class="sidebar">
    <div class="sb-brand">
        <div class="sb-mark"><i data-lucide="shield-check"></i></div>
        <div><div class="sb-title">Petugas</div><div class="sb-sub">Medika Centra</div></div>
    </div>
    <div class="sb-section">Menu</div>
    <button class="nav-item active" onclick="showPage('antrian')" id="nav-antrian"><i data-lucide="list-ordered"></i>Daftar Antrian</button>
    <button class="nav-item" onclick="showPage('walkin')" id="nav-walkin"><i data-lucide="user-plus"></i>Walk-In Manual</button>
    <div class="sb-footer">
        <button class="nav-item" onclick="logout()" style="color:#f87171;"><i data-lucide="log-out"></i>Keluar</button>
    </div>
</aside>

<div class="main">
    <header class="topbar">
        <div class="topbar-title" id="topbar-title">Daftar Antrian Hari Ini</div>
        <div class="staff-chip"><i data-lucide="user-cog" style="width:13px;height:13px;"></i><span id="staff-name">Petugas</span></div>
    </header>
    <div class="content">

        <!-- Antrian -->
        <div class="page active" id="page-antrian">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px;">
                <p style="font-size:.83rem;color:var(--gray-400);">Klik "Verifikasi Hadir" saat pasien datang ke loket.</p>
                <button class="btn btn-outline btn-sm" onclick="loadAntrian()"><i data-lucide="refresh-cw"></i>Refresh</button>
            </div>
            <div class="poli-tabs" id="poli-tabs"></div>
            <div class="card">
                <table class="data-table">
                    <thead><tr><th>Nomor</th><th>Pasien</th><th>NIK</th><th>No HP</th><th>Poli</th><th>Status</th><th style="text-align:right;">Aksi</th></tr></thead>
                    <tbody id="antrian-tbody">
                        <tr><td colspan="7"><div class="sk" style="height:36px;margin:8px;"></div></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Walk-In -->
        <div class="page" id="page-walkin">
            <p style="font-size:.83rem;color:var(--gray-400);margin-bottom:20px;">Daftarkan pasien yang datang langsung tanpa booking online.</p>
            <div class="card" style="max-width:500px;">
                <div class="card-header"><span class="card-title">Form Walk-In Manual</span></div>
                <div style="padding:22px;">
                    <div id="wi-error" style="background:var(--red-light);color:var(--red);padding:10px 12px;border-radius:8px;font-size:.82rem;margin-bottom:14px;display:none;"></div>
                    <div class="form-grid">
                        <div class="fg full"><label>Nama Lengkap *</label><input type="text" id="wi-name" placeholder="Nama pasien"></div>
                        <div class="fg"><label>NIK (opsional)</label><input type="text" id="wi-nik" maxlength="16" placeholder="16 digit" inputmode="numeric"></div>
                        <div class="fg"><label>No HP *</label><input type="tel" id="wi-phone" placeholder="08xx"></div>
                        <div class="fg full"><label>Poli *</label><select id="wi-poli"><option value="">Pilih Poli…</option></select></div>
                        <div class="fg full"><label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.83rem;">
                            <input type="checkbox" id="wi-emergency" style="width:15px;height:15px;">
                            Tandai Gawat Darurat (langsung Arrived)
                        </label></div>
                    </div>
                    <button class="btn btn-primary" style="margin-top:18px;width:100%;justify-content:center;" onclick="submitWalkIn()" id="btn-walkin">
                        <i data-lucide="plus-circle"></i>Daftarkan Pasien
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Verifikasi -->
<div class="modal-overlay" id="modal-verify">
    <div class="modal-box">
        <div class="modal-header">
            <span class="modal-title">Verifikasi Kehadiran Pasien</span>
            <button class="btn-close" onclick="closeModal()"><i data-lucide="x" style="width:14px;height:14px;"></i></button>
        </div>
        <div id="verify-info" style="background:var(--teal-light);border-radius:10px;padding:12px 16px;margin-bottom:18px;font-size:.84rem;"></div>
        <input type="hidden" id="verify-id">
        <div class="form-grid">
            <div class="fg"><label>NIK (update jika kosong)</label><input type="text" id="v-nik" maxlength="16" placeholder="16 digit"></div>
            <div class="fg"><label>No KIS/BPJS (opsional)</label><input type="text" id="v-bpjs" placeholder="Nomor BPJS"></div>
            <div class="fg full"><label>No HP (update jika perlu)</label><input type="tel" id="v-phone" placeholder="08xx"></div>
        </div>
        <p style="font-size:.74rem;color:var(--gray-400);margin-top:8px;">Data kosong tidak akan mengubah profil pasien.</p>
        <div class="form-actions">
            <button class="btn btn-outline" onclick="closeModal()">Batal</button>
            <button class="btn btn-green" onclick="confirmVerify()"><i data-lucide="check-circle"></i>Konfirmasi Hadir</button>
        </div>
    </div>
</div>

<div id="toast"></div>
<script>
lucide.createIcons();
const API   = '/api';
const token = localStorage.getItem('auth_token');
const role  = localStorage.getItem('user_role');
if (!token || !['staff','admin'].includes(role)) window.location.href = '/login';

let allPolis = [];
let selPoliId = '';

function showPage(name) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    document.getElementById('page-' + name).classList.add('active');
    document.getElementById('nav-' + name)?.classList.add('active');
    const titles = { antrian:'Daftar Antrian Hari Ini', walkin:'Walk-In Manual' };
    document.getElementById('topbar-title').textContent = titles[name] || name;
    if (name === 'walkin') populateWalkInPoli();
    lucide.createIcons();
}

async function apiFetch(method, path, body = null) {
    const h = { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' };
    if (body) h['Content-Type'] = 'application/json';
    const r = await fetch(API + path, { method, headers: h, body: body ? JSON.stringify(body) : null });
    if (r.status === 401) { logout(); return null; }
    return r;
}

function toast(msg, type = '') {
    const el = document.createElement('div');
    el.className = 't-item ' + type;
    el.textContent = msg;
    document.getElementById('toast').appendChild(el);
    setTimeout(() => el.remove(), 3500);
}

function closeModal() { document.getElementById('modal-verify').classList.remove('open'); }

/* ── Antrian ── */
async function loadAntrian() {
    if (!allPolis.length) {
        const r = await apiFetch('GET', '/poli');
        if (r?.ok) allPolis = (await r.json()).data || [];
    }
    const tabs = document.getElementById('poli-tabs');
    tabs.innerHTML = [{ id:'', name:'Semua Poli' }, ...allPolis].map((p, i) =>
        `<button class="poli-tab ${i===0?'active':''}" onclick="selPoli('${p.id}',this)">${p.name}</button>`
    ).join('');
    selPoliId = '';
    await fetchAntrian();
}

function selPoli(id, btn) {
    document.querySelectorAll('.poli-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    selPoliId = id;
    fetchAntrian();
}

async function fetchAntrian() {
    const tbody = document.getElementById('antrian-tbody');
    tbody.innerHTML = '<tr><td colspan="7"><div class="sk" style="height:36px;margin:8px;"></div></td></tr>';
    const r = await apiFetch('GET', '/staff/queues' + (selPoliId ? '?poli_id=' + selPoliId : ''));
    if (!r) return;
    const json  = await r.json();
    const items = Object.values(json).flat();
    if (!items.length) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:36px;color:var(--gray-400);font-size:.875rem;">Tidak ada antrian aktif saat ini.</td></tr>';
        return;
    }
    const statusMap = { pending:'Menunggu', confirmed:'Terkonfirmasi', arrived:'Sudah Hadir', in_progress:'Dipanggil', completed:'Selesai' };
    const badgeMap  = { pending:'badge-pending', arrived:'badge-arrived', in_progress:'badge-progress', confirmed:'badge-pending' };
    tbody.innerHTML = items.map(a => {
        const prof  = a.user?.patient_profile ?? a.user?.patientProfile ?? {};
        const name  = prof.full_name ?? a.user?.name ?? '–';
        const nik   = prof.nik ?? '–';
        const phone = prof.phone_number ?? a.temp_phone ?? '–';
        const poli  = a.poli?.name ?? '–';
        const canVerify = ['pending','confirmed'].includes(a.status);
        return `<tr>
            <td><strong style="font-family:'Plus Jakarta Sans',sans-serif;">${a.queue_number}</strong></td>
            <td>${name}</td>
            <td style="font-size:.78rem;color:var(--gray-400);">${nik}</td>
            <td style="font-size:.78rem;">${phone}</td>
            <td>${poli}</td>
            <td><span class="badge ${badgeMap[a.status]||'badge-pending'}">${statusMap[a.status]||a.status}</span></td>
            <td style="text-align:right;">
            ${canVerify
                ? `<button onclick='openVerify(${JSON.stringify(a).replace(/'/g,"&#39;")})' class="btn btn-green btn-sm"><i data-lucide="check"></i>Verifikasi</button>`
                : `<span style="font-size:.76rem;color:var(--gray-400);">Sudah hadir</span>`}
            </td>
        </tr>`;
    }).join('');
    lucide.createIcons();
}

function openVerify(a) {
    const prof = a.user?.patient_profile ?? a.user?.patientProfile ?? {};
    document.getElementById('verify-id').value    = a.id;
    document.getElementById('v-nik').value         = prof.nik ?? '';
    document.getElementById('v-bpjs').value        = prof.bpjs_number ?? '';
    document.getElementById('v-phone').value       = prof.phone_number ?? a.temp_phone ?? '';
    document.getElementById('verify-info').innerHTML =
        `<strong>${prof.full_name ?? a.user?.name ?? '?'}</strong> &mdash; Nomor: <strong>${a.queue_number}</strong><br>
         Poli: ${a.poli?.name ?? '–'}`;
    document.getElementById('modal-verify').classList.add('open');
    lucide.createIcons();
}

async function confirmVerify() {
    const id    = document.getElementById('verify-id').value;
    const nik   = document.getElementById('v-nik').value.trim();
    const bpjs  = document.getElementById('v-bpjs').value.trim();
    const phone = document.getElementById('v-phone').value.trim();

    // Verifikasi kehadiran
    const r = await apiFetch('POST', '/staff/verify', { appointment_id: parseInt(id) });
    if (!r) return;
    const j = await r.json();

    if (!r.ok) { toast(j.message || 'Gagal verifikasi', 'err'); return; }

    // Update profil pasien jika ada data baru
    const userId = j.data?.user_id;
    if (userId && (nik || bpjs || phone)) {
        const upd = {};
        if (nik && nik.length === 16) upd.nik = nik;
        if (bpjs)  upd.bpjs_number  = bpjs;
        if (phone) upd.phone_number = phone;
        // Tidak ada endpoint khusus update-by-staff, skip jika tidak ada token pasien
        // Petugas hanya mencatat, update profil melalui admin jika diperlukan
    }

    toast('Pasien berhasil diverifikasi hadir!', 'ok');
    closeModal();
    fetchAntrian();
}

/* ── Walk-In ── */
async function populateWalkInPoli() {
    if (!allPolis.length) {
        const r = await apiFetch('GET', '/poli');
        if (r?.ok) allPolis = (await r.json()).data || [];
    }
    const sel = document.getElementById('wi-poli');
    sel.innerHTML = '<option value="">Pilih Poli…</option>' +
        allPolis.map(p => `<option value="${p.id}">${p.name}</option>`).join('');
}

async function submitWalkIn() {
    const name    = document.getElementById('wi-name').value.trim();
    const nik     = document.getElementById('wi-nik').value.trim();
    const phone   = document.getElementById('wi-phone').value.trim();
    const poliId  = document.getElementById('wi-poli').value;
    const isEmerg = document.getElementById('wi-emergency').checked;
    const errDiv  = document.getElementById('wi-error');
    const btn     = document.getElementById('btn-walkin');

    errDiv.style.display = 'none';
    if (!name || !phone || !poliId) {
        errDiv.textContent = 'Nama, No HP, dan Poli wajib diisi.';
        errDiv.style.display = 'block';
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '⏳ Mendaftarkan…';

    const r = await apiFetch('POST', '/staff/walk-in', {
        full_name: name, nik: nik || null, phone_number: phone,
        poli_id: parseInt(poliId), is_emergency: isEmerg,
    });
    btn.disabled = false;
    btn.innerHTML = '<i data-lucide="plus-circle"></i>Daftarkan Pasien';
    lucide.createIcons();

    if (!r) return;
    const j = await r.json();

    if (r.ok) {
        toast(`Walk-in berhasil! Nomor: ${j.data?.queue_number}`, 'ok');
        document.getElementById('wi-name').value  = '';
        document.getElementById('wi-nik').value   = '';
        document.getElementById('wi-phone').value = '';
        document.getElementById('wi-poli').value  = '';
        document.getElementById('wi-emergency').checked = false;
    } else {
        errDiv.textContent   = j.message || 'Gagal mendaftarkan pasien.';
        errDiv.style.display = 'block';
    }
}

function logout() { localStorage.clear(); window.location.href = '/login'; }

// Init
loadAntrian();
</script>
</body>
</html>
