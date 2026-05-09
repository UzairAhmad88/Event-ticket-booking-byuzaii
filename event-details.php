<?php

include 'config/db.php';
include 'includes/header.php';
include 'includes/navbar.php';

// CHECK EVENT ID

if(!isset($_GET['id'])){

    header("Location: events.php");
    exit();

}

$id = $_GET['id'];

// FETCH EVENT

$query = "SELECT * FROM events WHERE id='$id'";

$result = mysqli_query($conn, $query);

$event = mysqli_fetch_assoc($result);

?>

<div class="container py-5">

    <div class="row">

        <!-- EVENT IMAGE -->

        <div class="col-md-6">

            <img src="assets/images/events/<?php echo $event['image']; ?>"
                class="img-fluid rounded shadow">

        </div>

        <!-- EVENT DETAILS -->

        <div class="col-md-6">

            <h1 class="fw-bold mb-3">

                <?php echo $event['title']; ?>

            </h1>

            <p class="text-muted">

                <i class="bi bi-calendar-event"></i>

                <?php echo $event['event_date']; ?>

                |

                <i class="bi bi-clock"></i>

                <?php echo $event['event_time']; ?>

            </p>

            <p class="text-muted">

                <i class="bi bi-geo-alt"></i>

                <?php echo $event['venue']; ?>

            </p>

            <h3 class="text-primary fw-bold">

                $<?php echo $event['price']; ?>

            </h3>

            <p class="mt-4">

                <?php echo $event['description']; ?>

            </p>

            <p>

                <strong>Available Seats:</strong>

                <?php echo $event['available_seats']; ?>

            </p>

            <!-- BOOK BUTTON -->

            <a href="user/select-seat.php?event_id=<?php echo $event['id']; ?>"
                class="btn btn-dark btn-lg">

                Select Seats

            </a>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>