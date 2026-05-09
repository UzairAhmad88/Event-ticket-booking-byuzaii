<?php

include '../config/db.php';
include '../includes/session.php';
include '../includes/admin-auth.php';

$message = "";

if(isset($_POST['add_event'])){

    $title       = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $event_date  = $_POST['event_date'];
    $event_time  = $_POST['event_time'];
    $venue       = mysqli_real_escape_string($conn, $_POST['venue']);
    $price       = $_POST['price'];
    $total_seats = $_POST['total_seats'];

    // IMAGE UPLOAD

    $newImageName = $_FILES['image']['name'];   // FIX: removed the erroneous quotes around '$newImageName'

    $tmpName   = $_FILES['image']['tmp_name'];
    $imageSize = $_FILES['image']['size'];
    $imageError = $_FILES['image']['error'];

    // FILE EXTENSION

    $imageExt = strtolower(pathinfo($newImageName, PATHINFO_EXTENSION));

    // ALLOWED TYPES

    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    if($imageError !== UPLOAD_ERR_OK){

        $message = "<div class='alert alert-danger'>Image upload failed (error code: $imageError)</div>";

    }elseif(!in_array($imageExt, $allowed)){

        $message = "<div class='alert alert-danger'>Invalid image type. Allowed: jpg, jpeg, png, webp</div>";

    }elseif($imageSize > 5000000){

        $message = "<div class='alert alert-danger'>Image too large. Max size is 5MB</div>";

    }else{

        // RENAME & MOVE — only one call, only when validation passes

        $newImageName = time() . '_' . $newImageName;

        move_uploaded_file($tmpName, "../assets/images/events/$newImageName");

        // INSERT EVENT

        $query = "INSERT INTO events
                  (title, description, event_date, event_time,
                   venue, price, total_seats, available_seats, image)
                  VALUES
                  ('$title','$description','$event_date',
                   '$event_time','$venue','$price',
                   '$total_seats','$total_seats','$newImageName')";

        if(mysqli_query($conn, $query)){

            // GET EVENT ID

            $event_id = mysqli_insert_id($conn);

            // CREATE SEATS

            for($i = 1; $i <= $total_seats; $i++){

                $seat_number = "A" . $i;

                mysqli_query($conn,
                    "INSERT INTO seats(event_id, seat_number)
                     VALUES('$event_id', '$seat_number')");
            }

            $message = "<div class='alert alert-success'>Event Added Successfully</div>";

        }else{

            $message = "<div class='alert alert-danger'>Failed To Add Event: " . mysqli_error($conn) . "</div>";
        }
    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Event</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow border-0 p-4">

                <h2 class="mb-4">
                    Add New Event
                </h2>

                <?php echo $message; ?>

                <form method="POST"
                    enctype="multipart/form-data">

                    <div class="mb-3">

                        <label>
                            Event Title
                        </label>

                        <input type="text"
                            name="title"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-3">

                        <label>
                            Description
                        </label>

                        <textarea name="description"
                            class="form-control"
                            rows="4"></textarea>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label>
                                Event Date
                            </label>

                            <input type="date"
                                name="event_date"
                                class="form-control"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>
                                Event Time
                            </label>

                            <input type="time"
                                name="event_time"
                                class="form-control"
                                required>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label>
                            Venue
                        </label>

                        <input type="text"
                            name="venue"
                            class="form-control"
                            required>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label>
                                Ticket Price
                            </label>

                            <input type="number"
                                name="price"
                                class="form-control"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>
                                Total Seats
                            </label>

                            <input type="number"
                                name="total_seats"
                                class="form-control"
                                required>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label>
                            Event Image
                        </label>

                        <input type="file"
                            name="image"
                            class="form-control"
                            required>

                    </div>

                    <button type="submit"
                        name="add_event"
                        class="btn btn-primary">

                        Add Event

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>