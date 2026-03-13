@extends('layouts.app')

@section('title', 'Pengaturan — InvenTrack')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="card mb-3">
            <div class="card-header-custom">
                <h2 class="card-title-custom">
                    <i class="bi bi-gear-fill me-2" style="color:var(--primary)"></i>
                    Pengaturan Umum
                </h2>
                <span style="background:#fef9c3;color:#92400e;padding:.2rem .6rem;border-radius:6px;font-size:.7rem;font-weight:700">
                    <i class="bi bi-shield-fill-check"></i> Super Admin Only
                </span>
            </div>
            <div style="padding:1.5rem">
                <div style="display:flex;flex-direction:column;gap:1.25rem">

                    <!-- App Name -->
                    <div class="form-group" style="margin:0">
                        <label class="form-label-custom">Nama Aplikasi</label>
                        <input type="text" class="form-control-custom" value="InvenTrack" readonly
                               style="background:#f8fafc;color:var(--text-muted)">
                        <div style="font-size:.72rem;color:var(--text-muted);margin-top:.3rem">Nama aplikasi ditampilkan di sidebar dan judul halaman.</div>
                    </div>

                    <!-- Firebase DB URL -->
                    <div class="form-group" style="margin:0">
                        <label class="form-label-custom">Firebase Database URL</label>
                        <input type="text" class="form-control-custom" value="{{ env('FIREBASE_DATABASE_URL') }}" readonly
                               style="background:#f8fafc;color:var(--text-muted);font-family:'DM Mono',monospace;font-size:.8rem">
                        <div style="font-size:.72rem;color:var(--text-muted);margin-top:.3rem">Diatur melalui file <code>.env</code> di server.</div>
                    </div>

                    <!-- Default Role -->
                    <div class="form-group" style="margin:0">
                        <label class="form-label-custom">Role Default User Baru</label>
                        <select class="form-control-custom" disabled style="background:#f8fafc;color:var(--text-muted)">
                            <option selected>viewer (hanya baca)</option>
                        </select>
                        <div style="font-size:.72rem;color:var(--text-muted);margin-top:.3rem">User baru yang mendaftar otomatis mendapat role <strong>viewer</strong>. Ubah di halaman Manajemen User.</div>
                    </div>
                </div>

                <div style="margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid var(--border)">
                    <div class="alert-custom" style="background:#eff6ff;color:#1e40af;border:1px solid #bfdbfe;font-size:.82rem">
                        <i class="bi bi-info-circle-fill" style="flex-shrink:0"></i>
                        Pengaturan aplikasi dikelola melalui file <code>.env</code> dan Firebase Console.
                        Untuk mengubah konfigurasi Firebase, akses <a href="https://console.firebase.google.com" target="_blank" style="color:#1d4ed8;font-weight:600">Firebase Console</a>.
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="card">
            <div class="card-header-custom">
                <h2 class="card-title-custom">
                    <i class="bi bi-link-45deg me-2" style="color:var(--primary)"></i>
                    Tautan Cepat
                </h2>
            </div>
            <div style="padding:1.25rem;display:flex;flex-wrap:wrap;gap:.75rem">
                <a href="{{ route('settings.users') }}" class="btn-primary-custom">
                    <i class="bi bi-people-fill"></i> Manajemen User
                </a>
                <a href="{{ route('products.index') }}" class="btn-primary-custom" style="background:#f1f5f9;color:var(--text-main)">
                    <i class="bi bi-grid-3x3-gap-fill"></i> Dashboard
                </a>
                <a href="{{ route('reports.index') }}" class="btn-primary-custom" style="background:#f1f5f9;color:var(--text-main)">
                    <i class="bi bi-bar-chart-line-fill"></i> Laporan Stok
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
