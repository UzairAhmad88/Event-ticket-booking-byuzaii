<?php

include '../config/db.php';
include '../includes/session.php';
include '../includes/admin-auth.php';

// FETCH BOOKINGS

$query = "SELECT bookings.*,
          users.name,
          events.title,
          seats.seat_number

          FROM bookings

          JOIN users
          ON bookings.user_id = users.id

          JOIN events
          ON bookings.event_id = events.id

          JOIN seats
          ON bookings.seat_id = seats.id

          ORDER BY bookings.id DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>
        Manage Bookings
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <h1 class="mb-5">

        Manage Bookings

    </h1>

    <table class="table table-bordered bg-white">

        <thead class="table-dark">

            <tr>

                <th>Booking Code</th>
                <th>User</th>
                <th>Event</th>
                <th>Seat</th>
                <th>Status</th>
                <th>Date</th>

            </tr>

        </thead>

        <tbody>

            <?php while($booking = mysqli_fetch_assoc($result)): ?>

                <tr>

                    <td>

                        <?php echo $booking['booking_code']; ?>

                    </td>

                    <td>

                        <?php echo $booking['name']; ?>

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

                    <td>

                        <?php echo $booking['booking_date']; ?>

                    </td>

                </tr>

            <?php endwhile; ?>

        </tbody>

    </table>

</div>

</body>
</html>