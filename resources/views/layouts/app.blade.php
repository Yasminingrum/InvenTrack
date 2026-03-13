<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'InvenTrack — Sistem Manajemen Inventaris')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary:     #0f4c81;
            --primary-lt:  #1a6bbf;
            --accent:      #f97316;
            --accent-lt:   #fb923c;
            --surface:     #f8fafc;
            --card-bg:     #ffffff;
            --border:      #e2e8f0;
            --text-main:   #0f172a;
            --text-muted:  #64748b;
            --danger:      #ef4444;
            --success:     #22c55e;
            --sidebar-w:   260px;
            --sidebar-mini: 64px;
            --transition:  .25s ease;
        }

        * { box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--surface); color: var(--text-main); min-height: 100vh; }

        /* ══════════════════════════════════
           SIDEBAR
        ══════════════════════════════════ */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-w); height: 100vh;
            background: var(--primary);
            display: flex; flex-direction: column;
            z-index: 200; overflow: hidden;
            transition: width var(--transition);
        }

        body.sidebar-collapsed .sidebar          { width: var(--sidebar-mini); }
        body.sidebar-collapsed .main-wrap        { margin-left: var(--sidebar-mini); }
        body.sidebar-collapsed .brand-text,
        body.sidebar-collapsed .brand-sub,
        body.sidebar-collapsed .sidebar-link span,
        body.sidebar-collapsed .nav-section-label,
        body.sidebar-collapsed .user-name,
        body.sidebar-collapsed .user-email,
        body.sidebar-collapsed .sidebar-footer   { opacity: 0; pointer-events: none; width: 0; overflow: hidden; }
        body.sidebar-collapsed .sidebar-link     { justify-content: center; padding: .6rem 0; }
        body.sidebar-collapsed .brand-logo       { justify-content: center; }
        body.sidebar-collapsed .toggle-btn i     { transform: rotate(180deg); }
        body.sidebar-collapsed .user-panel       { justify-content: center; padding: .6rem 0; }
        body.sidebar-collapsed .user-avatar      { margin: 0; }

        /* Brand */
        .sidebar-brand {
            padding: 1rem 1rem .85rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
            display: flex; align-items: center; justify-content: space-between; gap: .5rem;
            flex-shrink: 0;
        }
        .brand-logo  { display: flex; align-items: center; gap: .75rem; text-decoration: none; min-width: 0; }
        .brand-icon  { width: 38px; height: 38px; background: var(--accent); border-radius: 10px; display: grid; place-items: center; font-size: 1.15rem; color: #fff; flex-shrink: 0; }
        .brand-text  { font-size: 1.05rem; font-weight: 800; color: #fff; letter-spacing: -.3px; line-height: 1.1; white-space: nowrap; transition: opacity var(--transition), width var(--transition); }
        .brand-sub   { font-size: .6rem; font-weight: 500; color: rgba(255,255,255,.45); letter-spacing: .5px; text-transform: uppercase; white-space: nowrap; transition: opacity var(--transition), width var(--transition); }

        .toggle-btn {
            width: 28px; height: 28px; flex-shrink: 0;
            background: rgba(255,255,255,.12); border: none; border-radius: 7px;
            display: grid; place-items: center; cursor: pointer;
            color: rgba(255,255,255,.8); font-size: .85rem; transition: background .15s;
        }
        .toggle-btn:hover { background: rgba(255,255,255,.22); color: #fff; }
        .toggle-btn i { transition: transform var(--transition); }

        /* User Panel */
        .user-panel {
            display: flex; align-items: center; gap: .65rem;
            padding: .85rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
            flex-shrink: 0; overflow: hidden;
            transition: padding var(--transition), justify-content var(--transition);
        }
        .user-avatar {
            width: 36px; height: 36px; flex-shrink: 0;
            background: var(--accent); border-radius: 50%;
            display: grid; place-items: center;
            font-size: .95rem; color: #fff; font-weight: 700;
            transition: margin var(--transition);
        }
        .user-info  { min-width: 0; flex: 1; overflow: hidden; }
        .user-name  { font-size: .82rem; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; transition: opacity var(--transition), width var(--transition); }
        .user-email { font-size: .68rem; color: rgba(255,255,255,.5); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; transition: opacity var(--transition), width var(--transition); }

        /* Nav */
        .sidebar-nav { padding: .85rem .6rem; flex: 1; overflow-y: auto; overflow-x: hidden; }
        .nav-section-label {
            font-size: .6rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
            color: rgba(255,255,255,.3); padding: .5rem .6rem .2rem;
            margin-top: .4rem; white-space: nowrap;
            transition: opacity var(--transition), width var(--transition);
        }
        .sidebar-link {
            display: flex; align-items: center; gap: .7rem;
            padding: .58rem .65rem; border-radius: 8px;
            color: rgba(255,255,255,.72); text-decoration: none;
            font-size: .875rem; font-weight: 500;
            transition: background .15s, color .15s, padding var(--transition), justify-content var(--transition);
            margin-bottom: 2px; white-space: nowrap; overflow: hidden;
        }
        .sidebar-link i  { font-size: 1rem; flex-shrink: 0; }
        .sidebar-link span { transition: opacity var(--transition), width var(--transition); }
        .sidebar-link:hover  { background: rgba(255,255,255,.11); color: #fff; }
        .sidebar-link.active { background: var(--accent); color: #fff; box-shadow: 0 4px 12px rgba(249,115,22,.3); }

        /* Tooltip */
        body.sidebar-collapsed .sidebar-link { position: relative; }
        body.sidebar-collapsed .sidebar-link::after {
            content: attr(data-label);
            position: absolute; left: calc(var(--sidebar-mini) - 4px);
            background: #1e293b; color: #fff; font-size: .78rem; font-weight: 600;
            padding: .35rem .7rem; border-radius: 7px; white-space: nowrap;
            pointer-events: none; opacity: 0; transform: translateX(6px);
            transition: opacity .15s, transform .15s; z-index: 999;
            box-shadow: 0 4px 12px rgba(0,0,0,.2);
        }
        body.sidebar-collapsed .sidebar-link:hover::after { opacity: 1; transform: translateX(10px); }

        /* Logout button in sidebar */
        .btn-logout {
            display: flex; align-items: center; gap: .7rem;
            padding: .58rem .65rem; border-radius: 8px;
            color: rgba(255,255,255,.6); background: none; border: none;
            font-size: .875rem; font-weight: 500; font-family: inherit; cursor: pointer;
            width: 100%; text-align: left;
            transition: background .15s, color .15s, padding var(--transition), justify-content var(--transition);
            white-space: nowrap; overflow: hidden;
        }
        .btn-logout i   { font-size: 1rem; flex-shrink: 0; }
        .btn-logout span { transition: opacity var(--transition), width var(--transition); }
        .btn-logout:hover { background: rgba(239,68,68,.2); color: #fca5a5; }
        body.sidebar-collapsed .btn-logout { justify-content: center; padding: .6rem 0; }
        body.sidebar-collapsed .btn-logout span { opacity: 0; width: 0; pointer-events: none; overflow: hidden; }

        .sidebar-footer {
            padding: .75rem 1rem; border-top: 1px solid rgba(255,255,255,.1);
            font-size: .72rem; color: rgba(255,255,255,.3);
            white-space: nowrap; transition: opacity var(--transition); flex-shrink: 0;
        }

        /* ══════════════════════════════════
           MAIN LAYOUT
        ══════════════════════════════════ */
        .main-wrap {
            margin-left: var(--sidebar-w); min-height: 100vh;
            display: flex; flex-direction: column;
            transition: margin-left var(--transition);
        }
        .page-content { padding: 1.75rem 2rem; flex: 1; }

        /* Cards */
        .card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
        .card-header-custom { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .5rem; }
        .card-title-custom { font-size: 1rem; font-weight: 700; color: var(--text-main); margin: 0; }

        /* Stat cards */
        .stat-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 1.25rem; display: flex; align-items: center; gap: 1rem; overflow: hidden; }
        .stat-icon { width: 48px; height: 48px; border-radius: 10px; display: grid; place-items: center; font-size: 1.3rem; flex-shrink: 0; }
        .stat-body { min-width: 0; flex: 1; }
        .stat-value { font-size: 1.4rem; font-weight: 800; line-height: 1.15; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .stat-label { font-size: .78rem; color: var(--text-muted); font-weight: 500; }

        /* Table */
        .table-custom { width: 100%; border-collapse: collapse; }
        .table-custom thead th { background: var(--surface); padding: .75rem 1rem; font-size: .75rem; font-weight: 700; letter-spacing: .5px; text-transform: uppercase; color: var(--text-muted); border-bottom: 1px solid var(--border); }
        .table-custom tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
        .table-custom tbody tr:last-child { border-bottom: none; }
        .table-custom tbody tr:hover { background: #f8fafc; }
        .table-custom tbody td { padding: .875rem 1rem; font-size: .875rem; vertical-align: middle; }

        /* Badges */
        .badge-stock { padding: .25rem .65rem; border-radius: 20px; font-size: .7rem; font-weight: 700; font-family: 'DM Mono', monospace; }
        .badge-high   { background: #dcfce7; color: #15803d; }
        .badge-medium { background: #fef9c3; color: #a16207; }
        .badge-low    { background: #fee2e2; color: #b91c1c; }
        .badge-cat    { background: #ede9fe; color: #6d28d9; padding: .2rem .6rem; border-radius: 6px; font-size: .72rem; font-weight: 600; }

        /* Buttons */
        .btn-primary-custom { background: var(--primary); color: #fff; border: none; padding: .5rem 1.1rem; border-radius: 8px; font-size: .875rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: .4rem; transition: background .15s, transform .1s; text-decoration: none; }
        .btn-primary-custom:hover { background: var(--primary-lt); color: #fff; transform: translateY(-1px); }
        .btn-accent { background: var(--accent); color: #fff; border: none; padding: .5rem 1.1rem; border-radius: 8px; font-size: .875rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: .4rem; transition: background .15s; text-decoration: none; }
        .btn-accent:hover { background: var(--accent-lt); color: #fff; }
        .btn-icon { width: 32px; height: 32px; border: none; border-radius: 7px; display: grid; place-items: center; cursor: pointer; transition: background .12s; font-size: .9rem; text-decoration: none; }
        .btn-edit { background: #eff6ff; color: #2563eb; }
        .btn-edit:hover { background: #dbeafe; }
        .btn-del  { background: #fef2f2; color: #dc2626; }
        .btn-del:hover  { background: #fee2e2; }

        /* Form */
        .form-group { margin-bottom: 1.25rem; }
        .form-label-custom { display: block; font-size: .8rem; font-weight: 700; color: var(--text-main); margin-bottom: .4rem; letter-spacing: .2px; }
        .form-control-custom { width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: .6rem .85rem; font-size: .875rem; font-family: inherit; color: var(--text-main); background: var(--card-bg); transition: border-color .15s, box-shadow .15s; outline: none; }
        .form-control-custom:focus { border-color: var(--primary-lt); box-shadow: 0 0 0 3px rgba(26,107,191,.12); }
        select.form-control-custom { appearance: auto; }
        textarea.form-control-custom { resize: vertical; min-height: 80px; }

        /* Alerts */
        .alert-custom { padding: .875rem 1.1rem; border-radius: 8px; font-size: .875rem; font-weight: 500; display: flex; align-items: center; gap: .6rem; margin-bottom: 1rem; }
        .alert-success-custom { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-danger-custom  { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

        /* Loading */
        .loading-overlay { position: fixed; inset: 0; background: rgba(15,76,129,.7); z-index: 9999; display: none; place-items: center; color: #fff; font-size: .875rem; font-weight: 600; flex-direction: column; gap: .75rem; }
        .loading-overlay.show { display: flex; }
        .spinner { width: 36px; height: 36px; border: 3px solid rgba(255,255,255,.3); border-top-color: #fff; border-radius: 50%; animation: spin .7s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Empty state */
        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--text-muted); }
        .empty-state i { font-size: 3rem; margin-bottom: .75rem; display: block; opacity: .3; }

        /* Toast */
        #toastContainer { position: fixed; top: 1.25rem; right: 1.25rem; z-index: 99999; display: flex; flex-direction: column; gap: .6rem; pointer-events: none; }
        .toast-notif { position: relative; overflow: hidden; min-width: 300px; max-width: 380px; background: #fff; border-radius: 12px; box-shadow: 0 10px 35px rgba(0,0,0,.14), 0 2px 8px rgba(0,0,0,.07); display: flex; align-items: flex-start; gap: .85rem; padding: 1rem 1.1rem; pointer-events: all; border-left: 4px solid transparent; opacity: 0; transform: translateX(50px); transition: opacity .25s ease, transform .25s ease; }
        .toast-notif.show   { opacity: 1; transform: translateX(0); }
        .toast-notif.hiding { opacity: 0; transform: translateX(50px); }
        .toast-notif.toast-success { border-left-color: #22c55e; }
        .toast-notif.toast-danger  { border-left-color: #ef4444; }
        .toast-notif.toast-info    { border-left-color: #3b82f6; }
        .toast-icon { width: 38px; height: 38px; border-radius: 9px; display: grid; place-items: center; font-size: 1.1rem; flex-shrink: 0; }
        .toast-success .toast-icon { background: #dcfce7; color: #16a34a; }
        .toast-danger  .toast-icon { background: #fee2e2; color: #dc2626; }
        .toast-info    .toast-icon { background: #dbeafe; color: #2563eb; }
        .toast-body  { flex: 1; min-width: 0; }
        .toast-title { font-size: .9rem; font-weight: 700; color: var(--text-main); margin-bottom: .1rem; }
        .toast-msg   { font-size: .8rem; color: var(--text-muted); line-height: 1.4; }
        .toast-close { background: none; border: none; cursor: pointer; color: var(--text-muted); font-size: 1rem; line-height: 1; padding: 0; flex-shrink: 0; margin-top: .1rem; transition: color .12s; }
        .toast-close:hover { color: var(--text-main); }
        .toast-progress { position: absolute; bottom: 0; left: 0; height: 3px; border-radius: 0 0 12px 12px; animation: toastProg linear forwards; }
        .toast-success .toast-progress { background: #22c55e; }
        .toast-danger  .toast-progress { background: #ef4444; }
        .toast-info    .toast-progress { background: #3b82f6; }
        @keyframes toastProg { from { width: 100%; } to { width: 0%; } }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { width: var(--sidebar-mini); }
            body.sidebar-collapsed .sidebar { width: 0; }
            .main-wrap { margin-left: var(--sidebar-mini); }
            body.sidebar-collapsed .main-wrap { margin-left: 0; }
            .page-content { padding: 1rem; }
            #toastContainer { right: .75rem; left: .75rem; top: .75rem; }
            .toast-notif { min-width: unset; max-width: 100%; }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
    <span>Memproses...</span>
</div>

<div id="toastContainer"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('products.index') }}" class="brand-logo">
            <div class="brand-icon"><i class="bi bi-box-seam-fill"></i></div>
            <div>
                <div class="brand-text">InvenTrack</div>
                <div class="brand-sub">Inventory System</div>
            </div>
        </a>
        <button class="toggle-btn" id="sidebarToggle" title="Perkecil/Perbesar sidebar">
            <i class="bi bi-layout-sidebar-reverse"></i>
        </button>
    </div>

    {{-- User panel — tampil nama & email dari session --}}
    <div class="user-panel">
        <div class="user-avatar">
            {{ strtoupper(substr(session('firebase_display_name', 'U'), 0, 1)) }}
        </div>
        <div class="user-info">
            <div class="user-name">{{ session('firebase_display_name', 'Pengguna') }}</div>
            <div class="user-email">{{ session('firebase_email', '') }}</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Menu Utama</div>

        <a href="{{ route('products.index') }}" data-label="Dashboard"
           class="sidebar-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
            <i class="bi bi-grid-3x3-gap-fill"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('products.index') }}" data-label="Semua Produk"
           class="sidebar-link {{ request()->routeIs('products.show') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            <span>Semua Produk</span>
        </a>

        <a href="{{ route('products.create') }}" data-label="Tambah Produk"
           class="sidebar-link {{ request()->routeIs('products.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i>
            <span>Tambah Produk</span>
        </a>

        <div class="nav-section-label" style="margin-top:1rem">Informasi</div>

        <a href="#" data-label="Laporan Stok" class="sidebar-link">
            <i class="bi bi-bar-chart-line"></i>
            <span>Laporan Stok</span>
        </a>

        <a href="#" data-label="Pengaturan" class="sidebar-link">
            <i class="bi bi-gear"></i>
            <span>Pengaturan</span>
        </a>

        {{-- Logout --}}
        <div class="nav-section-label" style="margin-top:1rem">Akun</div>
        <form method="POST" action="{{ route('logout') }}" id="logoutForm">
            @csrf
            <button type="submit" class="btn-logout" data-label="Logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>
    </nav>

    <div class="sidebar-footer">
        &copy; {{ date('Y') }} InvenTrack
    </div>
</aside>

<!-- Main Wrapper -->
<div class="main-wrap" id="mainWrap">
    <main class="page-content">
        @if(session('success'))
            <div class="alert-custom alert-success-custom">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert-custom alert-danger-custom">
                <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    window.showLoading = () => document.getElementById('loadingOverlay').classList.add('show');
    window.hideLoading = () => document.getElementById('loadingOverlay').classList.remove('show');

    /* Sidebar toggle */
    const toggleBtn = document.getElementById('sidebarToggle');
    if (localStorage.getItem('sidebarCollapsed') === '1') {
        document.body.classList.add('sidebar-collapsed');
    }
    toggleBtn.addEventListener('click', () => {
        const collapsed = document.body.classList.toggle('sidebar-collapsed');
        localStorage.setItem('sidebarCollapsed', collapsed ? '1' : '0');
    });

    /* Toast system */
    window.showToast = function(type, title, message = '', duration = 4500) {
        const icons = { success: 'bi-check-circle-fill', danger: 'bi-x-circle-fill', info: 'bi-info-circle-fill' };
        const container = document.getElementById('toastContainer');
        const el = document.createElement('div');
        el.className = `toast-notif toast-${type}`;
        el.innerHTML = `
            <div class="toast-icon"><i class="bi ${icons[type] || icons.info}"></i></div>
            <div class="toast-body">
                <div class="toast-title">${title}</div>
                ${message ? `<div class="toast-msg">${message}</div>` : ''}
            </div>
            <button class="toast-close" aria-label="Tutup"><i class="bi bi-x-lg"></i></button>
            <div class="toast-progress" style="animation-duration:${duration}ms"></div>
        `;
        container.appendChild(el);
        requestAnimationFrame(() => requestAnimationFrame(() => el.classList.add('show')));
        const dismiss = () => {
            el.classList.replace('show','hiding') || el.classList.add('hiding');
            el.addEventListener('transitionend', () => el.remove(), { once: true });
        };
        const timer = setTimeout(dismiss, duration);
        el.querySelector('.toast-close').addEventListener('click', () => { clearTimeout(timer); dismiss(); });
    };
</script>

@stack('scripts')
</body>
</html>
