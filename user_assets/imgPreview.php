<?php
require "../head.php";
require "../connect.php";

if (isset($_SESSION['uid'], $_SESSION['api_token'])){
    $data = [
        "uid" => $_SESSION['uid'],
        "api_token" => $_SESSION['api_token']
    ];
    require "./user_verification.php";
} else {
    header("Location: ../login");
    exit;
}

// Get the requested image file name
$sql = "SELECT `scripts_id` FROM `users` WHERE `uid` = '".$_SESSION['uid']."' AND `api_token` = '".$_SESSION['api_token']."'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$filename = "../scripts/" . $_SESSION['uid'] . "_assets_" . $row['scripts_id'] . "/" . $_GET['v'];

// Set the content type based on the file extension
$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
switch ($extension) {
    case 'jpg':
    case 'jpeg':
        $content_type = 'image/jpeg';
        break;
    case 'png':
        $content_type = 'image/png';
        break;
    case 'gif':
        $content_type = 'image/gif';
        break;
    case 'bmp':
        $content_type = 'image/bmp';
        break;
    case 'tiff':
    case 'tif':
        $content_type = 'image/tiff';
        break;
    case 'webp':
        $content_type = 'image/webp';
        break;
    case 'ico':
        $content_type = 'image/x-icon';
        break;
    case 'svg':
        $content_type = 'image/svg+xml';
        break;
    default:
        // If the extension is unknown, return a 404 error
        http_response_code(404);
        exit;
}

// Get the image size
$image_size = getimagesize($filename);

// Resize the image if it is bigger than 100px
if ($extension == 'svg' || $extension == 'gif') {
    // If the image is an SVG, just output the file
    header("Content-Type: $content_type");
    readfile($filename);
}else if ($image_size[0] > 100) {
    // Calculate the new height
    $new_height = ($image_size[1] / $image_size[0]) * 100;

    // Create a new image
    $new_image = imagecreatetruecolor(100, $new_height);

    // Load the original image
    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            $original_image = imagecreatefromjpeg($filename);
            break;
        case 'png':
            $original_image = imagecreatefrompng($filename);
            break;
        case 'gif':
            $original_image = imagecreatefromgif($filename);
            break;
        case 'bmp':
            $original_image = imagecreatefrombmp($filename);
            break;
        case 'tiff':
        case 'tif':
            $original_image = imagecreatefromtiff($filename);
            break;
        case 'webp':
            $original_image = imagecreatefromwebp($filename);
            break;
        case 'ico':
            $original_image = imagecreatefromxbm($filename);
            break;
        case 'svg':
            $original_image = imagecreatefromsvg($filename);
            break;
    }

    // Copy the original image to the new image
    imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, 100, $new_height, $image_size[0], $image_size[1]);

    // Output the new image
    header("Content-Type: $content_type");
    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            imagejpeg($new_image);
            break;
        case 'png':
            imagepng($new_image);
            break;
        case 'gif':
            imagegif($new_image);
            break;
        case 'bmp':
            imagebmp($new_image);
            break;
        case 'tiff':
        case 'tif':
            imagetiff($new_image);
            break;
        case 'webp':
            imagewebp($new_image);
            break;
        case 'ico':
            imagexbm($new_image);
            break;
        case 'svg':
            imagesvg($new_image);
            break;
    }
} else {
    // Output the original image
    header("Content-Type: $content_type");
    readfile($filename);
}
?>