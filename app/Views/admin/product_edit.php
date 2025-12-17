<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>



<div class="form-container">

<div class="form-card">
<div class="form-grid">

<form id="productForm" action="<?= base_url('/admin/products/update/'.$product['id']) ?>" method="POST" enctype="multipart/form-data">

<!-- LEFT FORM -->
<div>
    <div class="form-title">Edit Produk</div>

    <label>Nama Produk</label>
    <input type="text" name="name" required value="<?= $product['name']; ?>">

    <label>Kategori</label>
    <select name="category_id" required>
        <option value="">-- Pilih Kategori --</option>
        <?php foreach($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" 
                <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                <?= $cat['name'] ?>
            </option>
        <?php endforeach ?>
    </select>

    <label>Stock</label>
    <input type="number" name="stock" required value="<?= $product['stock']; ?>">

    <label>Harga</label>
    <input type="number" name="price" required value="<?= $product['price']; ?>">

    <label>Deskripsi</label>
    <textarea name="description"><?= $product['description']; ?></textarea>

    <label>Gambar Produk (Opsional)</label>
    <input type="file" name="gambar">
</div>

</form>

<div class="image-box">
    <img id="previewImage" 
         src="<?= base_url('images/cookies.jpg'); ?>" 
         class="preview-img">

    <div class="button-area">
        <button class="btn-save" type="submit" form="productForm">Save</button>

        <a href="<?= base_url('/admin/products'); ?>">
            <button type="button" class="btn-cancel">Cancel</button>
        </a>
    </div>
</div>

</div>
</div>

<script>
document.querySelector('input[name="gambar"]').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('previewImage');

    if (file) {
        preview.src = URL.createObjectURL(file);
    } else {
        preview.src = "<?= base_url('images/cookies.jpg'); ?>";
    }
});
</script>

<?= $this->endSection() ?>
