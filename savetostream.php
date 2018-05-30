<?php
session_start();
$_SESSION["user_id"] = "1aCr9dnyrNS6etJfyBroFaTV95j5hXsiaqVhzk";
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
    $filesize = $_FILES["file"]["size"];
    $title = '' . $_POST['titlename'];

//    $newfilename = md5($file_basename) . $file_ext;

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
//                $funs->createStreamFrom($_SESSION['user_id'],str_replace(" ","_",$title)."_stream");

                $fb = $funs->publishFrom("k_stream",$title,$hash);
//                $address = $funs->listPermissions();
//                $funs->addAssets($address, $title, $hash);
                print_r($funs->getErrors());
//                echo $fb;
//                echo "saved";
//                    echo $funs->getErrors();
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