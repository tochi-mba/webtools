<?php
// get the text input
$text = isset($_GET['u']) ? $_GET['u'] : '';

// get the first letter and capitalize it
$letter = strtoupper(substr($text, 0, 1));

// set the image size
$size = 200;

// create a new image
$image = imagecreatetruecolor($size, $size);

// generate a random background color
$bgColor = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));

// fill the background with the random color
imagefill($image, 0, 0, $bgColor);

// set the font and text color
$font = 'arial.ttf';
$textColor = imagecolorallocate($image, 255, 255, 255);

// calculate the text position
$bbox = imagettfbbox(80, 0, $font, $letter);
$dx = abs($bbox[2] - $bbox[0]);
$dy = abs($bbox[5] - $bbox[3]);
$x = ($size - $dx) / 2;
$y = ($size + $dy) / 2;

// write the letter to the image
imagettftext($image, 80, 0, $x, $y, $textColor, $font, $letter);

// set the content type header to display the image
header('Content-Type: image/png');

// output the image
imagepng($image);

// clean up
imagedestroy($image);
?>
