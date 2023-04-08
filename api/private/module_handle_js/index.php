<?php
// Get the input data from the JSON request body
$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody);
$_POST = $data;
require "../../../connect.php";
require "../validate_input.php";
foreach (get_object_vars($_POST) as $key => $value) {
    if ($key !== "jsCode") {
        $_POST->$key = validateInput($value);
    }
}

$data = $_POST;
require "../user_verification_js.php";
// Extract the input parameters
$apiToken = $data->api_token;
$uid = $data->uid;
$scriptId = $data->script_id;
$moduleOpen = $data->moduleOpen;
$jsCode = isset($data->jsCode) ? $data->jsCode : null;

// Define the file path and name
$filePath = "../../../scripts/{$uid}_private";
$fileName = "{$uid}_module.js";

// Create the file if moduleOpen is true and jsCode is provided
if ($moduleOpen && $jsCode !== null) {
  // Write the JavaScript code to the file
  file_put_contents("{$filePath}/{$fileName}", $jsCode);
  
  // Return a success response with a message
  $response = new stdClass();
  $response->success = true;
  $response->message = "Script '{$scriptId}' saved to '{$fileName}'.";
} else {
  // Delete the file if it exists
  if (file_exists("{$filePath}/{$fileName}")) {
    unlink("{$filePath}/{$fileName}");
  }
  
  // Return a success response with a message
  $response = new stdClass();
  $response->success = true;
  $response->message = "Script '{$scriptId}' deleted from '{$fileName}'.";
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
