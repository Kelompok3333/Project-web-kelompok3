<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// ==========================================
// IMPORT CONTROLLERS (Sesuai Struktur Folder)
// ==========================================

// 1. Controller Publik (Root Api)
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\PoliController;

// 2. Controller Auth
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialLoginController;

// 3. Controller Pasien (Folder Patient)
use App\Http\Controllers\Api\Patient\AppointmentController;
use App\Http\Controllers\Api\Patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\Api\Patient\PatientProfileController;
use App\Http\Controllers\Api\Patient\QueueSlotController;
use App\Http\Controllers\Api\Patient\ScheduleController as PatientScheduleController;

// 4. Controller Staff (Folder Staff)
use App\Http\Controllers\Api\Staff\QueueController as StaffQueueController;

// 5. Controller Admin (Folder Admin)
use App\Http\Controllers\Api\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Api\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Api\Admin\DoctorScheduleController as AdminScheduleController;
use App\Http\Controllers\Api\Admin\PoliController as AdminPoliController;
use App\Http\Controllers\Api\Admin\QueueCallController as AdminQueueCallController;
use App\Http\Controllers\Api\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Api\Admin\StaffController as AdminStaffController;

// 6. Controller Dokter Dashboard (Folder Doctor)
use App\Http\Controllers\Api\Doctor\DashboardController as DoctorDashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// AUTH ROUTES (Public - Tanpa Login)
// ==========================================
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/login/test', function (Request $request) {
    $credentials = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    $user = \App\Models\User::where('email', $credentials['email'])
        ->where('is_active', true)
        ->first();

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return response()->json(['message' => 'Email atau password salah'], 401);
    }

    $user->tokens()->delete();
    $token = $user->createToken('testing-token')->plainTextToken;

    return response()->json([
        'message'    => 'Login testing berhasil!',
        'user_id'    => $user->id,
        'role'       => $user->role->name ?? 'unknown',
        'token_type' => 'Bearer',
        'token'      => $token,
    ]);
});

Route::post('/login/google',    [SocialLoginController::class, 'google']);
Route::post('/login/facebook',  [SocialLoginController::class, 'facebook']);


// ==========================================
// PUBLIC DATA ROUTES (Tanpa Login)
// ==========================================
Route::get('/poli',     [PoliController::class,    'index']);
Route::get('/doctors',  [DoctorController::class,  'index']);
Route::get('/articles', [ArticleController::class, 'index']);
// Jadwal tersedia — untuk date-picker booking pasien (publik, no auth)
Route::get('/schedules',                 [PatientScheduleController::class, 'index']);
Route::get('/schedules/available-dates', [PatientScheduleController::class, 'availableDates']);
// Slot nomor antrian per poli per hari (publik, status mine butuh token tapi optional)
Route::get('/queue-slots',               [QueueSlotController::class, 'index']);
// Papan antrian publik — bisa diakses layar TV tanpa login
Route::get('/queue/board', [AdminQueueCallController::class, 'board']);


