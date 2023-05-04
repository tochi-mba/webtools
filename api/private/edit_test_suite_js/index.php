<?php
// Get the input data from the JSON request body
$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody);
$_POST = $data;
require "../../../connect.php";
require "../validate_input.php";
foreach (get_object_vars($_POST) as $key => $value) {
    $_POST->$key = validateInput($value);
}

$data = $_POST;
require "../user_verification_js.php";
$apiToken = $data->api_token;
$uid = $data->uid;
$securityCode = $data->scripts_id;
$scriptId= $data->script_id;
$code = $data->html;
$file = '../../../scripts/' . $uid . '_tests_' . $securityCode . '/' . $scriptId . '.html';
if (!file_exists($file)) {
    file_put_contents($file, '');
}

file_put_contents($file, html_entity_decode($code));

?>
