<?php
//check if session exists
if (!isset($_SESSION['auth']) || empty($_SESSION['auth'])) {
    header("Location: ../login");
    exit();
}
?>