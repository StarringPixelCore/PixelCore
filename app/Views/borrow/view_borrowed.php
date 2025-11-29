<?= $this->include('include/view_head', ['title' => $title ?? 'Borrowed Equipment']) ?>
<link rel="stylesheet" href="<?= base_url('public/css/reserve.css') ?>">

<body>
<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => $active ?? 'borrowed']) ?>
    
    <div class="dashboard-container">
        <h1 class="dash-title">Borrowed Equipment</h1>
        <p class="dash-subtitle">Manage equipment borrow requests</p>

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

        <div class="content-card" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0px 3px 8px rgba(0,0,0,0.15); margin-top: 20px;">
            <?php if (empty($borrows)): ?>
                <p class="text-center text-muted py-4">No borrow requests found.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID Number</th>
                                <th>Name</th>
                                <th>Equipment</th>
                                <th>Accessory</th>
                                <th>Room Number</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($borrows as $borrow): ?>
                                <tr>
                                    <td><?= esc($borrow['id_number']) ?></td>
                                    <td><?= esc($borrow['firstname'] . ' ' . $borrow['lastname']) ?></td>
                                    <td><?= esc($borrow['equipment_name']) ?></td>
                                    <td><?= !empty($borrow['accessories']) ? esc(implode(', ', $borrow['accessories'])) : '<span class="text-muted">-</span>' ?></td>
                                    <td><?= esc($borrow['room_number']) ?></td>
                                    <td><?= date('M d, Y', strtotime($borrow['borrow_date'])) ?></td>
                                    <td><?= date('h:i A', strtotime($borrow['borrow_time'])) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $borrow['status'] === 'Pending' ? 'warning' : ($borrow['status'] === 'Received' ? 'info' : 'success') ?>">
                                            <?= esc($borrow['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <?php if ($borrow['status'] === 'Pending'): ?>
                                                <a href="<?= base_url('borrow/received/' . $borrow['id']) ?>" 
                                                   class="btn btn-sm btn-success" 
                                                   onclick="return confirm('Mark this equipment as received? This will decrease the available count.')"
                                                   title="Mark as Received">
                                                    <i class="bi bi-check-circle"></i> Received
                                                </a>
                                            <?php elseif ($borrow['status'] === 'Received'): ?>
                                                <a href="<?= base_url('borrow/returned/' . $borrow['id']) ?>" 
                                                   class="btn btn-sm btn-primary" 
                                                   onclick="return confirm('Mark this equipment as returned? This will increase the available count.')"
                                                   title="Mark as Returned">
                                                    <i class="bi bi-arrow-return-left"></i> Returned
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Completed</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>

