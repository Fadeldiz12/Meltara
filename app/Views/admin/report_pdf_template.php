<?php
// app/Views/admin/report_pdf_template.php
// Pastikan variabel yang dibutuhkan tersedia saat dipanggil:
// $start, $end, $totalOrders, $totalRevenue, $avgOrderValue, $topProduct,
// $trendLabels, $trendData, $catRows, $products, $topCustomers,
// $avgRating, $totalReviews, $reviewDist, $totalShipping, $freeShippingCount
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<title>Laporan <?= esc($start ?? '') ?> — <?= esc($end ?? '') ?></title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
    /* warna & variabel */
    :root{
        --bg: #FAF8F5;
        --card: #FFFFFF;
        --muted: #7a6450;
        --accent: #C18A5C;
        --soft: #F1E9E2;
        --text: #2E2E2E;
        --radius: 10px;
        --maxw: 1100px;
    }

    /* umum */
    html,body{margin:0;padding:0;font-family: "Helvetica Neue", Arial, sans-serif;color:var(--text);background:var(--bg);font-size:12.5px}
    .wrap{max-width:var(--maxw);margin:18px auto;padding:18px;background:transparent}
    .card{background:var(--card);padding:12px;border-radius:var(--radius);border:1px solid var(--soft);box-shadow:0 4px 10px rgba(0,0,0,0.03)}
    .header{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:12px}
    .brand{display:flex;gap:12px;align-items:center}
    .logo{width:60px;height:60px;border-radius:12px;background:linear-gradient(135deg,#fff,#f7efe6);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--accent);box-shadow:0 4px 10px rgba(0,0,0,0.04)}
    .title{font-size:18px;font-weight:700}
    .subtitle{font-size:12px;color:var(--muted)}
    .meta{text-align:right;font-size:11.5px;color:var(--muted)}

    /* KPI grid */
    .kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-top:12px}
    .kpi{padding:10px}
    .kpi .label{font-size:11px;color:var(--muted);margin-bottom:6px}
    .kpi .value{font-weight:700;font-size:16px}

    /* two-column content */
    .row{display:grid;grid-template-columns:2fr 1fr;gap:12px;margin-top:12px}
    .section-title{font-weight:700;margin:0 0 8px 0;font-size:13px;color:var(--text)}

    /* compact tables */
    table{width:100%;border-collapse:collapse;font-size:12px}
    thead th{padding:8px 10px;text-align:left;color:var(--muted);font-weight:700;border-bottom:1px solid #efe6dd}
    tbody td{padding:8px 10px;border-bottom:1px solid #f5efe7;vertical-align:middle}
    .prod-img{width:56px;height:56px;object-fit:cover;border-radius:8px;border:1px solid #eee;display:block}

    /* customers list */
    .list{display:flex;flex-direction:column;gap:8px}
    .list .item{display:flex;justify-content:space-between;align-items:center;padding:8px;border-radius:8px;background:var(--card);border:1px solid #fbf6f0}
    .avatar{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:#f4e7dd;color:#8a6b4c;font-weight:700}

    /* utilities */
    .muted{color:var(--muted);font-size:12px}
    .right{text-align:right}
    .small{font-size:11px;color:var(--muted)}
    .foot{margin-top:14px;font-size:11px;color:#8a7b6d;text-align:center}

    /* page-break for PDF */
    .page-break{page-break-after:always}

    /* responsive for preview */
    @media (max-width:900px){
        .kpis{grid-template-columns:repeat(2,1fr)}
        .row{grid-template-columns:1fr}
    }
</style>
</head>
<body>
<div class="wrap">

    <div class="header">
        <div class="brand">
            <div class="logo">LOGO</div>
            <div>
                <div class="title">Laporan Penjualan</div>
                <div class="subtitle"><?= esc($start ?? '-') ?> — <?= esc($end ?? '-') ?></div>
            </div>
        </div>

        <div class="meta">
            <div class="small">Di-generate: <?= date('d M Y H:i') ?></div>
            <div class="small">Pengguna: <?= esc(session()->get('admin_name') ?? 'Admin') ?></div>
        </div>
    </div>

    <!-- KPI -->
    <div class="kpis">
        <div class="card kpi">
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp <?= number_format($totalRevenue ?? 0,0,',','.') ?></div>
            <div class="small muted">Periode terpilih</div>
        </div>
        <div class="card kpi">
            <div class="label">Total Pesanan</div>
            <div class="value"><?= number_format($totalOrders ?? 0) ?></div>
            <div class="small muted">Jumlah order</div>
        </div>
        <div class="card kpi">
            <div class="label">Rata-rata Pesanan (AOV)</div>
            <div class="value">Rp <?= number_format($avgOrderValue ?? 0,0,',','.') ?></div>
            <div class="small muted">Per transaksi</div>
        </div>
        <div class="card kpi">
            <div class="label">Produk Teratas</div>
            <div class="value"><?= esc($topProduct['product_name'] ?? '-') ?></div>
            <div class="small muted"><?= isset($topProduct['total_qty']) ? number_format($topProduct['total_qty']).' terjual' : '' ?></div>
        </div>
    </div>

    <!-- charts / summaries -->
    <div class="row">
        <div class="card">
            <div class="section-title">Ringkasan Penjualan Harian</div>
            <div class="small muted">Tabel ringkasan — untuk grafik interaktif gunakan halaman admin web.</div>

            <?php if(!empty($trendLabels) && !empty($trendData)): ?>
                <table style="margin-top:8px">
                    <thead>
                        <tr><th style="width:30%">Tanggal</th><th style="width:70%" class="right">Pendapatan (Rp)</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($trendLabels as $i => $day): ?>
                            <tr>
                                <td><?= esc($day) ?></td>
                                <td class="right">Rp <?= number_format($trendData[$i] ?? 0,0,',','.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="small muted" style="padding:8px 0">Tidak ada data tren untuk periode ini.</div>
            <?php endif; ?>
        </div>

        <div class="card">
            <div class="section-title">Performa per Kategori</div>
            <?php if(!empty($catRows)): ?>
                <table style="margin-top:8px">
                    <thead><tr><th>Kategori</th><th class="right">Revenue (Rp)</th></tr></thead>
                    <tbody>
                        <?php foreach($catRows as $c): ?>
                            <tr>
                                <td><?= esc($c['category_name'] ?? '-') ?></td>
                                <td class="right">Rp <?= number_format($c['revenue'] ?? 0,0,',','.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="small muted" style="padding:8px 0">Tidak ada data kategori.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- customers & reviews -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:12px">
        <div class="card">
            <div class="section-title">Pelanggan Unggulan</div>
            <?php if(!empty($topCustomers)): ?>
                <div class="list" style="margin-top:8px">
                    <?php foreach($topCustomers as $c): ?>
                        <div class="item">
                            <div style="display:flex;gap:10px;align-items:center">
                                <div class="avatar"><?= strtoupper(substr($c['username'] ?? ('U'.$c['user_id'] ?? 'U'),0,2)) ?></div>
                                <div>
                                    <div style="font-weight:700"><?= esc($c['username'] ?? 'User'.($c['user_id'] ?? '')) ?></div>
                                    <div class="small muted">Belanja: Rp <?= number_format($c['total_spent'] ?? 0,0,',','.') ?></div>
                                </div>
                            </div>
                            <div class="small muted"><?= isset($c['orders_count']) ? $c['orders_count'].' pesanan' : '' ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="small muted">Tidak ada data pelanggan.</div>
            <?php endif; ?>
        </div>

        <div class="card">
            <div class="section-title">Statistik Ulasan</div>
            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:6px">
                <div>
                    <div style="font-size:18px;font-weight:700"><?= $avgRating ?? 0 ?> <span class="small muted">/5</span></div>
                    <div class="small muted"><?= number_format($totalReviews ?? 0) ?> ulasan</div>
                </div>

                <div style="width:120px;text-align:right">
                    <?php if(!empty($reviewDist) && array_sum($reviewDist) > 0): ?>
                        <?php $totalDist = array_sum($reviewDist); for($i=5;$i>=1;$i--): $cnt = $reviewDist[$i] ?? 0; $pct = $totalDist ? round(($cnt/$totalDist)*100) : 0; ?>
                            <div class="small muted"><?= $i ?>★ — <?= $cnt ?> (<?= $pct ?>%)</div>
                        <?php endfor; ?>
                    <?php else: ?>
                        <div class="small muted">Tidak ada data ulasan</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- products table (page-break before if long) -->
    <div class="card" style="margin-top:12px">
        <div class="section-title">Detail Penjualan Produk</div>
        <div class="small muted">Daftar produk terjual dalam periode terpilih</div>

        <table style="margin-top:10px">
            <thead>
                <tr>
                    <th style="width:6%">ID</th>
                    <th style="width:10%">Gambar</th>
                    <th>Nama Produk</th>
                    <th style="width:12%;text-align:right">Total Terjual</th>
                    <th style="width:12%;text-align:right">Sisa Stok</th>
                    <th style="width:16%;text-align:right">Revenue (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($products)): ?>
                    <?php foreach($products as $p): ?>
                        <tr>
                            <td><?= esc($p['id'] ?? '') ?></td>
                            <td>
                                <?php if(!empty($p['gambar'])): ?>
                                    <img src="<?= esc(base_url('uploads/products/' . $p['gambar'])) ?>" alt="" class="prod-img" />
                                <?php else: ?>
                                    <div style="width:56px;height:56px;border-radius:8px;background:#f7f3ee;display:flex;align-items:center;justify-content:center;color:var(--muted)">No Img</div>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($p['name'] ?? '-') ?></td>
                            <td class="right"><?= number_format($p['qty_sold'] ?? 0) ?></td>
                            <td class="right"><?= number_format($p['stock'] ?? 0) ?></td>
                            <td class="right">Rp <?= number_format($p['revenue'] ?? 0,0,',','.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center;padding:18px;color:var(--muted)">Tidak ada data produk untuk periode ini.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- shipping & notes -->
    <div style="display:flex;gap:12px;margin-top:12px;flex-wrap:wrap">
        <div class="card" style="flex:1;min-width:260px">
            <div class="section-title">Ringkasan Pengiriman</div>
            <div class="small muted" style="margin-top:8px">Total biaya dan pengiriman gratis</div>
            <div style="margin-top:10px">
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px dashed #f6efe6">
                    <div class="small muted">Total Biaya Pengiriman</div>
                    <div style="font-weight:700">Rp <?= number_format($totalShipping ?? 0,0,',','.') ?></div>
                </div>
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px dashed #f6efe6">
                    <div class="small muted">Pengiriman Gratis (pesanan)</div>
                    <div style="font-weight:700"><?= number_format($freeShippingCount ?? 0) ?></div>
                </div>
                <div style="display:flex;justify-content:space-between;padding:8px 0">
                    <div class="small muted">Total Order</div>
                    <div style="font-weight:700"><?= number_format($totalOrders ?? 0) ?></div>
                </div>
            </div>
        </div>

        <div class="card" style="width:320px;min-width:220px">
            <div class="section-title">Catatan</div>
            <div class="small muted" style="margin-top:8px">
                Laporan dibuat berdasarkan data pesanan dan ulasan dari database pada rentang tanggal yang dipilih.
                Untuk tampilan interaktif (grafik/diagram), buka halaman admin di aplikasi web.
            </div>
        </div>
    </div>

    <div class="foot">Generated by <?= esc($_SERVER['SERVER_NAME'] ?? 'YourApp') ?> • <?= date('Y') ?></div>

</div>
</body>
</html>
