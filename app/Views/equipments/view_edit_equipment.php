<?= $this->include('include/view_head'); ?>

<body>

<div class="wrapper">
    <?= view('include/view_sidebar', ['active' => 'equipments']) ?>
    
    <div class="main-content">
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
        </div>
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
                        <?php if (session('errors.category')): ?>
                            <div class="invalid-feedback d-block">
                                <?= session('errors.category') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Description -->
                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?= old('description') ?? esc($equipment['description']) ?></textarea>
                    </div>
                </div>

                <div class="form-section">
                    <h5 class="form-section-title">Quantity & Condition</h5>

                    <div class="row">
                        <!-- Total Quantity -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="quantity" class="form-label">Total Quantity <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="quantity" name="quantity" 
                                       value="<?= old('quantity') ?? $equipment['quantity'] ?>" min="1" required>
                                <?php if (session('errors.quantity')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= session('errors.quantity') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Available Count -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="available_count" class="form-label">Available Count <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="available_count" name="available_count" 
                                       value="<?= old('available_count') ?? $equipment['available_count'] ?>" min="0" required>
                                <?php if (session('errors.available_count')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= session('errors.available_count') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Condition -->
                    <div class="form-group mb-3">
                        <label for="item_condition" class="form-label">Condition <span class="text-danger">*</span></label>
                        <select class="form-control" id="item_condition" name="item_condition" required>
                            <option value="">-- Select Condition --</option>
                            <option value="Good" <?= (old('item_condition') ?? $equipment['item_condition']) === 'Good' ? 'selected' : '' ?>>Good</option>
                            <option value="Fair" <?= (old('item_condition') ?? $equipment['item_condition']) === 'Fair' ? 'selected' : '' ?>>Fair</option>
                            <option value="Poor" <?= (old('item_condition') ?? $equipment['item_condition']) === 'Poor' ? 'selected' : '' ?>>Poor</option>
                            <option value="Damaged" <?= (old('item_condition') ?? $equipment['item_condition']) === 'Damaged' ? 'selected' : '' ?>>Damaged</option>
                        </select>
                        <?php if (session('errors.item_condition')): ?>
                            <div class="invalid-feedback d-block">
                                <?= session('errors.item_condition') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-section">
                    <h5 class="form-section-title">Additional Details</h5>

                    <div class="row">
                        <!-- Serial Number -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="serial_number" class="form-label">Serial Number</label>
                                <input type="text" class="form-control" id="serial_number" name="serial_number" 
                                       value="<?= old('serial_number') ?? esc($equipment['serial_number']) ?>">
                            </div>
                        </div>

                        <!-- Purchase Date -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="purchase_date" class="form-label">Purchase Date</label>
                                <input type="date" class="form-control" id="purchase_date" name="purchase_date" 
                                       value="<?= old('purchase_date') ?? $equipment['purchase_date'] ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="form-group mb-3">
                        <label for="location" class="form-label">Storage Location</label>
                        <input type="text" class="form-control" id="location" name="location" 
                               value="<?= old('location') ?? esc($equipment['location']) ?>" placeholder="e.g., Room 101, Cabinet A">
                    </div>

                    <!-- Accessories -->
                    <div class="form-group mb-3">
                        <label for="accessories" class="form-label">Accessories Included</label>
                        <textarea class="form-control" id="accessories" name="accessories" rows="2" placeholder="e.g., Charger, Power cable, Mouse"><?= old('accessories') ?? esc($equipment['accessories']) ?></textarea>
                        <small class="text-muted">List accessories that come with this equipment</small>
                    </div>

                    <!-- Notes -->
                    <div class="form-group mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Additional notes or remarks"><?= old('notes') ?? esc($equipment['notes']) ?></textarea>
                    </div>
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
        </div>

    </div>
</div>

</body>
</html>
