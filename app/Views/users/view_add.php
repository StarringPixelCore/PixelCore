<!DOCTYPE html>
<html lang="en">
<?= view('include/view_head', ['title' => $title ?? 'Add New User']) ?>
<link rel="stylesheet" href="<?= base_url('public/css/editUser.css') ?>">
<body>
<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => $active ?? 'users']) ?>
    <div class="dashboard-container">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="add-user-form-box">
                        <h2 class="page-title">Add New User</h2>
                        
                        <?php if(session('errors')): ?>
                            <div class="alert alert-warning">
                                <ul class="mb-0">
                                    <?php foreach(session('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('users/insert') ?>" method="post">
                            <div class="form-group">
                                <label for="id_number" class="form-label">ID Number <span class="text-danger">*</span></label>
                                <input type="text" name="id_number" id="id_number" class="form-control" value="<?= set_value('id_number') ?>">
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="firstname" class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="firstname" id="firstname" class="form-control" value="<?= set_value('firstname') ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="lastname" id="lastname" class="form-control" value="<?= set_value('lastname') ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" value="<?= set_value('email') ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label for="confirmpassword" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="confirmpassword" id="confirmpassword" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select name="role" id="role" class="form-select">
                                    <option value="">Select Role</option>
                                    <option value="USER" <?= set_value('role') == 'USER' ? 'selected' : '' ?>>USER</option>
                                    <option value="ITSO PERSONNEL" <?= set_value('role') == 'ITSO PERSONNEL' ? 'selected' : '' ?>>ITSO PERSONNEL</option>
                                    <option value="STUDENT" <?= set_value('role') == 'STUDENT' ? 'selected' : '' ?>>STUDENT</option>
                                    <option value="ASSOCIATE" <?= set_value('role') == 'ASSOCIATE' ? 'selected' : '' ?>>ASSOCIATE</option>
                                </select>
                            </div>
                            
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle"></i> Save
                                </button>
                                <a href="<?= base_url('users') ?>" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </a>
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
