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

header("Content-Type: $content_type");
readfile($filename);
?>
