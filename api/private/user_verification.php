<?php
$api_token = $data['api_token'];

// Query the database
$sql = "SELECT `uid` FROM `users` WHERE `api_token`='$api_token'";

// Execute the SQL query
$result = mysqli_query($conn, $sql);

// Store the uid from the query result in a variable
$row = mysqli_fetch_assoc($result);


// Check if the query result is empty
if(!$row) {
    // If the query result is empty, return an error
    echo json_encode([
        "success" => false,
        "message" => "Invalid API token"
    ]);
    exit;
}
?>