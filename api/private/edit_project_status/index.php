<?php
require "../private.php";
require "../../../connect.php"; 

function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  //edit project status. 1 = unlisted, 2 = private, 3 = public, 4 = monetized
if (isset($_POST["api_token"], $_POST["uid"], $_POST["project_id"], $_POST["status"], $_POST["old_status"])) {
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
        if ($uid !== $data["uid"]) {
            echo json_encode([
                "success" => false,
                "message" => "Refresh your API token"
            ]);
            exit();
        }else{
                if ($data['status'] == "1" || $data['status'] == "2" || $data['status'] == "3" || $data['status'] == "4") {
                    if ($data['status'] == "1") {
                        # monetization must be approved by at least a level 2 admin
                        $content= array(
                            "type" => "monetization",
                            "data" => array(
                                "project_id" => $data["project_id"],
                                "uid" => $uid,
                            )
                        )
                        $content = json_encode($content);
                        $project_id=$data['project_id'];
                        $sql = "INSERT INTO `moderation` (`ID`, `issued_by`, `type`, `level`, `content`, `date`, `project_id`) VALUES (NULL, '$uid', 'approval', '>=2', '$content', NOW(), '$project_id');";
                        $result = mysqli_query($conn, $sql);
                        if(!$result) {
                            # send an email to the admin informing them that there was an attempt and an error where no request was sent but there was a request made. log it too. so a level 3 and up admin will have to chck and see directly on the database
                            echo json_encode([
                                "success" => false,
                                "message" => "Error sending monetization request"
                            ]);
                            exit();
                        }else{
                            echo json_encode([
                                "success" => true,
                                "message" => "Monetization request sent",
                                "status" => $data['old_status'],
                                "project_id" => $project_id
                            ]);
                            exit();
                        }
                    }
                    $status=$data['status'];
                    $sql = "UPDATE `scripts` SET `status`='$status' WHERE `uid`='$uid' AND `script_id`='$project_id'";
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        echo json_encode([
                            "success" => false,
                            "message" => "Error updating project status"
                        ]);
                        exit();
                    }else{
                        #remove monetization request if it exists
                        $sql = "DELETE FROM `moderation` WHERE `issued_by`='$uid' AND `project_id`='$project_id'";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            # send an email to the admin informing them. and send an email to the user saying monetization request has been removed due to a status change in the project.
                        }else{
                            # send an email to the admin informing them that there was an attempt and an error so a level 3 and up admin will have to chck and see directly on the database
                        }
                        echo json_encode([
                            "success" => true,
                            "message" => "Project status updated",
                            "status" => $status
                        ]);
                        exit();
                    }
                }else{
                    echo json_encode([
                        "success" => false,
                        "message" => "Invalid status"
                    ]);
                    exit();
                }
            }
    }
}else{
    echo json_encode([
        "success" => false,
        "message" => "Set all requests fields"
    ]);
}