<?php
require_once 'functions.php';

$funs = new Functions();

//$path = 'F:\landtitle.png';
//$image = $funs->hashImage($path);
//$image = $funs->createStreamFrom("1aCr9dnyrNS6etJfyBroFaTV95j5hXsiaqVhzk","users");
$image = $funs->liststreams();
print_r($image);

print $funs->getErrors();
?>