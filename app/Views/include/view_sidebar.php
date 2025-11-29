<?php if (!isset($active)) { $active = ''; } ?>

<?php
$isLoggedIn = session()->has('user_id');
$user = null;
$linkTarget = base_url('login');

// DEFAULT IMAGE (from public/uploads/profile/default.png)
$profilePicUrl = base_url('public/uploads/profile/default.jpg');
$displayName = 'Guest User';

if ($isLoggedIn) {
    $userModel = new \App\Models\UserModel();
    $user = $userModel->find(session()->get('user_id'));

    if ($user) {
        $displayName = $user['firstname'] . ' ' . $user['lastname'];
        $linkTarget = base_url('profile');

        // USER UPLOADED PICTURE
        if (!empty($user['profile_picture'])) {

            $uploadedPath = FCPATH . "public/uploads/profile/" . $user['profile_picture'];

            if (is_file($uploadedPath)) {
                $profilePicUrl = base_url("public/uploads/profile/" . $user['profile_picture']);
            }
        }
    }
}
?>

<div class="sidebar">
    <div class="text-center mb-4">
        <img src="<?= base_url('public/assets/feutech.png') ?>" class="sidebar-logo">
    </div>

    <nav class="sidebar-menu">
        <?php 
        $userRole = session()->get('role');
        $isStudent = ($userRole === 'STUDENT');
        $isAssociate = ($userRole === 'ASSOCIATE');
        $isITSO = ($userRole === 'ITSO PERSONNEL');
        
        if ($isStudent): 
        ?>
            <!-- Menu for STUDENT -->
            <a href="<?= base_url('dashboard') ?>" class="menu-item <?= ($active=='dashboard') ? 'active' : '' ?>">DASHBOARD</a>
            <a href="<?= base_url('equipment') ?>" class="menu-item <?= ($active=='equipments') ? 'active' : '' ?>">EQUIPMENT</a>
            <a href="<?= base_url('borrow') ?>" class="menu-item <?= ($active=='borrow') ? 'active' : '' ?>">BORROW</a>
        <?php elseif ($isAssociate): ?>
            <!-- Menu for ASSOCIATE -->
            <a href="<?= base_url('dashboard') ?>" class="menu-item <?= ($active=='dashboard') ? 'active' : '' ?>">DASHBOARD</a>
            <a href="<?= base_url('equipment') ?>" class="menu-item <?= ($active=='equipments') ? 'active' : '' ?>">EQUIPMENT</a>
            <a href="<?= base_url('borrow') ?>" class="menu-item <?= ($active=='borrow') ? 'active' : '' ?>">BORROW</a>
            <a href="<?= base_url('reserve') ?>" class="menu-item <?= ($active=='reserve') ? 'active' : '' ?>">RESERVE</a>
        <?php elseif ($isITSO): ?>
            <!-- Menu for ITSO PERSONNEL -->
            <a href="<?= base_url('dashboard') ?>" class="menu-item <?= ($active=='dashboard') ? 'active' : '' ?>">DASHBOARD</a>
            <a href="<?= base_url('users') ?>" class="menu-item <?= ($active=='users') ? 'active' : '' ?>">USERS</a>
            <a href="<?= base_url('equipment') ?>" class="menu-item <?= ($active=='equipments') ? 'active' : '' ?>">EQUIPMENTS</a>
            <a href="<?= base_url('reservations') ?>" class="menu-item <?= ($active=='reservations') ? 'active' : '' ?>">RESERVATIONS</a>
            <a href="<?= base_url('borrowed') ?>" class="menu-item <?= ($active=='borrowed') ? 'active' : '' ?>">BORROWED</a>
            <a href="<?= base_url('returned') ?>" class="menu-item <?= ($active=='returned') ? 'active' : '' ?>">RETURNED</a>
        <?php endif; ?>
    </nav>

    <!-- PROFILE BUTTON -->
    <a href="<?= $linkTarget ?>" class="profile-box-wrapper">
        <div class="profile-box">
            <img src="<?= $profilePicUrl ?>" class="profile-img">
            <p class="profile-name"><?= esc($displayName) ?></p>
        </div>
    </a>

</div>

