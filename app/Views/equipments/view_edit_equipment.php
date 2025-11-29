<?= $this->include('include/view_head'); ?>
<link rel="stylesheet" href="<?= base_url('public/css/editEquipment.css') ?>">
<body>

<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => 'equipments']) ?>
    
    <div class="dashboard-container">
        <!-- PAGE HEADER -->
        <div class="page-header">
            <h1 class="page-title">Edit Equipment</h1>
            <p class="page-subtitle">Update equipment information</p>
        </div>

        <!-- ERROR MESSAGES -->
        <?php if (session('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Validation Errors:</strong>
                <ul class="mb-0">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- EDIT FORM -->
        <div class="form-container">
            <form action="<?= base_url('equipment/update/' . $equipment['id']) ?>" method="POST">
                <?= csrf_field() ?>

                <!-- Equipment Name -->
                <div class="form-group mb-3">
                    <label for="equipment_name" class="form-label">Equipment Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="equipment_name" name="equipment_name" 
                           value="<?= old('equipment_name') ?? esc($equipment['equipment_name']) ?>" required>
                </div>

                <!-- Category -->
                <div class="form-group mb-3">
                    <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="">-- Select Category --</option>
                        <option value="Laptop" <?= (old('category') ?? $equipment['category']) === 'Laptop' ? 'selected' : '' ?>>Laptop</option>
                        <option value="DLP" <?= (old('category') ?? $equipment['category']) === 'DLP' ? 'selected' : '' ?>>DLP</option>
                        <option value="Cable" <?= (old('category') ?? $equipment['category']) === 'Cable' ? 'selected' : '' ?>>Cable</option>
                        <option value="Remote Control" <?= (old('category') ?? $equipment['category']) === 'Remote Control' ? 'selected' : '' ?>>DLP Remote Control</option>
                        <option value="Keyboard/Mouse" <?= (old('category') ?? $equipment['category']) === 'Keyboard/Mouse' ? 'selected' : '' ?>>Keyboard & Mouse</option>
                        <option value="Drawing Tablet" <?= (old('category') ?? $equipment['category']) === 'Drawing Tablet' ? 'selected' : '' ?>>Wacom Drawing Tablet</option>
                        <option value="Speaker Set" <?= (old('category') ?? $equipment['category']) === 'Speaker Set' ? 'selected' : '' ?>>Speaker Set</option>
                        <option value="Webcam" <?= (old('category') ?? $equipment['category']) === 'Webcam' ? 'selected' : '' ?>>Webcam</option>
                        <option value="Extension Cord" <?= (old('category') ?? $equipment['category']) === 'Extension Cord' ? 'selected' : '' ?>>Extension Cord</option>
                        <option value="Crimping Tool" <?= (old('category') ?? $equipment['category']) === 'Crimping Tool' ? 'selected' : '' ?>>Cable Crimping Tool</option>
                        <option value="Cable Tester" <?= (old('category') ?? $equipment['category']) === 'Cable Tester' ? 'selected' : '' ?>>Cable Tester</option>
                        <option value="Lab Room Key" <?= (old('category') ?? $equipment['category']) === 'Lab Room Key' ? 'selected' : '' ?>>Lab Room Key</option>
                        <option value="Other" <?= (old('category') ?? $equipment['category']) === 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>

                <!-- Quantity -->
                <div class="form-group mb-3">
                    <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="quantity" name="quantity" 
                           value="<?= old('quantity') ?? $equipment['quantity'] ?>" min="1" required>
                </div>

                <!-- Available Count -->
                <div class="form-group mb-3">
                    <label for="available_count" class="form-label">Available Count <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="available_count" name="available_count" 
                           value="<?= old('available_count') ?? $equipment['available_count'] ?>" min="0" required>
                </div>

                <!-- FORM ACTIONS -->
                <div class="form-actions mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Update Equipment
                    </button>
                    <a href="<?= base_url('equipment') ?>" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>


        </form>
        </div>

    </div>
</div>

</body>
</html>
