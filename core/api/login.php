<?php
session_start();
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
        $user = $db->SelectOne("SELECT * FROM users WHERE email = :email", ['email' => $_POST['email']]);

        if (!$user)
            doError(401, "Email Address does not exist");

        //compare password
        if (password_verify($_POST['password'], $user['hash']) === false)
            doError(401, "You have entered an Invalid Password");

        //return success
        http_response_code(200);
        $retval = array(
            "token" => $user['user_id'],
            "type" => $user['acc_type'],
            "success" => true,
            "message" => "Login successful"
        );
        //set session
        $_SESSION['auth'] = array(
            "token" => $user['user_id'],
            "type" => $user['acc_type']
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