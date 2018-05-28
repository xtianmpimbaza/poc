<?php

function CroppedThumbnail($imgSrc,$thumbnail_width,$thumbnail_height) { //$imgSrc is a FILE - Returns an image resource.

    //getting the image dimensions 
    list($width_orig, $height_orig) = getimagesize($imgSrc);  
    $myImage = imagecreatefromjpeg($imgSrc);
    $ratio_orig = $width_orig/$height_orig;
   
    if ($thumbnail_width/$thumbnail_height > $ratio_orig) {
       $new_height = $thumbnail_width/$ratio_orig;
       $new_width = $thumbnail_width;
    } else {
       $new_width = $thumbnail_height*$ratio_orig;
       $new_height = $thumbnail_height;
    }
   
    $x_mid = $new_width/2;  //horizontal middle
    $y_mid = $new_height/2; //vertical middle
   
    $process = imagecreatetruecolor(round($new_width), round($new_height));
   
    imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
    $thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
    imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($thumbnail_width/2)), ($y_mid-($thumbnail_height/2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);
	
	imagejpeg($process, $myImage, 80);

    imagedestroy($process);
    imagedestroy($myImage);
    return $thumb;
	
}

if (isset($_GET['src'])) {

	// parameters
	$image_path = $_GET['src'];
	$width = (isset($_GET['width'])) ? $_GET['width'] : 80;
	$height = (isset($_GET['height'])) ? $_GET['height'] : 80;
	
	// generate thumbnail
	$newThumb = CroppedThumbnail("$image_path", $width, $height);
	
	// display image
	header('Content-type: image/jpeg');
	imagejpeg($newThumb);

} else {
	echo "Parameters not found.";
}

?>