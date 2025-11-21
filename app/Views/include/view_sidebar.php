 <?php
    $isLoggedIn = session()->has('user_id');
    $user = null;
    $profilePic = 'default.png';
    $displayName = 'Guest User';
    $linkTarget = base_url('login');

    if ($isLoggedIn) {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find(session()->get('user_id'));

        if ($user) {
            $profilePic = $user['profile_picture'];
            $displayName = $user['fullname'];
            $linkTarget = base_url('profile');
        }
    }
    ?>

 
 <!-- SIDEBAR -->
  
    <div class="sidebar">
        <div class="text-center mb-4">
            <img src="<?= base_url('public/assets/feutech.png') ?>" class="sidebar-logo">
        </div>

        <nav class="sidebar-menu">
        <a href="<?= base_url('dashboard') ?>" class="menu-item <?= ($active=='dashboard') ? 'active' : '' ?>">DASHBOARD</a>
        <a href="<?= base_url('equipments') ?>" class="menu-item <?= ($active=='equipments') ? 'active' : '' ?>">EQUIPMENTS</a>
        <a href="<?= base_url('reservations') ?>" class="menu-item <?= ($active=='reservations') ? 'active' : '' ?>">RESERVATIONS</a>
        <a href="<?= base_url('borrowed') ?>" class="menu-item <?= ($active=='borrowed') ? 'active' : '' ?>">BORROWED</a>
        <a href="<?= base_url('returned') ?>" class="menu-item <?= ($active=='returned') ? 'active' : '' ?>">RETURNED</a>
    </nav>


        <!-- PROFILE -->
       <a href="<?= $linkTarget ?>" class="profile-box-wrapper">
        <div class="profile-box">
            <img src="<?= base_url('writable/uploads/profile/' . $profilePic) ?>" class="profile-img">
            <p class="profile-name"><?= esc($displayName) ?></p>
        </div>
    </a>

    
    </div>