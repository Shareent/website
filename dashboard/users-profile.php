<?php
require('core/app.php');
//check if session exists
if (!isset($_SESSION['auth']) || empty($_SESSION['auth'])) {
    header("Location: ../login");
    exit();
}

//success / failure error
$msg = $success = '';
if (isset($_SESSION['success']) && isset($_SESSION['msg'])) {
    // || checks for boolean values only
    $success = $_SESSION['success'] || false;
    $msg = $_SESSION['msg'];
    //remove the session
    unset($_SESSION['success']);
    unset($_SESSION['msg']);
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['action']) && !empty($_POST['action'])) {
        $action = $_POST['action'];
        $user = $db->SelectOne("SELECT * FROM users WHERE users.user_id = :id", ['id' => $_SESSION['auth']['token']]);
        if ($action == "upd-profile" && $user) {
            $target_dir = "uploads/";
            $profile_img = $_FILES["profile_img"]["name"];
            $self_desc = $_POST['self_desc'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $phone = $_POST['phone'];
            $addr = $_POST['addr'];
            //check if data exists or you update it
            if (!$profile) {
                $target_file = $target_dir . basename($_FILES["profile_img"]["name"]);
                move_uploaded_file($_FILES["profile_img"]["tmp_name"], $target_file);
                $db->Insert("INSERT INTO profile (user_id, fname, lname, addr, phone, profile_img, self_desc) VALUES (:uid, :fname, :lname, :addr, :phone, :profile_img, :self_desc)", [
                    'uid' => $_SESSION['auth']['token'],
                    'profile_img' => $profile_img,
                    'fname' => $fname,
                    'lname' => $lname,
                    'phone' => $phone,
                    'addr' => $addr,
                    'self_desc' => $self_desc
                ]);
            } else {
                //$profile_img = $profile['profile_img'];
                if($profile_img){
                    
                    if(file_exists($target_dir.$profile['profile_img'])){
                        unlink($target_dir.$profile['profile_img']);
                    }
                    
                    $target_file = $target_dir . basename($_FILES["profile_img"]["name"]);
                    move_uploaded_file($_FILES["profile_img"]["tmp_name"], $target_file);
                }

                $db->Update("UPDATE profile SET fname = :fname, lname = :lname, addr = :addr, phone = :phone, profile_img = :prof_img WHERE user_id = :uid", [
                    'uid' => $_SESSION['auth']['token'],
                    'fname' => $fname,
                    'prof_img' => $profile_img, 
                    'lname' => $lname,
                    'phone' => $phone,
                    'addr' => $addr
                ]);
            }


            $_SESSION['success'] = true;
            $_SESSION['msg'] = "Profile updated successfully";

            header("Location: ./users-profile.php");
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>User Dashboard</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <?php include('includes/head.php'); ?>
    <style>
    .profile .profile-card img {
        width: 150px !important;
        height: 150px !important;
        max-width: unset !important;
        object-fit: cover !important;
    }
    </style>
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
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <img src="<?php (isset($profile) && !empty($profile) && $profile['profile_img']) ? print('uploads/'.$profile['profile_img']) : print('assets/img/dummy-propfile-pic.webp'); ?>"
                                alt="Profile" class="rounded-circle" />
                            <h2><?php print($name); ?></h2>
                            <h3><?php print($accType); ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#profile-overview">
                                        Overview
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">
                                        Edit Profile
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                                    <h5 class="card-title">Profile Details</h5>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 profile-label">First Name</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php (isset($profile) && !empty($profile) && $profile['fname']) ? print($profile['fname']) : print('NOT SET'); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 profile-label">Last Name</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php (isset($profile) && !empty($profile) && $profile['lname']) ? print($profile['lname']) : print('NOT SET'); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 profile-label">Phone Number</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php (isset($profile) && !empty($profile) && $profile['phone']) ? print($profile['phone']) : print('NOT SET'); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 profile-label">Address</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php (isset($profile) && !empty($profile) && $profile['addr']) ? print($profile['addr']) : print('NOT SET'); ?>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                    <!-- Profile Edit Form -->
                                    <form style="max-width:700px;margin:auto" method="post" id="form_upd_profile"
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="action" value="upd-profile">
                                        <div class="mb-2">
                                            <label class="form-label">Profile picture</label>
                                            <input name="profile_img" type="file" class="form-control"
                                                id="inp_profile_pic" octavalidate="R" maxsize="5mb"
                                                accept-mime="image/png, image/jpg, image/jpeg" />
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-6">
                                                <label class="form-label">First Name</label>
                                                <input octavalidate="R,ALPHA_ONLY" name="fname" type="text"
                                                    class="form-control" id="inp_fname"
                                                    value="<?php (isset($profile) && !empty($profile) && $profile['fname']) ? print($profile['fname']) : ''; ?>"
                                                    placeholder="Faith" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">Last Name</label>
                                                <input octavalidate="R,ALPHA_ONLY" name="lname" type="text"
                                                    class="form-control" id="inp_lname"
                                                    value="<?php (isset($profile) && !empty($profile) && $profile['lname']) ? print($profile['lname']) : ''; ?>"
                                                    placeholder="Okoro" />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label>Phone number</label>
                                            <input octavalidate="R,DIGITS" name="phone" minlength="11" type="text"
                                                class="form-control" id="inp_phone" placeholder="08000000000"
                                                value="<?php (isset($profile) && !empty($profile) && $profile['phone']) ? print($profile['phone']) : ''; ?>" />
                                        </div>
                                        <div class="mb-3">
                                            <label>Address</label>
                                            <textarea maxlength="50" id="inp_addr" class="form-control" octavalidate="R,TEXT"
                                                name="addr"><?php (isset($profile) && !empty($profile) && $profile['addr']) ? print($profile['addr']) : ''; ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>A little description of yourself</label>
                                            <textarea maxlength="50" id="inp_self_desc" class="form-control" octavalidate="R,TEXT" name="self_desc"><?php (isset($profile) && !empty($profile) && $profile['self_desc']) ? print($profile['self_desc']) : ''; ?></textarea>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary">
                                                Save Changes
                                            </button>
                                        </div>
                                    </form>

                                </div>
                                <!-- End Profile Edit Form -->
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include('includes/foot.php'); ?>
    <!-- End Footer -->

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const myForm = new octaValidate('form_upd_profile');

        $('#form_upd_profile').on('submit', function(e) {
            e.preventDefault();

            if (myForm.validate()) {
                e.currentTarget.submit()
            }
        })
    })
    <?php
    if (isset($success) && isset($msg)) {
    if ($success && !empty($msg)) {
    ?>
    toastr.success("<?php echo $msg; ?>")
    <?php
        } elseif (!$success && !empty($msg)) { ?>
    toastr.error("<?php echo $msg; ?>")
    <?php
        }
}
    ?>
    </script>
</body>

</html>