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
            <h2>Create New Password</h2>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('/reset-password/process') ?>" method="POST">

                <!-- Token URL -->
                <input type="hidden" name="token" value="<?= esc($token) ?>">

                <label>New Password</label>
                <input type="password" name="password" required minlength="6">

                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required minlength="6">

                <button type="submit" class="btn-login">Reset Password</button>

                <p class="forgot-password-text">
                    <a href="/login">Return to Login Page</a>
                </p>

            </form>
        </div>

    </div>
</div>

<?= $this->endSection() ?>