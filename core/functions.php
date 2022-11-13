<?php
function doError(int $status = 400, $error)
{
    //Easily print out errors to the user
    $retval = array(
        "success" => false,
        "message" => $error
    );
    http_response_code($status);
    return (print_r(json_encode($retval)) . exit());
}
?>