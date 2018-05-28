<?php
require_once 'functions.php';
$funs = new Functions();

if (isset($_FILES["file"]["type"]) && isset($_POST['titlename'])) {

    $filename = $_FILES["file"]["name"];
    $file_basename = substr($filename, 0, strripos($filename, '.')); // get file name
    $file_ext = substr($filename, strripos($filename, '.')); // get file extention
    $filesize = $_FILES["file"]["size"];
    $title = ''.$_POST['titlename'];

    $newfilename = md5($file_basename) . $file_ext;

    $validextensions = array("jpeg", "jpg", "png");
    $temporary = explode(".", $filename);
    $file_extension = end($temporary);

    if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
        ) && ($_FILES["file"]["size"] < 200000)//Approx. 200kb files can be uploaded.
        && in_array($file_extension, $validextensions)) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
        } else {
            if (file_exists("uploads/" . $newfilename)) {
                echo $filename . " <span id='invalid'><b>file already exists.</b></span> ";
            } else {
                $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
                $targetPath = "uploads/" . $newfilename; // Target path where file is to be stored
                if (move_uploaded_file($sourcePath, $targetPath)){

                    //add to assets

                    $address = $funs->listPermissions();
                    $funs->addAssets($address, $title, $newfilename);
                    echo "Saved successifully";
//                    echo $funs->getErrors();
                } else{
                    echo "An error occured";
                }
            }
        }
    } else {
        echo "Invalid file Size or Type";
    }
}else{echo 'no file';}

?>