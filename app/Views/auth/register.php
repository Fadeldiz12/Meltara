<?= $this->extend('layout/auth_layout') ?>
<?= $this->section('content') ?>

<div class="auth-container">
    <div class="auth-box reverse slide-right"><!-- reverse = gambar ke kanan -->

        <!-- Cake Card -->
        <div class="cake-card">
            <img src="<?= base_url('images/cake.png') ?>" alt="Cake">
        </div>

        <!-- Sign Up Form -->
        <div class="form-card">
            <h2>Sign Up</h2>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif ?>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif ?>

<form action="/register" method="POST">

    <label>Username</label>
    <input type="text" name="username" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Confirm Password</label>
    <input type="password" name="confirm_password" required>

    <button type="submit" class="btn-login">Sign Up</button>

                <p class="register-text">
                    Already have an account? <a href="/login">Login</a>
                </p>

            </form>

        </div>

    </div>
</div>

<?= $this->endSection() ?>