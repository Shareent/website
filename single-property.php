<?php

$id = (isset($_GET) && isset($_GET['id']) && !empty($_GET['id'])) ? intval($_GET['id']) : 0;

if(!$id) {
    header("Location: ./properties");
    exit();
}

require('core/db.php');

$db = new DatabaseClass();

//only display verified spaces
$space = $db->SelectOne("SELECT * FROM spaces INNER JOIN profile INNER JOIN users ON spaces.user_id = profile.user_id AND users.user_id = profile.user_id AND spaces.is_verified = :v AND spaces.id = :id AND spaces.is_booked = :book", ['id' => $id, 'v' => 'yes', 'book' => 'no']);


print('
<script>
document.addEventListener(\'DOMContentLoaded\', () => {
    document.querySelector(\'#days_avail\').innerText = '.$space["days_avail"].'
})
</script>
');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Sharent</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/imgs/sharent.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

    <!-- ======= Property Search Section ======= -->
    <div class="click-closed"></div>
    <!--/ Form Search Star /-->
    <?php include('includes/search.php'); ?>
    <!-- ======= Header/Navbar ======= -->
    <?php include('includes/navbar.php'); ?>

    <main id="main">

        <!-- ======= Intro Single ======= -->
        <section class="intro-single">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-8">
                        <div class="title-single-box">
                            <h1 class="title-single"><?php echo $space['space_name']; ?></h1>
                            <span class="color-text-a"><?php echo $space['space_location_state']; ?> State</span>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="property-grid.html">Properties</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?php echo $space['space_name']; ?>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section><!-- End Intro Single-->

        <!-- ======= Property Single ======= -->
        <section class="property-single nav-arrow-b">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div id="property-single-carousel" class="swiper">
                            <div class="swiper-wrapper">
                                <div class="carousel-item-b swiper-slide">
                                    <img src="dashboard/uploads/<?php echo $space['space_img']; ?>" alt="<?php echo $space['space_name']; ?>">
                                </div>
                                <div class="carousel-item-b swiper-slide">
                                    <img src="dashboard/uploads/<?php echo $space['space_img']; ?>" alt="<?php echo $space['space_name']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="property-single-carousel-pagination carousel-pagination"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="row justify-content-between">
                            <div class="col-md-6 col-lg-6">
                                <div class="property-summary">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="title-box-d section-t4">
                                                <h3 class="title-d">Quick Summary</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="summary-list">
                                        <ul class="list">
                                            <li class="d-flex justify-content-between">
                                                <strong>Property ID:</strong>
                                                <span><?php echo $space['id']; ?></span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <strong>Price</strong>
                                                <span>&#8358;<?php echo $space['space_price']; ?></span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <strong>Location:</strong>
                                                <span><?php echo $space['space_location_state']; ?></span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <strong>Property Type:</strong>
                                                <span><?php echo $space['space_type']; ?></span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <strong>Time Range:</strong>
                                                <span><?php echo $space['time_range']; ?></span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <strong>Days Available:</strong>
                                                <span id="days_avail"></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 section-md-t3">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="title-box-d">
                                            <h3 class="title-d" style="margin-top: 65px;">Property Description</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="property-description">
                                    <p class="description color-text-a">
                                    <?php echo $space['space_desc']; ?>
                                    </p>
                                </div>
                                <div class="mt-5">
                                    <a href="./register?account-type=buyer" class="btn btn-success p-3">Login / Register to book this space</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row section-t3">
                            <div class="col-sm-12">
                                <div class="title-box-d">
                                    <h3 class="title-d">Contact Agent</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <img src="dashboard/uploads/<?php echo $space['profile_img']; ?>" alt="<?php echo $space['fname']; ?>"
                                    class="img-fluid">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="property-agent">
                                    <h4 class="title-agent"><?php echo $space['fname']. ' ' .$space['lname'] ; ?></h4>
                                    <p class="color-text-a p-3">
                                    <?php echo $space['self_desc']; ?>
                                    </p>
                                    <ul class="list-unstyled">
                                        <li class="d-flex justify-content-between">
                                            <strong>Phone:</strong>
                                            <span class="color-text-a"><?php echo $space['phone']; ?></span>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <strong>Email:</strong>
                                            <span class="color-text-a"><?php echo $space['email']; ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- End Property Single-->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include('includes/footer.php'); ?>
    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>