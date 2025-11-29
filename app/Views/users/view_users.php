<!DOCTYPE html>
<html lang="en">
<?= view('include/view_head', ['title' => $title ?? 'Users List']) ?>
<link rel="stylesheet" href="<?= base_url('public/css/equipments.css') ?>">

<body>
<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => $active ?? 'users']) ?>
    <div class="dashboard-container">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="content-card">
                        <div class="header-section">
                            <h2 class="page-title">Users List</h2>
                            <a href="<?= base_url('users/add'); ?>" class="btn-add">
                                <i class="bi bi-person-plus"></i>
                                Add New User
                            </a>
                        </div>
                        <?php if(session('success')): ?>
                            <div class="alert alert-success">
                                <p><?= session('success'); ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <div class="table-container">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th>ID Number</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($users)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No users found.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach($users as $user): ?>
                                        <tr>
                                            <td><?= esc($user['id_number']) ?></td>
                                            <td><?= esc($user['firstname'] . ' ' . $user['lastname']) ?></td>
                                            <td><?= esc($user['email']) ?></td>
                                            <td><?= esc($user['role']) ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="<?= base_url('users/view/'.$user['id']) ?>" class="btn-view" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="<?= base_url('users/edit/'.$user['id']) ?>" class="btn-edit" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="#" class="btn-delete delete-btn" 
                                                       data-bs-toggle="modal" 
                                                       data-bs-target="#confirmDeleteModal" 
                                                       data-url="<?= base_url('users/delete/'.$user['id']) ?>"
                                                       data-name="<?= esc($user['firstname'] . ' ' . $user['lastname']) ?>"
                                                       title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <div class="pagination-wrapper">
                                <?= view('include/tailwind_pagination', ['pager' => $pager]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('public/js/deleteModal.js'); ?>"></script>
<?= $this->include('include/view_deleteModal'); ?>
</body>
</html>