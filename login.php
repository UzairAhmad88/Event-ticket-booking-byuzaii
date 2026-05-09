<?php

include 'config/db.php';
include 'includes/session.php';

$message = "";

// LOGIN

if(isset($_POST['login'])){

    $email =
        mysqli_real_escape_string(
            $conn,
            $_POST['email']
        );

    $password =
        $_POST['password'];

    $query =
        "SELECT * FROM users
         WHERE email='$email'";

    $result =
        mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){

        $user =
            mysqli_fetch_assoc($result);

        if(password_verify(
            $password,
            $user['password']
        )){

            session_regenerate_id(true);

            $_SESSION['user_id'] =
                $user['id'];

            $_SESSION['user_name'] =
                $user['name'];

            $_SESSION['role'] =
                $user['role'];

            // ROLE-BASED REDIRECT
            if($_SESSION['role'] === 'admin'){
                header("Location: /event-ticket-booking-system/admin/dashboard.php");
            } else {
                header("Location: /event-ticket-booking-system/user/dashboard.php");
            }
            exit();

        }else{

            $message =
                "<div class='alert alert-danger'>
                    Invalid Password
                 </div>";
        }

    }else{

        $message =
            "<div class='alert alert-danger'>
                User Not Found
             </div>";
    }
}

include 'includes/header.php';
include 'includes/navbar.php';

?>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow border-0 p-5">

                <h2 class="text-center mb-4">

                    Login

                </h2>

                <?php echo $message; ?>

                <form method="POST">

                    <div class="mb-3">

                        <label class="form-label">

                            Email

                        </label>

                        <input type="email"
                            name="email"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-4">

                        <label class="form-label">

                            Password

                        </label>

                        <input type="password"
                            name="password"
                            class="form-control"
                            required>

                    </div>

                    <button type="submit"
                        name="login"
                        class="btn btn-dark w-100">

                        Login

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>