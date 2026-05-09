<?php

include '../config/db.php';
include '../includes/session.php';
include '../includes/admin-auth.php';

// CHECK ID

if(isset($_GET['id'])){

    $id = $_GET['id'];

    mysqli_query($conn,
        "DELETE FROM events
         WHERE id='$id'");

}

header("Location: manage-events.php");
exit();

?>