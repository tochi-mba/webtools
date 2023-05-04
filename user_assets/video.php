<?php
require "../head.php";
require "../connect.php";
if (isset($_SESSION['uid'], $_SESSION['api_token'])){
    $data = [
        "uid" => $_SESSION['uid'],
        "api_token" => $_SESSION['api_token']
    ];
    require "./user_verification.php";
}else{
    header("Location: ../login");
    exit;
}

// Get the requested video file name
$sql = "SELECT `scripts_id` FROM `users` WHERE `uid` = '".$_SESSION['uid']."' AND `api_token` = '".$_SESSION['api_token']."'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$filename = "../scripts/" . $_SESSION['uid'] . "_assets_" . $row['scripts_id'] . "/" . $_GET['v'];

// Get the file extension
$file_extension = pathinfo($filename, PATHINFO_EXTENSION);

// Open the video file
$fp = fopen($filename, 'rb');

// Get the file size
$filesize = filesize($filename);

// Get the start and end positions from the HTTP_RANGE header
if (isset($_SERVER['HTTP_RANGE'])) {
    $range = $_SERVER['HTTP_RANGE'];
    $range = str_replace('bytes=', '', $range);
    $range = explode('-', $range);
    $range_start = intval($range[0]);
    $range_end = ($range[1] == '') ? ($filesize - 1) : intval($range[1]);
} else {
    $range_start = 0;
    $range_end = $filesize - 1;
}

// Calculate the length of the content to be sent
$length = $range_end - $range_start + 1;

// Set the appropriate headers for a partial content response
header('HTTP/1.1 206 Partial Content');
switch($file_extension) {
    case 'mp4':
        header('Content-Type: video/mp4');
        break;
    case 'webm':
        header('Content-Type: video/webm');
        break;
    case 'ogg':
        header('Content-Type: video/ogg');
        break;
    case 'mov':
        header('Content-Type: video/quicktime');
        break;
    case 'avi':
        header('Content-Type: video/x-msvideo');
        break;
    case 'flv':
        header('Content-Type: video/x-flv');
        break;
    case 'wmv':
        header('Content-Type: video/x-ms-wmv');
        break;
    case 'mkv':
        header('Content-Type: video/x-matroska');
        break;
    case 'm4v':
        header('Content-Type: video/x-m4v');
        break;
    default:
        // If the file extension is not recognized, set the content type to application/octet-stream
        header('Content-Type: application/octet-stream');
        break;
}
header('Content-Length: ' . $length);
header('Content-Range: bytes ' . $range_start . '-' . $range_end . '/' . $filesize);

// Set the start position for reading the video file
fseek($fp, $range_start);

// Output the video data in chunks of 8192 bytes
$buffer_size = 8192;
while (!feof($fp) && ($length > 0)) {
    $bytes_to_read = min($buffer_size, $length);
    $data = fread($fp, $bytes_to_read);
    echo $data;
    flush();
    $length -= strlen($data);
}

// Close the file pointer
fclose($fp);

?>
