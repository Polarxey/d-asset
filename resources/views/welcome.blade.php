<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D-Asset | PLN ICON+</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-width: 265px; }
        body { font-family: 'Inter', sans-serif; background-color: #0e1117; }
        .sidebar {
            min-height: 100vh; width: var(--sidebar-width);
            background: #161b22; position: fixed;
            border-right: 1px solid #21262d; z-index: 1000;
            display: flex; flex-direction: column;
        }
        .main-content { margin-left: var(--sidebar-width); padding: 28px 32px; min-height: 100vh; }
        .nav-link { border-radius: 6px; margin-bottom: 2px; padding: 7px 12px; font-size: 0.875rem; color: #8b949e; transition: all .15s; }
        .nav-link:hover { background: #21262d !important; color: #c9d1d9 !important; }
        .nav-link.active { background: #1f6feb20 !important; color: #58a6ff !important; font-weight: 600; border-left: 3px solid #58a6ff; border-radius: 0 6px 6px 0; }
        .nav-link .ti { width: 18px; text-align: center; }
        .section-label { font-size: 0.7rem; color: #484f58; letter-spacing: 1px; text-transform: uppercase; padding: 14px 12px 5px; font-weight: 600; }
        .card { background: #161b22; border: 1px solid #21262d; border-radius: 10px; }
        .table-dark { --bs-table-bg: #161b22; --bs-table-hover-bg: #1c2128; }
        .badge { font-weight: 500; font-size: 0.75rem; }
        .breadcrumb-item, .breadcrumb-item a { font-size: 0.8rem; color: #8b949e; }
        .brand-logo { font-size: 1.2rem; font-weight: 700; color: #58a6ff; letter-spacing: -0.5px; }
        .brand-sub { font-size: 0.65rem; color: #484f58; letter-spacing: 1px; }
        .sidebar-footer { margin-top: auto; padding: 12px 14px; border-top: 1px solid #21262d; }
        .stat-card { background: #161b22; border: 1px solid #21262d; border-radius: 10px; padding: 18px 20px; }
        .stat-card:hover { border-color: #30363d; }
    </style>
</head>
<body>

<div class="sidebar p-3">
    <div class="mb-3 px-1">
        <div class="brand-logo">D-ASSET</div>
        <div class="brand-sub">PLN ICON+ Bandung</div>
    </div>
    <hr style="border-color:#21262d; margin: 6px 0 10px;">

    <ul class="nav nav-pills flex-column mb-auto" style="gap:1px">
        <li>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="ti ti-layout-dashboard me-2"></i>Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('assets.index') }}" class="nav-link {{ request()->routeIs('assets.index') ? 'active' : '' }}">
                <i class="ti ti-device-laptop me-2"></i>Master Asset(s)
            </a>
        </li>

        <div class="section-label">Transaksi Masuk</div>
        <li>
            <a href="{{ route('rma.create') }}" class="nav-link {{ request()->routeIs('rma.*') ? 'active' : '' }}">
                <i class="ti ti-arrow-back-up me-2"></i>Barang Retur
            </a>
        </li>
        <li>
            <a href="{{ route('barang_masuk.create') }}" class="nav-link {{ request()->routeIs('barang_masuk.*') ? 'active' : '' }}">
                <i class="ti ti-package-import me-2"></i>Barang Masuk Baru
            </a>
        </li>

        <div class="section-label">Transaksi Keluar</div>
        <li>
            <a href="{{ route('bundle.create') }}" class="nav-link {{ request()->routeIs('bundle.create') ? 'active' : '' }}">
                <i class="ti ti-packages me-2"></i>Buat Paket Keluar
            </a>
        </li>
        <li>
            <a href="{{ route('bundle.index') }}" class="nav-link {{ request()->routeIs('bundle.index') ? 'active' : '' }}">
                <i class="ti ti-list-details me-2"></i>Daftar Paket
            </a>
        </li>

        <div class="section-label">Generate Dokumen</div>
        <li>
            <a href="{{ route('transactions.create') }}" class="nav-link {{ request()->routeIs('transactions.create') ? 'active' : '' }}">
                <i class="ti ti-file-invoice me-2"></i>Generate BSTP
            </a>
        </li>
        <li>
            <a href="{{ route('transactions.index') }}" class="nav-link {{ request()->routeIs('transactions.index') ? 'active' : '' }}">
                <i class="ti ti-history me-2"></i>Riwayat BSTP
            </a>
        </li>

        <div class="section-label">Sistem</div>
        <li>
            <a href="{{ route('activity_log.index') }}" class="nav-link {{ request()->routeIs('activity_log.*') ? 'active' : '' }}">
                <i class="ti ti-activity me-2"></i>Log Activity
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <div style="font-size:0.78rem; color:#484f58;">
            <span style="color:#8b949e; font-weight:600;">Dzaki MH</span> &middot; Internship<br>
            PLN ICON+ Bandung
        </div>
    </div>
</div>

<div class="main-content">
    @if(session('success'))
    <div class="alert border-0 mb-4 d-flex align-items-center gap-2"
         style="background:#1a3a2a; border-left:3px solid #238636 !important; border-radius:8px; color:#3fb950; padding:12px 16px; border-left: 3px solid #238636;">
        <i class="ti ti-circle-check-filled"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert border-0 mb-4 d-flex align-items-center gap-2"
         style="background:#3a1a1a; border-left:3px solid #da3633 !important; border-radius:8px; color:#f85149; padding:12px 16px;">
        <i class="ti ti-alert-circle"></i>
        {{ session('error') }}
    </div>
    @endif

    @yield('content')
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
