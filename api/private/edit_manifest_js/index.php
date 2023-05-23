<?php
// Get the input data from the JSON request body
$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody);
$_POST = $data;
require "../../../connect.php";
require "../validate_input.php";
foreach (get_object_vars($_POST) as $key => $value) {
    if ($key !== "authWebsites") {
        $_POST->$key = validateInput($value);
    }else{
        for ($i = 0; $i < count($value); $i++) {
            $_POST->authWebsites[$i] = validateInput($value[$i]);
        }
    }
}

$data = $_POST;
require "../user_verification_js.php";
$api_token = $_SESSION["api_token"];
$sql = "SELECT scripts_id FROM users WHERE uid = '{$data->uid}' AND api_token = '$api_token'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
$security_code = $row["scripts_id"];
$sql = "SELECT manifest FROM scripts WHERE script_id = '{$data->script_id}' AND uid = '{$data->uid}'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $legacyManifest = json_decode($row["manifest"], true);
    $changed = false;
    if ($legacyManifest[$data->version][0]['status'] == $data->status){
        $changed = true;
    }

    if ($legacyManifest[$data->version][0]['authorized_websites'] == $data->authWebsites){
        $changed = true;
    }
    function move_directory_files($dir1, $dir2, $version, $data, $security_code) {

        // Check if the directories are the same
        

        if ($dir1 == "monetized"){
            $dir1 = "../../../scripts/"."{$data->uid}_". $dir1."_".$security_code."/"."{$data->script_id}"."/".$version."/";
        }else if ($dir1 == "public"){
            $dir1 = "../../../scripts/"."{$data->uid}_". $dir1."/"."{$data->script_id}"."/".$version."/";
        }else if ($dir1 == "private"){
            $dir1 = "../../../scripts/"."{$data->uid}_". $dir1."/"."{$data->script_id}"."/".$version."/";
        }else if ($dir1 == "unlisted"){
            $dir1 = "../../../scripts/"."{$data->uid}_". $dir1."_".$security_code."/"."{$data->script_id}"."/".$version."/";
        }
        if ($dir1 === $dir2) {
            return;
        }
        if (!file_exists($dir2)) {
            mkdir($dir2, 0777, true);
        }
        // Loop through all files in the first directory and move them to the second directory
        $files = scandir($dir1);
        foreach ($files as $file) {
            if ($file !== "." && $file !== "..") {
                $src = $dir1 . $file;
                $dst = $dir2 . $file;
                rename($src, $dst);
            }
        }
        
        // Remove the first directory
        // Delete all files in the directory
$files = glob($dir1 . '/*');
foreach($files as $file){
    if(is_file($file)){
        unlink($file);
    }
}

// Delete the directory itself
if (is_dir($dir1)) {
    rmdir($dir1);
}

    }
    
    if ($changed){
        $monetized = false;
        if ($data->status == "monetized"){
            $keys = array_keys($legacyManifest);
            $lastKey = array_pop($keys);
            foreach ($legacyManifest as $key => $value){
                if ($key !== $lastKey) {
                    move_directory_files($legacyManifest[$key][0]['status'],"../../../scripts/"."{$data->uid}_monetized_".$security_code."/"."{$data->script_id}"."/".$key."/", $key, $data, $security_code);
                    $legacyManifest[$key][0]['status'] = "monetized";
                }
            }
        }else{

            $keys = array_keys($legacyManifest);
                $lastKey = array_pop($keys);
                if ($lastKey != $data->version){
                    
                
            foreach ($legacyManifest as $key => $value){
                if ($legacyManifest[$key][0]['status'] == "monetized"){
                    if ($key !== $lastKey) {

                    $monetized = true;
                    }
                }
            }
            if ($monetized){
                $legacyManifest[$data->version][0]['status'] = $data->status;
                foreach ($legacyManifest as $key => $value){
                    if ($key !== $data->version){
                        move_directory_files($legacyManifest[$key][0]['status'],"../../../scripts/"."{$data->uid}_private/"."{$data->script_id}"."/".$key."/", $key, $data, $security_code);
                        $legacyManifest[$key][0]['status'] = "private";
                    }
                }
            }else{
                if ($data->status == "public"){
                    move_directory_files($legacyManifest[$data->version][0]['status'],"../../../scripts/"."{$data->uid}_public/"."{$data->script_id}"."/".$data->version."/", $data->version, $data, $security_code);
                }else if ($data->status == "private"){
                    move_directory_files($legacyManifest[$data->version][0]['status'],"../../../scripts/"."{$data->uid}_private/"."{$data->script_id}"."/".$data->version."/", $data->version, $data, $security_code);
                }else if ($data->status == "unlisted"){
                    move_directory_files($legacyManifest[$data->version][0]['status'],"../../../scripts/"."{$data->uid}_unlisted_".$security_code."/"."{$data->script_id}"."/".$data->version."/", $data->version, $data, $security_code);
                }
                $legacyManifest[$data->version][0]['status'] = $data->status;

            }
        }
        }
        $legacyManifest[$data->version][0]['authorized_websites'] = $data->authWebsites;
        $sql = "UPDATE scripts SET manifest = '" . json_encode($legacyManifest) . "' WHERE script_id = '{$data->script_id}' AND uid = '{$data->uid}'";
        if ($conn->query($sql)){
            echo json_encode(array(
                "success" => true,
                "message" => "Manifest updated"
            ));
        }else{
            echo json_encode(array(
                "success" => false,
                "message" => "Manifest not updated"
            ));
        }
    }
}
?>