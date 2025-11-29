<?= $this->include('include/view_head'); ?>
<link rel="stylesheet" href="<?= base_url('public/css/equipments.css') ?>">


<body>

<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => 'equipments']) ?>
    
    <div class="dashboard-container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="content-card">
                        <!-- PAGE HEADER -->
                        <div class="header-section">
                            <div>
                                <h1 class="page-title">Equipment Management</h1>
                                <p class="page-subtitle">Manage all school equipment and gadgets</p>
                            </div>
                            <?php if (session()->get('role') === 'ITSO PERSONNEL'): ?>
                                <a href="<?= base_url('equipment/add') ?>" class="btn-add">
                                    <i class="bi bi-plus-circle"></i> Add New Equipment
                                </a>
                            <?php endif; ?>
                        </div>

                        <!-- SUCCESS/ERROR MESSAGES -->
                        <?php if (session('success')): ?>
                            <div class="alert alert-success">
                                <p><?= session('success') ?></p>
                                <button type="button" class="btn-close-alert">×</button>
                            </div>
                        <?php endif; ?>

                        <?php if (session('error')): ?>
                            <div class="alert alert-danger">
                                <p><?= session('error') ?></p>
                                <button type="button" class="btn-close-alert">×</button>
                            </div>
                        <?php endif; ?>

                        <!-- EQUIPMENT TABLE -->
                        <div class="table-container">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Equipment Name</th>
                                        <th>Category</th>
                                        <th>Qty</th>
                                        <th>Available</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($equipments)): ?>
                                        <?php foreach ($equipments as $equipment): ?>
                                            <tr>
                                                <td><?= $equipment['id'] ?></td>
                                                <td>
                                                    <strong><?= esc($equipment['equipment_name']) ?></strong>
                                                </td>
                                                <td><?= esc($equipment['category']) ?></td>
                                                <td><?= $equipment['quantity'] ?></td>
                                                <td>
                                                    <span class="badge <?= $equipment['available_count'] > 0 ? 'badge-success' : 'badge-danger' ?>">
                                                        <?= $equipment['available_count'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge <?= $equipment['status'] === 'Active' ? 'badge-success' : 'badge-warning' ?>">
                                                        <?= $equipment['status'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="<?= base_url('equipment/view/' . $equipment['id']) ?>" class="btn-view" title="View">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <?php if (session()->get('role') === 'ITSO PERSONNEL'): ?>
                                                            <a href="<?= base_url('equipment/edit/' . $equipment['id']) ?>" class="btn-edit" title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                            <?php if ($equipment['status'] === 'Active'): ?>
                                                                <a href="#" class="btn-delete delete-btn" 
                                                                   data-bs-toggle="modal" 
                                                                   data-bs-target="#confirmDeleteModal" 
                                                                   data-url="<?= base_url('equipment/delete/' . $equipment['id']) ?>"
                                                                   data-name="<?= esc($equipment['equipment_name']) ?>"
                                                                   title="Deactivate">
                                                                    <i class="bi bi-trash"></i>
                                                                </a>
                                                            <?php else: ?>
                                                                <a href="<?= base_url('equipment/reactivate/' . $equipment['id']) ?>" class="btn-reactivate" title="Reactivate">
                                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <p class="empty-state">No equipment found. <a href="<?= base_url('equipment/add') ?>">Add one now</a></p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- PAGINATION -->
                        <?php if (!empty($pager)): ?>
                            <div class="pagination-wrapper">
                                <?= view('include/tailwind_pagination', ['pager' => $pager]) ?>
                            </div>
                        <?php endif; ?>
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