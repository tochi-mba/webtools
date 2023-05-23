<?php
// Function to retrieve valid scripts based on tab name
function getValidScripts($conn, $tab_name) {
    $validScripts = array();
    $count = 0;
    $limit = 6; // Maximum number of valid scripts to retrieve
    $lastId = PHP_INT_MAX; // Start with a very large last ID to begin with the latest script
  
    // Loop until we have reached the last script or have found enough valid scripts
    while ($count < $limit && $lastId > 0) {
        if ($tab_name == "all") {
            $sql = "SELECT * FROM scripts WHERE ID < $lastId ORDER BY ID DESC LIMIT 1";
        } else if ($tab_name == "for you") {
            $sql = "SELECT * FROM scripts WHERE ID < $lastId ORDER BY ID DESC LIMIT 1";
        } else if ($tab_name == "js module") {
            $sql = "SELECT * FROM scripts WHERE ID < $lastId AND type = 'module' ORDER BY ID DESC LIMIT 1";
        } else {
            $sql = "SELECT * FROM scripts WHERE ID < $lastId ORDER BY ID DESC LIMIT 1";
        }
        $result = mysqli_query($conn, $sql);
  
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // Check if script meets criteria
            if (!empty($row['manifest']) && !empty($row['publish_manifest']) && $row['publish_manifest']!="[]" && $row['publish_manifest']!="" && !empty($row['publish_description']) && !empty($row['publish_image'])) {
                $manifest = json_decode($row['manifest'], true);
                $versions = array();
                $uid = $row['uid'];
                $sql1 = "SELECT username FROM users WHERE uid='$uid'";
                $result1 = mysqli_query($conn, $sql1);
                $row1 = mysqli_fetch_assoc($result1);
                $row['username'] = $row1['username'];

                foreach ($manifest as $version => $details) {
                    foreach ($details as $detail) {
                        if ($detail['status'] == 'public' or $detail['status'] == 'monetized') {
                            $versions[] = $version;
                        }
                    }
                }
                if (count($versions) != 0) {
                
                if ($tab_name == "js only") {
                    $active_files = $row['active_files'];
                    $active_files = json_decode($active_files, true);
                    if ($active_files['code'] == "active" && $active_files['codeCss'] == "empty") {
                        $row['active_versions'] = $versions;
                        $validScripts[] = $row;
                        $count++;
                    }
                } else if ($tab_name == "css only") {
                    $active_files = $row['active_files'];
                    $active_files = json_decode($active_files, true);
                    if ($active_files['code'] == "empty" && $active_files['codeCss'] == "active") {
                        $row['active_versions'] = $versions;
                        $validScripts[] = $row;
                        $count++;
                    }
                } else if ($tab_name == "monetized") {
                    $versions = array();
                    foreach ($manifest as $version => $details) {
                        foreach ($details as $detail) {
                            if ($detail['status'] == 'monetized') {
                                $versions[] = $version;
                            }
                        }
                    }
                    if (count($versions) > 0) {
                        $row['active_versions'] = $versions;
                        $validScripts[] = $row;
                        $count++;
                    }
                } else if ($tab_name == "free") {
                    $versions = array();
                    foreach ($manifest as $version => $details) {
                        foreach ($details as $detail) {
                            if ($detail['status'] == 'public') {
                                $versions[] = $version;
                            }
                        }
                    }
                    if (count($versions) > 0) {
                        $row['active_versions'] = $versions;
                        $validScripts[] = $row;
                        $count++;
                    }
                } else if ($tab_name != "for you" && $tab_name != "all" && $tab_name != "js module" && $tab_name != "js only" && $tab_name != "css only" && $tab_name != "monetized" && $tab_name != "free") {
                    if (count($versions) > 0) {
                        $tags = explode(",", strtolower($row['tags']));
                        if (in_array($tab_name, $tags)) {
                            $row['active_versions'] = $versions;
                            $validScripts[] = $row;
                            $count++;                          
                        }                      
                    }
                }else{
                    $row['active_versions'] = $versions;
                    $validScripts[] = $row;
                    $count++;
                }
            }
            }
            // Update last ID to the current script ID
            $lastId = $row['ID'];
        } else {
            // No more scripts to retrieve, exit loop
            $lastId = 0;
        }
    }
  
    return $validScripts;
}

// Get the input data from the JSON request body
$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody);

// Sanitize all input values
require_once("../../../connect.php");
require_once("../validate_input.php");
foreach ($data as $key => $value) {
    $data->$key = validateInput($value);
}

// Get tab name and index from input data
$tab_name = strtolower($data->tab_name);
// Retrieve valid scripts based on tab name
$valid_scripts = getValidScripts($conn, $tab_name);

// Return valid scripts as JSON response
echo json_encode(
    array(
        "success" => true,
        "valid_scripts" => $valid_scripts,
        "tab_name" => $tab_name
    )
);
exit();
?>