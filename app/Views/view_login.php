<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITSO Login</title>

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
       
        .left-image {
            background: url('<?= base_url("assets/login_bg.jpg") ?>') no-repeat center center;
            background-size: cover;
            height: 100vh;
        }
        .login-panel {
            background: #fff;
            border-radius: 25px;
            padding: 50px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .login-title {
            font-weight: 700;
            font-size: 32px;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #0f3d2e;
        }
        .btn-login {
            background: #0f3d2e;
            color: #fff;
            width: 100%;
            padding: 12px;
            font-size: 18px;
            border-radius: 10px;
        }
        .btn-register {
            position: absolute;
            top: 20px;
            right: 30px;
        }
        .brand-logo {
            width: 70px;
            position: absolute;
            top: 15px;
            right: 140px;
        }
        a {
            color: #c00;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container-fluid p-0">
    <div class="row g-0">

        <!-- LEFT IMAGE -->
        <div class="col-md-6 left-image"></div>

        <!-- RIGHT PANEL -->
        <div class="col-md-6 d-flex align-items-center justify-content-center position-relative">

            <!-- REGISTER BUTTON -->
            <a href="<?= base_url('register') ?>" class="btn btn-outline-dark btn-register">REGISTER</a>

            <!-- LOGO -->
            <img src="<?= base_url('assets/img/logo.png') ?>" class="brand-logo">

            <div class="login-panel col-md-8">

                <h2 class="login-title">Welcome back to ITSO</h2>
                <p>Log in to borrow or reserve school equipment.</p>

                <!-- LOGIN FORM -->
                <form action="<?= base_url('auth/login') ?>" method="POST">

                    <div class="mb-3">
                        <input type="text" name="student_number" class="form-control" placeholder="Student Number">
                    </div>

                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                    </div>

                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="<?= base_url('forgot_password') ?>">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn btn-login mt-3">LOGIN</button>
                </form>
            </div>
        </div>

    </div>
</div>

</body>
</html>
