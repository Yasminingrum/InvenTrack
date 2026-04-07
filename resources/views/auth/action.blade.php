<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InvenTrack — Verifikasi Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#0f4c81; --accent:#f97316; --surface:#f0f4f8; --card-bg:#ffffff; --border:#e2e8f0; --text-main:#0f172a; --text-muted:#64748b; }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--surface); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        body::before { content: ''; position: fixed; inset: 0; background: radial-gradient(circle at 20% 20%, rgba(15,76,129,.08) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(249,115,22,.06) 0%, transparent 50%); pointer-events: none; }
        .card { position: relative; z-index: 10; background: var(--card-bg); border: 1px solid var(--border); border-radius: 18px; box-shadow: 0 8px 40px rgba(0,0,0,.1); padding: 2.5rem 2.25rem; width: 100%; max-width: 420px; margin: 1.5rem; text-align: center; }
        .logo { display: flex; align-items: center; justify-content: center; gap: .75rem; margin-bottom: 2rem; }
        .logo-icon { width: 46px; height: 46px; background: var(--accent); border-radius: 12px; display: grid; place-items: center; font-size: 1.3rem; color: #fff; box-shadow: 0 4px 14px rgba(249,115,22,.35); }
        .logo-text { font-size: 1.5rem; font-weight: 800; color: var(--primary); letter-spacing: -.5px; }
        .icon-wrap { width: 72px; height: 72px; border-radius: 50%; display: grid; place-items: center; font-size: 2rem; margin: 0 auto 1.25rem; }
        .icon-loading { background: #eff6ff; color: var(--primary); }
        .icon-success { background: #f0fdf4; color: #16a34a; }
        .icon-error   { background: #fef2f2; color: #dc2626; }
        .spin { animation: spin .8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        h2 { font-size: 1.2rem; font-weight: 800; color: var(--text-main); margin-bottom: .5rem; }
        p  { font-size: .85rem; color: var(--text-muted); line-height: 1.6; }
        .btn { display: inline-flex; align-items: center; gap: .5rem; margin-top: 1.5rem; background: var(--primary); color: #fff; border: none; padding: .7rem 1.5rem; border-radius: 9px; font-size: .875rem; font-weight: 700; font-family: inherit; cursor: pointer; text-decoration: none; box-shadow: 0 4px 14px rgba(15,76,129,.25); transition: background .15s; }
        .btn:hover { background: #1a6bbf; }
        #stateLoading, #stateSuccess, #stateError { display: none; }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">
        <div class="logo-icon"><i class="bi bi-box-seam-fill"></i></div>
        <div class="logo-text">InvenTrack</div>
    </div>

    {{-- State: Loading --}}
    <div id="stateLoading">
        <div class="icon-wrap icon-loading">
            <i class="bi bi-arrow-repeat spin"></i>
        </div>
        <h2>Memverifikasi email Anda...</h2>
        <p>Mohon tunggu sebentar.</p>
    </div>

    {{-- State: Sukses --}}
    <div id="stateSuccess">
        <div class="icon-wrap icon-success">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <h2>Email berhasil diverifikasi! 🎉</h2>
        <p>Akun Anda sudah aktif. Silakan login untuk mulai menggunakan InvenTrack.</p>
        <a href="{{ route('login') }}?verified=1" class="btn">
            <i class="bi bi-box-arrow-in-right"></i> Ke Halaman Login
        </a>
    </div>

    {{-- State: Error --}}
    <div id="stateError">
        <div class="icon-wrap icon-error">
            <i class="bi bi-x-circle-fill"></i>
        </div>
        <h2>Verifikasi gagal</h2>
        <p id="errorMsg">Link verifikasi tidak valid atau sudah kadaluarsa. Silakan minta link baru.</p>
        <a href="{{ route('login') }}" class="btn" style="background:#dc2626;box-shadow:0 4px 14px rgba(220,38,38,.25);">
            <i class="bi bi-arrow-left"></i> Kembali ke Login
        </a>
    </div>
</div>

<script type="module">
    import { initializeApp }             from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
    import { getAuth, applyActionCode }  from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

    const firebaseConfig = {
        apiKey:            "{{ env('FIREBASE_API_KEY') }}",
        authDomain:        "{{ env('FIREBASE_AUTH_DOMAIN') }}",
        databaseURL:       "{{ env('FIREBASE_DATABASE_URL') }}",
        projectId:         "{{ env('FIREBASE_PROJECT_ID') }}",
        storageBucket:     "{{ env('FIREBASE_STORAGE_BUCKET') }}",
        messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
        appId:             "{{ env('FIREBASE_APP_ID') }}",
    };

    const app  = initializeApp(firebaseConfig);
    const auth = getAuth(app);

    function show(state) {
        ['stateLoading', 'stateSuccess', 'stateError'].forEach(id => {
            document.getElementById(id).style.display = (id === state) ? 'block' : 'none';
        });
    }

    const params  = new URLSearchParams(window.location.search);
    const mode    = params.get('mode');
    const oobCode = params.get('oobCode');

    show('stateLoading');

    if (mode === 'verifyEmail' && oobCode) {
        try {
            await applyActionCode(auth, oobCode);
            show('stateSuccess');
        } catch (err) {
            const messages = {
                'auth/invalid-action-code': 'Link verifikasi tidak valid atau sudah pernah digunakan.',
                'auth/expired-action-code': 'Link verifikasi sudah kadaluarsa. Silakan minta link baru.',
                'auth/user-disabled':       'Akun ini telah dinonaktifkan.',
                'auth/user-not-found':      'Akun tidak ditemukan.',
            };
            document.getElementById('errorMsg').textContent = messages[err.code] || 'Terjadi kesalahan. Silakan coba lagi.';
            show('stateError');
        }
    } else {
        document.getElementById('errorMsg').textContent = 'Link tidak valid. Pastikan Anda menggunakan link dari email verifikasi.';
        show('stateError');
    }
</script>
</body>
</html>
