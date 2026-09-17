<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Data Diri – Medika Centra</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --teal:       #0d7a6b;
            --teal-dark:  #095c50;
            --teal-light: #e6f4f1;
            --bg:         #f4f8f7;
            --white:      #ffffff;
            --gray-100:   #f3f4f6;
            --gray-200:   #e5e7eb;
            --gray-400:   #9ca3af;
            --gray-500:   #6b7280;
            --gray-700:   #374151;
            --gray-900:   #111827;
            --red:        #dc2626;
            --red-light:  #fee2e2;
            --amber:      #b45309;
            --radius:     10px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--gray-900); min-height: 100vh; }
        h1,h2,h3 { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── Header strip ───────── */
        .page-header {
            background: var(--teal-dark);
            color: white;
            padding: 16px 0;
            text-align: center;
        }
        .page-header .brand { font-size: 1.05rem; font-weight: 800; letter-spacing: -.01em; }
        .page-header .sub   { font-size: .78rem; opacity: .75; margin-top: 2px; }

        /* ── KIS Card preview ───── */
        .kis-preview {
            max-width: 560px;
            margin: 28px auto 0;
            background: linear-gradient(135deg, var(--teal-dark) 0%, #1a9985 50%, #0d7a6b 100%);
            border-radius: 18px;
            padding: 22px 26px;
            color: white;
            box-shadow: 0 8px 32px rgba(9,92,80,.35);
            position: relative;
            overflow: hidden;
        }
        .kis-preview::before {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='28'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
        }
        .kis-top { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; position: relative; }
        .kis-logo { width: 44px; height: 44px; background: rgba(255,255,255,.15); border-radius: 10px;
            display: flex; align-items: center; justify-content: center; }
        .kis-logo svg { width: 22px; height: 22px; stroke: white; }
        .kis-title { font-family: 'Plus Jakarta Sans', sans-serif; }
        .kis-title .t1 { font-size: .65rem; font-weight: 600; opacity: .75; text-transform: uppercase; letter-spacing: .08em; }
        .kis-title .t2 { font-size: 1rem; font-weight: 800; }
        .kis-fields { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; position: relative; }
        .kis-field .lbl { font-size: .64rem; opacity: .7; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 2px; }
        .kis-field .val { font-size: .9rem; font-weight: 700; min-height: 18px; }
        .kis-field .val.empty { font-style: italic; opacity: .4; font-weight: 400; font-size: .78rem; }
        .kis-chip { position: absolute; top: 16px; right: 16px; width: 48px; height: 36px;
            background: linear-gradient(135deg,#fbbf24,#f59e0b); border-radius: 6px; opacity: .85; }
        .kis-chip-lines { position: absolute; inset: 0; display: flex; flex-direction: column;
            justify-content: space-around; padding: 6px 8px; }
        .kis-chip-lines div { height: 2px; background: rgba(0,0,0,.25); border-radius: 1px; }

        /* ── Form card ──────────── */
        .form-card {
            max-width: 600px;
            margin: 28px auto 48px;
            background: var(--white);
            border-radius: 18px;
            border: 1px solid var(--gray-200);
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
            overflow: hidden;
        }
        .form-card-header {
            background: var(--teal);
            color: white;
            padding: 16px 24px;
        }
        .form-card-header h2 { font-size: 1rem; font-weight: 800; }
        .form-card-header p  { font-size: .78rem; opacity: .8; margin-top: 2px; }
        .form-body { padding: 24px; }

        .section-label {
            font-size: .68rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: .08em;
            color: var(--teal-dark);
            margin: 20px 0 12px;
            display: flex; align-items: center; gap: 8px;
        }
        .section-label::after { content:''; flex:1; height:1px; background:var(--teal-light); }
        .section-label:first-child { margin-top: 0; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-grid .full { grid-column: 1 / -1; }

        .field { display: flex; flex-direction: column; gap: 5px; }
        .field label { font-size: .78rem; font-weight: 700; color: var(--gray-700); }
        .field label .req { color: var(--red); margin-left: 2px; }
        .field label .opt { color: var(--gray-400); font-weight: 500; font-size: .72rem; margin-left: 4px; }

        .field input,
        .field select,
        .field textarea {
            padding: 9px 12px;
            border: 1.5px solid var(--gray-200);
            border-radius: var(--radius);
            font-family: inherit;
            font-size: .875rem;
            color: var(--gray-900);
            outline: none;
            transition: border-color .15s, background .15s;
            background: var(--white);
        }
        .field input:focus,
        .field select:focus,
        .field textarea:focus { border-color: var(--teal); background: #f2faf8; }
        .field input.err { border-color: var(--red); background: var(--red-light); }
        .field .hint { font-size: .72rem; color: var(--gray-400); }
        .field .err-msg { font-size: .72rem; color: var(--red); display: none; }
        .field .err-msg.show { display: block; }

        .btn-submit {
            width: 100%;
            padding: 13px;
            border-radius: var(--radius);
            border: none;
            background: var(--teal);
            color: white;
            font-family: inherit;
            font-size: .95rem;
            font-weight: 700;
            cursor: pointer;
            transition: .15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
        }
        .btn-submit:hover    { background: var(--teal-dark); }
        .btn-submit:disabled { opacity: .6; cursor: not-allowed; }
        .btn-submit svg      { width: 17px; height: 17px; }

        .global-error {
            background: var(--red-light);
            border: 1px solid #fca5a5;
            color: var(--red);
            padding: 11px 14px;
            border-radius: var(--radius);
            font-size: .82rem;
            margin-bottom: 16px;
            display: none;
        }

        .privacy-note {
            display: flex; align-items: flex-start; gap: 10px;
            background: #fffbeb; border: 1px solid #fde68a;
            border-radius: var(--radius); padding: 11px 14px;
            font-size: .78rem; color: var(--amber);
            margin-top: 16px;
        }
        .privacy-note svg { width: 15px; height: 15px; flex-shrink: 0; margin-top: 1px; }

        @media (max-width: 640px) {
            .form-grid { grid-template-columns: 1fr; }
            .form-card  { margin: 16px; border-radius: 14px; }
            .kis-preview { margin: 16px; }
        }
    </style>
</head>
<body>

<div class="page-header">
    <div class="brand">🏥 Medika Centra</div>
    <div class="sub">Portal Pasien</div>
</div>

<!-- KIS Card Preview (diisi otomatis saat user mengetik) -->
<div class="kis-preview">
    <div class="kis-chip">
        <div class="kis-chip-lines">
            <div></div><div></div><div></div><div></div>
        </div>
    </div>
    <div class="kis-top">
        <div class="kis-logo"><i data-lucide="heart-pulse"></i></div>
        <div class="kis-title">
            <div class="t1">Kartu Identitas Pasien</div>
            <div class="t2">Medika Centra</div>
        </div>
    </div>
    <div class="kis-fields">
        <div class="kis-field" style="grid-column:1/-1;">
            <div class="lbl">Nama Lengkap</div>
            <div class="val empty" id="prev-name">Nama belum diisi</div>
        </div>
        <div class="kis-field">
            <div class="lbl">NIK</div>
            <div class="val empty" id="prev-nik">– – – –</div>
        </div>
        <div class="kis-field">
            <div class="lbl">No. KIS/BPJS</div>
            <div class="val empty" id="prev-bpjs">Opsional</div>
        </div>
        <div class="kis-field">
            <div class="lbl">Tgl. Lahir</div>
            <div class="val empty" id="prev-dob">–</div>
        </div>
        <div class="kis-field">
            <div class="lbl">Gol. Darah</div>
            <div class="val empty" id="prev-blood">–</div>
        </div>
    </div>
</div>

<!-- Form -->
<div class="form-card">
    <div class="form-card-header">
        <h2>Lengkapi Data Diri Pasien</h2>
        <p>Data ini bersifat rahasia dan hanya digunakan untuk keperluan layanan klinik.</p>
    </div>
    <div class="form-body">
        <div id="globalError" class="global-error"></div>
        <form id="profileForm">

            <div class="section-label">Data Identitas</div>
            <div class="form-grid">
                <div class="field full">
                    <label>Nomor Induk Kependudukan (NIK)<span class="opt">(opsional, isi jika sudah punya KTP)</span></label>
                    <input type="text" id="nik" maxlength="16" placeholder="Kosongkan jika belum punya KTP" inputmode="numeric"
                        oninput="syncPreview()">
                    <span class="hint">Jika diisi, harus tepat 16 digit dan belum terdaftar.</span>
                    <span class="err-msg" id="err-nik"></span>
                </div>
                <div class="field full">
                    <label>Nomor Kartu KIS / BPJS Kesehatan<span class="opt">(opsional)</span></label>
                    <input type="text" id="bpjs_number" maxlength="20" placeholder="Kosongkan jika tidak punya"
                        oninput="syncPreview()">
                    <span class="err-msg" id="err-bpjs_number"></span>
                </div>
                <div class="field full">
                    <label>Nama Lengkap<span class="req">*</span></label>
                    <input type="text" id="full_name" placeholder="Nama lengkap"
                        oninput="syncPreview()">
                    <span class="err-msg" id="err-full_name"></span>
                </div>
                <div class="field">
                    <label>Tempat Lahir<span class="req">*</span></label>
                    <input type="text" id="birthplace" placeholder="Kota / Kabupaten">
                    <span class="err-msg" id="err-birthplace"></span>
                </div>
                <div class="field">
                    <label>Tanggal Lahir<span class="req">*</span></label>
                    <input type="date" id="date_of_birth" oninput="syncPreview()">
                    <span class="err-msg" id="err-date_of_birth"></span>
                </div>
                <div class="field">
                    <label>Jenis Kelamin<span class="req">*</span></label>
                    <select id="gender">
                        <option value="">– Pilih –</option>
                        <option value="male">Laki-laki</option>
                        <option value="female">Perempuan</option>
                    </select>
                    <span class="err-msg" id="err-gender"></span>
                </div>
                <div class="field">
                    <label>Golongan Darah<span class="opt">(opsional)</span></label>
                    <select id="blood_type" onchange="syncPreview()">
                        <option value="">– Tidak Tahu –</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                </div>
            </div>

            <div class="section-label">Kontak & Alamat</div>
            <div class="form-grid">
                <div class="field full">
                    <label>Alamat Domisili Lengkap<span class="req">*</span></label>
                    <textarea id="address" rows="2" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota, Provinsi"></textarea>
                    <span class="err-msg" id="err-address"></span>
                </div>
                <div class="field full">
                    <label>Nomor HP Aktif<span class="req">*</span></label>
                    <input type="tel" id="phone_number" placeholder="08xxxxxxxxxx" inputmode="numeric">
                    <span class="hint">Akan digunakan untuk notifikasi antrian.</span>
                    <span class="err-msg" id="err-phone_number"></span>
                </div>
            </div>

            <div class="privacy-note">
                <i data-lucide="shield-check"></i>
                <span>Data NIK dan informasi identitas Anda diproses secara aman dan hanya digunakan untuk kebutuhan layanan klinik. Tidak dibagikan ke pihak ketiga.</span>
            </div>

            <button type="submit" id="btnSave" class="btn-submit">
                <i data-lucide="save"></i> Simpan & Lanjutkan
            </button>
        </form>
    </div>
</div>

<script>
lucide.createIcons();

const token = localStorage.getItem('auth_token');
if (!token) window.location.href = '/login';

/* ── Preview KIS card ── */
function syncPreview() {
    const name  = document.getElementById('full_name').value.trim();
    const nik   = document.getElementById('nik').value.trim();
    const bpjs  = document.getElementById('bpjs_number').value.trim();
    const dob   = document.getElementById('date_of_birth').value;
    const blood = document.getElementById('blood_type').value;

    set('prev-name',  name  || null, 'Nama belum diisi');
    set('prev-nik',   nik   || null, '– – – –');
    set('prev-bpjs',  bpjs  || null, 'Opsional');
    set('prev-dob',   dob   ? formatDate(dob) : null, '–');
    set('prev-blood', blood || null, '–');

    function set(id, val, empty) {
        const el = document.getElementById(id);
        if (val) {
            el.textContent  = val;
            el.className    = 'val';
        } else {
            el.textContent  = empty;
            el.className    = 'val empty';
        }
    }
}

function formatDate(str) {
    if (!str) return '–';
    return new Date(str + 'T00:00:00').toLocaleDateString('id-ID',
        { day:'numeric', month:'long', year:'numeric' });
}

/* ── Inline error helpers ── */
function clearErrors() {
    document.querySelectorAll('.err-msg').forEach(el => { el.textContent=''; el.classList.remove('show'); });
    document.querySelectorAll('.err').forEach(el => el.classList.remove('err'));
}

function showFieldError(field, msg) {
    const inp = document.getElementById(field);
    const err = document.getElementById('err-' + field);
    if (inp) inp.classList.add('err');
    if (err) { err.textContent = msg; err.classList.add('show'); }
}

/* ── Submit ── */
document.getElementById('profileForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    clearErrors();

    const btn     = document.getElementById('btnSave');
    const errDiv  = document.getElementById('globalError');
    errDiv.style.display = 'none';

    const payload = {
        nik:           document.getElementById('nik').value.trim(),
        bpjs_number:   document.getElementById('bpjs_number').value.trim() || null,
        full_name:     document.getElementById('full_name').value.trim(),
        birthplace:    document.getElementById('birthplace').value.trim(),
        date_of_birth: document.getElementById('date_of_birth').value,
        gender:        document.getElementById('gender').value,
        blood_type:    document.getElementById('blood_type').value || null,
        address:       document.getElementById('address').value.trim(),
        phone_number:  document.getElementById('phone_number').value.trim(),
    };

    /* Client-side basic validation */
    let hasErr = false;
    // NIK opsional — kalau diisi harus 16 digit
    if (payload.nik && payload.nik.length !== 16) {
        showFieldError('nik', 'NIK harus tepat 16 digit.');
        hasErr = true;
    }
    if (!payload.full_name)                { showFieldError('full_name', 'Nama wajib diisi.'); hasErr = true; }
    if (!payload.birthplace)               { showFieldError('birthplace', 'Tempat lahir wajib diisi.'); hasErr = true; }
    if (!payload.date_of_birth)            { showFieldError('date_of_birth', 'Tanggal lahir wajib diisi.'); hasErr = true; }
    if (!payload.gender)                   { showFieldError('gender', 'Pilih jenis kelamin.'); hasErr = true; }
    if (!payload.address || payload.address.length < 10) { showFieldError('address', 'Alamat minimal 10 karakter.'); hasErr = true; }
    if (!payload.phone_number || payload.phone_number.length < 10) { showFieldError('phone_number', 'Nomor HP minimal 10 digit.'); hasErr = true; }
    if (hasErr) return;

    btn.disabled = true;
    btn.innerHTML = '<i data-lucide="loader-2" style="animation:spin .8s linear infinite;"></i> Menyimpan...';
    lucide.createIcons();

    try {
        const res  = await fetch('/api/profile', {
            method:  'POST',
            headers: {
                'Content-Type':  'application/json',
                'Accept':        'application/json',
                'Authorization': 'Bearer ' + token,
            },
            body: JSON.stringify(payload),
        });

        const data = await res.json();

        if (res.ok) {
            window.location.href = '/patient-dashboard';
        } else if (res.status === 422 && data.errors) {
            Object.entries(data.errors).forEach(([field, msgs]) => {
                showFieldError(field, msgs[0]);
            });
        } else {
            errDiv.textContent   = data.message || 'Terjadi kesalahan. Coba lagi.';
            errDiv.style.display = 'block';
        }
    } catch {
        errDiv.textContent   = 'Tidak dapat terhubung ke server.';
        errDiv.style.display = 'block';
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i data-lucide="save"></i> Simpan & Lanjutkan';
        lucide.createIcons();
    }
});
</script>
<style>@keyframes spin { to { transform: rotate(360deg); } }</style>
</body>
</html>
