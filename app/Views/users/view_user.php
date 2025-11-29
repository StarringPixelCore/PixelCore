<!DOCTYPE html>
<html lang="en">
<?= view('include/view_head', ['title' => $title ?? 'View User']) ?>
<link rel="stylesheet" href="<?= base_url('public/css/user.css') ?>">

<body>
<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => $active ?? 'users']) ?>
    <div class="dashboard-container">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="content-card">
                        <div class="mb-4">
                            <h2 class="page-title">View User</h2>
                        </div>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form>
                            <div class="form-group mb-3">
                                <label for="id_number" class="form-label">ID Number</label>
                                <input type="text" name="id_number" id="id_number" class="form-control" readonly value="<?= esc($user['id_number']) ?>">
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="firstname" class="form-label">First Name</label>
                                <input type="text" name="firstname" id="firstname" class="form-control" readonly value="<?= esc($user['firstname']) ?>">
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="lastname" class="form-label">Last Name</label>
                                <input type="text" name="lastname" id="lastname" class="form-control" readonly value="<?= esc($user['lastname']) ?>">
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" readonly value="<?= esc($user['email']) ?>">
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="role" class="form-label">Role</label>
                                <input type="text" name="role" id="role" class="form-control" readonly value="<?= esc($user['role']) ?>">
                            </div>
                            
                            <div class="form-group d-flex gap-2">
                                <a href="<?= base_url('users') ?>" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
