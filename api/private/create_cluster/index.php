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
$name = $data->name;
$status = $data->status;
$project_id = $data->project_id;
$author_id = $data->author_uid;
$version = $data->version;
$auth_websites = $data->auth_websites;
$decoded_websites = json_decode($auth_websites, true);

// Check if name is longer than 150 characters
if (strlen($name) > 150) {
    echo json_encode(array(
        "success" => false,
        "message" => "Name exceeds the maximum limit of 150 characters.",
    ));
    exit;
}

$sanitized_websites = [];

foreach ($decoded_websites as $url) {
    $sanitized_url = filter_var($url, FILTER_SANITIZE_URL);
    // You can also perform additional validation or checks on the URL if needed
    $sanitized_websites[] = $sanitized_url;
}




function generateUID($conn) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_';
    $uid = '';
    $uidExists = true;
    
    while ($uidExists) {
        $uid = '';
        
        for ($i = 0; $i < 4; $i++) {
            $index = mt_rand(0, strlen($characters) - 1);
            $uid .= $characters[$index];
        }
        
        $sql = 'SELECT uid FROM clusters WHERE uid = \'' . $uid . '\'';
        
        if (!doesUIDExist($sql, $conn)) {
            $uidExists = false;
        }
    }
    
    return $uid;
}


function doesUIDExist($sql, $conn) {
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0){
        return true;
    }else{
        return false;
    }
}

$content = array([
    "project_id" => $project_id,
    "author_id" => $author_id,
    "version" => $version]
);
$content = json_encode($content);
$cluster_id = generateUID($conn);
$sql = "INSERT INTO `clusters` (`ID`, `uid`, `name`, `cluster_id`, `content`, `date_created`, `status`, `authorized_websites`, `description`) VALUES (NULL, '".$uid."', '".$name."', '".$cluster_id."', '".$content."', '".date('Y-m-d')."', '".$status."', '".json_encode($sanitized_websites)."', NULL);";

if (mysqli_query($conn, $sql)){
    echo json_encode(array(
        "success" => true,
        "message" => "cluster created successfully",
        "cluster_id" => $cluster_id,
    ));
}else{
    echo json_encode(array(
        "success" => false,
        "message" => "cluster creation failed",
    ));
}

