<?php

include '../config/db.php';

// CHECK EVENT ID

if(!isset($_GET['event_id'])){

    exit();

}

$event_id = $_GET['event_id'];

// FETCH BOOKED SEATS

$query = mysqli_query($conn,
    "SELECT seat_number
     FROM seats
     WHERE event_id='$event_id'
     AND status='booked'");

$bookedSeats = [];

while($seat = mysqli_fetch_assoc($query)){

    $bookedSeats[] = $seat['seat_number'];

}

// RETURN JSON

echo json_encode($bookedSeats);

?>