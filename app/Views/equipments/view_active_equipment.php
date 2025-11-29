<?= $this->include('include/view_head'); ?>
<link rel="stylesheet" href="<?= base_url('public/css/viewReports.css') ?>">


<body>
<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => 'reports']) ?>
    
    <div class="dashboard-container">
        <!-- PAGE HEADER -->
        <div class="page-header">
            <h1 class="page-title">Active Equipment Report</h1>
            <p class="page-subtitle">List of all active equipment in the system</p>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="content-actions mb-4">
            <a href="<?= base_url('reports') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Reports
            </a>
            <a href="<?= base_url('reports/export-active-equipment') ?>" class="btn btn-success">
                <i class="bi bi-download"></i> Export to Excel
            </a>
        </div>

        <!-- ACTIVE EQUIPMENT TABLE -->
        <div class="content-card">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Equipment Name</th>
                        <th>Category</th>
                        <th>Total Qty</th>
                        <th>Available</th>
                        <th>Status</th>
                        <th>Created Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($equipments)): ?>
                        <?php foreach ($equipments as $equipment): ?>
                            <tr>
                                <td><?= $equipment['id'] ?></td>
                                <td><strong><?= esc($equipment['equipment_name']) ?></strong></td>
                                <td><?= esc($equipment['category']) ?></td>
                                <td><?= $equipment['quantity'] ?></td>
                                <td>
                                    <span class="badge bg-<?= $equipment['available_count'] > 0 ? 'success' : 'danger' ?>">
                                        <?= $equipment['available_count'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        <?= $equipment['status'] ?>
                                    </span>
                                </td>
                                <td><?= date('M d, Y', strtotime($equipment['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <p class="text-muted">No active equipment found.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- SUMMARY -->
        <div class="alert alert-info mt-4">
            <strong>Total Active Equipment:</strong> <?= count($equipments) ?> items
        </div>

    </div>
</div>

</body>
</html>