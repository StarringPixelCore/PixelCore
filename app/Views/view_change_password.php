<?= $this->include('include/view_head', ['title' => 'Change Password']) ?>

<body>

<div class="dashboard-container">

<?= $this->include('include/view_sidebar', ['active' => $active ?? 'profile']) ?>

    <div class="profile-container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="profile-header">Change Password</h1>
            <a href="<?= base_url('profile') ?>" class="logout-btn" style="background: #6c757d;">
                <i class="bi bi-arrow-left"></i> Back to Profile
            </a>
        </div>

        <!-- CHANGE PASSWORD SECTION -->
        <div class="password-box" style="margin-top: 40px;">
            <h3 style="color: #4B763A; margin-bottom: 20px;">Change Password</h3>

            <?php if (session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('profile/update-password') ?>" method="POST">
                <div class="mb-3">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control profile-input">
                </div>

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control profile-input">
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control profile-input">
                </div>

                <button type="submit" class="profile-save-btn">Update Password</button>
            </form>
        </div>

    </div>

</div>

</body>
</html>

