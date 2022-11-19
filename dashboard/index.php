<?php
require('core/app.php');

//all spaces
$spaces = $db->SelectAll("SELECT * FROM spaces WHERE user_id = :uid", ['uid' => $user['user_id']]);

//count total spaces
$spaces_count = ($spaces) ? count($spaces) : 0;
//total price
$price = 0;
if ($spaces) {
  foreach ($spaces as $i => $space) {
    $price += intval($space['space_price']);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Sharent User Dashboard</title>
  <meta content="" name="description" />
  <meta content="" name="keywords" />
  <?php include('includes/head.php'); ?>
</head>

<body>
  <!-- ======= Header ======= -->
  <?php include('includes/header.php'); ?>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <?php include('includes/sidebar.php'); ?>
  <!-- End Sidebar-->

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Welcome User</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">
            <!-- Reports -->
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">
                    Rent out your space on our platform <span>Today</span>
                  </h5>

                  <!-- Line Chart -->

                  <!-- <img
                      src="./assets/img/flier1.jpeg"
                      alt=""
                      srcset=""
                      width="100%"
                    /> -->
                  <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="assets/img/office-1.jpeg" class="d-block w-100" alt="...">
                      </div>
                      <div class="carousel-item">
                        <img src="assets/img/office-2.jpeg" class="d-block w-100" alt="...">
                      </div>
                      <div class="carousel-item">
                        <img src="assets/img/news-5.jpg" class="d-block w-100" alt="...">
                      </div>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                      data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                      data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>

                  </div>
                  <!-- End Line Chart -->
                </div>
              </div>
            </div>
            <!-- End Reports -->
            <!-- Sales Card -->
            <div class="col-xxl-4 col-lg-12 col-md-6 ">
              <div class="card info-card sales-card">


                <div class="card-body">
                  <h5 class="card-title">
                    <a href="./add-space">Upload your spaces </a>
                  </h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-building"></i>
                    </div>
                    <div class="ps-3">
                      <h6>
                        <?php print($spaces_count); ?>
                      </h6>
                      <span class="text-success small pt-1 fw-bold">Total</span>
                      <span class="text-muted small pt-2 ps-1">Uploaded spaces</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-lg-12 col-md-6">
              <div class="card info-card revenue-card">

                <div class="card-body">
                  <h5 class="card-title">Set your <span>Price</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      &#8358;
                    </div>
                    <div class="ps-3">
                      <h6>
                        <?php print($price); ?>
                      </h6>
                      <span class="text-success small pt-1 fw-bold"></span>
                      <span class="text-muted small pt-2 ps-1">On your terms</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Revenue Card -->
          </div>
        </div>
        <!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">
          <!-- Recent Activity -->

          <div class="card-body">
            <h5 class="card-title">Become Part of us <span>| Today</span></h5>

            <div class="activity">
              <div class="activity-item d-flex">
                <img src="./assets/img/flier2.jpeg" alt="" width="100%">
              </div>

              <div class="activity-item d-flex mt-4">
                <img src="./assets/img/flier2.jpeg" alt="" width="100%">
              </div>
              <div class="activity-item d-flex mt-4">
                <img src="./assets/img/flier2.jpeg" alt="" width="100%">
              </div>
              <!-- End activity item-->
            </div>
          </div>
        </div>
        <!-- End Recent Activity -->

        <!-- Budget Report -->
        <div class="card">
          <div class="card-body pb-0 mt-4>
            
                <div
                  id=" budgetChart" style="min-height: 400px" class="echart ">
            <video class="" autoplay width="100%" muted loop>
              <source src="./assets/videos/Sharent.mp4" type="video/mp4">
              Your browser is not supported!
            </video>
          </div>
        </div>
      </div>
      <!-- End Video -->

      </div>
      <!-- End Right side columns -->
      </div>
    </section>
  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include('includes/foot.php'); ?>
</body>

</html>