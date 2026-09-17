<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medika Centra</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --primary: #10B981;
            --primary-dark: #047857;
            --primary-light: #D1FAE5;
            --bg: #F0FDF4;
            --text-main: #111827;
            --text-muted: #6B7280;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text-main);
            scroll-behavior: smooth;
        }

        /* NAVBAR PREMIUM */
        .navbar-premium {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
        }

        .nav-link {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-muted);
            padding: 0.5rem 1rem;
            border-radius: 999px;
            transition: all 0.2s;
        }

        /* Class active akan dipindahkan oleh JS */
        .nav-link.active {
            color: var(--primary-dark);
            background: var(--primary-light);
        }

        /* MASKOT COLLABOO STYLE */
        .mascot-container {
            position: relative;
            width: 240px;
            height: 240px;
            animation: float 4s ease-in-out infinite;
        }

        .mascot-body {
            width: 180px;
            height: 160px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 45% 45% 40% 40%;
            position: absolute;
            bottom: 20px;
            left: 30px;
            box-shadow: inset -10px -10px 20px rgba(0, 0, 0, 0.1), 0 20px 40px rgba(16, 185, 129, 0.3);
            z-index: 10;
        }

        .mascot-ear {
            width: 50px;
            height: 50px;
            background: var(--primary-dark);
            border-radius: 50%;
            position: absolute;
            top: 10px;
            z-index: 5;
        }

        .ear-l {
            left: 20px;
            transform: rotate(-20deg);
        }

        .ear-r {
            right: 20px;
            transform: rotate(20deg);
        }

        .mascot-eye {
            width: 45px;
            height: 55px;
            background: white;
            border-radius: 50%;
            position: absolute;
            top: 40px;
            z-index: 20;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .eye-l {
            left: 35px;
        }

        .eye-r {
            right: 35px;
        }

        .pupil {
            width: 20px;
            height: 25px;
            background: #1f2937;
            border-radius: 50%;
            position: relative;
        }

        .pupil::after {
            content: '';
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            position: absolute;
            top: 4px;
            right: 4px;
        }

        .mascot-cheek {
            width: 25px;
            height: 15px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            position: absolute;
            top: 90px;
            z-index: 20;
        }

        .cheek-l {
            left: 25px;
        }

        .cheek-r {
            right: 25px;
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

        .card-modern {
            background: white;
            border-radius: 24px;
            border: 1px solid #E5E7EB;
            transition: all 0.3s;
        }

        .card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -10px rgba(16, 185, 129, 0.15);
            border-color: var(--primary-light);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
        }
    </style>
</head>

<body class="min-h-screen">

    <!-- NAVBAR -->
    <nav class="navbar-premium fixed w-full top-0 z-50 h-20 flex items-center">
        <div class="max-w-7xl mx-auto px-6 w-full flex justify-between items-center">
            <div class="flex items-center gap-3 cursor-pointer" onclick="window.scrollTo(0,0)">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[var(--primary)] to-[var(--primary-dark)] flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                    <i data-lucide="heart-pulse" class="w-6 h-6"></i>
                </div>
                <span class="font-extrabold text-xl tracking-tight text-[var(--primary-dark)]">Klinik<span class="text-[var(--primary)]">Medika Centra</span></span>
            </div>

            <!-- Menu Links dengan ID untuk Scroll Spy -->
            <div class="hidden md:flex items-center gap-2 bg-white/50 p-1.5 rounded-full border border-emerald-100">
                <a href="#beranda" id="nav-beranda" class="nav-link active">Beranda</a>
                <a href="#poli" id="nav-poli" class="nav-link">Poli & Dokter</a>
                <a href="#artikel" id="nav-artikel" class="nav-link">Artikel</a>
                <a href="#syarat" id="nav-syarat" class="nav-link">Syarat</a>
                <a href="#faq" id="nav-faq" class="nav-link">FAQ</a>
            </div>

            <button onclick="handleLogin()" class="hidden md:flex items-center gap-2 bg-[var(--text-main)] text-white px-6 py-3 rounded-full font-bold hover:bg-gray-800 transition-all shadow-xl hover:shadow-2xl hover:-translate-y-1">
                <i data-lucide="calendar-check" class="w-4 h-4"></i> Daftar Antrian
            </button>
            <button class="md:hidden p-2 text-[var(--text-main)]"><i data-lucide="menu" class="w-8 h-8"></i></button>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section id="beranda" class="pt-32 pb-20 px-6 overflow-hidden relative min-h-screen flex items-center">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 items-center w-full">
            <div class="relative z-10">
                <div class="inline-block px-4 py-1.5 rounded-full bg-[var(--primary-light)] text-[var(--primary-dark)] font-bold text-sm mb-6 border border-emerald-200">
                    ✨ Buka Setiap Hari 07.00 - 20.00
                </div>
                <h1 class="text-5xl lg:text-7xl font-extrabold leading-tight text-[var(--text-main)] mb-6">
                    Sehat Itu <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[var(--primary)] to-[var(--primary-dark)]">Gak Ribet.</span>
                </h1>
                <p class="text-lg text-[var(--text-muted)] mb-8 max-w-md leading-relaxed font-medium">
                    Medika Centra melayani 6 poli dengan dokter spesialis berpengalaman. Booking online, pantau antrian real-time, dan berobat tanpa antre lama.
                </p>
                <div class="flex flex-wrap gap-4 mb-8">
                    <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-full border border-gray-100 shadow-sm">
                        <i data-lucide="map-pin" class="w-4 h-4 text-[var(--primary)]"></i>
                        <span class="text-sm font-bold">Jl. Cendana Raya No. 45</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-full border border-gray-100 shadow-sm">
                        <i data-lucide="phone" class="w-4 h-4 text-[var(--primary)]"></i>
                        <span class="text-sm font-bold">(024) 123-4567</span>
                    </div>
                </div>
                <div class="flex gap-4">
                    <button onclick="handleLogin()" class="bg-[var(--primary)] text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg shadow-emerald-500/40 hover:bg-[var(--primary-dark)] transition-all">Booking Sekarang</button>
                    <a href="#poli" class="bg-white text-[var(--text-main)] border-2 border-gray-100 px-8 py-4 rounded-full font-bold text-lg hover:border-[var(--primary)] transition-all flex items-center gap-2">Lihat Jadwal <i data-lucide="arrow-right" class="w-5 h-5"></i></a>
                </div>
            </div>
            <!-- MASKOT AREA -->
            <div class="relative flex justify-center lg:justify-end">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-gradient-to-tr from-[var(--primary-light)] to-white rounded-full blur-3xl -z-10"></div>
                <div class="mascot-container">
                    <div class="mascot-ear ear-l"></div>
                    <div class="mascot-ear ear-r"></div>
                    <div class="mascot-body">
                        <div class="mascot-eye eye-l">
                            <div class="pupil"></div>
                        </div>
                        <div class="mascot-eye eye-r">
                            <div class="pupil"></div>
                        </div>
                        <div class="mascot-cheek cheek-l"></div>
                        <div class="mascot-cheek cheek-r"></div>
                        <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-32 h-16 border-b-8 border-[#F59E0B] rounded-b-full z-30"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- POLI SECTION -->
    <section id="poli" class="py-20 px-6 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="section-title mb-4">Poli & Jadwal Dokter</h2>
                <p class="text-[var(--text-muted)] text-lg">Pilih layanan kesehatan yang Anda butuhkan</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="poliGrid">
                <div class="col-span-full text-center py-12 text-gray-400 animate-pulse">Memuat data poli...</div>
            </div>
        </div>
    </section>

    <!-- ARTIKEL SECTION -->
    <section id="artikel" class="py-20 px-6 bg-[var(--bg)]">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="section-title mb-4">Info Kesehatan</h2>
                    <p class="text-[var(--text-muted)] text-lg">Update berkala dari tim medis kami</p>
                </div>
                <button class="hidden md:flex items-center gap-2 text-[var(--primary-dark)] font-bold hover:underline">Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i></button>
            </div>
            <div class="grid md:grid-cols-3 gap-6" id="articleGrid">
                <div class="col-span-full text-center py-12 text-gray-400 animate-pulse">Memuat artikel...</div>
            </div>
        </div>
    </section>

    <!-- SYARAT BEROBAT -->
    <section id="syarat" class="py-20 px-6 bg-white">
        <div class="max-w-5xl mx-auto">
            <h2 class="section-title mb-12 text-center">Syarat & Dokumen Berobat</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="card-modern p-8">
                    <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-4"><i data-lucide="user-plus" class="w-6 h-6"></i></div>
                    <h3 class="text-xl font-bold mb-4">Pasien Baru (Umum)</h3>
                    <ul class="space-y-3 text-[var(--text-muted)]">
                        <li class="flex gap-3"><i data-lucide="check-circle-2" class="w-5 h-5 text-[var(--primary)] shrink-0"></i> KTP Asli & Fotokopi</li>
                        <li class="flex gap-3"><i data-lucide="check-circle-2" class="w-5 h-5 text-[var(--primary)] shrink-0"></i> Kartu Keluarga (KK)</li>
                        <li class="flex gap-3"><i data-lucide="check-circle-2" class="w-5 h-5 text-[var(--primary)] shrink-0"></i> Nomor HP Aktif</li>
                    </ul>
                </div>
                <div class="card-modern p-8">
                    <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center mb-4"><i data-lucide="shield-check" class="w-6 h-6"></i></div>
                    <h3 class="text-xl font-bold mb-4">Pasien BPJS</h3>
                    <ul class="space-y-3 text-[var(--text-muted)]">
                        <li class="flex gap-3"><i data-lucide="check-circle-2" class="w-5 h-5 text-[var(--primary)] shrink-0"></i> Kartu BPJS Aktif</li>
                        <li class="flex gap-3"><i data-lucide="check-circle-2" class="w-5 h-5 text-[var(--primary)] shrink-0"></i> Surat Rujukan FKTP</li>
                        <li class="flex gap-3"><i data-lucide="check-circle-2" class="w-5 h-5 text-[var(--primary)] shrink-0"></i> KTP & KK Asli</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-20 px-6 bg-[var(--bg)]">
        <div class="max-w-3xl mx-auto">
            <h2 class="section-title mb-12 text-center">Pertanyaan Umum</h2>
            <div class="space-y-4" id="faqContainer">
                <div class="card-modern overflow-hidden faq-item">
                    <button class="w-full flex items-center justify-between p-6 text-left faq-btn font-bold text-lg">Apakah harus booking online?<i data-lucide="chevron-down" class="w-6 h-6 text-gray-400 transition-transform faq-icon"></i></button>
                    <div class="faq-answer hidden px-6 pb-6 text-[var(--text-muted)]">Tidak wajib. Booking online membantu Anda mendapat estimasi waktu lebih akurat, namun pasien walk-in tetap kami layani.</div>
                </div>
                <div class="card-modern overflow-hidden faq-item">
                    <button class="w-full flex items-center justify-between p-6 text-left faq-btn font-bold text-lg">Bagaimana cara membatalkan antrian?<i data-lucide="chevron-down" class="w-6 h-6 text-gray-400 transition-transform faq-icon"></i></button>
                    <div class="faq-answer hidden px-6 pb-6 text-[var(--text-muted)]">Anda bisa membatalkan melalui menu "Riwayat" di dashboard pasien maksimal 2 jam sebelum jadwal praktik.</div>
                </div>
                <div class="card-modern overflow-hidden faq-item">
                    <button class="w-full flex items-center justify-between p-6 text-left faq-btn font-bold text-lg">Apakah data medis saya aman?<i data-lucide="chevron-down" class="w-6 h-6 text-gray-400 transition-transform faq-icon"></i></button>
                    <div class="faq-answer hidden px-6 pb-6 text-[var(--text-muted)]">Sangat aman. Kami menggunakan sistem terenkripsi dan hanya dokter yang menangani Anda yang dapat mengakses rekam medis.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER DENGAN ICON SOSMED BARU -->
    <footer class="bg-[var(--text-main)] text-white pt-20 pb-10 px-6">
        <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-10 mb-12">
            <div class="md:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-[var(--primary)] flex items-center justify-center"><i data-lucide="heart-pulse" class="w-6 h-6 text-white"></i></div>
                    <span class="font-extrabold text-2xl">MedikaCentra</span>
                </div>
                <p class="text-gray-400 max-w-sm mb-6">Melayani dengan hati, merawat dengan teknologi. Kesehatan Anda adalah prioritas utama kami.</p>
                <div class="flex gap-4">
                    <!-- Instagram Icon -->
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[var(--primary)] transition-colors group">
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                    <!-- TikTok Icon -->
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[var(--primary)] transition-colors group">
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93v6.16c0 2.52-1.12 4.84-2.98 6.37-1.48 1.25-3.35 1.94-5.27 1.94-4.23 0-7.65-3.43-7.65-7.66 0-3.29 2.08-6.11 5.02-7.21 1.02-.38 2.13-.57 3.25-.57v4.03c-.53 0-1.06.08-1.57.24-1.3.41-2.25 1.62-2.25 3.04 0 1.78 1.45 3.22 3.22 3.22 1.78 0 3.22-1.44 3.22-3.22V.02h-3.87z" />
                        </svg>
                    </a>
                    <!-- Facebook Icon -->
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[var(--primary)] transition-colors group">
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-6">Navigasi</h4>
                <ul class="space-y-4 text-gray-400">
                    <li><a href="#beranda" class="hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="#poli" class="hover:text-white transition-colors">Jadwal Dokter</a></li>
                    <li><a href="#artikel" class="hover:text-white transition-colors">Artikel Kesehatan</a></li>
                    <li><a href="#faq" class="hover:text-white transition-colors">Bantuan</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-6">Jam Operasional</h4>
                <ul class="space-y-4 text-gray-400">
                    <li class="flex justify-between"><span>Senin - Jumat</span> <span class="text-white">07.00 - 20.00</span></li>
                    <li class="flex justify-between"><span>Sabtu</span> <span class="text-white">07.00 - 17.00</span></li>
                    <li class="flex justify-between"><span>Minggu</span> <span class="text-white">08.00 - 13.00</span></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 pt-8 text-center text-gray-500 text-sm">&copy; 2026 Medika Centra. All rights reserved.</div>
    </footer>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        lucide.createIcons();

        // 1. SCROLL SPY UNTUK NAVBAR (Agar warna aktif berpindah saat discroll)
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-link');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= (sectionTop - 150)) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').includes(current)) {
                    link.classList.add('active');
                }
            });
        });

        // 2. LOGIN REDIRECT LOGIC
        function handleLogin() {
            const token = localStorage.getItem('auth_token');
            const role  = localStorage.getItem('user_role');
            if (token) {
                // Arahkan ke dashboard sesuai role, tanpa alert
                const map = {
                    admin:   '/admin-dashboard',
                    doctor:  '/doctor-dashboard',
                    staff:   '/staff-dashboard',
                    patient: '/patient-dashboard',
                };
                window.location.href = map[role] || '/patient-dashboard';
            } else {
                window.location.href = "{{ url('/login') }}";
            }
        }

        // 3. FAQ TOGGLE
        document.querySelectorAll('.faq-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const item = btn.parentElement;
                const answer = item.querySelector('.faq-answer');
                const icon = item.querySelector('.faq-icon');
                answer.classList.toggle('hidden');
                icon.style.transform = answer.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
            });
        });

        // 4. FETCH DATA DARI BACKEND
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                // Fetch Poli
                const poliRes = await fetch('/api/poli');
                if (poliRes.ok) {
                    const polis = await poliRes.json();
                    const container = document.getElementById('poliGrid');
                    container.innerHTML = '';
                    polis.forEach(poli => {
                        let iconName = 'stethoscope';
                        if (poli.code === 'GIGI') iconName = 'smile';
                        if (poli.code === 'ANAK') iconName = 'baby';
                        container.innerHTML += `
                            <div class="card-modern p-6 relative overflow-hidden group">
                                <div class="w-14 h-14 rounded-2xl bg-[var(--primary-light)] text-[var(--primary-dark)] flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                    <i data-lucide="${iconName}" class="w-7 h-7"></i>
                                </div>
                                <h3 class="text-xl font-bold mb-2">${poli.name}</h3>
                                <p class="text-[var(--text-muted)] text-sm mb-4 line-clamp-2">${poli.description}</p>
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-gray-100 text-gray-600">Kuota: ${poli.max_queue_per_day}/hari</span>
                                    <button onclick="handleLogin()" class="text-sm font-bold text-[var(--primary-dark)] hover:underline">Booking <i data-lucide="arrow-right" class="w-3 h-3 inline"></i></button>
                                </div>
                            </div>`;
                    });
                    lucide.createIcons();
                }

                // Fetch Articles (Dummy Fallback)
                const artCont = document.getElementById('articleGrid');
                artCont.innerHTML = `
                    <div class="card-modern p-6 flex flex-col h-full">
                        <span class="text-xs font-bold text-[var(--primary)] uppercase tracking-wider mb-2">Penyakit Menular</span>
                        <h3 class="text-lg font-bold mb-3 leading-snug">Kenali Gejala Awal Demam Berdarah di Musim Hujan</h3>
                        <p class="text-[var(--text-muted)] text-sm flex-1 mb-4">Musim hujan membuat populasi nyamuk meningkat. Ketahui tanda-tanda awal DBD agar penanganan tidak terlambat.</p>
                        <a href="#" class="text-sm font-bold text-[var(--primary-dark)] hover:underline mt-auto">Baca Selengkapnya</a>
                    </div>
                    <div class="card-modern p-6 flex flex-col h-full">
                        <span class="text-xs font-bold text-[var(--primary)] uppercase tracking-wider mb-2">Anak</span>
                        <h3 class="text-lg font-bold mb-3 leading-snug">Pentingnya Imunisasi Lengkap untuk Anak di Bawah 5 Tahun</h3>
                        <p class="text-[var(--text-muted)] text-sm flex-1 mb-4">Imunisasi dasar lengkap melindungi anak dari penyakit yang sebenarnya bisa dicegah. Simak jadwal dan manfaatnya.</p>
                        <a href="#" class="text-sm font-bold text-[var(--primary-dark)] hover:underline mt-auto">Baca Selengkapnya</a>
                    </div>
                    <div class="card-modern p-6 flex flex-col h-full">
                        <span class="text-xs font-bold text-[var(--primary)] uppercase tracking-wider mb-2">Gigi & Mulut</span>
                        <h3 class="text-lg font-bold mb-3 leading-snug">Tips Menjaga Kesehatan Gigi Selama Puasa</h3>
                        <p class="text-[var(--text-muted)] text-sm flex-1 mb-4">Perubahan pola makan saat puasa memengaruhi kesehatan gigi dan mulut. Ini cara menjaganya tetap sehat.</p>
                        <a href="#" class="text-sm font-bold text-[var(--primary-dark)] hover:underline mt-auto">Baca Selengkapnya</a>
                    </div>`;

            } catch (error) {
                console.error('Error loading data:', error);
            }
        });
    </script>
</body>

</html>