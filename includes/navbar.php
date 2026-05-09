<?php
include __DIR__ . '/session.php';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">

    <div class="container">

        <!-- LOGO -->

        <a class="navbar-brand fw-bold fs-2"
            href="/event-ticket-booking-system/index.php">

            🎟 EventBook

        </a>

        <!-- MOBILE TOGGLE -->

        <button class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <!-- NAVBAR LINKS -->

        <div class="collapse navbar-collapse"
            id="navbarNav">

            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item">

                    <a class="nav-link"
                        href="/event-ticket-booking-system/index.php">

                        Home

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link"
                        href="/event-ticket-booking-system/events.php">

                        Events

                    </a>

                </li>

                <?php if(isset($_SESSION['user_id'])): ?>

                    <li class="nav-item">

                        <a class="nav-link"
                            href="/event-ticket-booking-system/user/dashboard.php">

                            Dashboard

                        </a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link"
                            href="/event-ticket-booking-system/user/my-bookings.php">

                            My Bookings

                        </a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link"
                            href="/event-ticket-booking-system/logout.php">

                            Logout

                        </a>

                    </li>

                <?php else: ?>

                    <li class="nav-item">

                        <a class="nav-link"
                            href="/event-ticket-booking-system/login.php">

                            Login

                        </a>

                    </li>

                    <li class="nav-item ms-2">

                        <a class="btn btn-primary"
                            href="/event-ticket-booking-system/register.php">

                            Register

                        </a>

                    </li>

                <?php endif; ?>

                <!-- DARK MODE -->

                <li class="nav-item ms-3">

                    <button id="darkModeToggle"
                        class="btn btn-outline-light">

                        🌙

                    </button>

                </li>

            </ul>

        </div>

    </div>

</nav>