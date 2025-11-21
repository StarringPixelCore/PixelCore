<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITSO Register</title>

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f4f4f4;
        }
        .left-image {
            background: url('<?= base_url("assets/img/login_bg.jpg") ?>') no-repeat center center;
            background-size: cover;
            height: 100vh;
        }
        .register-panel {
            background: #fff;
            border-radius: 25px;
            padding: 50px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .title {
            font-weight: 700;
            font-size: 32px;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #0f3d2e;
        }
        .btn-register-submit {
            background: #0f3d2e;
            color: #fff;
            width: 100%;
            padding: 12px;
            font-size: 18px;
            border-radius: 10px;
        }
        .btn-login {
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
    </style>
</head>

<body>

<div class="container-fluid p-0">
    <div class="row g-0">

        <!-- LEFT IMAGE -->
        <div class="col-md-6 left-image"></div>

        <!-- RIGHT PANEL -->
        <div class="col-md-6 d-flex align-items-center justify-content-center position-relative">

            <!-- LOGIN BUTTON -->
            <a href="<?= base_url('login') ?>" class="btn btn-outline-dark btn-login">LOGIN</a>

            <!-- LOGO -->
            <img src="<?= base_url('assets/img/logo.png') ?>" class="brand-logo">

            <div class="register-panel col-md-8">

                <h2 class="title">Create Your Account</h2>
                <p>Register to access ITSO equipment services.</p>

                <!-- REGISTER FORM -->
                <form action="<?= base_url('auth/register') ?>" method="POST">

                    <div class="mb-3">
                        <input type="text" name="student_number" class="form-control" placeholder="Student Number">
                    </div>

                    <div class="mb-3">
                        <input type="text" name="fullname" class="form-control" placeholder="Full Name">
                    </div>

                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                    </div>

                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>

                    <div class="mb-3">
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                    </div>

                    <button type="submit" class="btn btn-register-submit mt-3">REGISTER</button>
                </form>

            </div>

        </div>

    </div>
</div>

</body>
</html>
