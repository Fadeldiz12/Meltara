<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="page">

    <h1>Pengaturan Produk</h1>

    <div class="card">

        <div class="card-header">
            <h2>Daftar Produk</h2>

            <a href="<?= base_url('/admin/products/add'); ?>">
                <button class="btn-add">Tambah Product</button>
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nomor Produk</th>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Stock</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>

                        <!-- Nomor Produk -->
                        <td><?= 'PRD' . str_pad($p['id'], 4, '0', STR_PAD_LEFT) ?></td>

                        <!-- Gambar Produk -->
                        <td>
                            <?php
                                $filename = $p['gambar'] ?? '';

                                $uploadDir = FCPATH . 'uploads/products/';
                                $baseUrl   = base_url('uploads/products/');

                                if (!empty($filename)) {
                                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                                    if ($ext === '') {
                                        $found = false;
                                        $candidates = ['jpg','jpeg','png'];

                                        foreach ($candidates as $e) {
                                            $candidate = $filename . '.' . $e;
                                            if (is_file($uploadDir . $candidate)) {
                                                $filename = $candidate;
                                                $found = true;
                                                break;
                                            }
                                        }
                                    }
                                }

                                $imgPath = $uploadDir . $filename;
                                $imgUrl  = $baseUrl . $filename;
                            ?>

                            <?php if (!empty($filename) && is_file($imgPath)): ?>
                                <img src="<?= $imgUrl ?>"
                                     alt="<?= esc($p['name']) ?>"
                                     style="
                                        width:60px;
                                        height:60px;
                                        border-radius:8px;
                                        object-fit:cover;
                                        object-position:center;
                                     ">
                            <?php else: ?>
                                <span style="color:#777; font-size:12px;">Tidak ada gambar</span>
                            <?php endif; ?>
                        </td>

                        <!-- Nama Produk -->
                        <td><?= esc($p['name']) ?></td>

                        <!-- Stock -->
                        <td><?= esc($p['stock']) ?></td>

                        <!-- Harga -->
                        <td>Rp <?= number_format($p['price'], 0, ',', '.') ?></td>

                        <!-- Kategori -->
                        <td><?= esc($p['category_name']) ?></td>

                        <!-- Tombol Aksi -->
                        <td class="table-actions">
                            <a href="<?= base_url('/admin/products/edit/'.$p['id']) ?>">
                                <button class="btn-edit">Edit</button>
                            </a>

                            <a href="<?= base_url('/admin/products/delete/'.$p['id']) ?>"
                               onclick="return confirm('Hapus produk ini?')">
                                <button class="btn-delete">Hapus</button>
                            </a>
                        </td>

                    </tr>
                <?php endforeach ?>
            </tbody>

        </table>

    </div>

</div>

<?= $this->endSection() ?>
