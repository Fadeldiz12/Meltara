<?php 
$cart = session()->get('cart') ?? [];
$totalItems = 0;
foreach ($cart as $c) {
    $totalItems += $c['qty'];
}
?>

<nav class="navbar">
    <!-- LEFT -->
    <div class="nav-left">
        <img src="<?= base_url('images/logo.png') ?>" alt="Logo">
        <h1 class="brand">Meltara</h1>
    </div>

    <!-- HAMBURGER -->
    <div class="hamburger" id="hamburgerBtn">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <!-- CENTER MENU -->
    <div class="nav-center" id="navMenu">
        <a href="<?= base_url('/') ?>">Home</a>
        <a href="<?= base_url('/menu') ?>">Menu</a>
        <a href="<?= base_url('/pesanan') ?>">Daftar Pesanan</a>
<a href="<?= base_url('/histori') ?>">Histori</a>
    </div>

    <!-- RIGHT -->
    <div class="nav-right">
        <a href="<?= base_url('/cart') ?>" class="icon-box">
            🛒
            <?php if ($totalItems > 0): ?>
                <span class="cart-badge"><?= $totalItems ?></span>
            <?php endif; ?>
        </a>
        <a href="<?= base_url('/login') ?>" class="icon-box">👤</a>
    </div>
</nav>

<script>
// toggle menu responsive
const hamburger = document.getElementById('hamburgerBtn');
const navMenu = document.getElementById('navMenu');

hamburger.addEventListener('click', () => {
    navMenu.classList.toggle('active');
});
</script>
