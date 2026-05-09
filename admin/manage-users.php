<?php

include '../config/db.php';
include '../includes/session.php';
include '../includes/admin-auth.php';

// FETCH USERS

$result = mysqli_query($conn,
    "SELECT * FROM users
     ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>
        Manage Users
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <h1 class="mb-5">

        Manage Users

    </h1>

    <table class="table table-bordered bg-white">

        <thead class="table-dark">

            <tr>

                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>

            </tr>

        </thead>

        <tbody>

            <?php while($user = mysqli_fetch_assoc($result)): ?>

                <tr>

                    <td>

                        <?php echo $user['id']; ?>

                    </td>

                    <td>

                        <?php echo $user['name']; ?>

                    </td>

                    <td>

                        <?php echo $user['email']; ?>

                    </td>

                    <td>

                        <?php echo $user['phone']; ?>

                    </td>

                    <td>

                        <?php echo $user['role']; ?>

                    </td>

                </tr>

            <?php endwhile; ?>

        </tbody>

    </table>

</div>

</body>
</html>