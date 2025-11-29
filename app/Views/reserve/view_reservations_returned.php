<?= $this->include('include/view_head', ['title' => $title ?? 'Returned Reservations']) ?>
<link rel="stylesheet" href="<?= base_url('public/css/reservedReturned.css') ?>">

<body>
<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => $active ?? 'reservations']) ?>
    
    <div class="dashboard-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="dash-title">Returned Reservations</h1>
                <p class="dash-subtitle">List of completed equipment reservations</p>
            </div>
            <div class="btn-group" role="group">
                <a href="<?= base_url('returned') ?>" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-return-left"></i> View Returned Borrows
                </a>
                <a href="<?= base_url('reservations') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Active Reservations
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

        <div class="content-card" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0px 3px 8px rgba(0,0,0,0.15); margin-top: 20px;">
            <?php if (empty($returnedReservations)): ?>
                <p class="text-center text-muted py-4">No returned reservation records found.</p>
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
                                <th>Reserve Date</th>
                                <th>Reserve Time</th>
                                <th>Returned Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($returnedReservations as $reservation): ?>
                                <tr>
                                    <td><?= esc($reservation['id_number']) ?></td>
                                    <td><?= esc($reservation['firstname'] . ' ' . $reservation['lastname']) ?></td>
                                    <td><?= esc($reservation['equipment_name']) ?></td>
                                    <td><?= !empty($reservation['accessories']) ? esc(implode(', ', $reservation['accessories'])) : '<span class="text-muted">-</span>' ?></td>
                                    <td><?= esc($reservation['room_number']) ?></td>
                                    <td><?= date('M d, Y', strtotime($reservation['reserve_date'])) ?></td>
                                    <td><?= date('h:i A', strtotime($reservation['reserve_time'])) ?></td>
                                    <td><?= !empty($reservation['returned_at']) ? date('M d, Y h:i A', strtotime($reservation['returned_at'])) : date('M d, Y h:i A', strtotime($reservation['created_at'])) ?></td>
                                    <td>
                                        <span class="badge bg-success">
                                            Complete
                                        </span>
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

