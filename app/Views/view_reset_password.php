<?= $this->include('include/view_head'); ?>

<body>
<div class="login-wrapper">
    <div class="login-left">
        <div class="login-overlay"></div>
    </div>

    <div class="login-right">
        <div class="login-top-buttons">
            <a href="<?= base_url('login') ?>" class="btn btn-register-small">LOGIN</a>
            <a href="<?= base_url('dashboard') ?>">
                <img src="<?= base_url('public/assets/feutech.png') ?>" class="login-logo">
            </a>
        </div>

        <div class="login-panel">
            <h2 class="login-title">Reset your password</h2>
            <p class="login-subtitle">Choose a new password for your account.</p>

            <?php if (session('errors')): ?>
                <div class="alert alert-danger">
                    <?= implode('<br>', session('errors')); ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('reset-password/' . $token) ?>" method="POST">
                <input type="password" name="password" class="form-control login-input" placeholder="New password">
                <input type="password" name="confirmpassword" class="form-control login-input" placeholder="Confirm password">
                <button type="submit" class="btn login-btn mt-3">Update Password</button>
            </form>

            <div class="text-center mt-3">
                <a href="<?= base_url('login') ?>" class="login-forgot">Back to login</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>

