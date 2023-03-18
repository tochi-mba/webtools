<?php

// Get data from the request body
$data = $_GET;
// Check if the API token is set
if (isset($data['api_token'])) {
    require "../spam.php";
    // Store the API token
    $api_token = $data['api_token'];

    // Connect to the database
    require "../../connect.php";

    // Get the user ID associated with the API token
    $sql = "SELECT `uid` FROM `users` WHERE `api_token`='$api_token'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        $uid = $row["uid"];
    }else{
        // Return an error if the API token is invalid
        echo json_encode([
            "success" => false,
            "message" => "Invalid API token"
        ]);
    }

    // Check if the API token is valid
    if(mysqli_num_rows($result) > 0) {
        // Check if the mode is set
        if(isset($data["mode"])) {
            // Store the mode
            $mode = $data["mode"];

            // Check the mode
            if($mode == 0) {
                // Check if the amount is set
                if(isset($data["amount"])) {
                    // Store the amount
                    $amount = $data["amount"];

                    // Get the scripts from the database
                    $sql = "SELECT * FROM `scripts` WHERE `uid`='$uid' LIMIT $amount";
                    $result = mysqli_query($conn, $sql);

                    // Store the scripts
                    $scripts = array();
                    while($row = mysqli_fetch_assoc($result)) {
                        $scripts[] = $row;
                    }

                    // Return the scripts
                    echo json_encode([
                        "success" => true,
                        "message" => "Scripts Retrieved!",
                        "data" => $scripts
                    ]);
                } else {
                    // Return an error if the amount is not set
                    echo json_encode([
                        "success" => false,
                        "message" => "Amount parameter must be set!"
                    ]);
                }
            } elseif($mode == 1) {
                // Check if the amount is set
                if(isset($data["amount"])) {
                    // Store the amount
                    $amount = $data["amount"];

                    // Get the scripts from the database
                    $sql = "SELECT * FROM `scripts` WHERE `uid`='$uid' ORDER BY `ID` DESC LIMIT $amount";
                    $result = mysqli_query($conn, $sql);

                    // Store the scripts
                    $scripts = array();
                    while($row = mysqli_fetch_assoc($result)) {
                        $scripts[] = $row;
                    }

                    // Return the scripts
                    echo json_encode([
                        "success" => true,
                        "message" => "Scripts Retrieved!",
                        "data" => $scripts
                    ]);
                } else {
                    // Return an error if the amount is not set
                    echo json_encode([
                        "success" => false,
                        "message" => "Amount parameter must be set!"
                    ]);
                }
            } elseif($mode == 2) {
                // Check if the script ID is set
                if(isset($data["script_id"])) {
                    // Store the script ID
                    $script_id = $data["script_id"];

                    // Get the script from the database
                    $sql = "SELECT * FROM `scripts` WHERE `uid`='$uid' AND `script_id`='$script_id'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);

                    // Check if the script exists
                    if($row) {
                        // Return the script
                        echo json_encode([
                            "success" => true,
                            "message" => "Script Retrieved!",
                            "data" => $row
                        ]);
                    } else {
                        // Return an error if the script does not exist
                        echo json_encode([
                            "success" => false,
                            "message" => "Script not found!"
                        ]);
                    }
                } else {
                    // Return an error if the script ID is not set
                    echo json_encode([
                        "success" => false,
                        "message" => "Script ID parameter must be set!"
                    ]);
                }
            } elseif($mode == 3) {
                // Get all the scripts from the database
                $sql = "SELECT * FROM `scripts` WHERE `uid`='$uid'";
                $result = mysqli_query($conn, $sql);

                // Store the scripts
                $scripts = array();
                while($row = mysqli_fetch_assoc($result)) {
                    $scripts[] = $row;
                }

                // Return the scripts
                echo json_encode([
                    "success" => true,
                    "message" => "Scripts Retrieved!",
                    "data" => $scripts
                ]);
            } else {
                // Return an error if the mode is invalid
                echo json_encode([
                    "success" => false,
                    "message" => "Invalid mode!"
                ]);
            }
        } else {
            // Return an error if the mode is not set
            echo json_encode([
                "success" => false,
                "message" => "Mode parameter must be set!"
            ]);
        }
    }
}else {
    // If the API token is empty, return an error
    echo json_encode([
        "success" => false,
        "message" => "API token is required"
    ]);
    die();
}

?>