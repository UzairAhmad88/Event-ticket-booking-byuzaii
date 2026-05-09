<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

include '../config/db.php';
include '../includes/session.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

if(!isset($_GET['booking_id'])){
    die("Booking ID Missing");
}

$booking_id = intval($_GET['booking_id']);

$query = "
SELECT 
    bookings.*,
    events.title,
    events.event_date,
    events.venue
FROM bookings
JOIN events
ON bookings.event_id = events.id
WHERE bookings.id = '$booking_id'
";

$result = mysqli_query($conn, $query);

if(!$result){
    die(mysqli_error($conn));
}

if(mysqli_num_rows($result) == 0){
    die("Booking Not Found");
}

$booking = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Download Ticket</title>

    <style>

        body{
            background:#081120;
            font-family:Arial;
            color:white;
            padding:40px;
        }

        .ticket{

            max-width:650px;
            margin:auto;
            background:white;
            color:black;
            padding:40px;
            border-radius:15px;
            box-shadow:0 10px 30px rgba(0,0,0,0.3);
        }

        h1{
            text-align:center;
            margin-bottom:30px;
        }

        .row{
            margin-bottom:18px;
            font-size:18px;
        }

        .label{
            font-weight:bold;
        }

        .btn{
            margin-top:30px;
            width:100%;
            padding:15px;
            background:#2563eb;
            border:none;
            color:white;
            border-radius:10px;
            cursor:pointer;
            font-size:17px;
        }

    </style>

</head>

<body>

<div class="ticket">

    <h1>Event Ticket</h1>

    <div class="row">
        <span class="label">Booking ID:</span>
        <?php echo $booking['id']; ?>
    </div>

    <div class="row">
        <span class="label">Event:</span>
        <?php echo $booking['title']; ?>
    </div>

    <div class="row">
        <span class="label">Date:</span>
        <?php echo $booking['event_date']; ?>
    </div>

    <div class="row">
        <span class="label">Venue:</span>
        <?php echo $booking['venue']; ?>
    </div>

    <div class="row">
        <span class="label">Seats:</span>
        <?php echo $booking['seats']; ?>
    </div>

    <button class="btn" onclick="window.print()">
        Print Ticket
    </button>

</div>

</body>
</html>