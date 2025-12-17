<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>



<div class="form-container">

<div class="form-card">
<div class="form-grid">

<form id="productForm" action="<?= base_url('/admin/products/store') ?>" method="POST" enctype="multipart/form-data">


<!-- LEFT FORM -->
<div>
    <div class="form-title">Penambahan Produk</div>

    <label>Nama Produk</label>
    <input type="text" name="name" required>

    <label>Kategori</label>
    <select name="category_id" required>
        <option value="">-- Pilih Kategori --</option>
        <?php foreach($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
        <?php endforeach ?>
    </select>

    <label>Stock</label>
    <input type="number" name="stock" required>

    <label>Harga</label>
    <input type="number" name="price" required>

    <label>Deskripsi</label>
    <textarea name="description"></textarea>

    <label>Gambar Produk</label>
    <input type="file" name="gambar" required>
</div>

</form>

<!-- RIGHT IMAGE -->
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
