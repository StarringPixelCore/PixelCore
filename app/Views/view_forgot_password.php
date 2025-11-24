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
            <h2 class="login-title">Forgot your password?</h2>
            <p class="login-subtitle">Enter your email address and we'll send you a reset link.</p>

            <?php if (session('error')): ?>
                <div class="alert alert-danger"><?= session('error'); ?></div>
            <?php endif; ?>

            <?php if (session('success')): ?>
                <div class="alert alert-success"><?= session('success'); ?></div>
            <?php endif; ?>

            <form action="<?= base_url('forgot-password') ?>" method="POST">
                <input type="email" name="email" class="form-control login-input" placeholder="Email address" required>
                <button type="submit" class="btn login-btn mt-3">Send Reset Link</button>
            </form>

            <div class="text-center mt-3">
                <a href="<?= base_url('login') ?>" class="login-forgot">Back to login</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>

