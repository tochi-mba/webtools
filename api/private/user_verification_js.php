<?php
require "../../../head.php";
$api_token = $_SESSION["api_token"];
if (!$api_token) {
echo json_encode([
"success" => false,
"message" => "Must be from ".$website
]);
exit;
}

// Query the database
$sql = "SELECT uid FROM users WHERE api_token='$api_token' AND uid='$data->uid'";

// Execute the SQL query
$result = mysqli_query($conn, $sql);

// Store the uid from the query result in a variable
$row = mysqli_fetch_assoc($result);

// Check if the query result is empty
if (!$row) {
// If the query result is empty, return an error
echo json_encode([
"success" => false,
"message" => "Invalid API token"
]);
exit;
}
?>