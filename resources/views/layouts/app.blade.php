<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'InvenTrack — Sistem Manajemen Inventaris')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
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
            --warning:     #eab308;
            --sidebar-w:   260px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--surface);
            color: var(--text-main);
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--primary);
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: .75rem;
            text-decoration: none;
        }

        .brand-icon {
            width: 40px; height: 40px;
            background: var(--accent);
            border-radius: 10px;
            display: grid;
            place-items: center;
            font-size: 1.2rem;
            color: #fff;
            flex-shrink: 0;
        }

        .brand-text {
            font-size: 1.1rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.3px;
            line-height: 1.1;
        }

        .brand-sub {
            font-size: .65rem;
            font-weight: 500;
            color: rgba(255,255,255,.5);
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            padding: 1rem .75rem;
            flex: 1;
        }

        .nav-section-label {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: rgba(255,255,255,.35);
            padding: .5rem .75rem .25rem;
            margin-top: .5rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .6rem .75rem;
            border-radius: 8px;
            color: rgba(255,255,255,.75);
            text-decoration: none;
            font-size: .875rem;
            font-weight: 500;
            transition: all .15s ease;
            margin-bottom: 2px;
        }

        .sidebar-link i { font-size: 1rem; flex-shrink: 0; }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(255,255,255,.12);
            color: #fff;
        }

        .sidebar-link.active {
            background: var(--accent);
            color: #fff;
            box-shadow: 0 4px 12px rgba(249,115,22,.35);
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,.1);
            font-size: .75rem;
            color: rgba(255,255,255,.35);
        }

        /* ── Main layout ── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Topbar ── */
        .topbar {
            background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            padding: .875rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .topbar-badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: #fef3c7;
            color: #92400e;
            padding: .3rem .75rem;
            border-radius: 20px;
            font-size: .75rem;
            font-weight: 600;
        }

        /* ── Content ── */
        .page-content {
            padding: 1.75rem 2rem;
            flex: 1;
        }

        /* ── Cards ── */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,.04);
        }

        .card-header-custom {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title-custom {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
        }

        /* ── Stat cards ── */
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            line-height: 1.1;
            color: var(--text-main);
        }

        .stat-label {
            font-size: .8rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* ── Table ── */
        .table-custom {
            width: 100%;
            border-collapse: collapse;
        }

        .table-custom thead th {
            background: var(--surface);
            padding: .75rem 1rem;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .5px;
            text-transform: uppercase;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
        }

        .table-custom tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .1s;
        }

        .table-custom tbody tr:last-child { border-bottom: none; }
        .table-custom tbody tr:hover { background: #f8fafc; }

        .table-custom tbody td {
            padding: .875rem 1rem;
            font-size: .875rem;
            vertical-align: middle;
        }

        /* ── Badges ── */
        .badge-stock {
            padding: .25rem .65rem;
            border-radius: 20px;
            font-size: .7rem;
            font-weight: 700;
            font-family: 'DM Mono', monospace;
        }

        .badge-high   { background: #dcfce7; color: #15803d; }
        .badge-medium { background: #fef9c3; color: #a16207; }
        .badge-low    { background: #fee2e2; color: #b91c1c; }

        .badge-cat {
            background: #ede9fe;
            color: #6d28d9;
            padding: .2rem .6rem;
            border-radius: 6px;
            font-size: .72rem;
            font-weight: 600;
        }

        /* ── Buttons ── */
        .btn-primary-custom {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: .5rem 1.1rem;
            border-radius: 8px;
            font-size: .875rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            transition: background .15s, transform .1s;
            text-decoration: none;
        }

        .btn-primary-custom:hover {
            background: var(--primary-lt);
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-accent {
            background: var(--accent);
            color: #fff;
            border: none;
            padding: .5rem 1.1rem;
            border-radius: 8px;
            font-size: .875rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            transition: background .15s;
            text-decoration: none;
        }

        .btn-accent:hover { background: var(--accent-lt); color: #fff; }

        .btn-icon {
            width: 32px; height: 32px;
            border: none;
            border-radius: 7px;
            display: grid;
            place-items: center;
            cursor: pointer;
            transition: background .12s;
            font-size: .9rem;
            text-decoration: none;
        }

        .btn-edit  { background: #eff6ff; color: #2563eb; }
        .btn-edit:hover  { background: #dbeafe; }
        .btn-del   { background: #fef2f2; color: #dc2626; }
        .btn-del:hover   { background: #fee2e2; }

        /* ── Form ── */
        .form-group { margin-bottom: 1.25rem; }

        .form-label-custom {
            display: block;
            font-size: .8rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: .4rem;
            letter-spacing: .2px;
        }

        .form-control-custom {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: .6rem .85rem;
            font-size: .875rem;
            font-family: inherit;
            color: var(--text-main);
            background: var(--card-bg);
            transition: border-color .15s, box-shadow .15s;
            outline: none;
        }

        .form-control-custom:focus {
            border-color: var(--primary-lt);
            box-shadow: 0 0 0 3px rgba(26,107,191,.12);
        }

        select.form-control-custom { appearance: auto; }
        textarea.form-control-custom { resize: vertical; min-height: 80px; }

        /* ── Alerts ── */
        .alert-custom {
            padding: .875rem 1.1rem;
            border-radius: 8px;
            font-size: .875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: .6rem;
            margin-bottom: 1rem;
        }

        .alert-success-custom { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-danger-custom  { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

        /* ── Loading ── */
        .loading-overlay {
            position: fixed; inset: 0;
            background: rgba(15,76,129,.7);
            z-index: 9999;
            display: none;
            place-items: center;
            color: #fff;
            font-size: .875rem;
            font-weight: 600;
            flex-direction: column;
            gap: .75rem;
        }

        .loading-overlay.show { display: flex; }

        .spinner {
            width: 36px; height: 36px;
            border: 3px solid rgba(255,255,255,.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-muted);
        }

        .empty-state i { font-size: 3rem; margin-bottom: .75rem; display: block; opacity: .3; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform .3s; }
            .sidebar.open { transform: translateX(0); }
            .main-wrap { margin-left: 0; }
            .page-content { padding: 1rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
    <span>Memproses...</span>
</div>

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
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Menu Utama</div>

        <a href="{{ route('products.index') }}"
           class="sidebar-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
            <i class="bi bi-grid-3x3-gap-fill"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('products.index') }}"
           class="sidebar-link {{ request()->routeIs('products.*') && !request()->routeIs('products.index') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            <span>Semua Produk</span>
        </a>

        <a href="{{ route('products.create') }}"
           class="sidebar-link {{ request()->routeIs('products.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i>
            <span>Tambah Produk</span>
        </a>

        <div class="nav-section-label" style="margin-top:1rem">Informasi</div>

        <a href="#" class="sidebar-link">
            <i class="bi bi-bar-chart-line"></i>
            <span>Laporan Stok</span>
        </a>

        <a href="#" class="sidebar-link">
            <i class="bi bi-gear"></i>
            <span>Pengaturan</span>
        </a>
    </nav>
</aside>

<!-- Main Wrapper -->
<div class="main-wrap">

    <!-- Page Content -->
    <main class="page-content">
        @if(session('success'))
            <div class="alert-custom alert-success-custom">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-custom alert-danger-custom">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Sidebar mobile toggle
    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('open');
    });

    // Loading helper
    window.showLoading = () => document.getElementById('loadingOverlay').classList.add('show');
    window.hideLoading = () => document.getElementById('loadingOverlay').classList.remove('show');
</script>

@stack('scripts')
</body>
</html>
