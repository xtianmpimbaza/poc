<?php
require_once 'functions.php';

$funs = new Functions();

//$path = 'F:\landtitle.png';
//$image = $funs->hashImage($path);
//$image = $funs->createStreamFrom("1aCr9dnyrNS6etJfyBroFaTV95j5hXsiaqVhzk","users");
$image = $funs->hexToStr("516d5a477168376374656b6f677138694e356450454d4e37786f42586d7a7a73467571427039466773756e7a724d");
print_r($image);

print $funs->getErrors();
?>