<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialLoginController;

/* ── Halaman Publik ────────────────────── */
Route::get('/', function () {
    return view('welcome');
})->name('home');

/* ── Auth ──────────────────────────────── */
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/auth/{provider}/redirect', [SocialLoginController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [SocialLoginController::class, 'callback']);
Route::get('/auth/social/token', [SocialLoginController::class, 'sessionToken']);

/* ── Lengkapi Profil (wajib setelah register) ── */
Route::get('/complete-profile', function () {
    return view('complete-profile');
})->name('profile.complete');

/* ── Dashboard per Role ─────────────────── */
Route::get('/patient-dashboard', function () {
    return view('patient-dashboard');
})->name('patient.dashboard');

Route::get('/doctor-dashboard', function () {
    return view('doctor-dashboard');
})->name('doctor.dashboard');

Route::get('/staff-dashboard', function () {
    return view('staff-dashboard');
})->name('staff.dashboard');

Route::get('/admin-dashboard', function () {
    return view('admin-dashboard');
})->name('admin.dashboard');

/* ── Sistem Antrian ─────────────────────── */
Route::get('/queue-display', function () {
    return view('queue-display');
})->name('queue.display');

Route::get('/queue-board', function () {
    return view('queue-display');
})->name('queue.board');

/* ── Fallback ───────────────────────────── */
Route::fallback(function () {
    return redirect()->route('home');
});
