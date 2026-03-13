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
            background: var(--surface);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            padding: 2rem 0;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(circle at 20% 20%, rgba(15,76,129,.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(249,115,22,.06) 0%, transparent 50%);
            pointer-events: none;
        }

        .bg-shapes { position: fixed; inset: 0; pointer-events: none; overflow: hidden; z-index: 0; }
        .bg-shape { position: absolute; border-radius: 50%; opacity: .07; }
        .bg-shape-1 { width: 500px; height: 500px; background: var(--primary); top: -200px; left: -200px; }
        .bg-shape-2 { width: 300px; height: 300px; background: var(--accent);  bottom: -100px; right: -100px; }

        .auth-wrapper {
            position: relative; z-index: 10;
            width: 100%; max-width: 480px;
            padding: 1.5rem;
        }

        .auth-logo {
            display: flex; align-items: center; justify-content: center; gap: .75rem;
            margin-bottom: 1.75rem; text-decoration: none;
        }
        .logo-icon {
            width: 46px; height: 46px; background: var(--accent); border-radius: 12px;
            display: grid; place-items: center; font-size: 1.3rem; color: #fff;
            box-shadow: 0 4px 14px rgba(249,115,22,.35);
        }
        .logo-text { font-size: 1.5rem; font-weight: 800; color: var(--primary); letter-spacing: -.5px; }
        .logo-sub  { font-size: .65rem; color: var(--text-muted); letter-spacing: .5px; text-transform: uppercase; line-height: 1; }

        .auth-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: 0 8px 40px rgba(0,0,0,.1), 0 2px 8px rgba(0,0,0,.05);
            padding: 2.25rem;
        }

        .auth-title   { font-size: 1.35rem; font-weight: 800; color: var(--text-main); margin-bottom: .25rem; }
        .auth-subtitle { font-size: .82rem; color: var(--text-muted); margin-bottom: 1.75rem; }

        .divider {
            display: flex; align-items: center; gap: .75rem;
            margin: 1.25rem 0; color: var(--text-muted);
            font-size: .75rem; font-weight: 600;
        }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }

        .row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: .9rem; }

        .form-group   { margin-bottom: 1.1rem; }
        .form-label {
            display: block; font-size: .78rem; font-weight: 700;
            color: var(--text-main); margin-bottom: .4rem; letter-spacing: .2px;
        }
        .input-wrap   { position: relative; }
        .input-icon {
            position: absolute; left: .85rem; top: 50%; transform: translateY(-50%);
            color: var(--text-muted); font-size: .95rem; pointer-events: none;
        }
        .form-input {
            width: 100%; border: 1.5px solid var(--border); border-radius: 9px;
            padding: .65rem .85rem .65rem 2.5rem;
            font-size: .875rem; font-family: inherit; color: var(--text-main);
            background: #fafcff; transition: border-color .15s, box-shadow .15s; outline: none;
        }
        .form-input:focus { border-color: var(--primary-lt); box-shadow: 0 0 0 3px rgba(26,107,191,.12); background: #fff; }
        .form-input.is-error { border-color: var(--danger); box-shadow: 0 0 0 3px rgba(239,68,68,.1); }

        .btn-eye {
            position: absolute; right: .75rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; color: var(--text-muted);
            padding: .2rem; font-size: .95rem; transition: color .12s;
        }
        .btn-eye:hover { color: var(--text-main); }

        /* Password strength indicator */
        .password-strength { margin-top: .45rem; }
        .strength-bar { height: 4px; border-radius: 2px; background: var(--border); overflow: hidden; }
        .strength-fill { height: 100%; border-radius: 2px; transition: width .3s, background .3s; width: 0; }
        .strength-text { font-size: .7rem; font-weight: 600; margin-top: .25rem; color: var(--text-muted); }

        /* Terms checkbox */
        .checkbox-wrap {
            display: flex; align-items: flex-start; gap: .6rem;
            margin-top: .25rem; cursor: pointer;
        }
        .checkbox-wrap input[type="checkbox"] {
            width: 16px; height: 16px; margin-top: .1rem; flex-shrink: 0;
            accent-color: var(--primary); cursor: pointer;
        }
        .checkbox-label { font-size: .78rem; color: var(--text-muted); line-height: 1.5; cursor: pointer; }
        .checkbox-label a { color: var(--primary); font-weight: 600; text-decoration: none; }

        .btn-submit {
            width: 100%; background: var(--primary); color: #fff; border: none;
            padding: .75rem 1.25rem; border-radius: 9px;
            font-size: .9rem; font-weight: 700; font-family: inherit; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            transition: background .15s, transform .1s, box-shadow .15s;
            box-shadow: 0 4px 14px rgba(15,76,129,.25); margin-top: 1.5rem;
        }
        .btn-submit:hover { background: var(--primary-lt); transform: translateY(-1px); box-shadow: 0 6px 18px rgba(15,76,129,.3); }
        .btn-submit:disabled { opacity: .7; cursor: not-allowed; transform: none; }

        .btn-google {
            width: 100%; background: #fff; color: var(--text-main);
            border: 1.5px solid var(--border); padding: .65rem 1.25rem; border-radius: 9px;
            font-size: .875rem; font-weight: 600; font-family: inherit; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: .6rem;
            transition: background .15s, border-color .15s, box-shadow .15s;
        }
        .btn-google:hover { background: #f8fafc; border-color: #cbd5e1; box-shadow: 0 2px 8px rgba(0,0,0,.07); }
        .google-icon { width: 18px; height: 18px; }

        .alert {
            padding: .75rem 1rem; border-radius: 8px; font-size: .825rem; font-weight: 500;
            display: flex; align-items: flex-start; gap: .55rem; margin-bottom: 1.1rem;
        }
        .alert-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-danger  { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .alert i { flex-shrink: 0; margin-top: .1rem; }

        .auth-footer {
            text-align: center; margin-top: 1.5rem;
            font-size: .82rem; color: var(--text-muted);
        }
        .auth-footer a { color: var(--primary); font-weight: 700; text-decoration: none; }
        .auth-footer a:hover { color: var(--primary-lt); text-decoration: underline; }

        .spinner-sm {
            width: 18px; height: 18px;
            border: 2px solid rgba(255,255,255,.35);
            border-top-color: #fff; border-radius: 50%;
            animation: spin .6s linear infinite; display: none;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        .field-error { font-size: .73rem; color: var(--danger); margin-top: .3rem; display: none; }
        .field-error.show { display: block; }

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
        <h1 class="auth-title">Buat akun baru ✨</h1>
        <p class="auth-subtitle">Isi data di bawah untuk mulai mengelola inventaris Anda.</p>

        <div id="firebaseAlert" class="alert alert-danger" style="display:none">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span id="firebaseAlertMsg">Terjadi kesalahan.</span>
        </div>

        <div id="successAlert" class="alert alert-success" style="display:none">
            <i class="bi bi-check-circle-fill"></i>
            <span id="successAlertMsg">Akun berhasil dibuat!</span>
        </div>

        {{-- Google Register --}}
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
                    <input type="text" id="displayName" class="form-input"
                           placeholder="Nama lengkap Anda" autocomplete="name">
                </div>
                <div class="field-error" id="nameError">Nama wajib diisi.</div>
            </div>

            <div class="form-group">
                <label class="form-label">Alamat Email</label>
                <div class="input-wrap">
                    <i class="bi bi-envelope-fill input-icon"></i>
                    <input type="email" id="email" class="form-input"
                           placeholder="nama@email.com" autocomplete="email">
                </div>
                <div class="field-error" id="emailError">Email tidak valid.</div>
            </div>

            <div class="row-2">
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Password</label>
                    <div class="input-wrap">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input type="password" id="password" class="form-input"
                               placeholder="Min. 8 karakter" autocomplete="new-password"
                               oninput="checkPasswordStrength(this.value)">
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
                        <input type="password" id="confirmPassword" class="form-input"
                               placeholder="Ulangi password" autocomplete="new-password">
                        <button type="button" class="btn-eye" id="toggleConfirm">
                            <i class="bi bi-eye-slash-fill" id="eyeIcon2"></i>
                        </button>
                    </div>
                    <div class="field-error" id="confirmError">Password tidak cocok.</div>
                </div>
            </div>

            <div class="form-group" style="margin-top:1.1rem">
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

    <div class="auth-footer">
        Sudah punya akun?
        <a href="{{ route('login') }}">Masuk di sini</a>
    </div>

</div>

<script type="module">
    import { initializeApp }                                    from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
    import { getAuth, createUserWithEmailAndPassword,
             updateProfile, signInWithPopup,
             GoogleAuthProvider }                               from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

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
    const provider = new GoogleAuthProvider();

    // ── Helpers ──
    function showError(msg) {
        const el = document.getElementById('firebaseAlert');
        document.getElementById('firebaseAlertMsg').textContent = msg;
        el.style.display = 'flex';
        document.getElementById('successAlert').style.display = 'none';
        el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function showSuccess(msg) {
        const el = document.getElementById('successAlert');
        document.getElementById('successAlertMsg').textContent = msg;
        el.style.display = 'flex';
        document.getElementById('firebaseAlert').style.display = 'none';
    }

    function setLoading(loading) {
        const btn     = document.getElementById('btnRegister');
        const spinner = document.getElementById('registerSpinner');
        const text    = document.getElementById('btnRegisterText');
        btn.disabled        = loading;
        spinner.style.display = loading ? 'block' : 'none';
        text.style.display    = loading ? 'none'  : 'flex';
    }

    async function storeSessionAndRedirect(user) {
        const res = await fetch("{{ route('auth.session') }}", {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept':       'application/json',
            },
            body: JSON.stringify({
                uid:          user.uid,
                email:        user.email,
                display_name: user.displayName || user.email,
            }),
        });
        if (res.ok) {
            window.location.href = "{{ route('products.index') }}";
        } else {
            showError('Akun dibuat, tetapi gagal membuat sesi. Silakan login.');
            setLoading(false);
        }
    }

    // ── Password strength checker (exposed globally for inline handler) ──
    window.checkPasswordStrength = function(password) {
        const fill = document.getElementById('strengthFill');
        const text = document.getElementById('strengthText');
        let score = 0;
        if (password.length >= 8)         score++;
        if (/[A-Z]/.test(password))       score++;
        if (/[0-9]/.test(password))       score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;

        const levels = [
            { width:'0%',   bg:'',           label:'—' },
            { width:'25%',  bg:'#ef4444',    label:'Lemah' },
            { width:'50%',  bg:'#f97316',    label:'Cukup' },
            { width:'75%',  bg:'#eab308',    label:'Baik' },
            { width:'100%', bg:'#22c55e',    label:'Kuat 💪' },
        ];
        const lv = levels[score];
        fill.style.width      = lv.width;
        fill.style.background = lv.bg;
        text.textContent      = lv.label;
        text.style.color      = lv.bg || 'var(--text-muted)';
    };

    // ── Register with Email/Password ──
    document.getElementById('registerForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        document.getElementById('firebaseAlert').style.display = 'none';

        const name    = document.getElementById('displayName').value.trim();
        const email   = document.getElementById('email').value.trim();
        const pwd     = document.getElementById('password').value;
        const confPwd = document.getElementById('confirmPassword').value;
        const agreed  = document.getElementById('agreeTerms').checked;
        let valid = true;

        // Validation
        const setErr = (id, show) => {
            document.getElementById(id).classList.toggle('show', show);
            const inputId = id.replace('Error','').replace('name','displayName').replace('confirm','confirmPassword').replace('terms','agreeTerms');
        };

        if (!name)  { document.getElementById('nameError').classList.add('show');    valid = false; }
        else          document.getElementById('nameError').classList.remove('show');

        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            document.getElementById('emailError').classList.add('show');    valid = false;
        } else    document.getElementById('emailError').classList.remove('show');

        if (pwd.length < 8) { document.getElementById('passwordError').classList.add('show');  valid = false; }
        else                  document.getElementById('passwordError').classList.remove('show');

        if (pwd !== confPwd) { document.getElementById('confirmError').classList.add('show');  valid = false; }
        else                   document.getElementById('confirmError').classList.remove('show');

        if (!agreed) { document.getElementById('termsError').classList.add('show');   valid = false; }
        else           document.getElementById('termsError').classList.remove('show');

        if (!valid) return;
        setLoading(true);

        try {
            const cred = await createUserWithEmailAndPassword(auth, email, pwd);
            // Update display name
            await updateProfile(cred.user, { displayName: name });
            await storeSessionAndRedirect(cred.user);
        } catch (err) {
            setLoading(false);
            const map = {
                'auth/email-already-in-use': 'Email sudah terdaftar. Silakan login.',
                'auth/invalid-email':        'Format email tidak valid.',
                'auth/weak-password':        'Password terlalu lemah. Gunakan min. 6 karakter.',
                'auth/network-request-failed': 'Koneksi gagal. Periksa internet Anda.',
            };
            showError(map[err.code] || `Error: ${err.message}`);
        }
    });

    // ── Google Register ──
    document.getElementById('btnGoogle').addEventListener('click', async () => {
        document.getElementById('firebaseAlert').style.display = 'none';
        try {
            const result = await signInWithPopup(auth, provider);
            await storeSessionAndRedirect(result.user);
        } catch (err) {
            if (err.code !== 'auth/popup-closed-by-user') {
                showError(`Daftar dengan Google gagal: ${err.message}`);
            }
        }
    });

    // ── Toggle password visibility ──
    document.getElementById('togglePassword').addEventListener('click', () => {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eyeIcon1');
        input.type  = input.type === 'password' ? 'text' : 'password';
        icon.className = input.type === 'password' ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
    });
    document.getElementById('toggleConfirm').addEventListener('click', () => {
        const input = document.getElementById('confirmPassword');
        const icon  = document.getElementById('eyeIcon2');
        input.type  = input.type === 'password' ? 'text' : 'password';
        icon.className = input.type === 'password' ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
    });
</script>

</body>
</html>
