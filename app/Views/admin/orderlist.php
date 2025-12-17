<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('css/admin-orders.css') ?>">

<div class="admin-order-page">
    <h1 class="page-title">Order Managemnt</h1>

    <div class="tabs">
        <?php
        $tabs = [
            'all' => 'Semua',
            'Pending' => 'Pending',
            'Confirmed' => 'Confirmed',
            'Shipped' => 'Shipped',
            'Completed' => 'Completed',
        ];
        foreach($tabs as $key => $label):
            $k = $key;
            $active = ($activeStatus === $k) ? 'tab-active' : '';
            $url = base_url('admin/orders') . '?status=' . $k;
        ?>
            <a class="tab <?= $active ?>" href="<?= $url ?>"><?= $label ?></a>
        <?php endforeach; ?>
    </div>

    <div class="orders-card">
        <h2 class="orders-title">Daftar Pesanan</h2>

        <table class="orders-table">
            <thead>
                <tr>
                    <th>Nomor Pesanan</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($orders)): ?>
                    <tr><td colspan="6" style="text-align:center;padding:18px;">Belum ada pesanan</td></tr>
                <?php else: ?>
                    <?php foreach($orders as $o): ?>
                        <tr>
                            <td><?= esc($o['order_number']) ?></td>
                            <td><?= isset($o['order_date']) ? date('Y-m-d', strtotime($o['order_date'])) : '-' ?></td>
                            <td><?= esc($o['customer_name'] ?? ($o['user_id'] ?? '-')) ?></td>
                            <td>Rp <?= number_format($o['total_amount'] ?? ($o['subtotal'] ?? 0),0,',','.') ?></td>
                            <td>
                                <span class="status <?= strtolower($o['status']) ?>"><?= esc($o['status']) ?></span>
                            </td>
                            <td>
                                <a class="btn-detail" href="<?= base_url('admin/orders/'.$o['id']) ?>">Lihat Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
