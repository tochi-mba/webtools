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
function getThirdFolder($url) {
    $url = explode('/', $url);

    $url =  array_slice($url, 4);

    $new_path = implode('/', $url);
    
  
    return $new_path;
  }

function getExt($url) {
    $url = explode('/', $url);

    $url =  array_slice($url, count($url)-1);

    $file = $url[0];

    $ext = explode('.', $file);

    $ext = array_slice($ext, count($ext)-1);
    
    $ext = $ext[0];
    
    return $ext;
  }
$url = $data -> full_url;
$fullPath = "../../" . $url;
if (file_exists($fullPath)){
    $content = file_get_contents($fullPath);
    echo json_encode(array(
        "success" => true,
        "data" => htmlentities($content),
        "error" => false,
        "path" => $fullPath,
        "ext" => getExt($url)
    ));
    exit;
}else{
    echo json_encode(array(
        "success" => false,
        "error" => "File not found",
        "path" => $fullPath
    ));
    exit;
}
?>