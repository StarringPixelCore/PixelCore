<?= $this->include('include/view_head'); ?>
<link rel="stylesheet" href="<?= base_url('public/css/addEquipment.css') ?>">

<body>

<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => 'equipments']) ?>
    
    <div class="dashboard-container">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="content-card">
                        <!-- PAGE HEADER -->
                        <div class="mb-4">
                            <h1 class="page-title">Add New Equipment</h1>
                            <p class="page-subtitle">Register a new equipment or gadget</p>
                        </div>

                        <!-- ERROR MESSAGES -->
                        <?php if (session('errors')): ?>
                            <div class="alert alert-danger">
                                <div>
                                    <strong>Validation Errors:</strong>
                                    <ul class="error-list">
                                        <?php foreach (session('errors') as $error): ?>
                                            <li><?= esc($error) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <button type="button" class="btn-close-alert">×</button>
                            </div>
                        <?php endif; ?>

                        <!-- ADD FORM -->
                        <form action="<?= base_url('equipment/insert') ?>" method="POST">
                            <?= csrf_field() ?>

                            <!-- Equipment Name -->
                            <div class="form-group">
                                <label for="equipment_name" class="form-label">Equipment Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="equipment_name" name="equipment_name" 
                                       value="<?= old('equipment_name') ?>" required>
                            </div>

                            <!-- Category -->
                            <div class="form-group">
                                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-control" id="category" name="category" required>
                                    <option value="">-- Select Category --</option>
                                    <option value="Laptop" <?= old('category') === 'Laptop' ? 'selected' : '' ?>>Laptop</option>
                                    <option value="DLP" <?= old('category') === 'DLP' ? 'selected' : '' ?>>DLP</option>
                                    <option value="Cable" <?= old('category') === 'Cable' ? 'selected' : '' ?>>Cable</option>
                                    <option value="Remote Control" <?= old('category') === 'Remote Control' ? 'selected' : '' ?>>DLP Remote Control</option>
                                    <option value="Keyboard/Mouse" <?= old('category') === 'Keyboard/Mouse' ? 'selected' : '' ?>>Keyboard & Mouse</option>
                                    <option value="Drawing Tablet" <?= old('category') === 'Drawing Tablet' ? 'selected' : '' ?>>Wacom Drawing Tablet</option>
                                    <option value="Speaker Set" <?= old('category') === 'Speaker Set' ? 'selected' : '' ?>>Speaker Set</option>
                                    <option value="Webcam" <?= old('category') === 'Webcam' ? 'selected' : '' ?>>Webcam</option>
                                    <option value="Extension Cord" <?= old('category') === 'Extension Cord' ? 'selected' : '' ?>>Extension Cord</option>
                                    <option value="Crimping Tool" <?= old('category') === 'Crimping Tool' ? 'selected' : '' ?>>Cable Crimping Tool</option>
                                    <option value="Cable Tester" <?= old('category') === 'Cable Tester' ? 'selected' : '' ?>>Cable Tester</option>
                                    <option value="Lab Room Key" <?= old('category') === 'Lab Room Key' ? 'selected' : '' ?>>Lab Room Key</option>
                                    <option value="Other" <?= old('category') === 'Other' ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div>

                            <!-- Quantity -->
                            <div class="form-group">
                                <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="quantity" name="quantity" 
                                       value="<?= old('quantity') ?>" min="1" required>
                            </div>

                            <!-- FORM ACTIONS -->
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle"></i> Add Equipment
                                </button>
                                <a href="<?= base_url('equipment') ?>" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>