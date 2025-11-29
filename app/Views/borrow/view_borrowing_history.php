<?= $this->include('include/view_head'); ?>
<link rel="stylesheet" href="<?= base_url('public/css/BorrowHistory.css') ?>">

<body>
<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => 'reports']) ?>
    
    <div class="dashboard-container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="content-card">
                        <!-- PAGE HEADER -->
                        <div class="header-section">
                            <div>
                                <h1 class="page-title">Borrowing History Report</h1>
                                <p class="page-subtitle">Complete borrowing records and user history</p>
                            </div>
                            <div class="action-buttons-header">
                                <a href="<?= base_url('reports') ?>" class="btn-secondary-header">
                                    <i class="bi bi-arrow-left"></i> Back to Reports
                                </a>
                                <a href="<?= base_url('reports/export-borrowing-history') . '?' . http_build_query($_GET) ?>" class="btn-add">
                                    <i class="bi bi-download"></i> Export to Excel
                                </a>
                            </div>
                        </div>

                        <!-- FILTER FORM -->
                        <div class="filter-card">
                            <h5 class="filter-title">Filter Options</h5>
                            <form method="GET" action="<?= base_url('reports/borrowing-history') ?>" class="filter-form">
                                <div class="filter-row">
                                    <div class="form-group-filter">
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
                                    <div class="form-group-filter-button">
                                        <button type="submit" class="btn-filter">
                                            <i class="bi bi-funnel"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- BORROWING HISTORY TABLE -->
                        <div class="table-container">
                            <table class="custom-table">
                                <thead>
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
                                                    <span class="badge <?= $borrow['status'] === 'Pending' ? 'badge-warning' : ($borrow['status'] === 'Received' ? 'badge-info' : 'badge-success') ?>">
                                                        <?= esc($borrow['status']) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <p class="empty-state">No borrowing records found.</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- SUMMARY -->
                        <div class="summary-card">
                            <div class="summary-item">
                                <strong>Total Records:</strong> 
                                <span><?= count($borrowings) ?></span>
                            </div>
                            <div class="summary-item">
                                <strong>Pending:</strong> 
                                <span><?= count(array_filter($borrowings, fn($b) => $b['status'] === 'Pending')) ?></span>
                            </div>
                            <div class="summary-item">
                                <strong>Returned:</strong> 
                                <span><?= count(array_filter($borrowings, fn($b) => $b['status'] === 'Returned')) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>