<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('css/admin-orders.css') ?>">

<div class="admin-order-page">
    <h1 class="page-title">Detail Pesanan</h1>

    <div class="detail-card">
        <div class="left">
            <h3>Order</h3>
            <p><b>No:</b> <?= esc($order['order_number'] ?? '-') ?></p>
            <p><b>Tanggal:</b> <?= isset($order['order_date']) ? date('d M Y', strtotime($order['order_date'])) : '-' ?></p>

            <p><b>Status Pesanan:</b> <?= esc($order['status'] ?? '-') ?></p>
            <p><b>Status Pembayaran:</b> <?= esc($order['payment_status'] ?? '-') ?></p>
            <p><b>Metode:</b> <?= esc($order['payment_method'] ?? '-') ?></p>

            <h4>Shipping</h4>
            <p><b>Penerima:</b> <?= esc($shipping['recipient'] ?? '-') ?></p>
            <p><b>Alamat:</b> <?= esc($shipping['address'] ?? '-') ?></p>
            <p><b>Telp:</b> <?= esc($shipping['phone'] ?? '-') ?></p>
            <p><b>Status Kirim:</b> <?= esc($shipping['delivery_status'] ?? 'Dikemas') ?></p>

            <!-- ================== VERIFIKASI PEMBAYARAN ================== -->
            <?php if (($order['payment_method'] ?? '') === 'QRIS'): ?>
                <hr>
                <h4>Verifikasi Pembayaran</h4>

                <?php if (!empty($proofPath)): ?>
                    <img src="<?= $proofPath ?>" style="max-width:220px;border-radius:8px;margin-bottom:10px;">
                <?php else: ?>
                    <p><i>Bukti pembayaran belum diupload</i></p>
                <?php endif; ?>

                <?php if (($order['payment_status'] ?? '') !== 'Success'): ?>
                    <form action="<?= base_url('admin/order/approvePayment/'.$order['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn-approve">Approve Pembayaran</button>
                    </form>

                    <form action="<?= base_url('admin/order/rejectPayment/'.$order['id']) ?>" method="post" style="margin-top:6px;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn-reject">Reject Pembayaran</button>
                    </form>
                <?php else: ?>
                    <p style="color:green;font-weight:bold;margin-top:8px;">
                        ✔ Pembayaran telah diverifikasi
                    </p>
                <?php endif; ?>
            <?php endif; ?>

            <!-- ================== UPDATE STATUS PENGIRIMAN ================== -->
<?php if (in_array(($order['payment_status'] ?? ''), ['Pending','Success'])): ?>
    <hr>
    <h4>Update Status Pesanan</h4>

    <form method="POST" action="<?= base_url('admin/order/updateOrderStatus/'.$order['id']) ?>">
        <?= csrf_field() ?>

        <select name="status"
            onchange="this.form.submit()"
            style="padding:8px;border-radius:6px;border:1px solid #C9B299;width:100%;margin-top:8px;">

            <option value="Dikemas" <?= ($order['status'] ?? '') === 'Dikemas' ? 'selected' : '' ?>>Dikemas</option>
            <option value="Dikirim" <?= ($order['status'] ?? '') === 'Dikirim' ? 'selected' : '' ?>>Dikirim</option>
            <option value="Selesai" <?= ($order['status'] ?? '') === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
        </select>
    </form>
<?php endif; ?>


        </div>

        <div class="right">
            <h4>Items</h4>
            <table class="items-table">
                <?php foreach ($items ?? [] as $it): ?>
                    <tr>
                        <td><?= esc($it['product_name']) ?> x<?= (int)$it['quantity'] ?></td>
                        <td style="text-align:right">
                            Rp <?= number_format((int)($it['subtotal'] ?? 0),0,',','.') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <tr class="total-row">
                    <td><b>Total</b></td>
                    <td style="text-align:right">
                        <b>Rp <?= number_format((int)($order['total_amount'] ?? 0),0,',','.') ?></b>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <a href="<?= base_url('admin/orders') ?>" class="btn-back">Kembali</a>
</div>

<?= $this->endSection() ?>
