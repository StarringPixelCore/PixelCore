<?= $this->include('include/view_head', ['title' => $title ?? 'Reschedule Reservation']) ?>

<body>
<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => $active ?? 'reservations']) ?>
    
    <div class="dashboard-container">
        <h1 class="dash-title">Reschedule Reservation</h1>
        <p class="dash-subtitle">Update the reservation date, time, and room number</p>

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

        <?php if (session('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="content-card" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0px 3px 8px rgba(0,0,0,0.15); margin-top: 20px;">
            <!-- Current Reservation Details -->
            <div class="mb-4 p-3 bg-light rounded">
                <h5 class="mb-3">Current Reservation Details</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <strong>Associate:</strong> <?= esc($reservation['firstname'] . ' ' . $reservation['lastname']) ?> (<?= esc($reservation['id_number']) ?>)
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Equipment:</strong> <?= esc($reservation['equipment_name']) ?>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>Current Date:</strong> <?= date('M d, Y', strtotime($reservation['reserve_date'])) ?>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>Current Time:</strong> <?= date('h:i A', strtotime($reservation['reserve_time'])) ?>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>Current Room:</strong> <?= esc($reservation['room_number']) ?>
                    </div>
                </div>
            </div>

            <!-- Reschedule Form -->
            <form action="<?= base_url('reserve/reschedule/' . $reservation['id']) ?>" method="POST">
                <h5 class="mb-3">New Reservation Details</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Room Number <span class="text-danger">*</span></label>
                        <input type="text" name="room_number" class="form-control" value="<?= old('room_number', $reservation['room_number']) ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">New Date <span class="text-danger">*</span></label>
                        <input type="date" name="reserve_date" class="form-control" value="<?= old('reserve_date', $reservation['reserve_date']) ?>" required min="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">New Time <span class="text-danger">*</span></label>
                        <input type="time" name="reserve_time" class="form-control" value="<?= old('reserve_time', $reservation['reserve_time']) ?>" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?= base_url('reservations') ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Reschedule Reservation</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>

