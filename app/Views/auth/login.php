<?= $this->extend('layout/auth_layout') ?>
<?= $this->section('content') ?>

<div class="auth-container">
    <div class="auth-box slide-left"><!-- default posisi login -->

        <!-- Cake Card -->
        <div class="cake-card">
            <img src="<?= base_url('images/cake.png') ?>" alt="Cake">
        </div>

        <!-- Login Form -->
        <div class="form-card">
            <h2>Login</h2>

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

            <form action="/login" method="POST">

                <label>Email</label>
                <input type="email" name="email" required>

                <label>Password</label>
                <input type="password" name="password" required>

                <button type="submit" class="btn-login">Login</button>

                <div class="auth-links">
                    <span>Create an account? <a href="/register">Sign Up</a></span>
                    <span><a href="/forgot-password">Forgot Password?</a></span>
                </div>

            </form>
        </div>

    </div>
</div>

<?= $this->endSection() ?>