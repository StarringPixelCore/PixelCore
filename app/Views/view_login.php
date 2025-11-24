<?= $this->include('include/view_head'); ?>

<body>

<div class="login-wrapper">

    <!-- LEFT SIDE WITH OVERLAY -->
    <div class="login-left">
        <div class="login-overlay"></div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="login-right">

        <!-- TOP BUTTONS -->
        <div class="login-top-buttons">
            <a href="<?= base_url('register') ?>" class="btn btn-register-small">REGISTER</a>
            <a href="<?= base_url('dashboard') ?>">
                <img src="<?= base_url('public/assets/feutech.png') ?>" class="login-logo">
            </a>

        </div>

        <div class="login-panel">
            <h2 class="login-title">Welcome back to<br>ITSO</h2>
            <p class="login-subtitle">Log in to borrow or reserve school equipment.</p>

        <?php
            if(session('errors')):
        ?>
                <div class="alert alert-danger">
                    <p>
                        <?= implode('<br>', session('errors')); ?>
                    </p>
                </div>
        <?php
            endif;
        ?>

        <?php
            if(session('success')):
        ?>
                <div class="alert alert-success">
                    <p>
                        <?= session('success'); ?>
                    </p>
                </div>
        <?php
            endif;
        ?>
        
            <form action="<?= base_url('login') ?>" method="POST">

                <input type="text" name="id_number" class="form-control login-input" placeholder="ID Number">

                <input type="password" name="password" class="form-control login-input" placeholder="Password">

                <a href="<?= base_url('forgot-password') ?>" class="login-forgot">Forgot Password?</a>

                <button type="submit" class="btn login-btn">LOGIN</button>
            </form>
        </div>
    </div>

</div>

</body>
</html>
