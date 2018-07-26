<?php
session_start();
require_once 'functions.php';
require 'ipfs/IPFS.php';

use Cloutier\PhpIpfsApi\IPFS;

$funs = new Functions();


// connect to ipfs daemon API server
$ipfs = new IPFS("localhost", "8080", "5001");

if (isset($_FILES["file"]["type"]) && isset($_POST['titlename'])) {

    $filename = $_FILES["file"]["name"];
    $file_basename = substr($filename, 0, strripos($filename, '.')); // get file name
    $file_ext = substr($filename, strripos($filename, '.')); // get file extention
//    $filesize = $_FILES["file"]["size"];
    $title = $_POST['titlename'];
    $reason = $_POST['reason'];
    $owner = $_POST['owner'];
    $issid = $_POST['asset'];
    $identifier = rand();
//    $publisher = $_SESSION['user_id'];

    $validextensions = array("jpeg", "jpg", "png");
    $temporary = explode(".", $filename);
    $file_extension = end($temporary);

    if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
        ) && in_array($file_extension, $validextensions)) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
        } else {
            $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable

            $image = $_FILES['file']['tmp_name'];
            $fo = fopen($_FILES['file']['tmp_name'], "r");
            $imageContent = fread($fo, filesize($image));
            $hash = $ipfs->add($imageContent);

            if ($hash != '' && $hash != null) {

                $custom_fields = array('reason' => $reason, 'owner' => $owner, 'file' => $hash, 'user' => $_SESSION['user'], 'id'=>$identifier);
                $hex = $funs->strToHex(json_encode($custom_fields));

//                print_r($hex);
                $str = $funs->listAssetsById($issid)[0]['details']['stream'];
                $fb = $funs->publishFrom($str, $title, $hex);

                $errors = $funs->getErrors();

                if ($errors != "" && $errors != null) {
                    echo $funs->getErrors();
                }else{
                    echo "saved";
                }

            } else {
                echo "error occured, file not saved";
            }
        }
    } else {
        echo "Invalid file Type";
    }
} else {
    echo 'no file';
}

?>