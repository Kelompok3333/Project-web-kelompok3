<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun – Medika Centra</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:       #10B981;
            --primary-dark:  #047857;
            --primary-light: #D1FAE5;
            --bg:            #F0FDF4;
            --text-main:     #111827;
            --text-muted:    #6B7280;
            --white:         #ffffff;
            --border:        #E5E7EB;
            --danger:        #EF4444;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-container {
            background: var(--white);
            border-radius: 28px;
            box-shadow: 0 20px 60px -10px rgba(16,185,129,.12);
            display: flex;
            width: 100%;
            max-width: 920px;
            overflow: hidden;
            min-height: 600px;
        }
        /* Mascot panel */
        .mascot-side {
            flex: 1;
            background: linear-gradient(145deg, var(--primary-light) 0%, #ffffff 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 32px;
        }
        .mascot-wrapper { position: relative; width: 190px; height: 190px; animation: float 4s ease-in-out infinite; }
        .m-body { width: 150px; height: 130px; background: linear-gradient(135deg,var(--primary),var(--primary-dark));
            border-radius: 45% 45% 40% 40%; position: absolute; bottom: 10px; left: 20px;
            box-shadow: inset -8px -8px 18px rgba(0,0,0,.1), 0 18px 36px rgba(16,185,129,.28); z-index: 10; }
        .m-ear { width: 42px; height: 42px; background: var(--primary-dark); border-radius: 50%; position: absolute; top: 0; z-index: 5; }
        .m-ear.left  { left: 12px; transform: rotate(-20deg); }
        .m-ear.right { right: 12px; transform: rotate(20deg); }
        .m-eye { width: 38px; height: 48px; background: white; border-radius: 50%; position: absolute;
            top: 33px; z-index: 20; display: flex; align-items: center; justify-content: center; }
        .m-eye.left  { left: 27px; }
        .m-eye.right { right: 27px; }
        .m-pupil { width: 16px; height: 20px; background: #1f2937; border-radius: 50%; position: relative; }
        .m-pupil::after { content:''; width:5px; height:5px; background:white; border-radius:50%;
            position:absolute; top:3px; right:3px; }
        .m-cheek { width: 18px; height: 11px; background: rgba(255,255,255,.38); border-radius: 50%;
            position: absolute; top: 75px; z-index: 20; }
        .m-cheek.left  { left: 18px; }
        .m-cheek.right { right: 18px; }
        .m-stethoscope { position: absolute; bottom: -8px; left: 50%; transform: translateX(-50%);
            width: 74px; height: 36px; border-bottom: 5px solid #F59E0B; border-radius: 0 0 37px 37px; z-index: 30; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-14px)} }
        .mascot-side h2 { font-size: 1.7rem; font-weight: 800; color: var(--primary-dark); text-align: center; margin-top: 18px; }
        .mascot-side p  { color: var(--text-muted); text-align: center; margin-top: 8px; font-size: .9rem; line-height: 1.5; max-width: 240px; }

        /* Form panel */
        .form-side { flex: 1.2; padding: 44px 48px; display: flex; flex-direction: column; justify-content: center; overflow-y: auto; }
        .form-header { margin-bottom: 22px; }
        .form-header h1 { font-size: 1.65rem; font-weight: 800; margin-bottom: 5px; }
        .form-header p  { color: var(--text-muted); font-size: .88rem; }

        .input-group { margin-bottom: 13px; }
        .input-group label { display: block; font-weight: 700; font-size: .8rem; margin-bottom: 5px; }
        .input-group input {
            width: 100%; padding: 11px 14px;
            border-radius: 10px; border: 1.5px solid var(--border);
            font-family: inherit; font-size: .9rem; outline: none; transition: .2s;
        }
        .input-group input:focus { border-color: var(--primary); background: var(--primary-light); }

        .btn-submit {
            width: 100%; padding: 13px; border-radius: 11px; border: none;
            background: var(--primary); color: white; font-weight: 700; font-size: .95rem;
            cursor: pointer; transition: .2s; margin-top: 6px;
        }
        .btn-submit:hover { background: var(--primary-dark); transform: translateY(-2px);
            box-shadow: 0 8px 18px -4px rgba(16,185,129,.38); }
        .btn-submit:disabled { opacity: .6; cursor: not-allowed; transform: none; }

        .divider { display: flex; align-items: center; color: var(--text-muted); font-size: .78rem; margin: 16px 0; }
        .divider::before, .divider::after { content:''; flex:1; border-bottom: 1px solid var(--border); }
        .divider span { padding: 0 10px; }

        .social-btn {
            width: 100%; padding: 10px; border-radius: 10px; border: 1.5px solid var(--border);
            background: white; display: flex; align-items: center; justify-content: center;
            gap: 9px; font-weight: 700; color: var(--text-main); cursor: pointer;
            transition: .2s; margin-bottom: 7px; font-size: .85rem; font-family: inherit;
        }
        .social-btn:hover { background: #F9FAFB; border-color: #D1D5DB; }

        .error-msg {
            background: #FEF2F2; color: var(--danger); padding: 10px 12px;
            border-radius: 8px; font-size: .82rem; margin-bottom: 14px;
            display: none; border: 1px solid #FECACA;
        }

        .footer-links { text-align: center; margin-top: 18px; font-size: .85rem; color: var(--text-muted); }
        .footer-links a { color: var(--primary-dark); font-weight: 700; text-decoration: none; }
        .footer-links a:hover { text-decoration: underline; }

        @media (max-width: 700px) {
            .auth-container { flex-direction: column; max-width: 440px; min-height: auto; }
            .mascot-side { padding: 26px 16px; min-height: 200px; }
            .mascot-wrapper { transform: scale(.75); }
            .form-side { padding: 28px 22px; }
        }
    </style>
</head>
<body>
<div class="auth-container">
    <!-- Mascot -->
    <div class="mascot-side">
        <div class="mascot-wrapper">
            <div class="m-ear left"></div>
            <div class="m-ear right"></div>
            <div class="m-body">
                <div class="m-eye left"><div class="m-pupil"></div></div>
                <div class="m-eye right"><div class="m-pupil"></div></div>
                <div class="m-cheek left"></div>
                <div class="m-cheek right"></div>
                <div class="m-stethoscope"></div>
            </div>
        </div>
        <h2>Bergabung!</h2>
        <p>Buat akun untuk booking antrian online dari mana saja, kapan saja.</p>
    </div>

    <!-- Form -->
    <div class="form-side">
        <div class="form-header">
            <h1>Buat Akun Baru</h1>
            <p>Isi data login Anda. Setelah daftar, Anda akan diminta melengkapi data diri.</p>
        </div>

        <div id="regError" class="error-msg"></div>

        <form id="registerForm">
            <div class="input-group">
                <label>Nama Lengkap</label>
                <input type="text" id="name" placeholder="Sesuai KTP" required>
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" id="email" placeholder="nama@email.com" required>
            </div>
            <div class="input-group">
                <label>Kata Sandi</label>
                <input type="password" id="password" placeholder="Minimal 8 karakter" required minlength="8">
            </div>
            <div class="input-group">
                <label>Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" placeholder="Ulangi kata sandi" required>
            </div>
            <button type="submit" id="btnReg" class="btn-submit">Daftar Sekarang →</button>
        </form>

        <div class="divider"><span>atau daftar dengan</span></div>

        <button class="social-btn" type="button" onclick="window.location.href='/auth/google/redirect'">
            <svg width="17" height="17" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            Lanjutkan dengan Google
        </button>

        <div class="footer-links">
            Sudah punya akun? <a href="{{ url('/login') }}">Masuk di sini</a><br><br>
            <a href="{{ url('/') }}" style="color:var(--text-muted);font-weight:500;">← Kembali ke Beranda</a>
        </div>
    </div>
</div>

<script>
async function consumeSocialLogin() {
    const params = new URLSearchParams(window.location.search);
    const socialError = params.get('social_error');

    if (socialError) {
        const errDiv = document.getElementById('regError');
        errDiv.textContent = socialError;
        errDiv.style.display = 'block';
        return;
    }

    if (params.get('social_login') !== '1') return;

    const response = await fetch('/auth/social/token', {
        headers: { 'Accept': 'application/json' },
    });
    const data = await response.json();

    if (!response.ok) throw new Error(data.message || 'Login sosial gagal.');

    localStorage.setItem('auth_token', data.token);
    localStorage.setItem('user_role', data.role ?? 'patient');
    localStorage.setItem('user_id', data.user_id ?? '');
    window.location.href = data.redirect || '/complete-profile';
}

consumeSocialLogin().catch(() => {
    const errDiv = document.getElementById('regError');
    errDiv.textContent = 'Login sosial gagal. Silakan coba lagi.';
    errDiv.style.display = 'block';
});

document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn      = document.getElementById('btnReg');
    const errDiv   = document.getElementById('regError');
    const pass     = document.getElementById('password').value;
    const passConf = document.getElementById('password_confirmation').value;

    errDiv.style.display = 'none';

    if (pass !== passConf) {
        errDiv.textContent   = 'Konfirmasi password tidak cocok.';
        errDiv.style.display = 'block';
        return;
    }

    btn.textContent = 'Mendaftarkan...';
    btn.disabled    = true;

    try {
        const res  = await fetch('/api/register', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({
                name:                  document.getElementById('name').value,
                email:                 document.getElementById('email').value,
                password:              pass,
                password_confirmation: passConf,
            }),
        });

        const data = await res.json();

        if (res.ok) {
            // Simpan token & info ke localStorage
            localStorage.setItem('auth_token', data.token);
            localStorage.setItem('user_role',  data.role ?? 'patient');
            localStorage.setItem('user_id',    data.user_id ?? '');

            // Selalu arahkan ke /complete-profile setelah register baru
            window.location.href = '/complete-profile';
        } else {
            const msgs = data.errors
                ? Object.values(data.errors).flat().join(' · ')
                : (data.message || 'Terjadi kesalahan.');
            errDiv.textContent   = msgs;
            errDiv.style.display = 'block';
        }
    } catch (err) {
        errDiv.textContent   = 'Tidak dapat terhubung ke server.';
        errDiv.style.display = 'block';
    } finally {
        btn.textContent = 'Daftar Sekarang →';
        btn.disabled    = false;
    }
});
</script>
</body>
</html>
