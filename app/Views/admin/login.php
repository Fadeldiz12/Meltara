<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS LOGIN (yang sudah kamu buat sebelumnya) -->
    <link rel="stylesheet" href="<?= base_url('css/auth.css') ?>">
</head>
<body>

<div class="auth-container">
    <div class="auth-box slide-left">

        <!-- Gambar Cake / Ilustrasi -->
        <div class="cake-card">
            <img src="<?= base_url('images/cake.png') ?>" alt="Cake">
        </div>

        <!-- FORM LOGIN ADMIN -->
        <div class="form-card">
            <h2>Admin Login</h2>

            <!-- ERROR MESSAGE -->
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- SUCCESS MESSAGE -->
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/login') ?>" method="post">

                <label>Email</label>
                <input type="email" name="email" required value="<?= old('email') ?>">

                <label>Password</label>
                <input type="password" name="password" required>

                <button type="submit" class="btn-login">Login</button>

                <div class="auth-links">
                    <a href="<?= base_url('/') ?>">Back to Website</a>
                </div>

            </form>
        </div>

    </div>
</div>

</body>
</html>
