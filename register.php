<?php
session_start();
//check if session exists
if(isset($_SESSION['auth']) && !empty($_SESSION['auth'])){
  header("Location: ./dashboard/");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sharent User Form</title>
  <link rel="shortcut icon" href="assets/imgs/sharent.png" type="image/x-icon" />
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/app.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet" />
  <!-- custom Javascript   -->
  <script defer src="assets/js/main.js"></script>
  <!-- octavalidate-->
  <script src="assets/js/validate.js"></script>
  <script src="assets/js/jquery-3.5.1.min.js"></script>
  <link rel="stylesheet" href="assets/toastr/toastr.min.css" />
  <script src="assets/toastr/toastr.min.js"></script>
  <style>
    .form-group {
      margin: 30px 0;
    }

    .auth-form-section {
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      max-width: 500px;
      margin: 50px auto;
      box-shadow: 0px 0px 8px #ddd;
    }

    .section-desc {
      margin: 20px 0;
      max-width: 300px;
    }
  </style>
</head>

<body id="register">
  <div class="container">
    <main>
      <section class="auth-form-section">

        <section class="section-desc">
          <h1 class="creat-acct">Hello, Friend!</h1>
          <p class="creat-acct__sub-txt">
            Enter your personal details to get started
          </p>
        </section>
        <section id="user-account-type">

        </section>
        <form method="post" id="form_register" novalidate>
          <div class="form-group">
            <label class="form-label">Email Address</label>
            <input id="inp_email" type="email" class="form-control" name="email" octavalidate="R,EMAIL"
              ov-required-msg="Your email address is required" placeholder="Enter your email address" />
          </div>
          <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" id="inp_pass" octavalidate="R" minlength="8" class="form-control" name="password"
              ov-required-msg="Your password is required" placeholder="Enter your password" />
          </div>
          <div class="form-group">
            <label class="form-label">Confirm password</label>
            <input type="password" id="inp_conpass" class="form-control" name="confirm_password" equalto="inp_pass"
              ov-equalto-msg="Both passwords do not match" placeholder="Re-enter your password" />
          </div>
          <div class="form-group mt-4">
            <button type="submit" class="btn app-btn btn-block w-100 primary">Register</button>
            <p class="text-center mt-3">Already have an account? <a class="link" href="login.html">Click here to
                login</a></p>
          </div>
        </form>
      </section>
    </main>
  </div>
  <script src="assets/js/auth.js"></script>
</body>

</html>