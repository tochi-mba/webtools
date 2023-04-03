

<?php
// Get the data from the request
$data = $_POST;
if (isset($data['api_token'])) {
    require "../spam.php";

    $api_token = $data['api_token'];
    require "../../connect.php";

    // Query the database
    $sql = "SELECT `uid`,`scripts_id` FROM `users` WHERE `api_token`='$api_token'";

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
    } else {
        // Validate the POST parameters
        if(isset($data["title"])) {
            $title = $data["title"];
            if(isset($data["tags"])) {
                $tags = $data["tags"];
            } else {
                $tags = "";
            }
            if(isset($data["description"])) {
                $description = $data["description"];
            } else {
                $description = "";
            }
            if(isset($data["js_code"])) {
                $js_code = $data["js_code"];
            } else {
                $js_code = "";
            }
            if(isset($data["css_code"])) {
                $css_code = $data["css_code"];
            } else {
                $css_code = "";
            }
            if(isset($data["readme"])) {
                $readme = $data["readme"];
            } else {
                $readme = "";
            }
            if(isset($data["libraries"])) {
                $libraries = $data["libraries"];
            } else {
                $libraries = "";
            }

            // Dictionary that will keep track of which POST is empty and which one is active
            $post_status = array();

            // Check to see if each POST is empty
            if(trim($js_code) === '') {
                // Add "code" to the post_status array as empty
                $post_status["code"] = "empty";
            } else {
                // Add "code" to the post_status array as active
                $post_status["code"] = "active";
            }
            if(trim($css_code) === '') {
                // Add "codeCss" to the post_status array as empty
                $post_status["codeCss"] = "empty";
            } else {
                // Add "codeCss" to the post_status array as active
                $post_status["codeCss"] = "active";
            }

            // Generate a unique ID
            $unique_id = uniqid();

            // Create a folder for the POST files
            while(file_exists("../../scripts/" . $uid . "_private/" . $unique_id)) {
                $unique_id = uniqid();
            }
           
            
            // Create a folder for the POST files
            mkdir("../../scripts/" . $uid . "_private/" . $unique_id . "/v1/", 0700, true);
            $manifest['v1']= array([
                "creation_date" => date("Y-m-d H:i:s"),
                "libraries" => $libraries,
                "status" => "private",
                "last_edited" => date("Y-m-d H:i:s"),
                "release_date" => "unreleased",
                "authorized_websites" => array()
            ]);
            $manifest = json_encode($manifest);
            // Check to see if the "code" POST is active and create a .js file
            if($post_status["code"] == "active") {
                // Create the .js file
                $code = $js_code;
                // Create a new file in the user's directory with the name $scriptId.js and write JavaScript code to it
                $file = fopen("../../scripts/" . $uid . "_private/" . $unique_id . "/v1/" . $unique_id . ".js", "w") or die("Unable to create the .js file!");
                fwrite($file, $code);
                fclose($file); 
            }

            // Check to see if the "codeCss" POST is active and create a .css file
            if($post_status["codeCss"] == "active") {
                // Create the .css file
                $css_file = fopen("../../scripts/" . $uid . "_private/" . $unique_id . "/v1/" . $unique_id . ".css", "w") or die("Unable to create the .css file!");

                // Write the contents of the "codeCss" POST to the .css file
                fwrite($css_file, $css_code);

                // Close the file
                fclose($css_file);
            }

            // Create the README file
            $readme_file = fopen("../../scripts/" . $uid . "_private/" . $unique_id . "/v1/README.txt", "w") or die("Unable to create the README file!");

            // Write the contents of the "codeReadme" POST to the README file
            fwrite($readme_file, $readme);

            // Close the file
            fclose($readme_file);

            $post_status = json_encode($post_status);
            $sql = "INSERT INTO scripts (ID, script_id, uid, active_files, date_created, last_edited, version, title, tags, category, description, libraries, manifest) VALUES (NULL, '$unique_id', '$uid', '$post_status ', NOW(), NOW(), 'v1', '$title', '$tags', '', '$description', '$libraries', '$manifest');";
            if (mysqli_query($conn, $sql)) {
                echo json_encode([
                    "success" => true,
                    "message" => "New Script Created!",
                    "data" => [
                        "title" => $title,
                        "tags" => $tags,
                        "description" => $description,
                        "script_id" => $unique_id,
                        "js_code" => $js_code,
                        "css_code" => $css_code,
                        "readme" => $readme,
                        "libraries" => $libraries,
                        "version" => "v1",
                        "date_created" => date("Y-m-d H:i:s"),
                        "status" => "private"
                    ]
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Error Creating New Script"
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Fill all mandatory parameters!"
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