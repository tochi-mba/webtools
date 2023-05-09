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

    if ($changed){
        $monetized = false;
        if ($data->status == "monetized"){
            $keys = array_keys($legacyManifest);
            $lastKey = array_pop($keys);
            
            foreach ($legacyManifest as $key => $value){
                if ($key !== $lastKey) {
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
                        $legacyManifest[$key][0]['status'] = "private";
                    }
                }
            }else{
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