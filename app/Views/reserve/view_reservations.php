<?= $this->include('include/view_head', ['title' => $title ?? 'Reservations']) ?>

<body>
<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => $active ?? 'reservations']) ?>
    
    <div class="dashboard-container">
        <h1 class="dash-title">Reservations</h1>
        <p class="dash-subtitle">Manage equipment reservation requests</p>

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
            <?php if (empty($reservations)): ?>
                <p class="text-center text-muted py-4">No reservation requests found.</p>
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
                            <?php foreach ($reservations as $reservation): ?>
                                <tr>
                                    <td><?= esc($reservation['id_number']) ?></td>
                                    <td><?= esc($reservation['firstname'] . ' ' . $reservation['lastname']) ?></td>
                                    <td><?= esc($reservation['equipment_name']) ?></td>
                                    <td><?= !empty($reservation['accessories']) ? esc(implode(', ', $reservation['accessories'])) : '<span class="text-muted">-</span>' ?></td>
                                    <td><?= esc($reservation['room_number']) ?></td>
                                    <td><?= date('M d, Y', strtotime($reservation['reserve_date'])) ?></td>
                                    <td><?= date('h:i A', strtotime($reservation['reserve_time'])) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $reservation['status'] === 'Pending' ? 'warning' : ($reservation['status'] === 'Received' ? 'info' : ($reservation['status'] === 'Cancelled' ? 'danger' : 'success')) ?>">
                                            <?= esc($reservation['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <?php if ($reservation['status'] === 'Pending'): ?>
                                                <a href="<?= base_url('reserve/received/' . $reservation['id']) ?>" 
                                                   class="btn btn-sm btn-success" 
                                                   onclick="return confirm('Mark this reservation as received? This will decrease the available count.')"
                                                   title="Mark as Received">
                                                    <i class="bi bi-check-circle"></i> Received
                                                </a>
                                                <a href="<?= base_url('reserve/reschedule/' . $reservation['id']) ?>" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Reschedule">
                                                    <i class="bi bi-calendar-event"></i> Reschedule
                                                </a>
                                                <a href="<?= base_url('reserve/cancel/' . $reservation['id']) ?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('Are you sure you want to cancel this reservation? An email notification will be sent to the associate.')"
                                                   title="Cancel">
                                                    <i class="bi bi-x-circle"></i> Cancel
                                                </a>
                                            <?php elseif ($reservation['status'] === 'Received'): ?>
                                                <a href="<?= base_url('reserve/returned/' . $reservation['id']) ?>" 
                                                   class="btn btn-sm btn-primary" 
                                                   onclick="return confirm('Mark this reservation as returned? This will increase the available count.')"
                                                   title="Mark as Returned">
                                                    <i class="bi bi-arrow-return-left"></i> Returned
                                                </a>
                                                <a href="<?= base_url('reserve/cancel/' . $reservation['id']) ?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('Are you sure you want to cancel this reservation? The equipment will be made available again and an email notification will be sent to the associate.')"
                                                   title="Cancel">
                                                    <i class="bi bi-x-circle"></i> Cancel
                                                </a>
                                            <?php elseif ($reservation['status'] === 'Cancelled'): ?>
                                                <span class="badge bg-danger">Cancelled</span>
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

