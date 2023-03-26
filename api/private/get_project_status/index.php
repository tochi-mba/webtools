<?php
require "../private.php";
require "../../../connect.php"; 

function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  
if (isset($_POST["api_token"], $_POST["uid"], $_POST["project_id"])) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = validateInput($value);
    }
    $data  = $_POST;
    require "../spam.php";

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
    }else {
        
        $uid = $row["uid"];
        if ($uid !== $_POST["uid"]) {
            echo json_encode([
                "success" => false,
                "message" => "Refresh your API token"
            ]);
            exit();
        }
        $sql = "SELECT `status` FROM `scripts` WHERE `uid`='$uid' AND `script_id`='".$data['project_id']."'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if(!$row) {
            echo json_encode([
                "success" => false,
                "message" => "Invalid project id"
            ]);
            exit();
        }else{
            // make the default status 2
            $status = $row["status"];
            if ($status == null){ {
                $status = "2";
            }
            echo json_encode([
                "success" => true,
                "status" => $status
            ]);
        }
       
    }
}else{
    echo json_encode([
        "success" => false,
        "message" => "Set all requests fields"
    ]);
}

?>