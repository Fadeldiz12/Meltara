<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Meltara Admin') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font modern tapi tetap soft -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            /* === PALET WARNA MENGIKUTI TEMPLATE LAMA === */
            --bg-main:   #FFFBE9;   /* background area konten */
            --bg-card:   #EDDCD6;   /* kartu / panel */
            --bg-sidebar:#E6CFA6;   /* sidebar hijau krem */
            --text-main: #3F2F23;
            --text-soft: #7A6450;

            --accent:        #C18A5C;
            --accent-strong: #B66B3D;
            --border-soft:   #E0CBB3;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-main);
            color: var(--text-main);
        }

        .wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* ========= SIDEBAR ========= */
        .sidebar {
            width: 250px;
            background: var(--bg-sidebar);
            padding: 25px 18px;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #FFFBE9;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
        }

        .brand img {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.85);
        }

        .brand h2 {
            font-size: 18px;
            font-weight: 600;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .menu a {
            text-decoration: none;
            color: #333;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            border-radius: 999px;
            font-size: 14px;
            transition: 0.18s ease;
        }

        .menu-item span.icon {
            font-size: 16px;
        }

        .menu-item:hover {
            background: #FFF2DD;
        }

        .menu a.active .menu-item,
        .menu-item.active {
            background: #FFFFFF;
            box-shadow: 0 6px 14px rgba(0,0,0,0.06);
        }

        /* ========= CONTENT WRAPPER ========= */
        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: var(--bg-main);
        }

        /* ========= TOPBAR ========= */
        .topbar {
            height: 70px;
            padding: 0 35px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #DDD;
            background: #FFF7EF;
        }

        .topbar-title {
            font-size: 20px;
            font-weight: 600;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: var(--text-soft);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22C55E;
        }

        .avatar-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--accent);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
        }

        /* ========= AREA PAGE GENERIC (Manajemen Produk, dll) ========= */

        .page {
            padding: 30px 40px;
        }

        .page h1,
        .page-title {
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .page-subtitle {
            font-size: 15px;
            color: var(--text-soft);
            margin-bottom: 18px;
        }

        /* Card container untuk tabel / konten utama */
        .card {
            background: var(--bg-card);
            padding: 25px;
            border-radius: 18px;
            border: 1px solid var(--border-soft);
            box-shadow: 0 6px 14px rgba(0,0,0,0.04);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .card-header h2 {
            font-size: 18px;
            font-weight: 600;
        }

        /* ========= BUTTONS (dipakai di manajemen produk) ========= */

        .btn-add {
            background: var(--accent-strong);
            border: none;
            padding: 8px 18px;
            border-radius: 999px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            color: #fff;
        }

        .btn-edit,
        .btn-delete {
            border: none;
            padding: 6px 16px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-edit {
            background: #FF9B9B;
            color: #4A1313;
        }

        .btn-delete {
            background: #888;
            color: #fff;
            margin-left: 6px;
        }

        /* ========= TABLE STYLE umum (dipakai Manajemen Produk) ========= */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            background: transparent;
        }

        thead tr {
            border-top: 1px solid #888;
            border-bottom: 1px solid #888;
            background: rgba(255,255,255,0.35);
        }

        th, td {
            padding: 12px 14px;
            text-align: left;
        }

        tbody tr {
            height: 52px;
        }

        tbody tr:nth-child(even) {
            background: rgba(255,255,255,0.30);
        }

        tbody tr:hover {
            background: rgba(255,255,255,0.55);
        }

        /* ========= FOOTER ========= */
        .footer {
            margin-top: auto;
            text-align: center;
            padding: 15px 35px;
            font-size: 13px;
            border-top: 1px solid #DDD;
            background: #FFF7EF;
            color: var(--text-soft);
        }

        /* ========= FORM STYLE (tambah/edit produk) ========= */
        .form-container {
            padding: 30px 40px;
            flex: 1;
        }

        .form-card {
            background: #F0E4DA;
            padding: 25px 30px;
            border-radius: 14px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 25px;
            align-items: flex-start;
        }

        .form-title {
            font-weight: 600;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid #333;
            width: 100%;
            max-width: 800px;
        }

        label {
            display: block;
            font-size: 13px;
            margin-top: 10px;
        }

        input, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #AAA;
            border-radius: 6px;
            font-family: inherit;
            font-size: 13px;
        }

        textarea { min-height: 100px; }

        .image-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 28px;
        }

        .preview-img {
            width: 494px;
            max-width: 100%;
            height: 329px;
            object-fit: cover;
            border: 1px solid #AAA;
            background: #fff;
            border-radius: 6px;
        }

        .button-area {
            margin-top: 15px;
            width: 494px;
            max-width: 100%;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .btn-save {
            background: #000;
            color: #fff;
            padding: 7px 30px;
            border: none;
            border-radius: 8px;
        }

        .btn-cancel {
            background: #FF8888;
            padding: 7px 30px;
            border: none;
            border-radius: 8px;
        }
    </style>

    <!-- CSS khusus per halaman (dashboard, dll) -->
    <?= $this->renderSection('styles') ?>
</head>
<body>

<div class="wrapper">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand">
            <img src="<?= base_url('images/logo.png'); ?>" alt="Meltara">
            <h2>Meltara Admin</h2>
        </div>

        <nav class="menu">
            <a href="<?= base_url('admin/dashboard') ?>" class="<?= ($activeMenu ?? '') === 'dashboard' ? 'active' : '' ?>">
                <div class="menu-item">
                    <span class="icon">🏠</span>
                    <span>Dashboard</span>
                </div>
            </a>
            <a href="<?= base_url('admin/products') ?>" class="<?= ($activeMenu ?? '') === 'products' ? 'active' : '' ?>">
                <div class="menu-item">
                    <span class="icon">📦</span>
                    <span>Manajemen Produk</span>
                </div>
            </a>
            <a href="<?= base_url('admin/orders') ?>" class="<?= ($activeMenu ?? '') === 'orders' ? 'active' : '' ?>">
                <div class="menu-item">
                    <span class="icon">🛒</span>
                    <span>Manajemen Pesanan</span>
                </div>
            </a>
            <a href="<?= base_url('admin/reviews') ?>" class="<?= ($activeMenu ?? '') === 'reviews' ? 'active' : '' ?>">
                <div class="menu-item">
                    <span class="icon">⭐</span>
                    <span>Ulasan & Rating</span>
                </div>
            </a>
            <a href="<?= base_url('admin/reports') ?>" class="<?= ($activeMenu ?? '') === 'reports' ? 'active' : '' ?>">
                <div class="menu-item">
                    <span class="icon">📊</span>
                    <span>Laporan</span>
                </div>
            </a>

            <!-- ===================== -->
    <!-- 🚀 TOMBOL LOGOUT TAMBAHAN -->
    <!-- ===================== -->
    <a href="<?= base_url('logout') ?>">
        <div class="menu-item" style="color:#b11; font-weight:600;">
            <span class="icon">🚪</span>
            <span>Logout</span>
        </div>
    </a>
        </nav>
    </aside>

    <!-- CONTENT -->
    <div class="content">
        <header class="topbar">
            <div class="topbar-title">
                <?= esc($pageTitle ?? 'Dashboard') ?>
            </div>
            <div class="topbar-right">
                <span class="status-dot"></span>
                <span>Online</span>
                <div class="avatar-circle">AU</div>
            </div>
        </header>

        <!-- ISI HALAMAN -->
        <?= $this->renderSection('content') ?>

        <footer class="footer">
            © <?= date('Y'); ?> Meltara. All rights reserved.
        </footer>
    </div>
</div>

<?= $this->renderSection('scripts') ?>
</body>
</html>
