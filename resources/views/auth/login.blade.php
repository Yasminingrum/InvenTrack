<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — InvenTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#0f4c81;--primary-lt:#1a6bbf;--accent:#f97316;--surface:#f0f4f8;--card-bg:#ffffff;--border:#e2e8f0;--text-main:#0f172a;--text-muted:#64748b;--danger:#ef4444; }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--surface);min-height:100vh;display:flex;align-items:center;justify-content:center;position:relative;overflow-x:hidden;padding:2rem 0;}
        body::before{content:'';position:fixed;inset:0;background:radial-gradient(circle at 20% 20%,rgba(15,76,129,.08) 0%,transparent 50%),radial-gradient(circle at 80% 80%,rgba(249,115,22,.06) 0%,transparent 50%);pointer-events:none;}
        .bg-shapes{position:fixed;inset:0;pointer-events:none;overflow:hidden;z-index:0;}
        .bg-shape{position:absolute;border-radius:50%;opacity:.07;}
        .bg-shape-1{width:500px;height:500px;background:var(--primary);top:-200px;left:-200px;}
        .bg-shape-2{width:300px;height:300px;background:var(--accent);bottom:-100px;right:-100px;}
        .bg-shape-3{width:200px;height:200px;background:var(--primary-lt);top:50%;right:10%;opacity:.05;}
        .auth-wrapper{position:relative;z-index:10;width:100%;max-width:440px;padding:1.5rem;}
        .auth-logo{display:flex;align-items:center;justify-content:center;gap:.75rem;margin-bottom:1.75rem;text-decoration:none;}
        .logo-icon{width:46px;height:46px;background:var(--accent);border-radius:12px;display:grid;place-items:center;font-size:1.3rem;color:#fff;box-shadow:0 4px 14px rgba(249,115,22,.35);}
        .logo-text{font-size:1.5rem;font-weight:800;color:var(--primary);letter-spacing:-.5px;}
        .logo-sub{font-size:.65rem;color:var(--text-muted);letter-spacing:.5px;text-transform:uppercase;line-height:1;}
        .auth-card{background:var(--card-bg);border:1px solid var(--border);border-radius:18px;box-shadow:0 8px 40px rgba(0,0,0,.1);padding:2.25rem;}
        .auth-title{font-size:1.35rem;font-weight:800;color:var(--text-main);margin-bottom:.25rem;}
        .auth-subtitle{font-size:.82rem;color:var(--text-muted);margin-bottom:1.75rem;}
        .divider{display:flex;align-items:center;gap:.75rem;margin:1.25rem 0;color:var(--text-muted);font-size:.75rem;font-weight:600;}
        .divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border);}
        .form-group{margin-bottom:1.1rem;}
        .form-label{display:block;font-size:.78rem;font-weight:700;color:var(--text-main);margin-bottom:.4rem;}
        .input-wrap{position:relative;}
        .input-icon{position:absolute;left:.85rem;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:.95rem;pointer-events:none;}
        .form-input{width:100%;border:1.5px solid var(--border);border-radius:9px;padding:.65rem .85rem .65rem 2.5rem;font-size:.875rem;font-family:inherit;color:var(--text-main);background:#fafcff;transition:border-color .15s,box-shadow .15s;outline:none;}
        .form-input:focus{border-color:var(--primary-lt);box-shadow:0 0 0 3px rgba(26,107,191,.12);background:#fff;}
        .form-input.is-error{border-color:var(--danger);}
        .btn-eye{position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);padding:.2rem;font-size:.95rem;}
        .btn-eye:hover{color:var(--text-main);}
        .btn-submit{width:100%;background:var(--primary);color:#fff;border:none;padding:.75rem 1.25rem;border-radius:9px;font-size:.9rem;font-weight:700;font-family:inherit;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.5rem;transition:background .15s;box-shadow:0 4px 14px rgba(15,76,129,.25);margin-top:1.5rem;}
        .btn-submit:hover{background:var(--primary-lt);}
        .btn-submit:disabled{opacity:.7;cursor:not-allowed;}
        .btn-google{width:100%;background:#fff;color:var(--text-main);border:1.5px solid var(--border);padding:.65rem 1.25rem;border-radius:9px;font-size:.875rem;font-weight:600;font-family:inherit;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.6rem;transition:background .15s,box-shadow .15s;}
        .btn-google:hover{background:#f8fafc;box-shadow:0 2px 8px rgba(0,0,0,.07);}
        .google-icon{width:18px;height:18px;}
        .alert{padding:.75rem 1rem;border-radius:8px;font-size:.825rem;font-weight:500;display:flex;align-items:flex-start;gap:.55rem;margin-bottom:1.1rem;}
        .alert-success{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
        .alert-danger{background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;}
        .alert-warning{background:#fffbeb;color:#92400e;border:1px solid #fde68a;}
        .alert i{flex-shrink:0;margin-top:.1rem;}
        .auth-footer{text-align:center;margin-top:1.5rem;font-size:.82rem;color:var(--text-muted);}
        .auth-footer a{color:var(--primary);font-weight:700;text-decoration:none;}
        .spinner-sm{width:18px;height:18px;border:2px solid rgba(255,255,255,.35);border-top-color:#fff;border-radius:50%;animation:spin .6s linear infinite;display:none;}
        @keyframes spin{to{transform:rotate(360deg);}}
        .field-error{font-size:.73rem;color:var(--danger);margin-top:.3rem;display:none;}
        .field-error.show{display:block;}
        #resendLink{color:#92400e;font-weight:700;cursor:pointer;text-decoration:underline;}
        #resendLink:hover{color:#78350f;}
    </style>
</head>
<body>
<div class="bg-shapes">
    <div class="bg-shape bg-shape-1"></div>
    <div class="bg-shape bg-shape-2"></div>
    <div class="bg-shape bg-shape-3"></div>
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
        <h1 class="auth-title">Selamat datang kembali 👋</h1>
        <p class="auth-subtitle">Masuk ke akun Anda untuk mengelola inventaris.</p>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
            </div>
        @endif

        <div id="firebaseAlert" class="alert alert-danger" style="display:none">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span id="firebaseAlertMsg">Terjadi kesalahan.</span>
        </div>

        {{-- Muncul jika email belum diverifikasi --}}
        <div id="verifyWarning" class="alert alert-warning" style="display:none">
            <i class="bi bi-envelope-exclamation-fill"></i>
            <div>
                Email Anda belum diverifikasi. Silakan cek inbox Anda.
                <br><span id="resendLink">Kirim ulang email verifikasi</span>
            </div>
        </div>

        <button class="btn-google" id="btnGoogle" type="button">
            <svg class="google-icon" viewBox="0 0 48 48">
                <path fill="#FFC107" d="M43.6 20.1H42V20H24v8h11.3C33.7 32.6 29.3 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.8 1.2 7.9 3l5.7-5.7C34.1 6.5 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.7-.4-3.9z"/>
                <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.5 16 19 12 24 12c3.1 0 5.8 1.2 7.9 3l5.7-5.7C34.1 6.5 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/>
                <path fill="#4CAF50" d="M24 44c5.2 0 9.9-2 13.4-5.1l-6.2-5.2C29.3 35.3 26.8 36 24 36c-5.2 0-9.7-3.3-11.3-8H6.3C9.7 36 16.3 44 24 44z"/>
                <path fill="#1976D2" d="M43.6 20.1H42V20H24v8h11.3c-.8 2.3-2.3 4.2-4.3 5.5l6.2 5.2C40.3 36.3 44 30.6 44 24c0-1.3-.1-2.7-.4-3.9z"/>
            </svg>
            Lanjutkan dengan Google
        </button>

        <div class="divider">atau masuk dengan email</div>

        <form id="loginForm" novalidate>
            <div class="form-group">
                <label class="form-label">Alamat Email</label>
                <div class="input-wrap">
                    <i class="bi bi-envelope-fill input-icon"></i>
                    <input type="email" id="email" class="form-input" placeholder="nama@email.com" autocomplete="email">
                </div>
                <div class="field-error" id="emailError">Email tidak valid.</div>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrap">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input type="password" id="password" class="form-input" placeholder="Masukkan password" autocomplete="current-password">
                    <button type="button" class="btn-eye" id="togglePassword">
                        <i class="bi bi-eye-slash-fill" id="eyeIcon"></i>
                    </button>
                </div>
                <div class="field-error" id="passwordError">Password wajib diisi.</div>
            </div>
            <button type="submit" class="btn-submit" id="btnLogin">
                <div class="spinner-sm" id="loginSpinner"></div>
                <span id="btnLoginText"><i class="bi bi-box-arrow-in-right"></i> Masuk</span>
            </button>
        </form>
    </div>

    <div class="auth-footer">
        Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
    </div>
</div>

<script type="module">
    import { initializeApp }       from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
    import { getAuth, signInWithEmailAndPassword,
             signInWithPopup, GoogleAuthProvider,
             sendEmailVerification } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
    import { getDatabase, ref, get } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

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

    function showError(msg) {
        const el = document.getElementById('firebaseAlert');
        document.getElementById('firebaseAlertMsg').textContent = msg;
        el.style.display = 'flex';
        document.getElementById('verifyWarning').style.display = 'none';
    }

    function setLoading(loading) {
        const btn     = document.getElementById('btnLogin');
        const spinner = document.getElementById('loginSpinner');
        const text    = document.getElementById('btnLoginText');
        btn.disabled          = loading;
        spinner.style.display = loading ? 'block' : 'none';
        text.style.display    = loading ? 'none'  : 'flex';
    }

    async function storeSessionAndRedirect(user) {
        const snap = await get(ref(db, `users/${user.uid}`));

        // Tolak login jika belum registrasi
        if (!snap.exists()) {
            await user.delete().catch(() => {});  // hapus akun Firebase yang baru dibuat saat popup
            showError('Akun Google ini belum terdaftar. Silakan daftar terlebih dahulu.');
            setLoading(false);
            return;
        }

        const role = snap.val().role || 'viewer';
        const res  = await fetch("{{ route('auth.session') }}", {
            method:  'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body: JSON.stringify({ uid: user.uid, email: user.email, display_name: user.displayName || user.email, role }),
        });
        if (res.ok) {
            window.location.href = "{{ route('products.index') }}";
        } else {
            showError('Gagal menyimpan sesi. Coba lagi.');
            setLoading(false);
        }
    }

    // ── Email/Password Login ──
    document.getElementById('loginForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        document.getElementById('firebaseAlert').style.display  = 'none';
        document.getElementById('verifyWarning').style.display  = 'none';

        const email    = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        let valid = true;

        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            document.getElementById('emailError').classList.add('show');
            document.getElementById('email').classList.add('is-error');
            valid = false;
        } else {
            document.getElementById('emailError').classList.remove('show');
            document.getElementById('email').classList.remove('is-error');
        }
        if (!password) {
            document.getElementById('passwordError').classList.add('show');
            document.getElementById('password').classList.add('is-error');
            valid = false;
        } else {
            document.getElementById('passwordError').classList.remove('show');
            document.getElementById('password').classList.remove('is-error');
        }
        if (!valid) return;
        setLoading(true);

        try {
            const cred = await signInWithEmailAndPassword(auth, email, password);

            // Reload dari server Firebase agar emailVerified selalu fresh
            await cred.user.reload();
            const user = auth.currentUser;

            // Blokir login jika email belum diverifikasi
            if (!user.emailVerified) {
                setLoading(false);
                window._unverifiedUser = user;
                document.getElementById('verifyWarning').style.display = 'flex';
                return;
            }

            await storeSessionAndRedirect(user);

        } catch (err) {
            setLoading(false);
            const map = {
                'auth/user-not-found':         'Akun tidak ditemukan. Silakan daftar terlebih dahulu.',
                'auth/wrong-password':         'Password salah. Coba lagi.',
                'auth/invalid-email':          'Format email tidak valid.',
                'auth/invalid-credential':     'Email atau password salah.',
                'auth/too-many-requests':      'Terlalu banyak percobaan. Coba lagi nanti.',
                'auth/network-request-failed': 'Koneksi gagal. Periksa internet Anda.',
            };
            showError(map[err.code] || `Error: ${err.message}`);
        }
    });

    // ── Kirim ulang verifikasi ──
    document.getElementById('resendLink').addEventListener('click', async () => {
        const user = window._unverifiedUser;
        if (!user) return;
        try {
            await sendEmailVerification(user);
            document.getElementById('resendLink').textContent = '✓ Email terkirim! Cek inbox Anda.';
            document.getElementById('resendLink').style.pointerEvents = 'none';
        } catch (err) {
            document.getElementById('resendLink').textContent = 'Gagal kirim. Coba beberapa saat lagi.';
        }
    });

    // ── Google Sign-In ──
    document.getElementById('btnGoogle').addEventListener('click', async () => {
        document.getElementById('firebaseAlert').style.display = 'none';
        try {
            const result = await signInWithPopup(auth, provider);
            // Google user: emailVerified selalu true → langsung masuk
            await storeSessionAndRedirect(result.user);
        } catch (err) {
            if (err.code !== 'auth/popup-closed-by-user') {
                showError(`Login Google gagal: ${err.message}`);
            }
        }
    });

    // ── Toggle password ──
    document.getElementById('togglePassword').addEventListener('click', () => {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eyeIcon');
        input.type     = input.type === 'password' ? 'text' : 'password';
        icon.className = input.type === 'password' ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
    });

        // ── Tampilkan pesan sukses jika redirect dari verifikasi email ──
    if (new URLSearchParams(window.location.search).get('verified') === '1') {
        document.getElementById('firebaseAlert').style.display = 'none';
        const el = document.createElement('div');
        el.className = 'alert alert-success';
        el.innerHTML = '<i class="bi bi-check-circle-fill"></i> Email berhasil diverifikasi! Silakan login.';
        document.querySelector('.auth-card').prepend(el);
    }
</script>
</body>
</html>
