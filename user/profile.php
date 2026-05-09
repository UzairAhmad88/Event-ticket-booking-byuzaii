<?php

include '../config/db.php';
include '../includes/session.php';

// LOGIN CHECK

if(!isset($_SESSION['user_id'])){

    header("Location: ../login.php");
    exit();

}

$user_id = $_SESSION['user_id'];

$message = "";

// UPDATE PROFILE

if(isset($_POST['update_profile'])){

    $name = mysqli_real_escape_string($conn,
        $_POST['name']);

    $phone = mysqli_real_escape_string($conn,
        $_POST['phone']);

    mysqli_query($conn,
        "UPDATE users
         SET name='$name',
         phone='$phone'
         WHERE id='$user_id'");

    $_SESSION['user_name'] = $name;

    $message = "<div class='alert alert-success'>
                    Profile Updated Successfully
                </div>";
}

// FETCH USER

$query = mysqli_query($conn,
    "SELECT * FROM users
     WHERE id='$user_id'");

$user = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Profile
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow border-0 p-5">

                <h2 class="mb-4 text-center">

                    My Profile

                </h2>

                <?php echo $message; ?>

                <form method="POST">

                    <!-- NAME -->

                    <div class="mb-3">

                        <label>
                            Full Name
                        </label>

                        <input type="text"
                            name="name"
                            class="form-control"
                            value="<?php echo $user['name']; ?>"
                            required>

                    </div>

                    <!-- EMAIL -->

                    <div class="mb-3">

                        <label>
                            Email
                        </label>

                        <input type="email"
                            class="form-control"
                            value="<?php echo $user['email']; ?>"
                            disabled>

                    </div>

                    <!-- PHONE -->

                    <div class="mb-4">

                        <label>
                            Phone
                        </label>

                        <input type="text"
                            name="phone"
                            class="form-control"
                            value="<?php echo $user['phone']; ?>">

                    </div>

                    <!-- BUTTON -->

                    <button type="submit"
                        name="update_profile"
                        class="btn btn-primary w-100">

                        Update Profile

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>