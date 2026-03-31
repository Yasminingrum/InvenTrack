<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }

    public function registerPage()
    {
        return view('auth.register');
    }

    public function logout(Request $request)
    {
        $request->session()->forget([
            'firebase_uid',
            'firebase_email',
            'firebase_display_name',
            'firebase_role',
        ]);
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Kirim email verifikasi custom (untuk Google Sign-In user).
     * Menyimpan token ke Firebase Realtime Database via REST API.
     */
    public function sendVerification(Request $request)
    {
        $request->validate([
            'uid'   => 'required|string',
            'email' => 'required|email',
            'name'  => 'nullable|string',
        ]);

        $uid   = $request->uid;
        $email = $request->email;
        $name  = $request->name ?? $email;

        $token   = Str::random(64);
        $expires = now()->addHours(24)->toISOString();

        // Simpan token ke Firebase DB via REST API
        $dbUrl = rtrim(env('FIREBASE_DATABASE_URL'), '/');
        Http::patch("{$dbUrl}/users/{$uid}.json", [
            'verify_token'      => $token,
            'verify_expires_at' => $expires,
        ]);

        // Kirim email verifikasi
        $verifyUrl = route('auth.verify-email', ['token' => $token, 'uid' => $uid]);
        Mail::send([], [], function ($message) use ($email, $name, $verifyUrl) {
            $message->to($email, $name)
                    ->subject('Verifikasi Email InvenTrack')
                    ->html($this->buildEmailHtml($name, $verifyUrl));
        });

        return response()->json(['success' => true]);
    }

    /**
     * Handle continueUrl dari Firebase email verification (untuk user email/password).
     * Firebase sudah verifikasi emailnya — kita tinggal sync email_verified: true ke DB.
     */
    public function verifyEmailSync(Request $request)
    {
        $uid = $request->query('uid');

        if ($uid) {
            $dbUrl = rtrim(env('FIREBASE_DATABASE_URL'), '/');
            Http::patch("{$dbUrl}/users/{$uid}.json", [
                'email_verified' => true,
            ]);
        }

        return redirect()->route('login')->with('success', '✅ Email berhasil diverifikasi! Silakan login.');
    }

    /**
     * Handle klik link verifikasi dari email (untuk Google user).
     * Validasi token, update email_verified: true di DB, redirect ke login.
     */
    public function verifyEmail(Request $request)
    {
        $token = $request->query('token');
        $uid   = $request->query('uid');

        if (!$token || !$uid) {
            return redirect()->route('login')->with('error', 'Link verifikasi tidak valid.');
        }

        $dbUrl    = rtrim(env('FIREBASE_DATABASE_URL'), '/');
        $response = Http::get("{$dbUrl}/users/{$uid}.json");

        if (!$response->ok() || $response->json() === null) {
            return redirect()->route('login')->with('error', 'Akun tidak ditemukan.');
        }

        $user = $response->json();

        if (($user['verify_token'] ?? '') !== $token) {
            return redirect()->route('login')->with('error', 'Token verifikasi tidak valid.');
        }

        if (now()->isAfter($user['verify_expires_at'] ?? '')) {
            return redirect()->route('login')->with('error', 'Link verifikasi sudah kedaluwarsa. Silakan minta link baru.');
        }

        // Tandai terverifikasi, hapus token
        Http::patch("{$dbUrl}/users/{$uid}.json", [
            'email_verified'    => true,
            'verify_token'      => null,
            'verify_expires_at' => null,
        ]);

        return redirect()->route('login')->with('success', '✅ Email berhasil diverifikasi! Silakan login.');
    }

    /**
     * Simpan session setelah Firebase Auth berhasil di frontend.
     */
    public function storeSession(Request $request)
    {
        $request->validate([
            'uid'          => 'required|string',
            'email'        => 'required|email',
            'display_name' => 'nullable|string',
            'role'         => 'nullable|string|in:superadmin,admin,viewer',
        ]);

        $request->session()->put('firebase_uid',          $request->uid);
        $request->session()->put('firebase_email',        $request->email);
        $request->session()->put('firebase_display_name', $request->display_name ?? $request->email);
        $request->session()->put('firebase_role',         $request->role ?? 'viewer');

        return response()->json(['success' => true]);
    }

    private function buildEmailHtml(string $name, string $url): string
    {
        return <<<HTML
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#f0f4f8;font-family:'Segoe UI',Arial,sans-serif">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f4f8;padding:40px 0">
  <tr><td align="center">
    <table width="520" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08)">
      <tr><td style="background:#0f4c81;padding:32px;text-align:center">
        <span style="font-size:22px;font-weight:800;color:#fff;letter-spacing:-0.5px">&#128230; InvenTrack</span>
      </td></tr>
      <tr><td style="padding:36px 40px">
        <h2 style="margin:0 0 12px;font-size:20px;font-weight:700;color:#0f172a">Verifikasi Email Anda</h2>
        <p style="margin:0 0 8px;font-size:15px;color:#475569;line-height:1.6">Halo, <strong>{$name}</strong>!</p>
        <p style="margin:0 0 28px;font-size:15px;color:#475569;line-height:1.6">
          Terima kasih telah mendaftar di InvenTrack. Klik tombol di bawah untuk memverifikasi email Anda.
          Link ini berlaku selama <strong>24 jam</strong>.
        </p>
        <div style="text-align:center;margin-bottom:28px">
          <a href="{$url}" style="display:inline-block;background:#0f4c81;color:#fff;text-decoration:none;padding:14px 36px;border-radius:10px;font-size:15px;font-weight:700">
            Verifikasi Email Sekarang
          </a>
        </div>
        <p style="margin:0 0 4px;font-size:13px;color:#94a3b8">Atau copy link berikut ke browser Anda:</p>
        <p style="margin:0;font-size:12px;color:#64748b;word-break:break-all;background:#f8fafc;padding:10px 12px;border-radius:6px;border:1px solid #e2e8f0">{$url}</p>
      </td></tr>
      <tr><td style="padding:20px 40px;background:#f8fafc;border-top:1px solid #e2e8f0;text-align:center">
        <p style="margin:0;font-size:12px;color:#94a3b8">
          Jika Anda tidak mendaftar di InvenTrack, abaikan email ini.<br>
          &copy; 2025 InvenTrack &middot; Inventory Management System
        </p>
      </td></tr>
    </table>
  </td></tr>
</table>
</body>
</html>
HTML;
    }
}
