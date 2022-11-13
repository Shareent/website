<?php
//import database class
require '../db.php';
//import functions
require '../functions.php';

//instantiate class
$db = new DatabaseClass();

//Check if it is a post request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {

        //check if email is registered already
        $users = $db->SelectAll("SELECT * FROM users WHERE email = :email", ['email' => $_POST['email']]);

        if (count($users))
            doError(400, "A user with this Email exists already");

        //hash password
        $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $uid = md5(time().$_POST['email']);
        //save to database
        $insert = $db->Insert("INSERT INTO users (user_id, acc_type, email, hash, date_joined) VALUES (:uid, :type, :email, :hash, :date)", ['uid' => $uid, 'type' => $_POST['acc_type'], 'email' => $_POST['email'], 'hash' => $pass, 'date' => strtotime(time())]);

        //return success
        http_response_code(200);
        $retval = array(
            "success" => true,
            "message" => "Registration successful"
        );
        print_r(json_encode($retval));

    } catch (Exception $e) {
        http_response_code(400);
        //return errors  
        $retval = array(
            "success" => false,
            "message" => $e->getMessage()
        );
        print_r(json_encode($retval));
    }
}

?>