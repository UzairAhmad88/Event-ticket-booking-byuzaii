<?php

include '../config/db.php';
include '../includes/session.php';

// LOGIN CHECK

if(!isset($_SESSION['user_id'])){

    header("Location: ../login.php");
    exit();

}

// CHECK DATA

if(!isset($_GET['event_id']) || !isset($_GET['seats'])){

    header("Location: ../events.php");
    exit();

}

$event_id = $_GET['event_id'];
$selectedSeats = explode(',', $_GET['seats']);
if(empty($selectedSeats)){

    header("Location: ../events.php");
    exit();

}


// FETCH EVENT

$eventQuery = mysqli_query($conn,
    "SELECT * FROM events WHERE id='$event_id'");

$event = mysqli_fetch_assoc($eventQuery);

// TOTAL PRICE

$totalPrice =
    count($selectedSeats) * $event['price'];

?>

<!DOCTYPE html>
<html>

<head>

    <title>Payment</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow border-0 p-5">

                <h2 class="mb-4 text-center">

                    Payment Details

                </h2>

                <!-- EVENT INFO -->

                <div class="mb-4">

                    <h4>
                        <?php echo $event['title']; ?>
                    </h4>

                    <p>

                        Seats:
                        <strong>

                            <?php echo implode(', ', $selectedSeats); ?>

                        </strong>

                    </p>

                    <h3 class="text-primary">

                        Total:
                        $<?php echo $totalPrice; ?>

                    </h3>

                </div>

                <!-- PAYMENT FORM -->

                <form method="POST"
                    action="payment-success.php">

                    <input type="hidden"
                        name="event_id"
                        value="<?php echo $event_id; ?>">

                    <input type="hidden"
                        name="seats"
                        value="<?php echo implode(',', $selectedSeats); ?>">

                    <input type="hidden"
                        name="total"
                        value="<?php echo $totalPrice; ?>">

                    <div class="mb-3">

                        <label>
                            Card Holder Name
                        </label>

                        <input type="text"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-3">

                        <label>
                            Card Number
                        </label>

                        <input type="text"
                            class="form-control"
                            placeholder="1234 5678 9012 3456"
                            required>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label>
                                Expiry Date
                            </label>

                            <input type="text"
                                class="form-control"
                                placeholder="MM/YY"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>
                                CVV
                            </label>

                            <input type="password"
                                class="form-control"
                                required>

                        </div>

                    </div>

                    <button type="submit"
                        class="btn btn-dark btn-lg w-100">

                        Pay Now

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>