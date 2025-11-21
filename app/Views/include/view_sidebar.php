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


        <!-- PROFILE (placeholder na muna waiting for backend) -->
        <div class="profile-box mt-5">
            <img src="">
            <p class="m-0"></p>
        </div>
    </div>