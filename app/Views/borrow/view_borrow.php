<?= $this->include('include/view_head', ['title' => $title ?? 'Borrow Equipment']) ?>
<link rel="stylesheet" href="<?= base_url('public/css/borrowToReserve.css') ?>">

<body>
<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => $active ?? 'borrow']) ?>
    
    <div class="dashboard-container">
        <h1 class="dash-title">Borrow Equipment</h1>
        <p class="dash-subtitle">Fill out the form below to request equipment</p>

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
            <form action="<?= base_url('borrow/submit') ?>" method="POST" id="borrowForm">
                <!-- User Information (Auto-filled) -->
                <div class="mb-4">
                    <h5 class="mb-3">Your Information</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ID Number</label>
                            <input type="text" class="form-control" value="<?= esc(session()->get('id_number')) ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" value="<?= esc(session()->get('firstname') . ' ' . session()->get('lastname')) ?>" readonly>
                        </div>
                    </div>
                </div>

                <!-- Equipment Selection -->
                <div class="mb-4">
                    <h5 class="mb-3">Equipment to Borrow</h5>
                    <div id="equipmentContainer">
                        <div class="equipment-item mb-3">
                            <select name="equipment_id[]" class="form-select equipment-select" required>
                                <option value="">Select Equipment</option>
                                <?php if (!empty($availableEquipment)): ?>
                                    <?php foreach ($availableEquipment as $equip): ?>
                                        <option value="<?= $equip['id'] ?>" data-name="<?= esc($equip['equipment_name']) ?>">
                                            <?= esc($equip['equipment_name']) ?> 
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="addEquipmentBtn">
                        <i class="bi bi-plus-circle"></i> Add Another Equipment
                    </button>
                </div>

                <!-- Room and Date/Time -->
                <div class="mb-4">
                    <h5 class="mb-3">Borrow Details</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Room Number <span class="text-danger">*</span></label>
                            <input type="text" name="room_number" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="borrow_date" class="form-control" required min="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Time <span class="text-danger">*</span></label>
                            <input type="time" name="borrow_time" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Submit Borrow Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url('public/js/borrowForm.js'); ?>"></script>

</body>
</html>

