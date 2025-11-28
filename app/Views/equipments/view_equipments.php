<?= $this->include('include/view_head'); ?>

<!-- 
    EQUIPMENT INDEX/MAIN VIEW
    This is the main equipment management page displaying all equipment in a table.
    Users can perform CRUD operations here: view all, add, edit, delete equipment.
-->

<body>

<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => 'equipments']) ?>
    
    <div class="main-content">
        <!-- PAGE HEADER -->
        <div class="page-header">
            <h1 class="page-title">Equipment Management</h1>
            <p class="page-subtitle">Manage all school equipment and gadgets</p>
        </div>

        <!-- SUCCESS/ERROR MESSAGES -->
        <?php if (session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- ADD BUTTON -->
        <div class="content-actions mb-4">
            <a href="<?= base_url('equipment/add') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Equipment
            </a>
        </div>

        <!-- EQUIPMENT TABLE -->
        <div class="content-card">
            <table class="table table-hover">
                <thead class="table-light">
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
                                    <span class="badge bg-<?= $equipment['available_count'] > 0 ? 'success' : 'danger' ?>">
                                        <?= $equipment['available_count'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $equipment['status'] === 'Active' ? 'success' : 'warning' ?>">
                                        <?= $equipment['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?= base_url('equipment/edit/' . $equipment['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php if ($equipment['status'] === 'Active'): ?>
                                            <a href="<?= base_url('equipment/delete/' . $equipment['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')" title="Deactivate">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="<?= base_url('equipment/reactivate/' . $equipment['id']) ?>" class="btn btn-sm btn-success" title="Reactivate">
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <p class="text-muted">No equipment found. <a href="<?= base_url('equipment/add') ?>">Add one now</a></p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <?php if (!empty($pager)): ?>
            <div class="pagination-wrapper mt-4">
                <?= $pager->links() ?>
            </div>
        <?php endif; ?>

    </div>
</div>

</body>
</html>
