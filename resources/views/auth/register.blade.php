<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — InvenTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:    #0f4c81;
            --primary-lt: #1a6bbf;
            --accent:     #f97316;
            --accent-lt:  #fb923c;
            --surface:    #f0f4f8;
            --card-bg:    #ffffff;
            --border:     #e2e8f0;
            --text-main:  #0f172a;
            --text-muted: #64748b;
            --danger:     #ef4444;
            --success:    #22c55e;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--surface); min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow-x: hidden; padding: 2rem 0;
        }
        body::before { content: ''; position: fixed; inset: 0; background: radial-gradient(circle at 20% 20%, rgba(15,76,129,.08) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(249,115,22,.06) 0%, transparent 50%); pointer-events: none; }
        .bg-shapes { position: fixed; inset: 0; pointer-events: none; overflow: hidden; z-index: 0; }
        .bg-shape { position: absolute; border-radius: 50%; opacity: .07; }
        .bg-shape-1 { width: 500px; height: 500px; background: var(--primary); top: -200px; left: -200px; }
        .bg-shape-2 { width: 300px; height: 300px; background: var(--accent); bottom: -100px; right: -100px; }
        .auth-wrapper { position: relative; z-index: 10; width: 100%; max-width: 480px; padding: 1.5rem; }
        .auth-logo { display: flex; align-items: center; justify-content: center; gap: .75rem; margin-bottom: 1.75rem; text-decoration: none; }
        .logo-icon { width: 46px; height: 46px; background: var(--accent); border-radius: 12px; display: grid; place-items: center; font-size: 1.3rem; color: #fff; box-shadow: 0 4px 14px rgba(249,115,22,.35); }
        .logo-text { font-size: 1.5rem; font-weight: 800; color: var(--primary); letter-spacing: -.5px; }
        .logo-sub  { font-size: .65rem; color: var(--text-muted); letter-spacing: .5px; text-transform: uppercase; line-height: 1; }
        .auth-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 18px; box-shadow: 0 8px 40px rgba(0,0,0,.1); padding: 2.25rem; }
        .auth-title    { font-size: 1.35rem; font-weight: 800; color: var(--text-main); margin-bottom: .25rem; }
        .auth-subtitle { font-size: .82rem; color: var(--text-muted); margin-bottom: 1.75rem; }
        .divider { display: flex; align-items: center; gap: .75rem; margin: 1.25rem 0; color: var(--text-muted); font-size: .75rem; font-weight: 600; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
        .row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: .9rem; }
        .form-group { margin-bottom: 1.1rem; }
        .form-label { display: block; font-size: .78rem; font-weight: 700; color: var(--text-main); margin-bottom: .4rem; letter-spacing: .2px; }
        .input-wrap { position: relative; }
        .input-icon { position: absolute; left: .85rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: .95rem; pointer-events: none; }
        .form-input { width: 100%; border: 1.5px solid var(--border); border-radius: 9px; padding: .65rem .85rem .65rem 2.5rem; font-size: .875rem; font-family: inherit; color: var(--text-main); background: #fafcff; transition: border-color .15s, box-shadow .15s; outline: none; }
        .form-input:focus { border-color: var(--primary-lt); box-shadow: 0 0 0 3px rgba(26,107,191,.12); background: #fff; }
        .form-input.is-error   { border-color: var(--danger);  box-shadow: 0 0 0 3px rgba(239,68,68,.1); }
        .form-input.is-success { border-color: var(--success); box-shadow: 0 0 0 3px rgba(34,197,94,.1); }
        .btn-eye { position: absolute; right: .75rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-muted); padding: .2rem; font-size: .95rem; }
        .btn-eye:hover { color: var(--text-main); }

        /* Invite code hints */
        .invite-hint { font-size: .7rem; margin-top: .35rem; display: flex; align-items: center; gap: .3rem; flex-wrap: wrap; }
        .invite-hint.hint-none    { color: var(--text-muted); }
        .invite-hint.hint-valid   { color: #15803d; }
        .invite-hint.hint-invalid { color: var(--danger); }
        .role-preview { display: inline-flex; align-items: center; gap: .3rem; padding: .15rem .55rem; border-radius: 20px; font-size: .68rem; font-weight: 700; }
        .role-preview.viewer     { background: #f1f5f9; color: #475569; }
        .role-preview.admin      { background: #dbeafe; color: #1e40af; }
        .role-preview.superadmin { background: #fee2e2; color: #991b1b; }

        /* Password strength */
        .password-strength { margin-top: .45rem; }
        .strength-bar  { height: 4px; border-radius: 2px; background: var(--border); overflow: hidden; }
        .strength-fill { height: 100%; border-radius: 2px; transition: width .3s, background .3s; width: 0; }
        .strength-text { font-size: .7rem; font-weight: 600; margin-top: .25rem; color: var(--text-muted); }

        .checkbox-wrap { display: flex; align-items: flex-start; gap: .6rem; margin-top: .25rem; cursor: pointer; }
        .checkbox-wrap input[type="checkbox"] { width: 16px; height: 16px; margin-top: .1rem; flex-shrink: 0; accent-color: var(--primary); }
        .checkbox-label { font-size: .78rem; color: var(--text-muted); line-height: 1.5; }
        .checkbox-label a { color: var(--primary); font-weight: 600; text-decoration: none; }

        .btn-submit { width: 100%; background: var(--primary); color: #fff; border: none; padding: .75rem 1.25rem; border-radius: 9px; font-size: .9rem; font-weight: 700; font-family: inherit; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: .5rem; transition: background .15s; box-shadow: 0 4px 14px rgba(15,76,129,.25); margin-top: 1.5rem; }
        .btn-submit:hover    { background: var(--primary-lt); }
        .btn-submit:disabled { opacity: .7; cursor: not-allowed; }
        .btn-google { width: 100%; background: #fff; color: var(--text-main); border: 1.5px solid var(--border); padding: .65rem 1.25rem; border-radius: 9px; font-size: .875rem; font-weight: 600; font-family: inherit; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: .6rem; transition: background .15s, box-shadow .15s; }
        .btn-google:hover { background: #f8fafc; box-shadow: 0 2px 8px rgba(0,0,0,.07); }
        .google-icon { width: 18px; height: 18px; }

        .alert { padding: .75rem 1rem; border-radius: 8px; font-size: .825rem; font-weight: 500; display: flex; align-items: flex-start; gap: .55rem; margin-bottom: 1.1rem; }
        .alert-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-danger  { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .alert-info    { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
        .alert i { flex-shrink: 0; margin-top: .1rem; }

        /* Verify screen */
        .verify-screen     { text-align: center; padding: .5rem 0; }
        .verify-icon       { width: 72px; height: 72px; background: #eff6ff; border-radius: 18px; display: grid; place-items: center; margin: 0 auto 1.25rem; font-size: 2rem; color: var(--primary); }
        .verify-title      { font-size: 1.2rem; font-weight: 800; color: var(--text-main); margin-bottom: .5rem; }
        .verify-desc       { font-size: .84rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1.5rem; }
        .verify-email-chip { display: inline-flex; align-items: center; gap: .4rem; background: #f1f5f9; border: 1px solid var(--border); padding: .35rem .85rem; border-radius: 20px; font-size: .82rem; font-weight: 600; color: var(--text-main); margin-bottom: 1.5rem; font-family: 'DM Mono', monospace; }
        .btn-outline { width: 100%; background: transparent; color: var(--primary); border: 1.5px solid var(--primary); padding: .65rem 1.25rem; border-radius: 9px; font-size: .875rem; font-weight: 600; font-family: inherit; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: .5rem; transition: background .15s; margin-bottom: .75rem; }
        .btn-outline:hover    { background: #eff6ff; }
        .btn-outline:disabled { opacity: .5; cursor: not-allowed; }

        .auth-footer { text-align: center; margin-top: 1.5rem; font-size: .82rem; color: var(--text-muted); }
        .auth-footer a { color: var(--primary); font-weight: 700; text-decoration: none; }

        .spinner-sm { width: 18px; height: 18px; border: 2px solid rgba(255,255,255,.35); border-top-color: #fff; border-radius: 50%; animation: spin .6s linear infinite; display: none; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .field-error { font-size: .73rem; color: var(--danger); margin-top: .3rem; display: none; }
        .field-error.show { display: block; }

        /* ══ MODAL ROLE ══ */
        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(15,23,42,.55); z-index: 9999;
            padding: 1rem; backdrop-filter: blur(4px);
            align-items: center; justify-content: center;
        }
        .modal-overlay.open { display: flex; }
        .modal-box {
            background: #fff; border-radius: 18px; padding: 2rem;
            width: 100%; max-width: 410px;
            box-shadow: 0 24px 64px rgba(0,0,0,.22);
            animation: modalIn .2s ease;
        }
        @keyframes modalIn { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
        .modal-head-icon { width: 50px; height: 50px; border-radius: 13px; display: grid; place-items: center; font-size: 1.35rem; margin-bottom: 1rem; background: #eff6ff; color: var(--primary); }
        .modal-title { font-size: 1.1rem; font-weight: 800; color: var(--text-main); margin-bottom: .3rem; }
        .modal-desc  { font-size: .8rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1.25rem; }

        /* Role selector cards */
        .role-cards { display: flex; flex-direction: column; gap: .55rem; }
        .role-card {
            display: flex; align-items: center; gap: .8rem;
            border: 2px solid var(--border); border-radius: 10px;
            padding: .7rem .9rem; cursor: pointer;
            transition: border-color .15s, background .15s;
        }
        .role-card:hover { border-color: #94a3b8; background: #f8fafc; }
        .role-card.selected-viewer     { border-color: var(--primary); background: #eff6ff; }
        .role-card.selected-admin      { border-color: #2563eb;        background: #eff6ff; }
        .role-card.selected-superadmin { border-color: #dc2626;        background: #fef2f2; }
        .rc-icon { width: 36px; height: 36px; border-radius: 9px; display: grid; place-items: center; font-size: .95rem; flex-shrink: 0; }
        .rc-body { flex: 1; min-width: 0; }
        .rc-name { font-size: .84rem; font-weight: 700; color: var(--text-main); display: flex; align-items: center; gap: .4rem; flex-wrap: wrap; }
        .rc-desc { font-size: .71rem; color: var(--text-muted); margin-top: .1rem; }
        .rc-check { width: 20px; height: 20px; border-radius: 50%; border: 2px solid var(--border); display: grid; place-items: center; flex-shrink: 0; font-size: .65rem; color: transparent; transition: all .15s; }
        .role-card.selected-viewer     .rc-check { background: var(--primary); border-color: var(--primary); color: #fff; }
        .role-card.selected-admin      .rc-check { background: #2563eb; border-color: #2563eb; color: #fff; }
        .role-card.selected-superadmin .rc-check { background: #dc2626; border-color: #dc2626; color: #fff; }
        .lock-badge { font-size: .63rem; background: #fef9c3; color: #92400e; padding: .1rem .45rem; border-radius: 20px; font-weight: 700; white-space: nowrap; }

        /* Invite code dalam modal */
        .modal-code-section { margin-top: .9rem; padding: .9rem; background: #f8fafc; border: 1px solid var(--border); border-radius: 10px; display: none; }
        .modal-code-section.show { display: block; }
        .modal-code-label { font-size: .75rem; font-weight: 700; color: var(--text-main); margin-bottom: .5rem; display: flex; align-items: center; gap: .35rem; }
        .modal-code-label span { font-weight: 400; color: var(--text-muted); }

        .modal-actions { display: flex; gap: .6rem; margin-top: 1.25rem; }
        .btn-modal-cancel { flex: 1; background: #f1f5f9; color: var(--text-main); border: none; padding: .65rem; border-radius: 8px; font-size: .875rem; font-weight: 600; font-family: inherit; cursor: pointer; transition: background .15s; }
        .btn-modal-cancel:hover { background: #e2e8f0; }
        .btn-modal-ok { flex: 2; background: var(--primary); color: #fff; border: none; padding: .65rem; border-radius: 8px; font-size: .875rem; font-weight: 700; font-family: inherit; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: .4rem; transition: background .15s; }
        .btn-modal-ok:hover    { background: var(--primary-lt); }
        .btn-modal-ok:disabled { opacity: .55; cursor: not-allowed; }

        @media (max-width: 480px) { .row-2 { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<div class="bg-shapes">
    <div class="bg-shape bg-shape-1"></div>
    <div class="bg-shape bg-shape-2"></div>
</div>

<div class="auth-wrapper">
    <a href="#" class="auth-logo">
        <div class="logo-icon"><i class="bi bi-box-seam-fill"></i></div>
        <div>
            <div class="logo-text">InvenTrack</div>
            <div class="logo-sub">Inventory Management System</div>
        </div>
    </a>

    <div class="auth-card">

        {{-- ══ FORM REGISTER ══ --}}
        <div id="registerSection">
            <h1 class="auth-title">Buat akun baru ✨</h1>
            <p class="auth-subtitle">Isi data di bawah untuk mulai mengelola inventaris Anda.</p>

            <div id="firebaseAlert" class="alert alert-danger" style="display:none">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span id="firebaseAlertMsg">Terjadi kesalahan.</span>
            </div>

            <button class="btn-google" id="btnGoogle" type="button">
                <svg class="google-icon" viewBox="0 0 48 48">
                    <path fill="#FFC107" d="M43.6 20.1H42V20H24v8h11.3C33.7 32.6 29.3 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.8 1.2 7.9 3l5.7-5.7C34.1 6.5 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.7-.4-3.9z"/>
                    <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.5 16 19 12 24 12c3.1 0 5.8 1.2 7.9 3l5.7-5.7C34.1 6.5 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/>
                    <path fill="#4CAF50" d="M24 44c5.2 0 9.9-2 13.4-5.1l-6.2-5.2C29.3 35.3 26.8 36 24 36c-5.2 0-9.7-3.3-11.3-8H6.3C9.7 36 16.3 44 24 44z"/>
                    <path fill="#1976D2" d="M43.6 20.1H42V20H24v8h11.3c-.8 2.3-2.3 4.2-4.3 5.5l6.2 5.2C40.3 36.3 44 30.6 44 24c0-1.3-.1-2.7-.4-3.9z"/>
                </svg>
                Daftar dengan Google
            </button>

            <div class="divider">atau daftar dengan email</div>

            <form id="registerForm" novalidate>
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <div class="input-wrap">
                        <i class="bi bi-person-fill input-icon"></i>
                        <input type="text" id="displayName" class="form-input" placeholder="Nama lengkap Anda" autocomplete="name">
                    </div>
                    <div class="field-error" id="nameError">Nama wajib diisi.</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Alamat Email</label>
                    <div class="input-wrap">
                        <i class="bi bi-envelope-fill input-icon"></i>
                        <input type="email" id="email" class="form-input" placeholder="nama@email.com" autocomplete="email">
                    </div>
                    <div class="field-error" id="emailError">Email tidak valid.</div>
                </div>

                <div class="row-2">
                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label">Password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" id="password" class="form-input" placeholder="Min. 8 karakter" autocomplete="new-password" oninput="checkPasswordStrength(this.value)">
                            <button type="button" class="btn-eye" id="togglePassword">
                                <i class="bi bi-eye-slash-fill" id="eyeIcon1"></i>
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                            <div class="strength-text" id="strengthText">—</div>
                        </div>
                        <div class="field-error" id="passwordError">Password min. 8 karakter.</div>
                    </div>
                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label">Konfirmasi Password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" id="confirmPassword" class="form-input" placeholder="Ulangi password" autocomplete="new-password">
                            <button type="button" class="btn-eye" id="toggleConfirm">
                                <i class="bi bi-eye-slash-fill" id="eyeIcon2"></i>
                            </button>
                        </div>
                        <div class="field-error" id="confirmError">Password tidak cocok.</div>
                    </div>
                </div>

                <div class="form-group" style="margin-top:1.1rem">
                    <label class="form-label">
                        Kode Undangan
                        <span style="font-weight:400;color:var(--text-muted)">(opsional)</span>
                    </label>
                    <div class="input-wrap">
                        <i class="bi bi-key-fill input-icon"></i>
                        <input type="text" id="inviteCode" class="form-input"
                               placeholder="Masukkan kode jika punya"
                               autocomplete="off" oninput="checkInviteCode(this.value)"
                               style="text-transform:uppercase;letter-spacing:.5px;font-family:'DM Mono',monospace">
                    </div>
                    <div class="invite-hint hint-none" id="inviteHint">
                        <i class="bi bi-info-circle"></i>
                        Tanpa kode → role <span class="role-preview viewer"><i class="bi bi-eye-fill"></i> viewer</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="checkbox-wrap">
                        <input type="checkbox" id="agreeTerms">
                        <span class="checkbox-label">
                            Saya setuju dengan <a href="#">Syarat & Ketentuan</a> dan
                            <a href="#">Kebijakan Privasi</a> InvenTrack.
                        </span>
                    </label>
                    <div class="field-error" id="termsError">Anda harus menyetujui syarat & ketentuan.</div>
                </div>

                <button type="submit" class="btn-submit" id="btnRegister">
                    <div class="spinner-sm" id="registerSpinner"></div>
                    <span id="btnRegisterText"><i class="bi bi-person-plus-fill"></i> Buat Akun</span>
                </button>
            </form>
        </div>

        {{-- ══ VERIFIKASI EMAIL ══ --}}
        <div id="verifySection" style="display:none">
            <div class="verify-screen">
                <div class="verify-icon"><i class="bi bi-envelope-check-fill"></i></div>
                <div class="verify-title">Cek email Anda! 📬</div>
                <div class="verify-desc">Kami telah mengirim link verifikasi ke:</div>
                <div class="verify-email-chip">
                    <i class="bi bi-envelope-fill" style="color:var(--primary)"></i>
                    <span id="verifyEmailDisplay">—</span>
                </div>
                <div class="verify-desc" style="font-size:.78rem">
                    Buka email Anda dan klik link verifikasi, lalu kembali ke sini untuk login.
                    Link berlaku selama <strong>24 jam</strong>.
                </div>
                <div id="verifyAlert" class="alert alert-info" style="display:none;text-align:left">
                    <i class="bi bi-info-circle-fill"></i>
                    <span id="verifyAlertMsg"></span>
                </div>
                <button class="btn-outline" id="btnResend" type="button">
                    <i class="bi bi-arrow-clockwise"></i> Kirim Ulang Email Verifikasi
                </button>
                <a href="{{ route('login') }}" class="btn-submit" style="text-decoration:none;margin-top:.5rem">
                    <i class="bi bi-box-arrow-in-right"></i> Ke Halaman Login
                </a>
                <div style="margin-top:1.25rem;font-size:.75rem;color:var(--text-muted)">
                    Tidak menerima email? Periksa folder <strong>Spam/Junk</strong> Anda.
                </div>
            </div>
        </div>

    </div>

    <div class="auth-footer">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>
</div>

{{-- ══ MODAL PILIH ROLE (hanya untuk Google Register user baru) ══ --}}
<div id="roleModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-head-icon"><i class="bi bi-person-badge-fill"></i></div>
        <div class="modal-title">Halo, <span id="modalUserName">—</span>! 🎉</div>
        <div class="modal-desc">
            Pilih role Anda. Role <strong>admin</strong> dan <strong>superadmin</strong> memerlukan kode undangan yang valid.
        </div>

        <div class="role-cards">

            {{-- Viewer --}}
            <div class="role-card selected-viewer" data-role="viewer" id="card-viewer" onclick="selectRole('viewer')">
                <div class="rc-icon" style="background:#f1f5f9;color:#475569"><i class="bi bi-eye-fill"></i></div>
                <div class="rc-body">
                    <div class="rc-name">Viewer</div>
                    <div class="rc-desc">Hanya dapat melihat dashboard & laporan stok</div>
                </div>
                <div class="rc-check"><i class="bi bi-check2"></i></div>
            </div>

            {{-- Admin --}}
            <div class="role-card" data-role="admin" id="card-admin" onclick="selectRole('admin')">
                <div class="rc-icon" style="background:#dbeafe;color:#1e40af"><i class="bi bi-person-gear"></i></div>
                <div class="rc-body">
                    <div class="rc-name">
                        Admin
                        <span class="lock-badge"><i class="bi bi-key-fill"></i> butuh kode</span>
                    </div>
                    <div class="rc-desc">CRUD produk, dashboard & laporan stok</div>
                </div>
                <div class="rc-check"><i class="bi bi-check2"></i></div>
            </div>

            {{-- Superadmin --}}
            <div class="role-card" data-role="superadmin" id="card-superadmin" onclick="selectRole('superadmin')">
                <div class="rc-icon" style="background:#fee2e2;color:#991b1b"><i class="bi bi-shield-fill-check"></i></div>
                <div class="rc-body">
                    <div class="rc-name">
                        Super Admin
                        <span class="lock-badge"><i class="bi bi-key-fill"></i> butuh kode</span>
                    </div>
                    <div class="rc-desc">Akses penuh termasuk manajemen user & pengaturan</div>
                </div>
                <div class="rc-check"><i class="bi bi-check2"></i></div>
            </div>

        </div>

        {{-- Field kode undangan — muncul saat pilih admin/superadmin --}}
        <div class="modal-code-section" id="modalCodeSection">
            <div class="modal-code-label">
                <i class="bi bi-key-fill" style="color:var(--accent)"></i>
                Kode Undangan <span id="modalCodeLabelRole">(wajib untuk role ini)</span>
            </div>
            <div class="input-wrap">
                <i class="bi bi-key-fill input-icon"></i>
                <input type="text" id="modalInviteCode" class="form-input"
                       placeholder="Masukkan kode undangan"
                       autocomplete="off"
                       oninput="onModalCodeInput(this.value)"
                       style="text-transform:uppercase;letter-spacing:.5px;font-family:'DM Mono',monospace">
            </div>
            <div class="invite-hint hint-none" id="modalInviteHint" style="margin-top:.35rem">
                <i class="bi bi-info-circle"></i> Masukkan kode untuk melanjutkan.
            </div>
        </div>

        <div class="modal-actions">
            <button class="btn-modal-cancel" id="btnModalCancel">Batal</button>
            <button class="btn-modal-ok" id="btnModalOk">
                <i class="bi bi-arrow-right-circle-fill"></i> Lanjut & Masuk
            </button>
        </div>
    </div>
</div>

<script type="module">
    import { initializeApp }                         from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
    import { getAuth, signInWithEmailAndPassword,
         signInWithPopup, GoogleAuthProvider,
         sendEmailVerification }    from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
    import { getDatabase, ref, set, get }             from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

    const firebaseConfig = {
        apiKey:            "{{ env('FIREBASE_API_KEY') }}",
        authDomain:        "{{ env('FIREBASE_AUTH_DOMAIN') }}",
        databaseURL:       "{{ env('FIREBASE_DATABASE_URL') }}",
        projectId:         "{{ env('FIREBASE_PROJECT_ID') }}",
        storageBucket:     "{{ env('FIREBASE_STORAGE_BUCKET') }}",
        messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
        appId:             "{{ env('FIREBASE_APP_ID') }}",
    };

    const app      = initializeApp(firebaseConfig);
    const auth     = getAuth(app);
    const db       = getDatabase(app);
    const provider = new GoogleAuthProvider();

    // ══════════════════════════════════════════
    // KODE UNDANGAN → ROLE
    // Tambah/ubah kode di sini sesuai kebutuhan
    // ══════════════════════════════════════════
    const INVITE_CODES = {
        'ADMIN2024': 'admin',
        'SUPER999':  'superadmin',
    };

    function getRoleFromCode(code) {
        if (!code) return null;
        return INVITE_CODES[code.trim().toUpperCase()] || null;
    }

    // ══════════════════════════════════════════
    // STATE MODAL
    // ══════════════════════════════════════════
    let _googleUser    = null;
    let _selectedRole  = 'viewer';
    let _codeUnlocked  = false;   // true jika kode sudah divalidasi untuk role terpilih

    // ── Pilih role card ──
    window.selectRole = function(role) {
        _selectedRole = role;
        _codeUnlocked = false;

        // Update highlight card
        ['viewer','admin','superadmin'].forEach(r => {
            const card = document.getElementById(`card-${r}`);
            card.className = 'role-card'; // reset
            if (r === role) card.classList.add(`selected-${role}`);
        });

        const needsCode = (role === 'admin' || role === 'superadmin');
        const section   = document.getElementById('modalCodeSection');

        if (needsCode) {
            section.classList.add('show');
            document.getElementById('modalCodeLabelRole').textContent = `(wajib untuk ${role})`;
            // Reset field kode
            const input = document.getElementById('modalInviteCode');
            input.value = '';
            input.classList.remove('is-success', 'is-error');
            document.getElementById('modalInviteHint').className = 'invite-hint hint-none';
            document.getElementById('modalInviteHint').innerHTML =
                `<i class="bi bi-info-circle"></i> Masukkan kode untuk melanjutkan sebagai <strong>${role}</strong>.`;
            input.focus();
        } else {
            section.classList.remove('show');
        }

        updateOkButton();
    };

    // ── Validasi kode saat diketik di modal ──
    window.onModalCodeInput = function(val) {
        const code  = val.trim().toUpperCase();
        const hint  = document.getElementById('modalInviteHint');
        const input = document.getElementById('modalInviteCode');
        const roleIcons = { admin: 'bi-person-gear', superadmin: 'bi-shield-fill-check' };

        if (!code) {
            hint.className = 'invite-hint hint-none';
            hint.innerHTML = `<i class="bi bi-info-circle"></i> Masukkan kode untuk melanjutkan sebagai <strong>${_selectedRole}</strong>.`;
            input.classList.remove('is-success', 'is-error');
            _codeUnlocked = false;
            updateOkButton();
            return;
        }

        const roleFromCode = getRoleFromCode(code);

        if (roleFromCode === _selectedRole) {
            hint.className = 'invite-hint hint-valid';
            hint.innerHTML = `<i class="bi bi-check-circle-fill"></i> Kode valid! Role <span class="role-preview ${roleFromCode}"><i class="bi ${roleIcons[roleFromCode]}"></i> ${roleFromCode}</span> aktif.`;
            input.classList.add('is-success');
            input.classList.remove('is-error');
            _codeUnlocked = true;
        } else if (roleFromCode && roleFromCode !== _selectedRole) {
            hint.className = 'invite-hint hint-invalid';
            hint.innerHTML = `<i class="bi bi-x-circle-fill"></i> Kode ini untuk role <strong>${roleFromCode}</strong>, bukan <strong>${_selectedRole}</strong>.`;
            input.classList.add('is-error');
            input.classList.remove('is-success');
            _codeUnlocked = false;
        } else {
            hint.className = 'invite-hint hint-invalid';
            hint.innerHTML = `<i class="bi bi-x-circle-fill"></i> Kode tidak valid.`;
            input.classList.add('is-error');
            input.classList.remove('is-success');
            _codeUnlocked = false;
        }

        updateOkButton();
    };

    function updateOkButton() {
        const btn       = document.getElementById('btnModalOk');
        const needsCode = (_selectedRole === 'admin' || _selectedRole === 'superadmin');
        btn.disabled    = needsCode && !_codeUnlocked;
    }

    // ── Cek kode undangan di form email/password ──
    window.checkInviteCode = function(val) {
        const hint  = document.getElementById('inviteHint');
        const input = document.getElementById('inviteCode');
        const code  = val.trim().toUpperCase();
        const roleIcons = { admin: 'bi-person-gear', superadmin: 'bi-shield-fill-check' };

        if (!code) {
            hint.className = 'invite-hint hint-none';
            hint.innerHTML = `<i class="bi bi-info-circle"></i> Tanpa kode → role <span class="role-preview viewer"><i class="bi bi-eye-fill"></i> viewer</span>`;
            input.classList.remove('is-success', 'is-error');
            return;
        }
        const role = getRoleFromCode(code);
        if (role) {
            hint.className = 'invite-hint hint-valid';
            hint.innerHTML = `<i class="bi bi-check-circle-fill"></i> Kode valid → role <span class="role-preview ${role}"><i class="bi ${roleIcons[role]}"></i> ${role}</span>`;
            input.classList.add('is-success');
            input.classList.remove('is-error');
        } else {
            hint.className = 'invite-hint hint-invalid';
            hint.innerHTML = `<i class="bi bi-x-circle-fill"></i> Kode tidak valid → akan didaftarkan sebagai <span class="role-preview viewer"><i class="bi bi-eye-fill"></i> viewer</span>`;
            input.classList.add('is-error');
            input.classList.remove('is-success');
        }
    };

    // ── Helpers ──
    function showError(msg) {
        const el = document.getElementById('firebaseAlert');
        document.getElementById('firebaseAlertMsg').textContent = msg;
        el.style.display = 'flex';
        el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function setLoading(loading) {
        const btn     = document.getElementById('btnRegister');
        const spinner = document.getElementById('registerSpinner');
        const text    = document.getElementById('btnRegisterText');
        btn.disabled          = loading;
        spinner.style.display = loading ? 'block' : 'none';
        text.style.display    = loading ? 'none'  : 'flex';
    }

    function showVerifyScreen(email) {
        document.getElementById('registerSection').style.display = 'none';
        document.getElementById('verifySection').style.display   = 'block';
        document.getElementById('verifyEmailDisplay').textContent = email;
    }

    async function saveUserToDb(uid, email, displayName, role) {
        await set(ref(db, `users/${uid}`), {
            email:          email,
            display_name:   displayName || email,
            role:           role,
            email_verified: false,
            created_at:     new Date().toISOString(),
        });
    }

    async function sendVerificationEmail(uid, email, name) {
        const res = await fetch("{{ route('auth.send-verification') }}", {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept':       'application/json',
            },
            body: JSON.stringify({ uid, email, name }),
        });
        return res.ok;
    }

    // ── Password strength ──
    window.checkPasswordStrength = function(password) {
        const fill = document.getElementById('strengthFill');
        const text = document.getElementById('strengthText');
        let score = 0;
        if (password.length >= 8)          score++;
        if (/[A-Z]/.test(password))        score++;
        if (/[0-9]/.test(password))        score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;
        const levels = [
            { width: '0%',   bg: '',        label: '—' },
            { width: '25%',  bg: '#ef4444', label: 'Lemah' },
            { width: '50%',  bg: '#f97316', label: 'Cukup' },
            { width: '75%',  bg: '#eab308', label: 'Baik' },
            { width: '100%', bg: '#22c55e', label: 'Kuat 💪' },
        ];
        const lv = levels[score];
        fill.style.width      = lv.width;
        fill.style.background = lv.bg;
        text.textContent      = lv.label;
        text.style.color      = lv.bg || 'var(--text-muted)';
    };

    // ══════════════════════════════════════════
    // REGISTER Email/Password
    // ══════════════════════════════════════════
    document.getElementById('registerForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        document.getElementById('firebaseAlert').style.display = 'none';

        const name    = document.getElementById('displayName').value.trim();
        const email   = document.getElementById('email').value.trim();
        const pwd     = document.getElementById('password').value;
        const confPwd = document.getElementById('confirmPassword').value;
        const agreed  = document.getElementById('agreeTerms').checked;
        const code    = document.getElementById('inviteCode').value.trim();
        let valid = true;

        if (!name) { document.getElementById('nameError').classList.add('show');     valid = false; }
        else          document.getElementById('nameError').classList.remove('show');
        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            document.getElementById('emailError').classList.add('show');  valid = false;
        } else document.getElementById('emailError').classList.remove('show');
        if (pwd.length < 8) { document.getElementById('passwordError').classList.add('show'); valid = false; }
        else                   document.getElementById('passwordError').classList.remove('show');
        if (pwd !== confPwd) { document.getElementById('confirmError').classList.add('show'); valid = false; }
        else                   document.getElementById('confirmError').classList.remove('show');
        if (!agreed) { document.getElementById('termsError').classList.add('show'); valid = false; }
        else           document.getElementById('termsError').classList.remove('show');

        if (!valid) return;
        setLoading(true);

        try {
            const role = getRoleFromCode(code) || 'viewer';
            const cred = await createUserWithEmailAndPassword(auth, email, pwd);
            await updateProfile(cred.user, { displayName: name });
            await sendEmailVerification(cred.user, {
                url: `${window.location.origin}/auth/email-verified`,
                handleCodeInApp: false,
            });
            await saveUserToDb(cred.user.uid, email, name, role);
            setLoading(false);
            showVerifyScreen(email);
        } catch (err) {
            setLoading(false);
            const map = {
                'auth/email-already-in-use':   'Email sudah terdaftar. Silakan login.',
                'auth/invalid-email':          'Format email tidak valid.',
                'auth/weak-password':          'Password terlalu lemah.',
                'auth/network-request-failed': 'Koneksi gagal. Periksa internet Anda.',
            };
            showError(map[err.code] || `Error: ${err.message}`);
        }
    });

    // ══════════════════════════════════════════
    // REGISTER Google
    // ══════════════════════════════════════════
    document.getElementById('btnGoogle').addEventListener('click', async () => {
        document.getElementById('firebaseAlert').style.display = 'none';
        try {
            const result = await signInWithPopup(auth, provider);
            const user   = result.user;
            const snap   = await get(ref(db, `users/${user.uid}`));

            if (snap.exists()) {
                // User LAMA → langsung masuk
                const role = snap.val().role || 'viewer';
                await storeSessionAndRedirect(user.uid, user.email, user.displayName, role);
            } else {
                // User BARU → tampilkan modal pilih role
                _googleUser   = user;
                _selectedRole = 'viewer';
                _codeUnlocked = false;

                document.getElementById('modalUserName').textContent = user.displayName || user.email;

                ['viewer','admin','superadmin'].forEach(r => {
                    document.getElementById(`card-${r}`).className = 'role-card';
                });
                document.getElementById('card-viewer').classList.add('selected-viewer');
                document.getElementById('modalCodeSection').classList.remove('show');
                document.getElementById('modalInviteCode').value = '';
                document.getElementById('modalInviteCode').classList.remove('is-success', 'is-error');
                updateOkButton();

                document.getElementById('roleModal').classList.add('open');
            }
        } catch (err) {
            if (err.code !== 'auth/popup-closed-by-user') {
                showError(`Login Google gagal: ${err.message}`);
            }
        }
    });

    // ── Modal: Lanjut & Masuk ──
    document.getElementById('btnModalOk').addEventListener('click', async () => {
        if (!_googleUser) return;
        const finalRole = _selectedRole;

        document.getElementById('btnModalOk').disabled = true;
        document.getElementById('roleModal').classList.remove('open');

        try {
            await saveUserToDb(_googleUser.uid, _googleUser.email, _googleUser.displayName, finalRole);
            const ok = await sendVerificationEmail(_googleUser.uid, _googleUser.email, _googleUser.displayName);
            if (!ok) throw new Error('Gagal kirim email');
            showVerifyScreen(_googleUser.email);
        } catch (err) {
            showError('Gagal menyimpan data atau mengirim email verifikasi. Coba lagi.');
            document.getElementById('btnModalOk').disabled = false;
            document.getElementById('roleModal').classList.add('open');
        }
    });

    // ── Modal: Batal ──
    document.getElementById('btnModalCancel').addEventListener('click', () => {
        document.getElementById('roleModal').classList.remove('open');
        _googleUser   = null;
        _selectedRole = 'viewer';
        _codeUnlocked = false;
    });

    // ── Kirim ulang verifikasi ──
    let resendCooldown = false;
    document.getElementById('btnResend').addEventListener('click', async () => {
        if (resendCooldown) return;
        const user = auth.currentUser;
        if (!user) return;
        try {
            await sendEmailVerification(user);
            resendCooldown = true;
            const btn = document.getElementById('btnResend');
            btn.disabled  = true;
            let secs = 60;
            const interval = setInterval(() => {
                btn.innerHTML = `<i class="bi bi-clock"></i> Kirim ulang dalam ${secs}s`;
                secs--;
                if (secs < 0) {
                    clearInterval(interval);
                    btn.disabled  = false;
                    btn.innerHTML = `<i class="bi bi-arrow-clockwise"></i> Kirim Ulang Email Verifikasi`;
                    resendCooldown = false;
                }
            }, 1000);
            const alertEl = document.getElementById('verifyAlert');
            document.getElementById('verifyAlertMsg').textContent = 'Email verifikasi berhasil dikirim ulang!';
            alertEl.className     = 'alert alert-success';
            alertEl.style.display = 'flex';
            setTimeout(() => alertEl.style.display = 'none', 4000);
        } catch (err) {
            const alertEl = document.getElementById('verifyAlert');
            document.getElementById('verifyAlertMsg').textContent = `Gagal kirim ulang: ${err.message}`;
            alertEl.className     = 'alert alert-danger';
            alertEl.style.display = 'flex';
        }
    });

    // ── Toggle password ──
    document.getElementById('togglePassword').addEventListener('click', () => {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eyeIcon1');
        input.type     = input.type === 'password' ? 'text' : 'password';
        icon.className = input.type === 'password' ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
    });
    document.getElementById('toggleConfirm').addEventListener('click', () => {
        const input = document.getElementById('confirmPassword');
        const icon  = document.getElementById('eyeIcon2');
        input.type     = input.type === 'password' ? 'text' : 'password';
        icon.className = input.type === 'password' ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
    });
</script>
</body>
</html>
