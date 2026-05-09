<?php

include '../config/db.php';
include '../includes/session.php';
include '../includes/admin-auth.php';

$result = mysqli_query($conn,
    "SELECT * FROM events ORDER BY id DESC");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Manage Events</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <h1 class="mb-4">
        Manage Events
    </h1>

    <table class="table table-bordered bg-white">

        <thead class="table-dark">

            <tr>

                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Date</th>
                <th>Venue</th>
                <th>Price</th>
                <th>Action</th>

            </tr>

        </thead>

        <tbody>

        <?php while($event = mysqli_fetch_assoc($result)): ?>

            <tr>

                <td>
                    <?php echo $event['id']; ?>
                </td>

                <td>

                    <img src="../assets/images/events/<?php echo $event['image']; ?>"
                        width="80">

                </td>

                <td>
                    <?php echo $event['title']; ?>
                </td>

                <td>
                    <?php echo $event['event_date']; ?>
                </td>

                <td>
                    <?php echo $event['venue']; ?>
                </td>

                <td>
                    $<?php echo $event['price']; ?>
                </td>

                <td>

                    <a href="edit-event.php?id=<?php echo $event['id']; ?>"
                        class="btn btn-sm btn-primary">

                        Edit

                    </a>

                    <a href="delete-event.php?id=<?php echo $event['id']; ?>"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure you want to delete this event?');">

                        Delete

                    </a>    
                </td>

            </tr>

        <?php endwhile; ?>

        </tbody>

    </table>

</div>

</body>
</html>