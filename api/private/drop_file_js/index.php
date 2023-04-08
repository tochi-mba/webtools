<?php

if (!isset($_FILES['file'])) {
    echo json_encode(array(
        "success" => false,
        "message" => "File data not found"
    ));
    exit;
}

require "../../../connect.php";
$data = $_POST;
$data = json_decode(json_encode($data));

require "../user_verification_js.php";
$data = get_object_vars($data);

$api_token = $data['api_token']; // add this line to fix the first error

$file = $_FILES['file'];
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$uid = $data['uid'];
$script_id = $data['script_id'];
$version = $data['version'];
$sql = "SELECT `active_files` FROM `scripts` WHERE `uid`='$uid' AND `script_id`='".$data['script_id']."'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$active_files = json_decode($row['active_files'], true);

if ($extension == 'js') {
    $new_extension = 'js';
    $active_files['code'] = "active";
} elseif ($extension == 'css') {
    $new_extension = 'css';
    $active_files['codeCss'] = "active";
} elseif ($extension == 'txt') {
    $new_extension = 'txt';
}else{
    echo json_encode(array(
        "success" => false,
        "message" => "Invalid file type"
    ));
    exit;
}

$sql = "UPDATE `scripts` SET `active_files`='".json_encode($active_files)."' WHERE `uid`='$uid' AND `script_id`='".$data['script_id']."'";
$result = mysqli_query($conn, $sql);

$filename = $script_id . '.' . $new_extension;
$directory = "../../../scripts/".$uid . '_private/'. $script_id . "/" . $version . '/';
if (!file_exists($directory)) {
    mkdir($directory, 0777, true);
}

$file_path = $directory . $filename;
if (file_exists($file_path)) {
    unlink($file_path);
}

if (move_uploaded_file($file['tmp_name'], $file_path)) {
    echo json_encode(array(
        "success" => true,
        "message" => "File uploaded successfully",
        "data" => file_get_contents($file_path),
        "type" => $new_extension
    ));
} else {
    echo json_encode(array(
        "success" => false,
        "message" => "Error uploading file"
    ));
} // add a closing quote and semicolon to fix the syntax error on line 33
?>