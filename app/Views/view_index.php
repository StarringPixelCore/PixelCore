<!DOCTYPE html>
<html lang="en">
<?= view('include/view_head') ?>
<body>
   <div class="wrapper">
    <?= view('include/view_sidebar') ?>
    <div class="main-content">
         <!-- MAIN CONTENT -->
    <div class="dashboard-container">

        <h1 class="dash-title">DASHBOARD</h1>
        <p class="dash-subtitle">OVERVIEW OF EQUIPMENT, BORROWINGS, AND RESERVATIONS</p>

        <!-- STATS SECTION -->
        <div class="row mt-4">

            <div class="col-md-6 mb-4">
                <div class="stat-card d-flex align-items-center">
                    <i class="bi bi-box-seam fs-1 me-3"></i>
                    <div>
                        <p class="fw-bold m-0">TOTAL EQUIPMENT</p>
                        <div class="stat-value"><?= $total_equipment ?? 0 ?></div>
                        <p class="label-text">Total number of equipments</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="stat-card d-flex align-items-center">
                    <i class="bi bi-check-square fs-1 me-3"></i>
                    <div>
                        <p class="fw-bold m-0">AVAILABLE</p>
                        <div class="stat-value"><?= $available ?? 0 ?></div>
                        <p class="label-text">Ready for Borrowing</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="stat-card d-flex align-items-center">
                    <i class="bi bi-arrow-repeat fs-1 me-3"></i>
                    <div>
                        <p class="fw-bold m-0">BORROWED</p>
                        <div class="stat-value"><?= $borrowed ?? 0 ?></div>
                        <p class="label-text">Currently Out</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="stat-card d-flex align-items-center">
                    <i class="bi bi-calendar-event fs-1 me-3"></i>
                    <div>
                        <p class="fw-bold m-0">RESERVATIONS</p>
                        <div class="stat-value"><?= $reservations_today ?? 0 ?> Today</div>
                        <p class="label-text">Upcoming Reservations</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- TABLE SECTION -->
        <div class="row mt-4">
            <div class="col-md-6 mb-4">
                <h5 class="fw-bold" style="color:#325B2E">RECENT BORROWINGS</h5>
                <table class="table table-bordered mt-2">
                    <thead class="table-success">
                        <tr>
                            <th>Name</th>
                            <th>Item</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td colspan="4" class="text-center">No data yet</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6 mb-4">
                <h5 class="fw-bold" style="color:#325B2E">LOW STOCK ITEMS</h5>
                <table class="table table-bordered mt-2">
                    <thead class="table-success">
                        <tr>
                            <th>Item</th>
                            <th>Available</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td colspan="3" class="text-center">No data yet</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    </div>
</div>


</body>
</html>
