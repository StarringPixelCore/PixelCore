<?php
    $isLoggedIn = session()->has('user_id');
    $user = null;
    $linkTarget = base_url('login');

    // DEFAULT profile image
    $profilePicUrl = base_url('public/assets/default.jpg');
    $displayName = 'Guest User';

    if ($isLoggedIn) {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find(session()->get('user_id'));

        if ($user) {
           
            $displayName = $user['firstname'] . ' ' . $user['lastname'];
            $linkTarget = base_url('profile');

            
            if (!empty($user['profile_picture'])) {
                $uploadedPath = FCPATH . "writable/uploads/profile/" . $user['profile_picture']; 

              
                if (is_file($uploadedPath)) {
                    $profilePicUrl = base_url("writable/uploads/profile/" . $user['profile_picture']);
                }
            }
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


        <!-- PROFILE SECTION -->
       <a href="<?= $linkTarget ?>" class="profile-box-wrapper">
        <div class="profile-box">
            <img src="<?= $profilePicUrl ?>" class="profile-img">
            <p class="profile-name"><?= esc($displayName) ?></p>
        </div>
    </a>

    
    </div>