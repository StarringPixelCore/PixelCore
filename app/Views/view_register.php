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
            <a href="<?= base_url('login') ?>" class="btn btn-register-small">LOGIN</a>
            <a href="<?= base_url('dashboard') ?>">
                <img src="<?= base_url('public/assets/feutech.png') ?>" class="login-logo">
            </a>
        </div>

        <div class="login-panel">
            <h2 class="login-title">Create Your<br>Account</h2>
            <p class="login-subtitle">Register to access ITSO equipment services.</p>

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

            <!-- REGISTER FORM -->
            <form action="<?= base_url('register') ?>" method="POST">

                <input type="text" name="id_number" 
                       class="form-control login-input" placeholder="ID Number">

                <input type="text" name="firstname" 
                       class="form-control login-input" placeholder="First Name">

                <input type="text" name="lastname" 
                       class="form-control login-input" placeholder="Last Name">

                <input type="email" name="email" 
                       class="form-control login-input" placeholder="Email">

                <input type="password" name="password" 
                       class="form-control login-input" placeholder="Password">

                <input type="password" name="confirmpassword" 
                       class="form-control login-input" placeholder="Confirm Password">

                <button type="submit" class="btn login-btn">REGISTER</button>
            </form>

        </div>
    </div>

</div>

</body>
</html>
