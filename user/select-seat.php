<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/db.php';
include '../includes/session.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

if(!isset($_GET['event_id'])){
    die("Event ID Missing");
}

$event_id = intval($_GET['event_id']);

/* ================= FETCH EVENT ================= */

$event_sql = "SELECT * FROM events WHERE id = $event_id";
$event_result = mysqli_query($conn, $event_sql);

if(!$event_result){
    die(mysqli_error($conn));
}

if(mysqli_num_rows($event_result) == 0){
    die("Event Not Found");
}

$event = mysqli_fetch_assoc($event_result);

/* ================= GET BOOKED SEATS ================= */

$booked_seats = [];

// FIX: bookings has seat_id (FK), not a 'seats' column.
// JOIN seats table to get the actual seat_number of each booked seat.
$booking_sql = "SELECT seats.seat_number
                FROM bookings
                JOIN seats ON bookings.seat_id = seats.id
                WHERE bookings.event_id = $event_id";

$booking_result = mysqli_query($conn, $booking_sql);

if($booking_result){

    while($row = mysqli_fetch_assoc($booking_result)){
        $booked_seats[] = $row['seat_number'];
    }
}

/* ================= BOOK SEAT ================= */

if(isset($_POST['book_ticket'])){

    $selected_seats = $_POST['selected_seats'];
    $user_id = $_SESSION['user_id'];

    if(empty($selected_seats)){
        echo "<script>alert('Please select seats');</script>";
    }
    else{

        $insert_sql = "
        INSERT INTO bookings(user_id, event_id, seats)
        VALUES('$user_id','$event_id','$selected_seats')
        ";

        if(mysqli_query($conn, $insert_sql)){

            $booking_id = mysqli_insert_id($conn);

            header("Location: payment-success.php?booking_id=".$booking_id);
            exit();

        }else{

            die(mysqli_error($conn));
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Select Seat</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial;
        }

        body{
            background:#081120;
            color:white;
            padding:40px;
        }

        .container{
            max-width:1200px;
            margin:auto;
            text-align:center;
        }

        h1{
            font-size:55px;
            margin-bottom:10px;
        }

        p{
            color:#ccc;
            margin-bottom:40px;
        }

        .screen{
            width:70%;
            margin:20px auto 70px;
            padding:18px;
            background:white;
            color:black;
            border-radius:10px;
            font-weight:bold;
        }

        .seats{
            display:grid;
            grid-template-columns:repeat(8,70px);
            gap:18px;
            justify-content:center;
        }

        .seat{
            width:65px;
            height:65px;
            background:#13203a;
            border:2px solid #3b82f6;
            border-radius:15px;
            display:flex;
            align-items:center;
            justify-content:center;
            cursor:pointer;
            transition:0.3s;
        }

        .seat:hover{
            background:#2563eb;
        }

        .selected{
            background:#22c55e !important;
            border-color:#22c55e;
        }

        .booked{
            background:#ef4444 !important;
            border-color:#ef4444;
            cursor:not-allowed;
        }

        .info{
            margin-top:50px;
        }

        .info h3{
            margin-bottom:20px;
        }

        button{
            padding:15px 35px;
            background:#2563eb;
            color:white;
            border:none;
            border-radius:10px;
            cursor:pointer;
            font-size:17px;
        }

    </style>

</head>

<body>

<div class="container">

    <h1><?php echo $event['title']; ?></h1>

    <p>Select your seats</p>

    <div class="screen">
        SCREEN
    </div>

    <form method="POST">

        <div class="seats">

            <?php

            for($i=1; $i<=40; $i++){

                $seat = "A".$i;

                $isBooked = in_array($seat, $booked_seats);
            ?>

                <div
                    class="seat <?php echo $isBooked ? 'booked' : ''; ?>"
                    data-seat="<?php echo $seat; ?>"
                >
                    <?php echo $seat; ?>
                </div>

            <?php } ?>

        </div>

        <div class="info">

            <h3>
                Selected Seats:
                <span id="selectedSeats">None</span>
            </h3>

            <input
                type="hidden"
                name="selected_seats"
                id="selectedSeatsInput"
            >

            <button type="submit" name="book_ticket">
                Confirm Booking
            </button>

        </div>

    </form>

</div>

<script>

const seats = document.querySelectorAll('.seat:not(.booked)');

const selectedSeatsText =
document.getElementById('selectedSeats');

const selectedSeatsInput =
document.getElementById('selectedSeatsInput');

let selectedSeats = [];

seats.forEach(seat => {

    seat.addEventListener('click', () => {

        const seatNumber = seat.dataset.seat;

        seat.classList.toggle('selected');

        if(selectedSeats.includes(seatNumber)){

            selectedSeats =
            selectedSeats.filter(s => s !== seatNumber);

        }else{

            selectedSeats.push(seatNumber);
        }

        selectedSeatsText.innerText =
        selectedSeats.length > 0
        ? selectedSeats.join(', ')
        : 'None';

        selectedSeatsInput.value =
        selectedSeats.join(',');
    });

});

</script>

</body>
</html>