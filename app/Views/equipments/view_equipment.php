<?= $this->include('include/view_head', ['title' => $title ?? 'View Equipment']) ?>
<link rel="stylesheet" href="<?= base_url('public/css/equipment.css') ?>">


<body>
<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => $active ?? 'equipments']) ?>
    
    <div class="dashboard-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="dash-title">Equipment Details</h1>
                <p class="dash-subtitle">View equipment information</p>
            </div>
            <div>
                <a href="<?= base_url('equipment') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

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

        <?php if (!empty($equipment)): ?>
            <div class="content-card" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0px 3px 8px rgba(0,0,0,0.15);">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h5 class="mb-3" style="color: #4B763A; font-weight: 600;">Equipment Information</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td style="width: 40%; font-weight: 600;">Equipment ID:</td>
                                <td><?= $equipment['id'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600;">Equipment Name:</td>
                                <td><strong><?= esc($equipment['equipment_name']) ?></strong></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600;">Category:</td>
                                <td><?= esc($equipment['category']) ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600;">Total Quantity:</td>
                                <td><?= $equipment['quantity'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600;">Available Count:</td>
                                <td>
                                    <span class="badge bg-<?= $equipment['available_count'] > 0 ? 'success' : 'danger' ?> fs-6">
                                        <?= $equipment['available_count'] ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600;">Status:</td>
                                <td>
                                    <span class="badge bg-<?= $equipment['status'] === 'Active' ? 'success' : 'warning' ?> fs-6">
                                        <?= esc($equipment['status']) ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600;">Date Added:</td>
                                <td><?= !empty($equipment['created_at']) ? date('M d, Y h:i A', strtotime($equipment['created_at'])) : 'N/A' ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                Equipment not found.
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="<?= base_url('public/js/deleteModal.js'); ?>"></script>
<?= $this->include('include/view_deleteModal'); ?>
</body>
</html>
