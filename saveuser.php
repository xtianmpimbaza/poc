<?php
session_start();
//$_SESSION["user_id"] = "1aCr9dnyrNS6etJfyBroFaTV95j5hXsiaqVhzk";
require_once 'functions.php';

$funs = new Functions();

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $status = "active";
    $publisher = $_SESSION['user_id'];
    $stream = "users";
    $user_address = $funs->getNewAddress();

    $custom_fields = array('username' => $username, 'password' => $password, 'status' => $status, 'user_address' => $user_address);
    $hex = $funs->strToHex(json_encode($custom_fields));
    $fb = $funs->publishFrom($publisher, $stream, $username, $hex);

    $errors = $funs->getErrors();

    if ($errors != "" && $errors != null) {
        echo $funs->getErrors();
    }else{
        echo "User saved successifully";
    }
//    if ($fb != "" && $fb != null) {
//        echo "User saved successifully";
//    }else{
//        print_r($funs->getErrors());
//    }

} else {
    echo 'Fill all required fields';
}

?>