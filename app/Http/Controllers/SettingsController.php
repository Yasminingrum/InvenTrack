<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Halaman Pengaturan Umum
     */
    public function index()
    {
        return view('settings.index');
    }

    /**
     * Halaman Manajemen User
     * Data user & role diambil dari Firebase via JS di frontend.
     */
    public function users()
    {
        return view('settings.users');
    }

    /**
     * Update role user — dipanggil via AJAX dari halaman manajemen user.
     * Actual write ke Firebase DB dilakukan di frontend (JS),
     * endpoint ini hanya sebagai proxy opsional jika ingin server-side write.
     * Untuk kesederhanaan, frontend langsung PATCH ke Firebase REST API.
     */
    public function updateRole(Request $request, string $uid)
    {
        $request->validate([
            'role' => 'required|in:superadmin,admin,viewer',
        ]);

        // Update ke Firebase REST API dari server (opsional)
        $dbUrl   = env('FIREBASE_DATABASE_URL');
        $payload = json_encode(['role' => $request->role]);

        $ch = curl_init("{$dbUrl}/users/{$uid}.json");
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST  => 'PATCH',
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Gagal update role.'], 500);
    }
}
