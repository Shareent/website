<?php
require('./core/app.php');
//check if user is an agent or a buyer //only agents are allowed
if($user['acc_type'] !== "agent"){
    header("Location: ./");
    exit();
}

$spaces = '';

if($profile && $user['acc_type'] == "agent"){
    $spaces = $db->SelectAll("SELECT * FROM spaces WHERE spaces.user_id = :uid", ['uid' => $user['user_id']]);
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['action']) && !empty($_POST['action']) 
    && isset($_POST['space_id']) && !empty($_POST['space_id'])){
        $action = $_POST['action'];
        //check if space belongs to agent
        $checkSpace = $db->SelectOne("SELECT * FROM spaces WHERE spaces.user_id = :uid AND spaces.id = :id", ['uid' => $user['user_id'], 'id' => $_POST['space_id']]);
        //delete space
        if($action == 'del-space' && $checkSpace){
            //if the space is for the user
                $db->Remove("DELETE FROM spaces WHERE spaces.id = :id AND spaces.user_id = :uid", ['uid' => $user['user_id'], 'id' => $checkSpace['id']]);
                $spaceImg = "uploads/".$checkSpace['space_img'];
                //if space has an img file
                if($spaceImg){
                    //if file exists
                    if(file_exists($spaceImg)){
                        //delete the file
                        unlink($spaceImg);
                    }
                }
                $_SESSION['msg'] = "Space has been deleted successfully";
                $_SESSION['success'] = true;
                header("Location: ./my-spaces");
                exit();
        }
        //verify space
        if($action == 'verify-space' && $checkSpace){
            //if the space is for the user
                $db->Update("UPDATE spaces SET space_cac = :cac, is_verified = :ver WHERE id = :id  AND user_id = :uid", ['uid' => $user['user_id'], 'cac' => $_POST['space_cac'], 'id' => $checkSpace['id'], 'ver' => 'yes']);
                $_SESSION['msg'] = "Space has been verified successfully";
                $_SESSION['success'] = true;
                header("Location: ./my-spaces");
                exit();
        }
    }
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
        .should-break{
            word-break: break-all;
        }
    </style>
</head>

<body>
    <main>
        <div class="container">
            <section class="section register min-vh-100 justify-content-center py-4">
                <div class="container">
                    <div class="text-center mb-3">
                        <img src="assets/img/sharent.png" alt="sharent logo" width="50px" />
                        <h4>Sharent</h4>
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
                                <img src="./uploads/<?php print($space['space_img']); ?>" class="card-img" alt="my_space_img" style="width: 100%;height: 300px;">
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
                                        <?php print($space['space_price']); ?>
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
                            <form method="post" class="me-2 d-inline"
                                onsubmit="return confirm('Are you sure that you want to delete this space?')">
                                <input type="hidden" name="action" value="del-space" />
                                <input type="hidden" name="space_id" value="<?php print($space['id']); ?>" />
                                <button type="submit" class="btn btn-outline-danger">
                                    Delete Space
                                </button>
                            </form>
                            <?php if($space['is_verified'] !== 'yes') : ?>
                            <button data-space-id="<?php print($space['id']); ?>" type="button" class="btn-verify-space btn btn-success"
                                data-bs-toggle="modal" data-bs-target="#verifyModal">
                                Verify Space
                            </button>
                            <?php else : ?>
                                <button type="button" class="btn btn-success" disabled>
                                Verified <i class="fas fa-check"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php
                        }
                    ?>
                    <!-- Modal  -->
                    <div class="modal fade" id="verifyModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-center">Verify Space</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-info">
                                        <p class="m-0">If your space fails the verification process, it will
                                            automatically be deleted from our server</p>
                                    </div>
                                    <form
                                        onsubmit="return confirm ('Are you sure that you want to use this data to verify this space? You can\'t update your CAC Registration number after submission')"
                                        class="row g-3" id="form_verify_space" method="post">
                                        <div class="">
                                            <input type="hidden" name="space_id" value="" id="inp_space_id">
                                            <input type="hidden" name="action" value="verify-space" />
                                            <label class="form-label">CAC Registration
                                                Number</label>
                                            <input octavalidate="R" name="space_cac" type="text" class="form-control"
                                                id="inp_cac" />
                                        </div>
                                    </form>
                                    <!-- Vertical Form -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button form="form_verify_space" type="submit" class="btn btn-primary">
                                        Verify Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Extra Large Modal-->
                    <?php else: ?>
                        <div class="alert alert-info text-center p-2">
                            <p class="m-0" style="font-size:2.3rem"><span class="bi bi-info-circle"></span></p>
                            <p class="m-0">No spaces found. <a href="./add-space"><br>Would you like to add one?</a> </p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </main>
    <!-- End #main -->
    <?php include('includes/foot.php'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-verify-space')?.forEach(el => {
                el.addEventListener('click', function () {
                    if (Number(this.getAttribute('data-space-id'))) {
                        $('#inp_space_id').val(el.getAttribute('data-space-id'))
                    }
                })
            })
        })

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
</body>

</html>