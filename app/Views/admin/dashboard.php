<?= $this->extend('layout/admin_template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/admin-dashboard.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>Dashboard</h1>
</div>

<!-- ====== KARTU STATISTIK ====== -->
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-label">Total Produk</div>
        <div class="kpi-value"><?= esc($totalProducts) ?></div>
    </div>

    <div class="kpi-card">
        <div class="kpi-label">Total Pesanan</div>
        <div class="kpi-value"><?= esc($totalOrders) ?></div>
        <div class="kpi-sub">Bulan ini</div>
    </div>

    <div class="kpi-card">
        <div class="kpi-label">Total Pendapatan</div>
        <div class="kpi-value">Rp <?= number_format($totalRevenue, 0, ',', '.') ?></div>
        <div class="kpi-sub">Bulan ini</div>
    </div>

    <div class="kpi-card">
        <div class="kpi-label">Pesanan Menunggu</div>
        <div class="kpi-value"><?= esc($pendingOrders) ?></div>
    </div>

    <div class="kpi-card">
        <div class="kpi-label">Rating Produk Rata-Rata</div>
        <div class="kpi-value"><?= esc(number_format($avgRating, 1, ',', '.')) ?></div>
        <div class="kpi-sub">Dari 5.0</div>
    </div>

    <div class="kpi-card">
        <div class="kpi-label">Produk Habis</div>
        <div class="kpi-value"><?= esc($outOfStock) ?></div>
    </div>
</div>

<!-- ====== GRAFIK ====== -->
<div class="chart-row">
    <div class="card">
        <h2>Penjualan dalam 30 Hari Terakhir</h2>
        <canvas id="sales30daysChart"></canvas>
    </div>

    <div class="card">
        <h2>Penjualan per Kategori</h2>
        <canvas id="salesByCategoryChart"></canvas>
    </div>
</div>

<!-- ====== PESANAN TERBARU + STOK RENDAH ====== -->
<div class="two-column-row">
    <div class="card">
        <h2>Pesanan Terbaru</h2>
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total Belanja</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentOrders as $order): ?>
                        <tr>
                            <td><?= esc($order['order_number']) ?></td>
                            <td><?= esc($order['customer_name'] ?? '-') ?></td>
                            <td><?= esc(date('Y-m-d', strtotime($order['order_date']))) ?></td>
                            <td>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                            <td>
                                <?php
                                    $status = $order['status'];
                                    $badgeClass = 'badge-secondary';
                                    $statusLabel = ucfirst($status);

                                    if ($status === 'completed') {
                                        $badgeClass = 'badge-success';
                                        $statusLabel = 'Selesai';
                                    } elseif ($status === 'pending') {
                                        $badgeClass = 'badge-warning';
                                        $statusLabel = 'Menunggu';
                                    } elseif ($status === 'processing') {
                                        $badgeClass = 'badge-info';
                                        $statusLabel = 'Diproses';
                                    } elseif ($status === 'cancelled') {
                                        $badgeClass = 'badge-danger';
                                        $statusLabel = 'Dibatalkan';
                                    }
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= $statusLabel ?></span>
                            </td>
                            <td>
                                <a href="#" class="icon-button" title="Lihat Detail">
                                    👁
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <h2>Peringatan Stok Rendah</h2>
        <ul class="low-stock-list">
            <?php foreach ($lowStockProducts as $p): ?>
                <li class="low-stock-item">
                    <div class="product-name"><?= esc($p['name']) ?></div>
                    <div class="product-stock">Stok: <?= esc($p['stock']) ?></div>
                    <?php
                        $stock = (int) $p['stock'];
                        if ($stock <= 0) {
                            $label = 'Habis';
                            $cls   = 'badge-danger';
                        } elseif ($stock <= 5) {
                            $label = 'Stok Menipis';
                            $cls   = 'badge-warning';
                        } else {
                            $label = 'Aktif';
                            $cls   = 'badge-success';
                        }
                    ?>
                    <span class="badge <?= $cls ?>"><?= $label ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<!-- ====== ULASAN TERBARU ====== -->
<div class="card">
    <h2>Ulasan Terbaru</h2>
    <div class="reviews-grid">
        <?php foreach ($latestReviews as $review): ?>
            <div class="review-card">
                <div class="review-header">
                    <div class="avatar">
                        <?php
                            $nama = $review['customer_name'] ?? '-';
                            $inisial = '';
                            $parts = explode(' ', $nama);
                            if (isset($parts[0][0])) $inisial .= strtoupper($parts[0][0]);
                            if (isset($parts[1][0])) $inisial .= strtoupper($parts[1][0]);
                        ?>
                        <?= esc($inisial) ?>
                    </div>
                    <div>
                        <div class="customer-name"><?= esc($nama) ?></div>
                        <div class="product-name-small"><?= esc($review['product_name'] ?? '-') ?></div>
                    </div>
                    <div class="review-status">
                        <?php
                            $approved = (int)($review['is_approved'] ?? 0);
                            $cls   = $approved === 1 ? 'badge-success' : 'badge-warning';
                            $label = $approved === 1 ? 'Disetujui' : 'Menunggu';
                        ?>
                        <span class="badge <?= $cls ?>"><?= $label ?></span>
                    </div>
                </div>
                <div class="review-rating">
                    <?php
                        $rating = (int) $review['rating'];
                        for ($i = 1; $i <= 5; $i++):
                    ?>
                        <span class="star <?= $i <= $rating ? 'filled' : '' ?>">★</span>
                    <?php endfor; ?>
                </div>
                <p class="review-comment">
                    <?= esc($review['comment']) ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const salesLabels   = <?= json_encode($salesChart['labels'] ?? []) ?>;
    const salesData     = <?= json_encode($salesChart['data'] ?? []) ?>;
    const categoryLabels = <?= json_encode($categoryChart['labels'] ?? []) ?>;
    const categoryData   = <?= json_encode($categoryChart['data'] ?? []) ?>;

    const ctxSales = document.getElementById('sales30daysChart').getContext('2d');
    new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: salesLabels,
            datasets: [{
                label: 'Total Penjualan',
                data: salesData,
                tension: 0.4,
                fill: false,
                borderColor: '#CBA78E',
                pointBackgroundColor: '#CBA78E'
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    const ctxCat = document.getElementById('salesByCategoryChart').getContext('2d');
    new Chart(ctxCat, {
        type: 'bar',
        data: {
            labels: categoryLabels,
            datasets: [{
                label: 'Total Terjual',
                data: categoryData,
                borderRadius: 10,
                backgroundColor: '#CBA78E'
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
<?= $this->endSection() ?>
