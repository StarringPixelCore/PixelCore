<!DOCTYPE html>
<html lang="en">
<?= view('include/view_head', ['title' => $title ?? 'Edit User']) ?>
<body>
<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => $active ?? 'users']) ?>
    <div class="dashboard-container">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="content-card">
                        <div class="mb-4">
                            <h2 class="page-title">Edit User</h2>
                        </div>

                        <!-- Flash Messages -->
                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('users/update/'.$user['id']) ?>" method="post">
                            <div class="form-group mb-3">
                                <label for="id_number" class="form-label">ID Number <span class="text-danger">*</span></label>
                                <input type="text" name="id_number" id="id_number" class="form-control" value="<?= esc($user['id_number']) ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="firstname" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="firstname" id="firstname" class="form-control" value="<?= esc($user['firstname']) ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="lastname" id="lastname" class="form-control" value="<?= esc($user['lastname']) ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" value="<?= esc($user['email']) ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="confirmpassword" class="form-label">Confirm Password</label>
                                <input type="password" name="confirmpassword" id="confirmpassword" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="USER" <?= ($user['role'] == 'USER') ? 'selected' : '' ?>>USER</option>
                                    <option value="ITSO PERSONNEL" <?= ($user['role'] == 'ITSO PERSONNEL') ? 'selected' : '' ?>>ITSO PERSONNEL</option>
                                </select>
                            </div>
                            <div class="form-group d-flex gap-2">
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="<?= base_url('users') ?>" class="btn btn-secondary">Cancel</a>
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
