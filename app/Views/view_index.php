<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITSO Equipment Management System</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- CUSTOM STYLE -->
    <style>
        body {
            background: #f3f7ef;
            font-family: "Poppins", sans-serif;
        }
        .sidebar {
            width: 250px;
            height: 100vh;              
            position: fixed;
            left: 0;
            top: 0;

            background: #4B763A;
            padding-top: 20px;

            display: flex;
            flex-direction: column;

            overflow-y: auto;           
            overflow-x: hidden;
        }

        .sidebar a {
            text-decoration: none !important;
        }

        .sidebar-content {
            flex-grow: 1;
            overflow-y: auto;    
        }

        .menu-item,
        .menu-item:hover,
        .menu-item.active {
            color: #FEFD8E !important;
        }
        
        .stat-card p,
        .stat-value,
        .label-text {
            color: #FEFD8E !important;
        }

        .menu-item {
            padding: 19px 30px;
            margin-bottom: 10px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
        }

        .menu-item:hover, .menu-item.active {
            background: white;
            color: #325B2E !important; 
            border-radius: 0 40px 40px 0;
        }

        .dashboard-container {
            margin-left: 250px;
            padding: 30px;
           
        }

        .dash-title {
            font-size: 32px;
            font-weight: 700;
            color: #4B763A;
        }

        .dash-subtitle{
            color: black;

        }

        .stat-card {
            background: #4B763A;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 3px 8px rgba(0,0,0,0.15);
        }

        .stat-value {
            font-size: 42px;
            font-weight: 800;
        }

        table {
            background: white;
        }

        .profile-box {
            background: #295623;
            padding: 15px;
            border-radius: 12px;
            margin-top: 250px;
            text-align: center;
        }
        .profile-box img {
            width: 55px;
            height: 55px;
            border-radius: 100px;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>

   <?= view('include/view_sidebar') ?>

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

</body>
</html>
