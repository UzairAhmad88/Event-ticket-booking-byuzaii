<?php

include '../config/db.php';
include '../includes/session.php';

// LOGIN CHECK

if(!isset($_SESSION['user_id'])){

    header("Location: ../login.php");
    exit();

}

$user_id = $_SESSION['user_id'];

// TOTAL BOOKINGS

$bookingQuery = mysqli_query($conn,
    "SELECT COUNT(*) AS total
     FROM bookings
     WHERE user_id='$user_id'");

$totalBookings =
    mysqli_fetch_assoc($bookingQuery)['total'];

// RECENT BOOKINGS

$recentQuery = mysqli_query($conn,
    "SELECT bookings.*,
            events.title,
            seats.seat_number

     FROM bookings

     JOIN events
     ON bookings.event_id = events.id

     JOIN seats
     ON bookings.seat_id = seats.id

     WHERE bookings.user_id='$user_id'

     ORDER BY bookings.id DESC

     LIMIT 5");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        User Dashboard
    </title>

    <!-- BOOTSTRAP -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- BOOTSTRAP ICONS -->

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CUSTOM CSS -->

    <link rel="stylesheet"
        href="../assets/css/dashboard.css">

</head>

<body>

<div class="d-flex">

    <!-- SIDEBAR -->

    <div class="sidebar p-4">

        <h3 class="text-white mb-5">

            🎟 User Panel

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

                <a href="my-bookings.php"
                    class="nav-link text-white">

                    <i class="bi bi-ticket-perforated"></i>

                    My Bookings

                </a>

            </li>

            <li class="nav-item mb-3">

                <a href="profile.php"
                    class="nav-link text-white">

                    <i class="bi bi-person-circle"></i>

                    Profile

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

        <!-- HEADER -->

        <div class="d-flex justify-content-between align-items-center mb-5">

            <div>

                <h1 class="fw-bold">

                    Welcome,
                    <?php echo $_SESSION['user_name']; ?>

                </h1>

                <p class="text-muted">

                    Manage your bookings and tickets

                </p>

            </div>

        </div>

        <!-- STATISTICS -->

        <div class="row g-4 mb-5">

            <!-- TOTAL BOOKINGS -->

            <div class="col-md-4">

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

            <!-- ACTIVE TICKETS -->

            <div class="col-md-4">

                <div class="card shadow border-0 stat-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h2 class="fw-bold text-success">

                                    Active

                                </h2>

                                <p class="text-muted">

                                    Ticket Status

                                </p>

                            </div>

                            <i class="bi bi-check-circle stat-icon text-success"></i>

                        </div>

                    </div>

                </div>

            </div>

            <!-- USER -->

            <div class="col-md-4">

                <div class="card shadow border-0 stat-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h2 class="fw-bold">

                                    User

                                </h2>

                                <p class="text-muted">

                                    Account Type

                                </p>

                            </div>

                            <i class="bi bi-person stat-icon"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- RECENT BOOKINGS -->

        <div class="card shadow border-0">

            <div class="card-header bg-white">

                <h4 class="mb-0">

                    Recent Bookings

                </h4>

            </div>

            <div class="card-body">

                <table class="table">

                    <thead>

                        <tr>

                            <th>Booking Code</th>
                            <th>Event</th>
                            <th>Seat</th>
                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php while($booking = mysqli_fetch_assoc($recentQuery)): ?>

                            <tr>

                                <td>

                                    <?php echo $booking['booking_code']; ?>

                                </td>

                                <td>

                                    <?php echo $booking['title']; ?>

                                </td>

                                <td>

                                    <?php echo $booking['seat_number']; ?>

                                </td>

                                <td>

                                    <span class="badge bg-success">

                                        <?php echo $booking['payment_status']; ?>

                                    </span>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>