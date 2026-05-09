<?php

include 'config/db.php';
include 'includes/header.php';
include 'includes/navbar.php';

// SEARCH SYSTEM

if(isset($_GET['search'])){

    $search = mysqli_real_escape_string(
        $conn,
        $_GET['search']
    );

    $query = "
        SELECT
            id,
            title,
            description,
            event_date,
            venue,
            price,
            image
        FROM events
        WHERE title LIKE '%$search%'
        ORDER BY id DESC
    ";

}else{

    $query = "
        SELECT
            id,
            title,
            description,
            event_date,
            venue,
            price,
            image
        FROM events
        ORDER BY id DESC
    ";
}

// FETCH EVENTS

$result = mysqli_query($conn, $query);

?>

<!-- HERO SECTION -->

<section class="py-5 bg-dark text-white">

    <div class="container text-center">

        <h1 class="display-4 fw-bold mb-3">

            Discover Amazing Events

        </h1>

        <p class="lead">

            Book tickets online quickly and securely

        </p>

    </div>

</section>



<!-- EVENTS SECTION -->

<section class="py-5">

    <div class="container">

        <!-- TITLE -->

        <div class="text-center mb-5">

            <h2 class="fw-bold">

                Upcoming Events

            </h2>

            <p class="text-muted">

                Explore and book your favorite events

            </p>

        </div>



        <!-- SEARCH FORM -->

        <form method="GET"
            class="mb-5">

            <div class="row justify-content-center">

                <div class="col-md-6 mb-3">

                    <input type="text"
                        name="search"
                        class="form-control form-control-lg"
                        placeholder="Search events..."
                        value="<?php
                            echo isset($_GET['search'])
                            ? htmlspecialchars($_GET['search'])
                            : '';
                        ?>">

                </div>

                <div class="col-md-2 mb-3">

                    <button class="btn btn-dark btn-lg w-100">

                        Search

                    </button>

                </div>

            </div>

        </form>



        <!-- EVENT CARDS -->

        <div class="row g-4">

            <?php if(mysqli_num_rows($result) > 0): ?>

                <?php while($event = mysqli_fetch_assoc($result)): ?>

                    <div class="col-lg-4 col-md-6">

                        <div class="card border-0 shadow h-100">

                            <!-- EVENT IMAGE -->

                            <img
                                src="assets/images/events/<?php echo !empty($event['image']) ? $event['image'] : 'default-event.jpg'; ?>"
                                class="card-img-top"
                                height="250"
                                style="object-fit:cover;"
                                loading="lazy"
                                alt="Event Image">

                            <!-- CARD BODY -->

                            <div class="card-body d-flex flex-column">

                                <!-- TITLE -->

                                <h4 class="fw-bold mb-3">

                                    <?php
                                    echo htmlspecialchars(
                                        $event['title']
                                    );
                                    ?>

                                </h4>

                                <!-- DATE -->

                                <p class="text-muted mb-2">

                                    📅
                                    <?php
                                    echo htmlspecialchars(
                                        $event['event_date']
                                    );
                                    ?>

                                </p>

                                <!-- VENUE -->

                                <p class="text-muted mb-3">

                                    📍
                                    <?php
                                    echo htmlspecialchars(
                                        $event['venue']
                                    );
                                    ?>

                                </p>

                                <!-- DESCRIPTION -->

                                <p class="flex-grow-1">

                                    <?php

                                    echo substr(
                                        htmlspecialchars(
                                            $event['description']
                                        ),
                                        0,
                                        100
                                    );

                                    ?>...

                                </p>

                                <!-- PRICE -->

                                <h5 class="text-primary fw-bold mb-4">

                                    $
                                    <?php
                                    echo htmlspecialchars(
                                        $event['price']
                                    );
                                    ?>

                                </h5>

                                <!-- BUTTON -->

                                <a href="event-details.php?id=<?php echo $event['id']; ?>"
                                    class="btn btn-dark w-100">

                                    Book Now

                                </a>

                            </div>

                        </div>

                    </div>

                <?php endwhile; ?>

            <?php else: ?>

                <!-- EMPTY STATE -->

                <div class="col-12">

                    <div class="text-center py-5">

                        <h3 class="text-muted mb-3">

                            No Events Found

                        </h3>

                        <p class="text-muted">

                            Try searching with another keyword

                        </p>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>

<?php include 'includes/footer.php'; ?>