<?php
// Get the request body as a JSON string
$requestBody = file_get_contents('php://input');

// Convert the JSON string to a PHP object
$data = json_decode($requestBody);

// Include necessary files
require "../../../connect.php";
require "../validate_input.php";
require "../user_verification_js.php";

// Validate and sanitize input data
$uid = validateInput($data->uid);
$mode = validateInput($data->mode);
$amount = validateInput($data->amount);

// Initialize the response array
$response = array();

// Check if the mode is valid (0 or 1)
if ($mode !== "0" && $mode !== "1") {
    $response['success'] = false;
    $response['message'] = "Invalid mode. Mode must be either 0 or 1.";
    echo json_encode($response);
    exit;
}

// Select the appropriate ordering based on the mode
$order = ($mode === "0") ? "ASC" : "DESC";

// Prepare and execute the SQL query
$sql = "SELECT name, status, cluster_id, content FROM clusters WHERE uid = '$uid' ORDER BY ID $order LIMIT $amount";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    $response['success'] = false;
    $response['message'] = "Failed to fetch clusters.";
    echo json_encode($response);
    exit;
}

if (!mysqli_num_rows($result) > 0) {
    $response['success'] = true;
    $response['data'] = $dataArray;
    echo json_encode($response);
    exit;
}
// Fetch the clusters and build the data array
$dataArray = array();
while ($row = mysqli_fetch_assoc($result)) {
    $cluster = array(
        'name' => $row['name'],
        'status' => $row['status'],
        'id' => $row['cluster_id'],
        'content' => $row['content']
    );
    $dataArray[] = $cluster;
}

if (count($dataArray) > 0) {
// Prepare the final response
$response['success'] = true;
$response['data'] = $dataArray;
echo json_encode($response);
}else{
    // Prepare the final response
    $response['success'] = true;
    $response['data'] = $dataArray;
    echo json_encode($response);
}


