<?php
    session_start();
    require('../core/db.php');
    $db = new DatabaseClass();
    
    $id = (isset($_GET) && isset($_GET['id']) && !empty($_GET['id'])) ? intval($_GET['id']) : 0;

    $user_id = $_SESSION['auth']['token'];

    if(!$id || !$user_id) {
        header("Location: ./all-spaces");
        exit();
    }
    
    $db->Update("UPDATE spaces SET is_booked = :book, booked_user = :user WHERE id = :id",[
        'id' => $id,
        'user' => $user_id,
        'book' => 'yes'
    ]);
    $_SESSION['success'] = true;
    $_SESSION['msg'] = "Space has been booked successfully";

    header("Location: ./all-spaces");
    exit();
?>