<?php
// Get the request body as a JSON string
$requestBody = file_get_contents('php://input');

// Convert the JSON string to a PHP object
$data = json_decode($requestBody);
require "../../../connect.php";
require "../validate_input.php";
foreach (get_object_vars($data) as $key => $value) {
    if ($key != "auth_websites"){
        $data->$key = validateInput($value);
    }
}
require "../user_verification_js.php";

$uid = $data->uid;
$project_id = $data->project_id;
$cluster_id = $data->cluster_id;
$author_id = $data->author_uid;
$version = $data->version;
$cluster_name = $data->cluster_name;
$checked = $data->add;

$content = array(
    "project_id" => $project_id,
    "author_id" => $author_id,
    "version" => $version
);

$sql = "SELECT title FROM scripts WHERE script_id = '$project_id' AND uid = '$author_id';";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_array($result)) {
    $project_name = $row['title'];
} else {
    echo json_encode(array(
        "success" => false,
        "message" => "Could not find project"
    ));
    exit;
}

$sql = "SELECT content FROM clusters WHERE cluster_id = '$cluster_id' AND uid = '$uid';";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_array($result)) {
    $all_content = $row['content'];
} else {
    echo json_encode(array(
        "success" => false,
        "message" => "Could not find cluster"
    ));
    exit;
}

$all_content = json_decode($all_content, true);

if ($checked) {
    $all_content[] = $content;
} else {
    $all_content = array_values(array_filter($all_content, function($item) use ($project_id, $author_id, $version) {
        return !($item['project_id'] === $project_id && $item['author_id'] === $author_id && $item['version'] === $version);
    }));
    
}

$all_content = json_encode($all_content);

$sql = "UPDATE clusters SET content = '$all_content' WHERE cluster_id = '$cluster_id' AND uid = '$uid';";

if (mysqli_query($conn, $sql)) {
    $message = $checked ? "Added '$project_name - $version' to $cluster_name" : "Removed '$project_name - $version' from $cluster_name";
    echo json_encode(array(
        "success" => true,
        "message" => $message
    ));
} else {
    $action = $checked ? "adding" : "removing";
    echo json_encode(array(
        "success" => false,
        "message" => "Failed $action '$project_name - $version' to $cluster_name"
    ));
}