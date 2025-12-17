<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('css/admin-orders.css') ?>"> <!-- kamu bisa reuse css -->
<style>
.review-card{background:#f3e6df;padding:28px;border-radius:14px;border:1px solid #e1cfc3;margin-top:18px;}
.table-review{width:100%;border-collapse:collapse}
.table-review th{background:transparent;padding:12px 14px;text-align:left;color:#4a2f1a;font-weight:700}
.table-review td{background:#fffdf7;padding:16px;border-bottom:1px solid rgba(0,0,0,0.04)}
.table-review tr:nth-child(even) td{background:#f7efe9}
.action-btn{display:inline-block;padding:8px 12px;border-radius:8px;text-decoration:none;border:1px solid #c8a8a0;background:white;color:#6b3f10;margin-left:8px}
.btn-delete{border-color:#f2a6a6;color:#c33;background:#fff}
.badge-approved{background:rgba(79,123,101,0.12);padding:6px 10px;border-radius:16px;color:#2e5a3d;font-weight:600}
.badge-pending{background:rgba(210,190,165,0.12);padding:6px 10px;border-radius:16px;color:#6b4424;font-weight:600}
.badge-rejected{color:#a33}
</style>

<div class="page-header">
    <h1>Review & Rating Management</h1>
</div>

<div class="review-card">
    <h3>Moderasi Ulasan Pelanggan</h3>

    <table class="table-review">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Customer</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($reviews)): ?>
                <tr><td colspan="6" style="text-align:center;padding:18px;">Belum ada ulasan</td></tr>
            <?php endif; ?>

            <?php foreach($reviews as $r): ?>
                <tr>
                    <td><?= esc($r['product_name'] ?? '-') ?></td>
                    <td><?= esc($r['username'] ?? ($r['user_id'] ?? '-')) ?></td>
                    <td>
                        <?php
                            $full = floor($r['rating']);
                            for($i=0;$i<$full;$i++){ echo '★ '; }
                            if($r['rating'] - $full >= 0.5) echo '☆';
                        ?>
                    </td>
                    <td><?= esc($r['comment']) ?></td>
                    <td>
                        <?php if($r['is_approved'] == 1): ?>
                            <span class="badge-approved">Approved</span>
                        <?php elseif($r['is_approved'] == 2): ?>
                            <span class="badge-rejected">Rejected</span>
                        <?php else: ?>
                            <span class="badge-pending">Pending</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($r['is_approved'] != 1): ?>
                            <a href="<?= base_url('admin/reviews/approve/'.$r['id']) ?>" class="action-btn">Approved</a>
                        <?php endif; ?>
                        <?php if($r['is_approved'] != 2): ?>
                            <a href="<?= base_url('admin/reviews/reject/'.$r['id']) ?>" class="action-btn">Reject</a>
                        <?php endif; ?>
                        <a href="<?= base_url('admin/reviews/delete/'.$r['id']) ?>" class="action-btn btn-delete" onclick="return confirm('Hapus review ini?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?= $this->endSection() ?>
