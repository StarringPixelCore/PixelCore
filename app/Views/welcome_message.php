<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Dashboard</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CUSTOM STYLE -->
    <style>
        body {
            background: #f3f7ef;
            font-family: "Poppins", sans-serif;
        }
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #4B763A;
            color: white;
            padding-top: 20px;
            position: fixed;
        }
        .sidebar .menu-item {
            padding: 12px 25px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            color: #d5e3d1;
        }
        .sidebar .menu-item:hover, .sidebar .active {
            background: white;
            color: #325B2E;
            border-radius: 40px 0 0 40px;
        }
        .dashboard-container {
            margin-left: 270px;
            padding: 35px;
        }

        .dash-title {
            font-size: 32px;
            font-weight: 700;
            color: #325B2E;
        }
        .dash-subtitle {
            font-size: 13px;
            letter-spacing: 1px;
            color: #5a5a5a;
        }

        .stat-card {
            background: #4B763A;
            color: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 3px 8px rgba(0,0,0,0.15);
        }
        .stat-value {
            font-size: 42px;
            font-weight: 800;
        }
        .label-text {
            font-size: 14px;
            margin-top: -5px;
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

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="text-center mb-4">
            <img src="https://i.imgur.com/vjH6d7C.png" width="120">
        </div>

        <div class="menu-item">DASHBOARD</div>
        <div class="menu-item">EQUIPMENTS</div>
        <div class="menu-item">RESERVATIONS</div>
        <div class="menu-item">BORROWED</div>
        <div class="menu-item">RETURNED</div>

        <!-- PROFILE -->
        <div class="profile-box mt-5">
            <img src="https://i.imgur.com/jQ5T3kO.png">
            <p class="m-0">Charlie Morningstar</p>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="dashboard-container">

        <h1 class="dash-title">DASHBOARD</h1>
        <p class="dash-subtitle">OVERVIEW OF EQUIPMENT, BORROWINGS, AND RESERVATIONS</p>

        <!-- STATS -->
        <div class="row mt-4">

            <div class="col-md-6 mb-4">
                <div class="stat-card">
                    <p class="fw-bold">TOTAL EQUIPMENT</p>
                    <div class="stat-value">
                        <?= $total_equipment ?? 0 ?>
                    </div>
                    <p class="label-text">Total number of equipments</p>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="stat-card">
                    <p class="fw-bold">AVAILABLE</p>
                    <div class="stat-value">
                        <?= $available ?? 0 ?>
                    </div>
                    <p class="label-text">Ready for Borrowing</p>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="stat-card">
                    <p class="fw-bold">BORROWED</p>
                    <div class="stat-value">
                        <?= $borrowed ?? 0 ?>
                    </div>
                    <p class="label-text">Currently Out</p>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="stat-card">
                    <p class="fw-bold">RESERVATIONS</p>
                    <div class="stat-value">
                        <?= $reservations_today ?? 0 ?> Today
                    </div>
                    <p class="label-text">Upcoming Reservations</p>
                </div>
            </div>
        </div>

        <!-- TABLE SECTION -->
        <div class="row mt-4">

            <div class="col-md-6 mb-4">
                <h5 class="fw-bold">RECENT BORROWINGS</h5>
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
                        <!-- LATER: Loop through borrowings -->
                        <tr><td colspan="4" class="text-center">No data yet</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6 mb-4">
                <h5 class="fw-bold">LOW STOCK ITEMS</h5>
                <table class="table table-bordered mt-2">
                    <thead class="table-success">
                        <tr>
                            <th>Item</th>
                            <th>Available</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- LATER: Loop through low stock -->
                        <tr><td colspan="3" class="text-center">No data yet</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>
