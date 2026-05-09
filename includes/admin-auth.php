<?php

include __DIR__ . '/session.php';

// CHECK LOGIN

if(!isset($_SESSION['user_id'])){

    header("Location: /event-ticket-booking-system/login.php");
    exit();

}

// CHECK ROLE

if($_SESSION['role'] !== 'admin'){

    header("Location: /event-ticket-booking-system/index.php");
    exit();

}