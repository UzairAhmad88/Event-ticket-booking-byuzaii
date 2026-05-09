<?php

include '../config/db.php';
include '../includes/session.php';
include '../includes/admin-auth.php';

// TOTAL EVENTS

$eventQuery = mysqli_query($conn,
    "SELECT COUNT(*) AS total
     FROM events");

$totalEvents =
    mysqli_fetch_assoc($eventQuery)['total'];

// TOTAL BOOKINGS

$bookingQuery = mysqli_query($conn,
    "SELECT COUNT(*) AS total
     FROM bookings");

$totalBookings =
    mysqli_fetch_assoc($bookingQuery)['total'];

// TOTAL USERS

$userQuery = mysqli_query($conn,
    "SELECT COUNT(*) AS total
     FROM users");

$totalUsers =
    mysqli_fetch_assoc($userQuery)['total'];

// TOTAL REVENUE

$revenueQuery = mysqli_query($conn,
    "SELECT SUM(events.price) AS revenue

     FROM bookings

     JOIN events
     ON bookings.event_id = events.id");

$totalRevenue =
    mysqli_fetch_assoc($revenueQuery)['revenue'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Admin Dashboard
    </title>

    <!-- BOOTSTRAP -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- BOOTSTRAP ICONS -->

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CUSTOM CSS -->

    <link rel="stylesheet"
        href="../assets/css/admin.css">

</head>

<body>

<div class="d-flex">

    <!-- SIDEBAR -->

    <div class="sidebar p-4">

        <h3 class="text-white mb-5">

            🎟 Admin Panel

        </h3>

        <ul class="nav flex-column">

            <li class="nav-item mb-3">

                <a href="dashboard.php"
                    class="nav-link text-white">

                    <i class="bi bi-speedometer2"></i>

                    Dashboard

                </a>

            </li>

            <li class="nav-item mb-3">

                <a href="add-event.php"
                    class="nav-link text-white">

                    <i class="bi bi-plus-circle"></i>

                    Add Event

                </a>

            </li>

            <li class="nav-item mb-3">

                <a href="manage-events.php"
                    class="nav-link text-white">

                    <i class="bi bi-calendar-event"></i>

                    Manage Events

                </a>

            </li>

            <li class="nav-item mb-3">

                <a href="manage-users.php"
                    class="nav-link text-white">

                    <i class="bi bi-people"></i>

                    Manage Users

                </a>

            </li>

            <li class="nav-item mb-3">

                <a href="manage-bookings.php"
                    class="nav-link text-white">

                    <i class="bi bi-ticket-perforated"></i>

                    Manage Bookings

                </a>

            </li>

            <li class="nav-item mt-5">

                <a href="../logout.php"
                    class="nav-link text-danger">

                    <i class="bi bi-box-arrow-right"></i>

                    Logout

                </a>

            </li>

        </ul>

    </div>

    <!-- MAIN CONTENT -->

    <div class="main-content p-5 w-100">

        <h1 class="fw-bold mb-5">

            Dashboard Overview

        </h1>

        <!-- STATISTICS -->

        <div class="row g-4">

            <!-- EVENTS -->

            <div class="col-md-3">

                <div class="card shadow border-0 stat-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h2 class="fw-bold">

                                    <?php echo $totalEvents; ?>

                                </h2>

                                <p class="text-muted">

                                    Total Events

                                </p>

                            </div>

                            <i class="bi bi-calendar-event stat-icon"></i>

                        </div>

                    </div>

                </div>

            </div>

            <!-- BOOKINGS -->

            <div class="col-md-3">

                <div class="card shadow border-0 stat-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h2 class="fw-bold">

                                    <?php echo $totalBookings; ?>

                                </h2>

                                <p class="text-muted">

                                    Total Bookings

                                </p>

                            </div>

                            <i class="bi bi-ticket-perforated stat-icon"></i>

                        </div>

                    </div>

                </div>

            </div>

            <!-- USERS -->

            <div class="col-md-3">

                <div class="card shadow border-0 stat-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h2 class="fw-bold">

                                    <?php echo $totalUsers; ?>

                                </h2>

                                <p class="text-muted">

                                    Total Users

                                </p>

                            </div>

                            <i class="bi bi-people stat-icon"></i>

                        </div>

                    </div>

                </div>

            </div>

            <!-- REVENUE -->

            <div class="col-md-3">

                <div class="card shadow border-0 stat-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h2 class="fw-bold text-success">

                                    $<?php echo $totalRevenue ?? 0; ?>

                                </h2>

                                <p class="text-muted">

                                    Revenue

                                </p>

                            </div>

                            <i class="bi bi-currency-dollar stat-icon text-success"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>