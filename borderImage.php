<?php

//http://webtoolsv2/borderImage.php?unlisted=true&public=true&private=true&monetized=false
// Get the query parameters
$unlisted = isset($_GET['unlisted']) && $_GET['unlisted'] === 'true';
$public = isset($_GET['public']) && $_GET['public'] === 'true';
$private = isset($_GET['private']) && $_GET['private'] === 'true';
$monetized = isset($_GET['monetized']) && $_GET['monetized'] === 'true';

// Create an image with the desired dimensions (100x100 pixels)
$image = imagecreatetruecolor(100, 100);

// Assign colors for each border segment
$unlistedColor = imagecolorallocate($image, 192, 192, 192); // Grey
$publicColor = imagecolorallocate($image, 0, 128, 0); // Green
$privateColor = imagecolorallocate($image, 255, 0, 0); // Red
$monetizedColor = imagecolorallocate($image, 255, 215, 0); // Gold

// Draw the border segments
if ($unlisted) {
    imagefilledrectangle($image, 91, 0, 99, 99, $unlistedColor);
}

if ($public) {
    imagefilledrectangle($image, 0, 0, 9, 99, $publicColor);
}

if ($private) {
    imagefilledrectangle($image, 0, 0, 99, 9, $privateColor);
}

// Draw the inner area (transparent or gold)
$innerColor = $monetized ? $monetizedColor : imagecolorallocatealpha($image, 0, 0, 0, 127);
imagefilledrectangle($image, 10, 10, 89, 89, $innerColor);

// Set the content type header and output the image
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>
