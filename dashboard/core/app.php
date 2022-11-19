<?php
session_start();

//authenticate users
require('auth.php');

//load database file
require('../core/db.php');

$db = new DatabaseClass();

//query user data
$user = $db->selectOne(
    "SELECT * FROM users WHERE users.user_id = :id",
    ['id' => $_SESSION['auth']['token']]
);
$profile = $db->selectOne(
    "SELECT * FROM profile WHERE profile.user_id = :id",
    ['id' => $_SESSION['auth']['token']]
);

$name = '';
$email = $user['email'];
$accType = $user['acc_type'];
//add to code snap including the use of || operator
if(!empty($profile) && $profile['fname'] && $profile['lname']){
    $name = $profile['lname'] . ' ' . $profile['fname'];
}else{
    $name = substr($user['email'], 0, strpos($user['email'], '@', 0));
}
//capitalize first char
$name = ucfirst($name);
$accType = ucfirst($accType);
?>