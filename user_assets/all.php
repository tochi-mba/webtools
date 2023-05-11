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
$full_path = "../scripts/" . $_SESSION['uid'] . "_assets_" . $row['scripts_id'] . "/" . $_GET['v'];

// If the requested path is a directory, add an index file to it
if (is_dir($full_path)) {
    $full_path .= '/index.html';
}

// Check if the requested file exists
if (!file_exists($full_path)) {
    // Return a 404 error if the file doesn't exist
    http_response_code(404);
    exit();
}

// Serve the file
header('Content-Type: ' . mime_content_type($full_path));
readfile($full_path);

?>
