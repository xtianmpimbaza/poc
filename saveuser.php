<?php
session_start();
//$_SESSION["user_id"] = "1aCr9dnyrNS6etJfyBroFaTV95j5hXsiaqVhzk";
require_once 'functions.php';

$funs = new Functions();

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $status = "active";
//    $publisher = $_SESSION['user_id'];  //
    $stream = "users";
//    $user_address = $funs->getNewAddress();

    $custom_fields = array('username' => $username, 'password' => $password, 'status' => $status);
    $hex = $funs->strToHex(json_encode($custom_fields));
    $fb = $funs->publishFrom($stream, $username, $hex);

    $errors = $funs->getErrors();

    if ($errors != "" && $errors != null) {
        echo $funs->getErrors();
    }else{
        echo "User saved successifully";
    }

} else {
    echo 'Fill all required fields';
}

?>