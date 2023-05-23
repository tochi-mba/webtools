<?php
// Get the request body as a JSON string
$requestBody = file_get_contents('php://input');

// Convert the JSON string to a PHP object
$data = json_decode($requestBody);
require "../../../connect.php";
require "../validate_input.php";
foreach (get_object_vars($data) as $key => $value) {
    $data->$key = validateInput($value);
}
require "../user_verification_js.php";

$uid = $data->uid;