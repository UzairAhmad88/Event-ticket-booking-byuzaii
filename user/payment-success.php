<?php

include '../config/db.php';
include '../includes/session.php';
include '../libraries/phpqrcode/qrlib.php';

// LOGIN CHECK

if(!isset($_SESSION['user_id'])){

    header("Location: ../login.php");
    exit();

}

$bookingCode  = '';
$qrFileName   = '';
$lastBookingId = 0;

// CHECK FORM SUBMISSION

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user_id  = $_SESSION['user_id'];
    $event_id = $_POST['event_id'];

    $selectedSeats = explode(',', $_POST['seats']);
    $total         = $_POST['total'];

    if(empty($selectedSeats) || empty($event_id)){
        header("Location: ../events.php");
        exit();
    }

    // GENERATE BOOKING CODE

    $bookingCode = "EVT-" . strtoupper(substr(md5(time()), 0, 8));

    // QR DATA

    $qrData = "Booking Code: $bookingCode";

    // QR FILE NAME

    $qrFileName = $bookingCode . '.png';

    // QR SAVE PATH

    $qrPath = '../qr/generated/' . $qrFileName;

    // GENERATE QR CODE

    QRcode::png(
        $qrData,
        $qrPath,
        QR_ECLEVEL_L,
        5
    );

    // SAVE BOOKINGS — one row per seat

    foreach($selectedSeats as $seatNumber){

        $seatNumber = trim($seatNumber);

        // GET SEAT ID

        $seatQuery = mysqli_query($conn,
            "SELECT * FROM seats
             WHERE event_id='$event_id'
             AND seat_number='$seatNumber'");

        $seat = mysqli_fetch_assoc($seatQuery);

        if(!$seat) continue; // skip if seat not found

        $seat_id = $seat['id'];

        // INSERT BOOKING

        mysqli_query($conn,
            "INSERT INTO bookings
            (
                user_id,
                event_id,
                seat_id,
                booking_code,
                payment_status,
                qr_code
            )
            VALUES
            (
                '$user_id',
                '$event_id',
                '$seat_id',
                '$bookingCode',
                'paid',
                '$qrFileName'
            )");

        // SAVE LAST INSERT ID

        $lastBookingId = mysqli_insert_id($conn);

        // UPDATE SEAT STATUS

        mysqli_query($conn,
            "UPDATE seats
             SET status='booked'
             WHERE id='$seat_id'");
    }

    // REDUCE AVAILABLE SEATS

    $seatCount = count($selectedSeats);

    mysqli_query($conn,
        "UPDATE events
         SET available_seats =
         available_seats - $seatCount
         WHERE id='$event_id'");

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Booking Success
    </title>

    <!-- BOOTSTRAP -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow border-0 p-5 text-center">

                <!-- SUCCESS MESSAGE -->

                <h1 class="text-success mb-4">

                    Booking Successful 🎉

                </h1>

                <p class="mb-4">

                    Your event ticket has been booked successfully.

                </p>

                <!-- BOOKING CODE -->

                <h4 class="mb-4">

                    Booking Code:

                    <strong class="text-primary">

                        <?php echo htmlspecialchars($bookingCode); ?>

                    </strong>

                </h4>

                <!-- QR CODE -->

                <?php if(!empty($qrFileName)): ?>

                <div class="my-4">

                    <img src="../qr/generated/<?php echo $qrFileName; ?>"
                        width="200">

                </div>

                <?php endif; ?>

                <!-- BUTTONS -->

                <div class="d-flex justify-content-center gap-3">

                    <!-- DOWNLOAD TICKET — use $lastBookingId from the loop -->

                    <?php if($lastBookingId > 0): ?>

                    <a href="download-ticket.php?booking_id=<?php echo $lastBookingId; ?>"
                        class="btn btn-primary">

                        Download Ticket

                    </a>

                    <?php endif; ?>

                    <!-- BACK TO EVENTS -->

                    <a href="../events.php"
                        class="btn btn-dark">

                        Back To Events

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>