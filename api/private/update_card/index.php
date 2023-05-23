<?php
// Get the input data from the JSON request body
$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody);
require_once("../../../connect.php");
require_once("../validate_input.php");

// Sanitize all input values
foreach ($data as $key => $value) {
    if ($key !== "image") {

    $data->$key = validateInput($value);
    }
}

// Verify user session
require_once("../user_verification_js.php");

// Extract the input parameters
$description = $data->description;
$uid = $data->uid;
$scriptId = $data->script_id;
$image = filter_var($data->image, FILTER_SANITIZE_URL);

// Check if the description is 250 characters or less
if (strlen($description) > 250) {
    $response = array(
        "success" => false,
        "message" => "Description must be 250 characters or less."
    );
    echo json_encode($response);
    exit();
}

// Trim and remove spaces from the image link
if (strlen($image) > 2083) {
    $response = array(
        "success" => false,
        "message" => "Image too long."
    );
    echo json_encode($response);
    exit();
}

// Check if the image is a private link
if (strpos($image, '/user_assets/image.php?v=private%2F') !== false) {
    $response = array(
        "success" => false,
        "message" => "Image link is private."
    );
    echo json_encode($response);
    exit();
}

// Check if the image is 600x500
list($width, $height) = getimagesize($image);
if ($width != 600 || $height != 500) {
    $response = array(
        "success" => false,
        "message" => "Image must be 600x500."
    );
    echo json_encode($response);
    exit();
}

// Update the SQL table with the publish image and description
$sql = "UPDATE scripts SET publish_image = '$image', publish_description = '$description' WHERE uid = '$uid' AND script_id = '$scriptId'";
$result = mysqli_query($conn, $sql);
if (!$result) {
    $response = array(
        "success" => false,
        "message" => "Error updating publish image and description."
    );
    echo json_encode($response);
    exit();
} else {
    $response = array(
        "success" => true,
        "message" => "Publish image and description updated successfully."
    );
    echo json_encode($response);
    exit();
}
?>
