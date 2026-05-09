<?php

// MUST include DB and session BEFORE any HTML output
include 'config/db.php';
include 'includes/session.php';

$message = "";

if(isset($_POST['register'])){

    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $phone    = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password'];

    // PASSWORD VALIDATION

    if(strlen($password) < 6){

        $message =
            "<div class='alert alert-danger'>
                Password must be at least 6 characters
             </div>";

    }elseif(!preg_match('/[A-Z]/', $password)){

        $message = "<div class='alert alert-danger'>
                        Password must contain at least one uppercase letter
                    </div>";

    }else{

        // HASH PASSWORD
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // CHECK EMAIL EXISTS
        $checkEmail = mysqli_query($conn,
            "SELECT * FROM users WHERE email='$email'");

        if(mysqli_num_rows($checkEmail) > 0){

            $message = "<div class='alert alert-danger'>
                            Email already exists
                        </div>";

        }else{

            $query = "INSERT INTO users(name,email,phone,password)
                      VALUES('$name','$email','$phone','$hashedPassword')";

            if(mysqli_query($conn, $query)){

                $message = "<div class='alert alert-success'>
                                Registration Successful
                            </div>";

            }else{

                $message = "<div class='alert alert-danger'>
                                Something went wrong
                            </div>";
            }

        }
    }

}

// HTML output AFTER all PHP/session logic
include 'includes/header.php';
include 'includes/navbar.php';

?>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow border-0 p-4">

                <h2 class="text-center mb-4">
                    Create Account
                </h2>

                <?php echo $message; ?>

                <form method="POST">

                    <div class="mb-3">

                        <label class="form-label">
                            Full Name
                        </label>

                        <input type="text"
                            name="name"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input type="email"
                            name="email"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Phone
                        </label>

                        <input type="text"
                            name="phone"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Password
                        </label>

                        <input type="password"
                            name="password"
                            class="form-control"
                            required>

                    </div>

                    <button type="submit"
                        name="register"
                        class="btn btn-primary w-100">

                        Register

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>