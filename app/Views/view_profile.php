<?= $this->include('include/view_head'); ?>

<body>

<div class="main-container">

<?= $this->include('include/view_sidebar', ['active' => 'profile']) ?>

    <div class="profile-container">

        <h1 class="profile-header">User Profile</h1>

        <div class="profile-top-section">

            <!-- PROFILE IMAGE -->
            <div class="profile-photo-wrapper">
                <img src="<?= base_url($profilePicUrl) ?>" class="profile-photo">

                <!-- EDIT ICON -->
                <label for="profilePicInput" class="profile-edit-icon">
                    ✎
                </label>

                <!-- DELETE ICON -->
                
                <form action="<?= base_url('profile/remove-picture') ?>" method="POST">
                    <button type="submit" class="profile-remove-icon">🗑</button>
                </form>



                <!-- HIDDEN INPUT FOR UPLOAD -->
                <form action="<?= base_url('profile/update-picture') ?>" 
                      method="POST" enctype="multipart/form-data">
                    <input type="file" id="profilePicInput" name="profile_picture" 
                           accept="image/*" onchange="this.form.submit()" hidden>
                </form>
            </div>

            <!-- NAME + LOGOUT -->
            <div class="profile-name-section">
                <h2 class="profile-name-display">
                    <?= esc($user['firstname'] . ' ' . $user['lastname']) ?>
                </h2>

                <div class="d-flex flex-column gap-2" style="margin-top: 10px;">
                    <a href="<?= base_url('profile/change-password') ?>" class="logout-btn" style="background: #4B763A; text-align: center;">
                        Change Password
                    </a>
                    <a href="<?= base_url('logout') ?>" class="logout-btn">Logout</a>
                </div>
            </div>

        </div>

        <!-- USER INFO -->
        <div class="user-info-grid">

            <div>
                <label class="info-label">Role:</label>
                <p class="info-value"><?= esc($user['role']) ?></p>
            </div>

            <div>
                <label class="info-label">Email:</label>
                <p class="info-value"><?= esc($user['email']) ?></p>
            </div>

            <div>
                <label class="info-label">ID Number:</label>
                <p class="info-value"><?= esc($user['id_number']) ?></p>
            </div>

            <div>
                <label class="info-label">First Name:</label>
                <p class="info-value"><?= esc($user['firstname']) ?></p>
            </div>

            <div>
                <label class="info-label">Last Name:</label>
                <p class="info-value"><?= esc($user['lastname']) ?></p>
            </div>

        </div>

    </div>

</div>

</body>
</html>
