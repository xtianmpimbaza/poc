<?php
require_once 'functions.php';

$funs = new Functions();

//$path = 'F:\landtitle.png';
//$image = $funs->hashImage($path);
$image = $funs->listAssets();
print_r($image);

print $funs->getErrors();
?>