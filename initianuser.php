<?php
session_start();
require_once 'functions.php';

$funs = new Functions();

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $status = "active";
//    $publisher = $_SESSION['user_id'];
    $stream = "users";
//    $gen_admin = $funs->getInitialAdmin();
//    $user_address = $funs->getNewAddress();
//    $funs->grantFrom($gen_admin,$user_address,"admin,activate,create,issue,receive,send,connect,mine");

    $custom_fields = array('username' => $username, 'password' => $password, 'status' => $status);
    $hex = $funs->strToHex(json_encode($custom_fields));

//    echo $gen_admin;
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