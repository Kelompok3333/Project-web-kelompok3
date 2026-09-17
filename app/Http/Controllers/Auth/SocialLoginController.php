<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialLoginController extends Controller
{
    public function redirect(string $provider)
    {
        abort_unless(in_array($provider, ['google', 'facebook'], true), 404);

        $service = config("services.$provider");
        if (
            empty($service['client_id']) ||
            empty($service['client_secret']) ||
            str_contains((string) $service['client_id'], 'GANTI_DENGAN') ||
            str_contains((string) $service['client_secret'], 'GANTI_DENGAN')
        ) {
            return redirect('/login?social_error=' . urlencode("Login $provider belum dikonfigurasi di server."));
        }

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        abort_unless(in_array($provider, ['google', 'facebook'], true), 404);

        try {
            $socialUser = Socialite::driver($provider)->user();

            if (empty($socialUser->getId()) || empty($socialUser->getEmail())) {
                throw new \RuntimeException('Provider tidak mengembalikan identitas pengguna yang lengkap.');
            }

            $user = $this->findOrCreateUser([
                'email'       => $socialUser->getEmail(),
                'name'        => $socialUser->getName() ?: $socialUser->getNickname() ?: $socialUser->getEmail(),
                'provider'    => $provider,
                'provider_id' => $socialUser->getId(),
            ]);

            if (!$user->is_active) {
                throw new \RuntimeException('Akun Anda dinonaktifkan.');
            }

            $payload = $this->issueToken($user)->getData(true);
            session(['social_login' => $payload]);

            return redirect('/login?social_login=1');
        } catch (Throwable $exception) {
            report($exception);

            return redirect('/login?social_error=' . urlencode('Login sosial gagal. Silakan coba lagi.'));
        }
    }

    public function sessionToken(Request $request)
    {
        $payload = $request->session()->pull('social_login');

        if (!$payload) {
            return response()->json(['message' => 'Sesi login sosial tidak ditemukan.'], 401);
        }

        return response()->json($payload);
    }

    /* ════════════════════════════════════════════════════
       GOOGLE LOGIN
       Flow: Browser → Google GSI popup → id_token
             → POST /api/login/google {token: id_token}
             → Verify ke Google tokeninfo endpoint
             → Return Sanctum token
    ════════════════════════════════════════════════════ */
    public function google(Request $request)
    {
        $request->validate(['token' => 'required|string']);

        // Verifikasi id_token ke Google
        $response = Http::timeout(10)
            ->get('https://oauth2.googleapis.com/tokeninfo', [
                'id_token' => $request->token,
            ]);

        if ($response->failed()) {
            return response()->json(['message' => 'Tidak dapat menghubungi server Google.'], 502);
        }

        $data = $response->json();

        // Token harus diterbitkan untuk aplikasi ini, bukan sekadar token Google yang valid.
        $clientId = config('services.google.client_id');
        if (
            empty($clientId) ||
            empty($data['email']) ||
            empty($data['sub']) ||
            ($data['aud'] ?? null) !== $clientId ||
            ($data['email_verified'] ?? 'false') !== 'true'
        ) {
            return response()->json(['message' => 'Token Google tidak valid atau tidak cocok.'], 401);
        }

        $user = $this->findOrCreateUser([
            'email'       => $data['email'],
            'name'        => $data['name'] ?? $data['email'],
            'provider'    => 'google',
            'provider_id' => $data['sub'],
        ]);

        return $this->issueToken($user);
    }

    /* ════════════════════════════════════════════════════
       FACEBOOK LOGIN
       Flow: Browser → FB Login SDK popup → accessToken
             → POST /api/login/facebook {token: accessToken}
             → Verify ke FB Graph API /me endpoint
             → Return Sanctum token
    ════════════════════════════════════════════════════ */
    public function facebook(Request $request)
    {
        $request->validate(['token' => 'required|string']);

        $appId = config('services.facebook.client_id');
        $appSecret = config('services.facebook.client_secret');

        if (empty($appId) || empty($appSecret)) {
            return response()->json(['message' => 'Login Facebook belum dikonfigurasi.'], 503);
        }

        // Pastikan token diterbitkan untuk Facebook App milik aplikasi ini.
        $debugResponse = Http::timeout(10)
            ->get('https://graph.facebook.com/debug_token', [
                'input_token' => $request->token,
                'access_token' => $appId . '|' . $appSecret,
            ]);

        $debugData = $debugResponse->json('data');
        if (
            $debugResponse->failed() ||
            !is_array($debugData) ||
            ($debugData['is_valid'] ?? false) !== true ||
            (string) ($debugData['app_id'] ?? '') !== (string) $appId
        ) {
            return response()->json(['message' => 'Token Facebook tidak valid atau tidak cocok.'], 401);
        }

        // Ambil identitas pengguna hanya setelah token lolos pemeriksaan aplikasi.
        $response = Http::timeout(10)
            ->get('https://graph.facebook.com/me', [
                'access_token' => $request->token,
                'fields'       => 'id,name,email',
            ]);

        if ($response->failed()) {
            return response()->json(['message' => 'Tidak dapat menghubungi server Facebook.'], 502);
        }

        $data = $response->json();

        if (
            empty($data['id']) ||
            isset($data['error']) ||
            (string) $data['id'] !== (string) ($debugData['user_id'] ?? '')
        ) {
            return response()->json(['message' => 'Token Facebook tidak valid.'], 401);
        }

        // Facebook tidak selalu mengembalikan email (tergantung izin akun)
        $email = $data['email']
            ?? ('fb_' . $data['id'] . '@medika.local');

        $user = $this->findOrCreateUser([
            'email'       => $email,
            'name'        => $data['name'] ?? 'Pengguna Facebook',
            'provider'    => 'facebook',
            'provider_id' => $data['id'],
        ]);

        return $this->issueToken($user);
    }

    /* ════════════════════════════════════════════════════
       PRIVATE HELPERS
    ════════════════════════════════════════════════════ */

    private function findOrCreateUser(array $data): User
    {
        $patientRoleId = Role::where('name', 'patient')->value('id') ?? 4;

        // Cari berdasarkan provider_id dulu (lebih aman dari email)
        $user = User::where('provider', $data['provider'])
            ->where('provider_id', $data['provider_id'])
            ->first();

        if (!$user) {
            // Coba temukan berdasarkan email (mungkin sudah register biasa)
            $user = User::where('email', $data['email'])->first();
        }

        if (!$user) {
            // Buat akun baru
            $user = User::create([
                'name'               => $data['name'],
                'email'              => $data['email'],
                'provider'           => $data['provider'],
                'provider_id'        => $data['provider_id'],
                'password'           => bcrypt(str()->random(32)),
                'role_id'            => $patientRoleId,
                'is_active'          => true,
                'email_verified_at'  => now(),
            ]);
        } else {
            // Update provider info kalau belum tersimpan
            if (empty($user->provider_id)) {
                $user->update([
                    'provider'    => $data['provider'],
                    'provider_id' => $data['provider_id'],
                ]);
            }
        }

        return $user;
    }

    private function issueToken(User $user): \Illuminate\Http\JsonResponse
    {
        if (!$user->is_active) {
            return response()->json(['message' => 'Akun Anda dinonaktifkan.'], 403);
        }

        // Hapus token lama supaya tidak menumpuk
        $user->tokens()->where('name', 'social-login')->delete();
        $token = $user->createToken('social-login')->plainTextToken;

        $needsProfile = !$user->patientProfile
            || empty($user->patientProfile->full_name)
            || empty($user->patientProfile->phone_number);

        return response()->json([
            'message'       => 'Login berhasil!',
            'token'         => $token,
            'role'          => $user->role?->name ?? 'patient',
            'user_id'       => $user->id,
            'needs_profile' => $needsProfile,
            'redirect'      => $needsProfile ? '/complete-profile' : $this->dashboardUrl($user->role?->name),
        ]);
    }

    private function dashboardUrl(?string $role): string
    {
        return match ($role) {
            'admin'   => '/admin-dashboard',
            'doctor'  => '/doctor-dashboard',
            'staff'   => '/staff-dashboard',
            default   => '/patient-dashboard',
        };
    }
}
