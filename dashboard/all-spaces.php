<?php
require('./core/app.php');
//check if user is an agent or a buyer //only buyers are allowed
if($user['acc_type'] !== "buyer"){
    header("Location: ./");
    exit();
}

$spaces = '';

//get the user's booked spaces
$booked_spaces = $db->SelectOne("SELECT * FROM spaces WHERE spaces.is_verified = :ver AND spaces.is_booked = :book AND spaces.booked_user = :user", ['ver' => 'yes', 'book' => 'yes', 'user' => $_SESSION['auth']['token']]);

if($profile && $user['acc_type'] == "buyer"){
    $spaces = $db->SelectAll("SELECT * FROM spaces WHERE spaces.is_verified = :ver AND spaces.is_booked = :book", ['ver' => 'yes', 'book' => 'no']);
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

//block, yes, no, failed lol \t is for tab character or the icon
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>My spaces</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <?php include('includes/head.php'); ?>
    <style>
    .should-break {
        word-break: break-all;
    }
    </style>
</head>

<body>
    <main>
        <div class="container">
            <?php if(!$booked_spaces): ?>
            <section class="section register min-vh-100 justify-content-center py-4">
                <div class="container">
                    <div class="text-center mb-3">
                        <img src="assets/img/sharent.png" alt="sharent logo" width="50px" />
                        <h4>Sharent</h4>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"></div>
                        <div class="col-6 text-end">
                            <a href="./" class="btn btn-primary">Visit the dashboard</a>
                        </div>
                    </div>
                    <?php if(count($spaces)): ?>
                    <?php
                        foreach($spaces as $i => $space){
                            $childKey = rand(0, 9999);
                            ?>

                    <div class="card mb-3" width="100%" id="<?php print('space -'.$childKey); ?>">
                        <div class="pb-2 card-title text-center">
                            <h6 class="title display-6">
                                <?php print($space['space_name']); ?>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <img src="./uploads/<?php print($space['space_img']); ?>" class="card-img"
                                    alt="my_space_img" style="width: 100%;height: 300px;object-fit: cover;">
                            </div>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="w-50">Type</th>
                                        <td class="w-50 should-break">
                                            <?php print($space['space_type']); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-50">Price</th>
                                        <td class="w-50 should-break">
                                            &#8358;<?php print($space['space_price']); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-50">Description</th>
                                        <td class="w-50 should-break">
                                            <?php print($space['space_desc']); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-50">Address</th>
                                        <td class="w-50 should-break">
                                            <?php print($space['space_addr']); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-50">Date Added</th>
                                        <td class="w-50 should-break">
                                            <?php print(date('D M Y', $space['date_added'])); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-end">
                                <button type="button" class="btn btn-info" onclick="payNow(<?php print($space['id']); ?>, <?php print($space['space_price']); ?>)">
                                    Book Space
                                </button>
                        </div>
                    </div>

                    <?php
                        }
                    ?>
                    <?php else: ?>
                    <div class="alert alert-info text-center p-2">
                        <p class="m-0" style="font-size:2.3rem"><span class="bi bi-info-circle"></span></p>
                        <p class="m-0">No spaces found</p>
                    </div>
                    <?php endif; ?>
                </div>
            </section>
            <?php else: ?>
                <div class="alert alert-danger text-center p-3" style="margin:10% auto">
                    <i class="bi bi-info" style="font-size:2rem"></i>
                    <p class="m-0">You have booked a space already!</p>
                    <a href="./" class="mt-2 btn btn-danger">Go back to dashboard</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <!-- End #main -->
    <?php include('includes/foot.php'); ?>
    <script>

    <?php
    if (isset($success) && isset($msg)) {
                if ($success && !empty($msg)) {
    ?>
    toastr.success("<?php echo $msg; ?>")
    <?php
        } elseif(!$success && !empty($msg)) { ?>
    toastr.error("<?php echo $msg; ?>")
    <?php
        }
            }
    ?>
    </script>
    <script src="https://js.paystack.co/v2/inline.js"></script>
    <script>
    function payNow(spaceId, price) {
        const paystack = new PaystackPop();

        paystack.newTransaction({

            key: 'pk_test_1c414d35d648274c22192be0ddf05b4fa78a8c1f',

            email: 'example@email.com',

            amount: Number(price)*100,

            onSuccess: (transaction) => {

                // Payment complete! Reference: transaction.reference 
                toastr.success("Payment successful");

                setTimeout( () => {
                    window.location.assign(`./book-space?id=${spaceId}`)
                }, 2000)
            },

            onCancel: () => {
                // user closed popup
                toastr.info("Payment was not completed");
            }

        });
    }
    </script>
</body>

</html>