<?= $this->include('include/view_head'); ?>

<body>
<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => 'reports']) ?>
    
    <div class="dashboard-container">
        <!-- PAGE HEADER -->
        <div class="page-header">
            <h1 class="page-title">Borrowing History Report</h1>
            <p class="page-subtitle">Complete borrowing records and user history</p>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="content-actions mb-4">
            <a href="<?= base_url('reports') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Reports
            </a>
            <a href="<?= base_url('reports/export-borrowing-history') . '?' . http_build_query($_GET) ?>" class="btn btn-primary">
                <i class="bi bi-download"></i> Export to Excel
            </a>
        </div>

        <!-- FILTER FORM -->
        <div class="content-card mb-4">
            <h5 class="mb-3">Filter Options</h5>
            <form method="GET" action="<?= base_url('reports/borrowing-history') ?>" class="row g-3">
                <div class="col-md-4">
                    <label for="user_id" class="form-label">User</label>
                    <select class="form-control" id="user_id" name="user_id">
                        <option value="">-- All Users --</option>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['id'] ?>" <?= (isset($_GET['user_id']) && $_GET['user_id'] == $user['id']) ? 'selected' : '' ?>>
                                    <?= esc($user['firstname'] . ' ' . $user['lastname']) ?> (<?= esc($user['id_number']) ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- BORROWING HISTORY TABLE -->
        <div class="content-card">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>ID Number</th>
                        <th>Equipment</th>
                        <th>Room</th>
                        <th>Borrow Date</th>
                        <th>Borrow Time</th>
                        <th>Returned At</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($borrowings)): ?>
                        <?php foreach ($borrowings as $borrow): ?>
                            <tr>
                                <td><?= $borrow['id'] ?></td>
                                <td><strong><?= esc($borrow['firstname'] . ' ' . $borrow['lastname']) ?></strong></td>
                                <td><?= esc($borrow['id_number']) ?></td>
                                <td><?= esc($borrow['equipment_name']) ?></td>
                                <td><?= esc($borrow['room_number']) ?></td>
                                <td><?= date('M d, Y', strtotime($borrow['borrow_date'])) ?></td>
                                <td><?= date('h:i A', strtotime($borrow['borrow_time'])) ?></td>
                                <td>
                                    <?php if ($borrow['returned_at']): ?>
                                        <?= date('M d, Y h:i A', strtotime($borrow['returned_at'])) ?>
                                    <?php else: ?>
                                        <span class="text-muted">Not Returned</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $borrow['status'] === 'Pending' ? 'warning' : ($borrow['status'] === 'Received' ? 'info' : 'success') ?>">
                                        <?= esc($borrow['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <p class="text-muted">No borrowing records found.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- SUMMARY -->
        <div class="alert alert-info mt-4">
            <div class="row">
                <div class="col-md-4">
                    <strong>Total Records:</strong> <?= count($borrowings) ?>
                </div>
                <div class="col-md-4">
                    <strong>Pending:</strong> <?= count(array_filter($borrowings, fn($b) => $b['status'] === 'Pending')) ?>
                </div>
                <div class="col-md-4">
                    <strong>Returned:</strong> <?= count(array_filter($borrowings, fn($b) => $b['status'] === 'Returned')) ?>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>