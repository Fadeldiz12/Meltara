<?= $this->extend('layout/admin_template') ?>
<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/admin-orders.css') ?>">
<style>
/* tambahan styling ringkas untuk cards dan grid */
.report-grid { display:grid; grid-template-columns: repeat(4,1fr); gap:18px; margin-top:18px; }
.report-card { background:#fff; padding:18px; border-radius:12px; border:1px solid #f0e6dd; box-shadow:0 6px 12px rgba(0,0,0,0.03); }
.report-card .title { font-size:13px; color:#7a6450; margin-bottom:8px; }
.report-card .value { font-size:22px; font-weight:700; color:#3f2f23; }
.charts { display:grid; grid-template-columns: 1fr 1fr; gap:18px; margin-top:20px; }
.products-table { margin-top:18px; width:100%; border-collapse:collapse; }
.products-table th, .products-table td { padding:14px; text-align:left; border-bottom:1px solid #f1e9e2; }
.products-table img { width:56px; height:56px; object-fit:cover; border-radius:8px; }
.card { background: var(--bg-card); padding:20px; border-radius:12px; border:1px solid var(--border-soft); }

/* tombol sederhana */
.btn-add { background: #C18A5C; color:#fff; padding:8px 14px; border-radius:12px; text-decoration:none; display:inline-block; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page">
    <div class="page-title">Laporan & Statistik</div>
    <div class="page-subtitle">Pantau performa penjualan dan analisis bisnis Anda</div>

    <!-- filter form -->
    <form method="get" action="<?= base_url('admin/reports') ?>" id="reportFilterForm">
        <div style="margin-top:12px" class="card">
            <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap">
                <div style="flex:1;display:flex;gap:8px;align-items:center">
                    <label style="min-width:110px">Pilih Rentang Tanggal</label>

                    <!-- pastikan value memakai format Y-m-d -->
                    <input type="date" name="start" value="<?= esc(date('Y-m-d', strtotime($start ?? date('Y-m-d', strtotime('-30 days'))))) ?>">
                    <input type="date" name="end"   value="<?= esc(date('Y-m-d', strtotime($end ?? date('Y-m-d')))) ?>">
                </div>

                <div style="flex:1;display:flex;gap:8px;align-items:center">
                    <label style="min-width:130px">Kategori Produk</label>
                    <select name="category">
                        <option value="0" <?= (int)($selectedCategory ?? 0) === 0 ? 'selected' : '' ?>>Semua</option>
                        <?php foreach($categories as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= (int)($selectedCategory ?? 0) === (int)$c['id'] ? 'selected' : '' ?>><?= esc($c['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="margin-left:auto;display:flex;gap:8px;align-items:center">
                    <button type="submit" class="btn-add">Terapkan Filter</button>
                    <a href="#" id="exportPdfBtn" class="btn-add" style="background:#b66b3d">Export PDF</a>
                </div>
            </div>
        </div>
    </form>

    <!-- KPI CARDS -->
    <div class="report-grid">
        <div class="report-card">
            <div class="title">Total Pendapatan</div>
            <div class="value">Rp <?= number_format($totalRevenue,0,',','.') ?></div>
            <div style="color:#7a6450;font-size:13px;margin-top:8px">Periode berjalan</div>
        </div>
        <div class="report-card">
            <div class="title">Total Pesanan</div>
            <div class="value"><?= number_format($totalOrders) ?></div>
            <div style="color:#7a6450;font-size:13px;margin-top:8px">Periode berjalan</div>
        </div>
        <div class="report-card">
            <div class="title">Rata-Rata Nilai Pesanan (AOV)</div>
            <div class="value">Rp <?= number_format($avgOrderValue,0,',','.') ?></div>
            <div style="color:#7a6450;font-size:13px;margin-top:8px">Per transaksi</div>
        </div>
        <div class="report-card">
            <div class="title">Produk Terlaris</div>
            <div class="value"><?= esc($topProduct['product_name'] ?? '-') ?></div>
            <div style="color:#7a6450;font-size:13px;margin-top:8px"><?= isset($topProduct['total_qty']) ? number_format($topProduct['total_qty']).' terjual' : '' ?></div>
        </div>
    </div>

    <!-- CHARTS -->
    <div class="charts">
        <div class="card">
            <h3 style="margin-bottom:12px">Tren Penjualan</h3>
            <canvas id="trendChart" height="220"></canvas>
        </div>

        <div class="card">
            <h3 style="margin-bottom:12px">Performa Penjualan per Kategori</h3>
            <canvas id="catChart" height="220"></canvas>
        </div>
    </div>

    <!-- ================= Laporan Pelanggan & Statistik Ulasan ================= -->
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-top:20px">
        <!-- Pelanggan Teratas -->
        <div class="card">
            <h4 style="margin-bottom:8px">Pelanggan Teratas</h4>
            <p style="color:#7a6450">Total belanja tertinggi</p>
            <div style="margin-top:12px">
                <?php if(!empty($topCustomers)): ?>
                    <?php foreach($topCustomers as $c): ?>
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px dashed #f0e6dd">
                            <div>
                                <div style="font-weight:600"><?= esc($c['username'] ?? 'User'.$c['user_id']) ?></div>
                                <div style="color:#7a6450;font-size:13px"><?= 'Rp '.number_format($c['total_spent'],0,',','.') ?></div>
                            </div>
                            <div style="width:40px;height:40px;border-radius:50%;background:#f4e7dd;display:flex;align-items:center;justify-content:center;font-weight:700;color:#8a6b4c">
                                <?= strtoupper(substr($c['username'] ?? 'U',0,2)) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Tidak ada data</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pelanggan Baru -->
        <div class="card">
            <h4>Pelanggan Baru</h4>
            <p style="color:#7a6450">Transaksi pertama kali</p>
            <div style="margin-top:12px">
                <?php if(!empty($newCustomers)): ?>
                    <?php foreach($newCustomers as $n): ?>
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px dashed #f0e6dd">
                            <div>
                                <div style="font-weight:600"><?= esc($n['username'] ?? 'User'.$n['user_id']) ?></div>
                                <div style="color:#7a6450;font-size:13px"><?= date('d M Y', strtotime($n['first_order'])) ?></div>
                            </div>
                            <div style="width:36px;height:36px;border-radius:50%;background:#efe0d5;display:flex;align-items:center;justify-content:center">
                                <?= strtoupper(substr($n['username'] ?? 'N',0,2)) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Tidak ada pelanggan baru</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pelanggan Kembali -->
        <div class="card">
            <h4>Pelanggan Kembali</h4>
            <p style="color:#7a6450">Berbelanja berulang kali</p>
            <div style="margin-top:12px">
                <?php if(!empty($returningCustomers)): ?>
                    <?php foreach($returningCustomers as $r): ?>
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px dashed #f0e6dd">
                            <div>
                                <div style="font-weight:600"><?= esc($r['username'] ?? 'User'.$r['user_id']) ?></div>
                                <div style="color:#7a6450;font-size:13px"><?= $r['orders_count'] ?> pesanan</div>
                            </div>
                            <div style="width:36px;height:36px;border-radius:50%;background:#e9f6ee;display:flex;align-items:center;justify-content:center;color:#2b7a4a">
                                <?= strtoupper(substr($r['username'] ?? 'R',0,2)) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Tidak ada pelanggan kembali</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Statistik Ulasan & Ringkasan Pengiriman -->
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:18px;margin-top:18px">
        <div class="card">
            <h4>Statistik Ulasan Produk</h4>
            <div style="display:flex;gap:18px;align-items:center;margin-top:12px">
                <div style="flex:1;background:#fff;padding:18px;border-radius:10px">
                    <div style="font-size:28px;font-weight:700"><?= $avgRating ?> <span style="font-size:14px;color:#7a6450">dari 5.0</span></div>
                    <div style="color:#7a6450;margin-top:6px"><?= $totalReviews ?> ulasan</div>
                </div>
                <div style="width:280px">
                    <canvas id="reviewDonut" width="280" height="140"></canvas>
                </div>
            </div>

            <div style="margin-top:12px">
                <h5>Produk dengan Ulasan Terbanyak</h5>
                <ul style="list-style:none;padding-left:0;margin-top:8px">
                    <?php if(!empty($topReviewedProducts)): ?>
                        <?php foreach($topReviewedProducts as $tp): ?>
                            <li style="padding:10px 0;border-bottom:1px dashed #f0e6dd;display:flex;justify-content:space-between">
                                <div><?= esc($tp['product_name'] ?? '-') ?></div>
                                <div style="color:#7a6450"><?= $tp['review_count'] ?> ulasan</div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>Tidak ada data ulasan</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="card">
            <h4>Ringkasan Pengiriman</h4>
            <div style="margin-top:12px">
                <div style="padding:12px;background:#fff;border-radius:10px;margin-bottom:10px">
                    <div style="color:#7a6450;font-size:13px">Total Biaya Pengiriman</div>
                    <div style="font-weight:700;font-size:18px">Rp <?= number_format($totalShipping,0,',','.') ?></div>
                    <div style="color:#7a6450;font-size:13px;margin-top:6px">Terkumpul periode ini</div>
                </div>

                <div style="padding:12px;background:#fff;border-radius:10px;margin-bottom:10px">
                    <div style="color:#7a6450;font-size:13px">Pengiriman Gratis</div>
                    <div style="font-weight:700"><?= $freeShippingCount ?> pesanan</div>
                </div>

                <div style="padding:12px;background:#fff;border-radius:10px">
                    <div style="color:#7a6450;font-size:13px">Total Order</div>
                    <div style="font-weight:700"><?= number_format($totalOrders) ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Produk Terjual Table -->
    <div class="card" style="margin-top:20px">
        <h3>Penjualan Produk</h3>
        <p style="color:#7a6450;margin-bottom:12px">Detail penjualan per produk dalam periode terpilih</p>

        <table class="products-table">
            <thead>
                <tr>
                    <th>Gambar Produk</th>
                    <th>Nama Produk</th>
                    <th>Total Terjual</th>
                    <th>Sisa Stok</th>
                    <th>Kontribusi Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($productRows)): ?>
                    <tr><td colspan="5" style="text-align:center;padding:18px;">Tidak ada data produk pada periode ini</td></tr>
                <?php endif; ?>

                <?php foreach($productRows as $p): ?>
                <tr>
                    <td><img src="<?= base_url('uploads/products/' . ($p['gambar'] ?? 'placeholder.png')) ?>" alt="" /></td>
                    <td><?= esc($p['name']) ?></td>
                    <td><?= number_format($p['qty_sold'] ?? 0) ?></td>
                    <td><span style="background:#eaf7ec;padding:6px 10px;border-radius:12px"><?= esc($p['stock'] ?? 0) ?></span></td>
                    <td>Rp <?= number_format($p['revenue'] ?? 0,0,',','.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// agar tombol Export selalu mengirim parameter yang sama dg form filter,
// kita baca value form dan buat query string saat tombol diklik.
document.getElementById('exportPdfBtn').addEventListener('click', function(e) {
    e.preventDefault();
    const f = document.getElementById('reportFilterForm');
    const params = new URLSearchParams(new FormData(f)).toString();
    window.location.href = "<?= base_url('admin/reports/export/pdf') ?>" + "?" + params;
});

const trendLabels = <?= json_encode($trendLabels) ?>;
const trendData = <?= json_encode($trendData) ?>;
const catRows = <?= json_encode(array_column($catRows, 'revenue', 'category_name')) ?>;

// Trend chart
const ctx = document.getElementById('trendChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: trendLabels,
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: trendData,
            tension: 0.35,
            fill: false,
            borderColor: '#C18A5C',
            pointBackgroundColor: '#C18A5C',
            pointRadius: 4
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                    }
                }
            }
        }
    }
});

// Category chart
const ctx2 = document.getElementById('catChart').getContext('2d');
const catLabels = Object.keys(catRows);
const catData = Object.values(catRows);
new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: catLabels,
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: catData,
            backgroundColor: '#D9C3A7'
        }]
    },
    options: {
        indexAxis: 'y',
        scales: {
            x: {
                ticks: {
                    callback: function(value) { return 'Rp ' + new Intl.NumberFormat('id-ID').format(value); }
                }
            }
        }
    }
});

// review donut
const reviewCtx = document.getElementById('reviewDonut').getContext('2d');
const reviewData = <?= json_encode(array_values($reviewDist ?? [0,0,0,0,0])) ?>;
const reviewLabels = ['1 bintang','2 bintang','3 bintang','4 bintang','5 bintang'];
new Chart(reviewCtx, {
    type: 'doughnut',
    data: {
        labels: reviewLabels,
        datasets: [{
            data: reviewData,
            backgroundColor: ['#f5e6e6','#edd6c8','#e7c9a8','#d9c3a7','#c18a5c']
        }]
    },
    options: {
        plugins: { legend: { position: 'right' } }
    }
});
</script>
<?= $this->endSection() ?>
