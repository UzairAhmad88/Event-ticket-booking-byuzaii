<?php

include '../config/db.php';
include '../includes/session.php';

if(!isset($_SESSION['user_id'])){

    header("Location: ../login.php");
    exit();

}

$user_id = $_SESSION['user_id'];

// FETCH BOOKINGS

$query = "SELECT bookings.*, events.title,
          seats.seat_number

          FROM bookings

          JOIN events
          ON bookings.event_id = events.id

          JOIN seats
          ON bookings.seat_id = seats.id

          WHERE bookings.user_id='$user_id'

          ORDER BY bookings.id DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>

<head>

    <title>My Bookings</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <h1 class="mb-5">
        My Bookings
    </h1>

    <table class="table table-bordered bg-white">

        <thead class="table-dark">

            <tr>

                <th>Booking Code</th>
                <th>Event</th>
                <th>Seat</th>
                <th>Status</th>
                <th>Date</th>
                <th>Ticket</th>

            </tr>

        </thead>

        <tbody>

            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($booking = mysqli_fetch_assoc($result)): ?>

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

                    <td>

                        <?php echo $booking['booking_date']; ?>

                    </td>

                    <td>

                        <a href="download-ticket.php?booking_id=<?php echo $booking['id']; ?>"
                            class="btn btn-primary btn-sm">

                            Download Ticket

                        </a>
                    </td>

                </tr>

            <?php endwhile; ?>
            <?php else: ?>

                <tr>

                    <td colspan="6" class="text-center">

                        No bookings found.

                    </td>

                </tr>
            <?php endif; ?>
            

        </tbody>

    </table>

</div>

</body>
</html>