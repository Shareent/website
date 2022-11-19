<?php
require('./core/app.php');
//check if user is an agent or a buyer //only agents are allowed
if ($user['acc_type'] !== "agent") {
    header("Location: ./");
    exit();
}
//IF USER HAS UPDATED HIS PROFILE
if ($profile && $user['acc_type'] == "agent") {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $db->Insert("INSERT INTO spaces (user_id, space_name, space_addr, space_type, space_desc, space_price,date_added) VALUES (:uid, :name, :addr, :type, :desc, :price, :date)", [
            'uid' => $user['user_id'],
            'name' => $_POST['space_name'],
            'type' => $_POST['space_type'],
            'desc' => $_POST['space_desc'],
            'price' => $_POST['space_price'],
            'addr' => $_POST['space_addr'],
            'date' => time()
        ]);


        $_SESSION['msg'] = "Space Added Successfully";
        $_SESSION['success'] = true;
        header('Location: ./add-space');
        exit();
    }
} else {
    $_SESSION['msg'] = "Please update your profile";
    $_SESSION['success'] = false;
    header('Location: ./users-profile');
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Add Space</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <?php include('includes/head.php'); ?>
</head>

<body>
    <main>
        <div class="container">
            <div class="text-center">
                <img src="assets/img/sharent.png" alt="sharent logo" width="50px" />
                <h4>Sharent</h4>
            </div>
            <section class="p-4 m-auto" style="max-width:500px;background-color:#fff;border-radius:20px">
                <div class="row mb-2">
                    <div class="col-6"></div>
                    <div class="col-6 text-end">
                        <a href="./" class="btn btn-primary">Visit the dashboard</a>
                    </div>
                </div>
                <form class="row g-3" method="post" id="form_add_space" novalidate>
                    <div class="mb-2">
                        <label for="address" class="form-label">Name of Space</label>
                        <input id="inp_s_name" octavalidate="R,ALPHA_SPACES" name="space_name" type="text"
                            class="form-control" />
                    </div>
                    <div class="mb-2">
                        <label for="yourEmail" class="form-label">Type of space</label>
                        <select id="inp_s_type" octavalidate="R,ALPHA_SPACES" name="space_type" class="form-select"
                            aria-label="Default select example">
                            <option selected value="">Select space type</option>
                            <option value="Office Space">Office Space</option>
                            <option value="house">House</option>
                            <option value="land">Land</option>
                            <option value="Work Spaces">Work spaces</option>
                        </select>
                    </div>
                    <label for="amount" class="form-label">Set your price</label>
                    <div class="input-group mb-2 mt-0">
                        <span class="input-group-text" id="naira">&#8358;</span>
                        <input name="space_price" id="inp_s_price" octavalidate="R,DIGITS" value="111" type="text"
                            class="form-control" aria-label="Amount (to the nearest naira)" aria-describedby="naira" />
                    </div>
                    <div class="mb-2">
                        <label for="address" class="form-label">Address of space</label>
                        <textarea id="inp_s_addr" octavalidate="R,TEXT" name="space_addr"
                            class="form-control"></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="yourName" class="form-label">Description of space</label>
                        <textarea name="space_desc" id="inp_s_desc" octavalidate="R,TEXT" class="form-control"
                            style="height: 100px"></textarea>
                    </div>
                    <div class="mb-2">
                        <div class="form-check">
                            <input ov-required:msg="You must accept the terms and conditions" octavalidate="R"
                                class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms"
                                required />
                            <label class="form-check-label" for="acceptTerms">I agree and accept the
                                <a href="#">terms and conditions</a></label>
                        </div>
                    </div>
                    <div class="mb-2">
                        <button class="btn btn-primary w-100" type="submit">
                            Upload Space
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </main>
    <!-- End #main -->

    <?php include('includes/foot.php'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            /*
            $('#inp_s_price').on('change', function(){
                if(this.value.charAt(0) !== "₦"){
                    const v = this.value.split('');
                    v.splice(0, 0, '₦');
                    this.value = v.join('')
                }
            })
            */

            const myForm = new octaValidate('form_add_space', { strictMode: true });
            //myForm.customRule('PRICE', /^₦+[0-9]+$/, 'Please enter a valid price');
            $('#form_add_space').on('submit', function (e) {
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