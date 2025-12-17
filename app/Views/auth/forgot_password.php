<?= $this->extend('layout/auth_layout') ?>
<?= $this->section('content') ?>

<div class="auth-container">
    <div class="auth-box slide-left">

        <!-- Cake Card -->
        <div class="cake-card">
            <img src="<?= base_url('images/cake.png') ?>" alt="Cake">
        </div>

        <!-- Reset Password Form -->
        <div class="form-card">
            <h2>Forgot Password</h2>

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

            <form action="<?= base_url('/forgot-password') ?>" method="POST">

                <label>Email</label>
                <input type="email" name="email" required>

                <button type="submit" class="btn-login">Send Reset Link</button>

                <p class="forgot-password-text">
                    <a href="/login">Return to Login Page</a>
                </p>

            </form>
        </div>

    </div>
</div>

<?= $this->endSection() ?>