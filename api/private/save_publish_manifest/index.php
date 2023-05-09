<?php

//params: api_token, uid, script_id
// Get the input data from the JSON request body
$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody);
$_POST = $data;
require "../../../connect.php";

$data = $_POST;
require "../user_verification_js.php";

// Extract the input parameters
$apiToken = $data->api_token;
$uid = $data->uid;
$scriptId = $data->script_id;
$publishManifest = str_replace("'", "\\'", $data->publish_manifest);

$sql = "UPDATE `scripts` SET `publish_manifest` = '$publishManifest' WHERE `uid` = '$uid' AND `script_id` = '$scriptId'";
$result = mysqli_query($conn, $sql);
if ($result) {
        echo json_encode([
                "success" => true,
                "message" => "Publish manifest saved."
        ]);
} else {
        echo json_encode([
                "success" => false,
                "message" => "Error saving publish manifest."
        ]);
}

?>