// ==========================================
// PROTECTED ROUTES (Wajib Login - Sanctum)
// ==========================================
Route::middleware('auth:sanctum')->group(function () {

    // ─── FITUR PASIEN ───────────────────────────────────────────────
    Route::get('/dashboard', [PatientDashboardController::class, 'index']);

    Route::get('/profile',  [PatientProfileController::class, 'show']);
    Route::post('/profile', [PatientProfileController::class, 'store']);
    Route::put('/profile',  [PatientProfileController::class, 'update']);

    Route::get('/appointments',                       [AppointmentController::class, 'index']);
    Route::post('/appointments',                      [AppointmentController::class, 'store']);
    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'destroy']);

    Route::get('/notifications', function (Request $request) {
        return response()->json($request->user()->notifications()->latest()->get());
    });

    // ── Status antrian pasien (polling) ──────────────────────────
    Route::get('/queue/my-status', [AdminQueueCallController::class, 'myStatus']);

    // ─── FITUR ADMIN ────────────────────────────────────────────────
    // Middleware 'admin' (EnsureUserIsAdmin) melindungi semua route /api/admin/*
    Route::prefix('admin')->middleware('admin')->group(function () {

        // Dashboard summary
        Route::get('/summary', [AdminReportController::class, 'summary']);

        // CRUD Poli
        Route::apiResource('polis', AdminPoliController::class)->except(['show']);

        // CRUD Dokter
        Route::get('doctors',              [AdminDoctorController::class, 'index']);
        Route::post('doctors',             [AdminDoctorController::class, 'store']);
        Route::put('doctors/{doctor}',     [AdminDoctorController::class, 'update']);
        Route::delete('doctors/{doctor}',  [AdminDoctorController::class, 'destroy']);

        // CRUD Petugas (Staff)
        Route::get('staff',                                [AdminStaffController::class, 'index']);
        Route::post('staff',                               [AdminStaffController::class, 'store']);
        Route::put('staff/{user}',                         [AdminStaffController::class, 'update']);
        Route::delete('staff/{user}',                      [AdminStaffController::class, 'destroy']);
        Route::patch('staff/{user}/toggle-active',         [AdminStaffController::class, 'toggleActive']);
        Route::post('staff/{user}/reset-password',         [AdminStaffController::class, 'resetPassword']);

        // CRUD Artikel Kesehatan
        Route::get('articles',                             [AdminArticleController::class, 'index']);
        Route::post('articles',                            [AdminArticleController::class, 'store']);
        Route::get('articles/{article}',                   [AdminArticleController::class, 'show']);
        Route::post('articles/{article}',                  [AdminArticleController::class, 'update']); // POST untuk support file upload + _method
        Route::delete('articles/{article}',                [AdminArticleController::class, 'destroy']);
        Route::patch('articles/{article}/toggle-publish',  [AdminArticleController::class, 'togglePublish']);

        // CRUD Jadwal Praktik Dokter
        Route::get('schedules',                            [AdminScheduleController::class, 'index']);
        Route::post('schedules',                           [AdminScheduleController::class, 'store']);
        Route::put('schedules/{doctorSchedule}',           [AdminScheduleController::class, 'update']);
        Route::delete('schedules/{doctorSchedule}',        [AdminScheduleController::class, 'destroy']);

        // Laporan Kunjungan
        Route::get('/reports/visits',      [AdminReportController::class, 'visits']);
        Route::get('/reports/top-doctors', [AdminReportController::class, 'topDoctors']);

        // ── Sistem Pemanggilan Antrian ────────────────────────────
        Route::get('/queue/board',                              [AdminQueueCallController::class, 'board']);
        Route::get('/queue/list',                               [AdminQueueCallController::class, 'list']);
        Route::post('/queue/{appointment}/call',                [AdminQueueCallController::class, 'call']);
        Route::post('/queue/{appointment}/recall',              [AdminQueueCallController::class, 'recall']);
        Route::post('/queue/{appointment}/complete',            [AdminQueueCallController::class, 'complete']);
        Route::post('/queue/{appointment}/skip',                [AdminQueueCallController::class, 'skip']);
        Route::post('/queue/{appointment}/reset',               [AdminQueueCallController::class, 'reset']);
    });

    // ─── FITUR PETUGAS (STAFF) ──────────────────────────────────────
    Route::prefix('staff')->group(function () {
        Route::get('/queues',   [StaffQueueController::class, 'index']);
        Route::post('/verify',  [StaffQueueController::class, 'verify']);
        Route::post('/walk-in', [StaffQueueController::class, 'storeWalkIn']);
    });

    // ─── FITUR DOKTER ───────────────────────────────────────────────
    Route::prefix('doctor')->group(function () {
        Route::get('/dashboard',                           [DoctorDashboardController::class, 'index']);
        Route::post('/exam/{appointment}/start',           [DoctorDashboardController::class, 'startExam']);
        Route::post('/exam/{appointment}/finish',          [DoctorDashboardController::class, 'finishExam']);
    });
});
