<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Medika Centra</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #10B981;
            --primary-dark: #047857;
            --primary-light: #D1FAE5;
            --bg: #F0FDF4;
            --text-main: #111827;
            --text-muted: #6B7280;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

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
            border-radius: 32px;
            box-shadow: 0 20px 60px -10px rgba(16, 185, 129, 0.15);
            display: flex;
            width: 100%;
            max-width: 950px;
            overflow: hidden;
            min-height: 600px;
        }

        /* MASCOT SIDE (Shared Style) */
        .mascot-side {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-light) 0%, #ffffff 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .mascot-wrapper {
            position: relative;
            width: 200px;
            height: 200px;
            animation: float 4s ease-in-out infinite;
        }

        .m-body {
            width: 160px;
            height: 140px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 45% 45% 40% 40%;
            position: absolute;
            bottom: 10px;
            left: 20px;
            box-shadow: inset -10px -10px 20px rgba(0, 0, 0, 0.1), 0 20px 40px rgba(16, 185, 129, 0.3);
            z-index: 10;
        }

        .m-ear {
            width: 45px;
            height: 45px;
            background: var(--primary-dark);
            border-radius: 50%;
            position: absolute;
            top: 0;
            z-index: 5;
        }

        .m-ear.left {
            left: 15px;
            transform: rotate(-20deg);
        }

        .m-ear.right {
            right: 15px;
            transform: rotate(20deg);
        }

        .m-eye {
            width: 40px;
            height: 50px;
            background: white;
            border-radius: 50%;
            position: absolute;
            top: 35px;
            z-index: 20;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .m-eye.left {
            left: 30px;
        }

        .m-eye.right {
            right: 30px;
        }

        .m-pupil {
            width: 18px;
            height: 22px;
            background: #1f2937;
            border-radius: 50%;
            position: relative;
        }

        .m-pupil::after {
            content: '';
            width: 6px;
            height: 6px;
            background: white;
            border-radius: 50%;
            position: absolute;
            top: 4px;
            right: 4px;
        }

        .m-cheek {
            width: 20px;
            height: 12px;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            position: absolute;
            top: 80px;
            z-index: 20;
        }

        .m-cheek.left {
            left: 20px;
        }

        .m-cheek.right {
            right: 20px;
        }

        .m-stethoscope {
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 40px;
            border-bottom: 6px solid #F59E0B;
            border-radius: 0 0 40px 40px;
            z-index: 30;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .mascot-side h2 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary-dark);
            text-align: center;
            margin-top: 20px;
            z-index: 10;
        }

        .mascot-side p {
            color: var(--text-muted);
            text-align: center;
            margin-top: 10px;
            font-size: 0.95rem;
            line-height: 1.5;
            z-index: 10;
            max-width: 280px;
        }

        /* FORM SIDE */
        .form-side {
            flex: 1.2;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 24px;
        }

        .form-header h1 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .form-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .input-group {
            margin-bottom: 16px;
        }

        .input-group label {
            display: block;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 6px;
            color: var(--text-main);
        }

        .input-group input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 2px solid #E5E7EB;
            font-family: inherit;
            font-size: 0.95rem;
            transition: all 0.2s;
            outline: none;
        }

        .input-group input:focus {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            border-radius: 12px;
            border: none;
            background: var(--primary);
            color: white;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 8px;
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.8rem;
            margin: 24px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #E5E7EB;
        }

        .divider span {
            padding: 0 12px;
        }

        .social-btn {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            border: 2px solid #E5E7EB;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 600;
            color: var(--text-main);
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .social-btn:hover {
            background: #F9FAFB;
            border-color: #D1D5DB;
        }

        .footer-links {
            text-align: center;
            margin-top: 24px;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .footer-links a {
            color: var(--primary-dark);
            font-weight: 700;
            text-decoration: none;
            margin-left: 4px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .error-msg {
            background: #FEF2F2;
            color: #EF4444;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 16px;
            display: none;
            text-align: center;
            border: 1px solid #FECACA;
        }

        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
                max-width: 450px;
                min-height: auto;
            }

            .mascot-side {
                padding: 30px 20px;
                min-height: 220px;
            }

            .mascot-wrapper {
                transform: scale(0.7);
            }

            .form-side {
                padding: 30px 24px;
            }
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <!-- MASCOT AREA -->
        <div class="mascot-side">
            <div class="mascot-wrapper">
                <div class="m-ear left"></div>
                <div class="m-ear right"></div>
                <div class="m-body">
                    <div class="m-eye left">
                        <div class="m-pupil"></div>
                    </div>
                    <div class="m-eye right">
                        <div class="m-pupil"></div>
                    </div>
                    <div class="m-cheek left"></div>
                    <div class="m-cheek right"></div>
                    <div class="m-stethoscope"></div>
                </div>
            </div>
            <h2>Selamat Datang!</h2>
            <p>Kesehatan Anda adalah prioritas kami.<br>Silakan masuk untuk melanjutkan.</p>
        </div>

        <!-- LOGIN FORM AREA -->
        <div class="form-side">
            <div class="form-header">
                <h1>Masuk ke Akun</h1>
                <p>Masukkan email dan kata sandi Anda.</p>
            </div>

            <div id="loginError" class="error-msg"></div>

            <form id="loginForm">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="nama@email.com" required>
                </div>
                <div class="input-group">
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" placeholder="••••••••" required>
                </div>
                <button type="submit" id="btnLogin" class="btn-submit">Masuk Sekarang</button>
            </form>

            <div class="divider"><span>atau masuk dengan</span></div>

            <button id="btn-google" class="social-btn" onclick="loginGoogle()">
                <svg width="18" height="18" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                </svg>
                Lanjutkan dengan Google
            </button>
            <button id="btn-facebook" class="social-btn" onclick="loginFacebook()">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="#1877F2">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                </svg>
                Lanjutkan dengan Facebook
            </button>

            <div class="footer-links">
                Belum punya akun? <a href="{{ url('/register') }}">Daftar di sini</a>
                <br><br>
                <a href="{{ url('/') }}" style="color: var(--text-muted); font-weight: 500;">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>

    <script>
        function loginGoogle() {
            window.location.href = '/auth/google/redirect';
        }

        function loginFacebook() {
            window.location.href = '/auth/facebook/redirect';
        }

        async function consumeSocialLogin() {
            const params = new URLSearchParams(window.location.search);
            const socialError = params.get('social_error');
            const errorDiv = document.getElementById('loginError');

            if (socialError) {
                errorDiv.innerText = socialError;
                errorDiv.style.display = 'block';
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
            window.location.href = data.redirect || '/patient-dashboard';
        }

        consumeSocialLogin().catch(() => {
            const errorDiv = document.getElementById('loginError');
            errorDiv.innerText = 'Login sosial gagal. Silakan coba lagi.';
            errorDiv.style.display = 'block';
        });

        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = document.getElementById('btnLogin');
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorDiv = document.getElementById('loginError');

            errorDiv.style.display = 'none';
            btn.innerText = 'Memproses...';
            btn.disabled = true;

            try {
                const response = await fetch('/api/login/test', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email,
                        password
                    })
                });
                const data = await response.json();

                if (response.ok) {
                    localStorage.setItem('auth_token', data.token);
                    localStorage.setItem('user_role',  data.role);
                    localStorage.setItem('user_id',    data.user_id ?? '');

                    let redirectUrl = '/patient-dashboard';
                    if (data.role === 'admin')   redirectUrl = '/admin-dashboard';
                    else if (data.role === 'doctor') redirectUrl = '/doctor-dashboard';
                    else if (data.role === 'staff')  redirectUrl = '/staff-dashboard';
                    else if (data.role === 'patient') {
                        // Cek apakah profil sudah lengkap
                        try {
                            const chk = await fetch('/api/profile', {
                                headers: { 'Authorization': 'Bearer ' + data.token, 'Accept': 'application/json' }
                            });
                            const chkData = await chk.json();
                            if (chkData.data?.needs_profile) redirectUrl = '/complete-profile';
                        } catch (_) { /* tetap ke patient-dashboard jika cek gagal */ }
                    }
                    window.location.href = redirectUrl;
                } else {
                    errorDiv.innerText = data.message || 'Email atau kata sandi salah.';
                    errorDiv.style.display = 'block';
                }
            } catch (err) {
                errorDiv.innerText = 'Gagal terhubung ke server.';
                errorDiv.style.display = 'block';
            } finally {
                btn.innerText = 'Masuk Sekarang';
                btn.disabled = false;
            }
        });
    </script>
</body>

</html>