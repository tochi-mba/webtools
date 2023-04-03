<?php
$data = $_POST;
if (isset($data['api_token'])) {
    require "../spam.php";

    $api_token = $data['api_token'];
    require "../../connect.php";

    // Query the database
    $sql = "SELECT `uid` FROM `users` WHERE `api_token`='$api_token'";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    // Store the uid from the query result in a variable
    $row = mysqli_fetch_assoc($result);
    $uid = $row["uid"];

    // Check if the query result is empty
    if(!$row) {
        // If the query result is empty, return an error
        echo json_encode([
            "success" => false,
            "message" => "Invalid API token"
        ]);
    }else{
        if (isset($data['script_id'])) {
            $edited=false;
            //Query database
            $script_id = $data['script_id'];
            $sql = "SELECT * FROM `scripts` WHERE `uid`='$uid' AND `script_id`='$script_id'";
            //Execute sql query
            $result = mysqli_query($conn, $sql);
            //Store the row from the query result in a variable
            $row = mysqli_fetch_assoc($result);
            //Check if the query result is empty
            if(!$row) {
                // If the query result is empty, return an error
                echo json_encode([
                    "success" => false,
                    "message" => "Invalid Script ID"
                ]);
            }else{
                $manifest=json_decode($row['manifest'],true);
                // Check if the js_code field is set
                if (isset($data['js_code'])) {
                    //Check if the js file exists
                    if (file_exists("../../scripts/".$uid."_private/".$script_id."/".$row['version']."/".$script_id.".js")) {
                            $edited=true;
                    } else {
                        //If the file does not exist, check if the js_code field is empty
                        if ($data['js_code']!="") {
                            $edited=true;
                        }
                    }
                }
                //Check if the css_code field is set
                if (isset($data['css_code'])) {
                    //Check if the css file exists
                    if (file_exists("../../scripts/".$uid."_private/".$script_id."/".$row['version']."/".$script_id.".css")) {
                            $edited=true;
                        
                    } else {
                        //If the file does not exist, check if the css_code field is empty
                        if ($data['css_code']!="") {
                            $edited=true;
                        }
                    }
                }
                //Check if the readme field is set
                if (isset($data['readme'])) {
                    //Check if the readme file exists
                    if (file_exists("../../scripts/".$uid."_private/".$script_id."/".$row['version']."/README.txt")) {
                            $edited=true;
                        
                    } else {
                        //If the file does not exist, check if the readme field is empty
                        if ($data['readme']!="") {
                            $edited=true;
                        }
                    }
                }

                //If any of the fields were edited
                if ($edited) {
                    if ($row['save_all']=='true' || $row['save_all']==null || $row['purchased']=="true") {
                        if ($row['save_all']==null) {
                            $sql = "UPDATE `scripts` SET `save_all`='true' WHERE `uid`='$uid' AND `script_id`='$script_id'";
                            $result = mysqli_query($conn, $sql);
                        }
                        $new_version = $row['version'];
                        $number = (float) substr($new_version, 1);
                        $number += 0.01;
                        $new_version = "v" . $number;
                        mkdir("../../scripts/".$uid."_private/".$script_id."/".$new_version, 0700, true);
                    }else{
                        if ($row['purchased']==null) {
                            $sql = "UPDATE `scripts` SET `purchased`='false' WHERE `uid`='$uid' AND `script_id`='$script_id'";
                            $result = mysqli_query($conn, $sql);
                        }
                        $new_version = $row['version'];
                        $dir = "../../scripts/".$uid."_private/".$script_id."/".$new_version;
                        if (is_dir($dir)) {
                            $objects = scandir($dir);
                            foreach ($objects as $object) {
                                if ($object != "." && $object != "..") {
                                    if (filetype($dir."/".$object) == "dir") rmdir($dir."/".$object); else unlink($dir."/".$object);
                                }
                            }
                            reset($objects);
                            rmdir($dir);
                        }
                        $number = (float) substr($new_version, 1);
                        $number += 0.01;
                        if (strpos($number, '.') !== false) {
                            $new_version = "v" . $number;
                        } else {
                            $new_version = "v" . (int) $number;
                        }
                        mkdir("../../scripts/".$uid."_private/".$script_id."/".$new_version, 0700, true);
                    }
                    

                    //Add the js file to the new folder
                    if (isset($data['js_code']) && $data['js_code'] != '') {
                        file_put_contents("../../scripts/".$uid."_private/".$script_id."/".$new_version."/".$script_id.".js", $data['js_code']);
                    }

                    //Add the css file to the new folder
                    if (isset($data['css_code']) && $data['css_code'] != '') {
                        file_put_contents("../../scripts/".$uid."_private/".$script_id."/".$new_version."/".$script_id.".css", $data['css_code']);
                    }

                    //Add the readme file to the new folder
                    if (isset($data['readme'])) {
                        file_put_contents("../../scripts/".$uid."_private/".$script_id."/".$new_version."/README.txt", $data['readme']);
                    }else{
                        file_put_contents("../../scripts/".$uid."_private/".$script_id."/".$new_version."/README.txt", "");
                    }

                    //Update the active_files field
                    $active_files = json_decode($row['active_files'], true);
                   if (isset($data['js_code'])) {
                        if ($data['js_code']!="") {
                            $active_files['code'] = "active";
                        }else{
                            $active_files['code'] = "empty";
                        }
                    }
                    if (isset($data['css_code'])) {
                        if ($data['css_code']!="") {
                            $active_files['codeCss'] = "active";
                        }else{
                            $active_files['codeCss'] = "empty";
                        }
                    }

                    //Update the database
                    $active_files = json_encode($active_files);
                    $manifest[$new_version] = array([
                        "creation_date" => date("Y-m-d H:i:s"),
                        "libraries" => $data['libraries'],
                        "status" => "private",
                        "last_edited" => date("Y-m-d H:i:s"),
                        "release_date" => "unreleased",
                        "authorized_websites" => array()
                    ]);
                    $manifest = json_encode($manifest);
                    $sql = "UPDATE `scripts` SET `active_files`='$active_files', `last_edited`=NOW(), `version`='$new_version'";
                    if (isset($data['title'])) {
                        $title = $data['title'];
                        $sql .= ", `title`='$title'";
                    }
                    if (isset($data['description'])) {
                        $description = $data['description'];
                        $sql .= ", `description`='$description'";
                    }
                    if (isset($data['tags'])) {
                        $tags = $data['tags'];
                        $sql .= ", `tags`='$tags'";
                    }
                    if (isset($data['libraries'])) {
                        $libraries = $data['libraries'];
                        $sql .= ", `libraries`='$libraries'";
                    }
                    $sql .= ",`manifest`='$manifest' WHERE `uid`='$uid' AND `script_id`='$script_id'";
                    mysqli_query($conn, $sql);

                    //Return the response
                    echo json_encode([
                        "success" => true,
                        "script_id" => $script_id,
                        "version" => $new_version,
                        "edited" => $edited
                    ]);
                } else {
                    //Update the active_files field
                    $active_files = json_decode($row['active_files'], true);
                    if (isset($data['js_code'])) {
                        if ($data['js_code']!="") {
                            $active_files['code'] = "active";
                        }else{
                            $active_files['code'] = "empty";
                        }
                    }
                    if (isset($data['css_code'])) {
                        if ($data['css_code']!="") {
                            $active_files['codeCss'] = "active";
                        }else{
                            $active_files['codeCss'] = "empty";
                        }
                    }

                    //Update the database
                    $active_files = json_encode($active_files);
                    $manifest = json_decode($row["manifest"], true);

                    foreach ($manifest[$row['version']] as &$version) {
                        $version["libraries"] = $data['libraries'];
                    }
                    $manifest = json_encode($manifest);
                    $sql = "UPDATE `scripts` SET `active_files`='$active_files', `last_edited`=NOW()";
                    if (isset($data['title'])) {
                        $title = $data['title'];
                        $sql .= ", `title`='$title'";
                    }
                    if (isset($data['description'])) {
                        $description = $data['description'];
                        $sql .= ", `description`='$description'";
                    }
                    if (isset($data['tags'])) {
                        $tags = $data['tags'];
                        $sql .= ", `tags`='$tags'";
                    }
                    if (isset($data['libraries'])) {
                        $libraries = $data['libraries'];
                        $sql .= ", `libraries`='$libraries'";
                    }
                    $sql .= ", `manifest`='$manifest' WHERE `uid`='$uid' AND `script_id`='$script_id'";
                    mysqli_query($conn, $sql);
                    //If no fields were edited, return a success message
                    echo json_encode([
                        "success" => true,
                        "message" => "Configuration fields were edited successfully"
                    ]);
                }

            }
        } else {
            //If script_id field is not set, return an error
            echo json_encode([
                "success" => false,
                "message" => "Script ID is required"
            ]);
        }
    }
}
?>