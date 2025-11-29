<?= $this->include('include/view_head'); ?>
<link rel="stylesheet" href="<?= base_url('public/css/reports.css') ?>">

<body>
<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => 'reports']) ?>
    
    <div class="dashboard-container">
        <div class="page-header">
            <h1 class="page-title">Reports</h1>
            <p class="page-subtitle">Generate and view system reports</p>
        </div>

        <div class="row mt-4">
            <!-- Active Equipment Report -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                        <h5 class="card-title mt-3">Active Equipment</h5>
                        <p class="card-text">View all active equipment in the system</p>
                        <a href="<?= base_url('active-equipment') ?>" class="btn btn-success">
                            View Report
                        </a>
                    </div>
                </div>
            </div>

            <!-- Unusable Equipment Report -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-x-circle-fill text-danger" style="font-size: 3rem;"></i>
                        <h5 class="card-title mt-3">Unusable Equipment</h5>
                        <p class="card-text">View deactivated or damaged equipment</p>
                        <a href="<?= base_url('unusable-equipment') ?>" class="btn btn-danger">
                            View Report
                        </a>
                    </div>
                </div>
            </div>

            <!-- Borrowing History Report -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-clock-history text-primary" style="font-size: 3rem;"></i>
                        <h5 class="card-title mt-3">Borrowing History</h5>
                        <p class="card-text">View user borrowing records and history</p>
                        <a href="<?= base_url('borrowing-history') ?>" class="btn btn-primary">
                            View Report
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>