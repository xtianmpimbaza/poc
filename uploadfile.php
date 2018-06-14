<?php
session_start();
//$_SESSION["user_id"] = "1aCr9dnyrNS6etJfyBroFaTV95j5hXsiaqVhzk";
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
    $latitude = '' . $_POST['lat'];
    $longitude = '' . $_POST['long'];

//    $newfilename = md5($file_basename) . $file_ext;

    $validextensions = array("jpeg", "jpg", "png");
    $temporary = explode(".", $filename);
    $file_extension = end($temporary);
    $owner = $_POST['owner'];
    $block = $_POST['block'];
//    $publisher = $_SESSION['user_id'];

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
            $metadata = str_replace(" ", "_", $title) . "_stream";

            if ($hash != '' && $hash != null) {
                $funs->createStream($metadata);


                $address = $funs->listAddresses();

                $custom_fields = array('file' => $hash, 'stream' => $metadata, 'owner' => $owner, 'block' => $block, 'user' => $_SESSION['user'], 'lat'=>$latitude, 'long'=>$longitude);


                $errors = $funs->getErrors();
                if ($errors != "" && $errors != null) {
                    echo $funs->getErrors();
                } else {
                    $funs->subscribe($metadata);
                    $funs->addAssets($address, $title, $custom_fields);

                    $err = $funs->getErrors();
                    if ($err != "" && $err != null) {
                        echo $funs->getErrors();
                    } else {
                        echo "Title saved successifully";
                    }
                }
            } else {
                echo "Error occured, file not saved";
            }
        }
    } else {
        echo "Invalid file Size or Type";
    }
} else {
    echo 'no file';
}

?>