<?php
function CallAPI($method, $url, $data = false)
 {
     $curl = curl_init();

     switch ($method)
     {
         case "POST":
             curl_setopt($curl, CURLOPT_POST, 1);

             if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
             break;
         case "PUT":
             curl_setopt($curl, CURLOPT_PUT, 1);
             break;
         default:
             if ($data)
                 $url = sprintf("%s?%s", $url, http_build_query($data));
     }

     // Optional Authentication:
     curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
     curl_setopt($curl, CURLOPT_USERPWD, "username:password");

     curl_setopt($curl, CURLOPT_URL, $url);
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

     $result = curl_exec($curl);

     curl_close($curl);

     return $result;
 }
 // Get the request body as a JSON string
 $requestBody = file_get_contents('php://input');

 // Convert the JSON string to a PHP object
 $data = json_decode($requestBody);
 $_POST=$data;
 if (isset($_POST->auto_save, $_POST->api_token, $_POST->uid)) {
        require "../../../connect.php";
        require "../validate_input.php";
        foreach (get_object_vars($_POST) as $key => $value) {
            if ($key !== "jsCode" && $key !== "cssCode" && $key !== "readme") {
                $_POST->$key = validateInput($value);
            }
        }
        
        $data=$_POST;
        require "../user_verification_js.php";
       

        
        $logs=array();
        function update(){
            global $data, $conn, $logs;
            if ($data->script_id !== null && $data->script_id !== ""){
                $code=array();
                if (isset($data->jsCode)&&$data->jsCode!="") {
                    $dir = '../../../scripts/'.$data->uid.'_private/'.$data->script_id.'/';
        
                    $dirs = array_filter(glob($dir . '/*'), 'is_dir');
        
                    natsort($dirs);
        
                    $latest_dir = end($dirs);
        
                    $latest_version = basename($latest_dir);
        
                    $jsCode=file_put_contents($dir.$latest_version.'/'.$data->script_id.'.js', $data->jsCode);
                    $code['code']= "active";
                    $logs[]="JS Code Updated";
                        
                }elseif($data->jsCode==""){
                    $code['code'] = "empty";
        
                    $logs[]="JS Code Updated";
                    $dir = '../../../scripts/'.$data->uid.'_private/'.$data->script_id.'/';

                    $dirs = array_filter(glob($dir . '/*'), 'is_dir');
        
                    natsort($dirs);
        
                    $latest_dir = end($dirs);
        
                    $latest_version = basename($latest_dir);

                    if (file_exists("../../../scripts/".$data->uid."_private/".$data->script_id."/".$latest_version."/".$data->script_id.".js")) {
                        unlink("../../../scripts/".$data->uid."_private/".$data->script_id."/".$latest_version."/".$data->script_id.".js");
                    }
                }
        
                if (isset($data->cssCode)&&$data->cssCode!=="") {
                    $dir = '../../../scripts/'.$data->uid.'_private/'.$data->script_id.'/';
        
                    $dirs = array_filter(glob($dir . '/*'), 'is_dir');
        
                    natsort($dirs);
        
                    $latest_dir = end($dirs);
        
                    $latest_version = basename($latest_dir);
        
                    $jsCode=file_put_contents($dir.$latest_version.'/'.$data->script_id.'.css', $data->cssCode);
                    $code['codeCss']= "active";
                    $logs[]="CSS Code Updated";
                        
                }elseif($data->cssCode==""){
                    $code['codeCss'] = "empty";
        
                    $logs[]="CSS Code Updated";

                    $dir = '../../../scripts/'.$data->uid.'_private/'.$data->script_id.'/';

                    $dirs = array_filter(glob($dir . '/*'), 'is_dir');
        
                    natsort($dirs);
        
                    $latest_dir = end($dirs);
        
                    $latest_version = basename($latest_dir);

                    if (file_exists("../../../scripts/".$data->uid."_private/".$data->script_id."/".$latest_version."/".$data->script_id.".css")) {
                        unlink("../../../scripts/".$data->uid."_private/".$data->script_id."/".$latest_version."/".$data->script_id.".css");
                    }
                }
        
                if (isset($data->readme)) {
                    $dir = '../../../scripts/'.$data->uid.'_private/'.$data->script_id.'/';
        
                    $dirs = array_filter(glob($dir . '/*'), 'is_dir');
        
                    natsort($dirs);
        
                    $latest_dir = end($dirs);
        
                    $latest_version = basename($latest_dir);
        
                    $jsCode=file_put_contents($dir.$latest_version.'/'.'/README.txt', $data->readme);
        
                    $logs[]="README Updated";
                        
                }

                // Set the update fields based on the available data
                $update_fields = array();
                if (isset($data->libraries)) {
                    $update_fields[] = "libraries = '".$data->libraries."'";
                    $logs[]="Libraries Updated";
                }
                if (isset($data->title)) {
                    $update_fields[] = "title = '".$data->title."'";
                    $logs[]="Title Updated";
                }
                if (isset($data->tags)) {
                    $update_fields[] = "tags = '".$data->tags."'";
                    $logs[]="Tags Updated";
                }
                if (isset($data->description)) {
                    $update_fields[] = "description = '".$data->description."'";
                    $logs[]="Description Updated";
                }
                if (isset($data->extraction)) {
                    $update_fields[] = "automatic_variable_extraction_enabled = '".$data->extraction."'";
                    $logs[]="Extraction Updated";
                }

                if (isset($data->extraction)) {
                    $update_fields[] = "type = '".$data->type."'";
                    $logs[]="Type Updated";
                }

                // Update the fields in the database
                if (!empty($update_fields)) {
                    $update_query = "UPDATE scripts SET " . implode(", ", $update_fields) . " WHERE script_id = '".$data->script_id."' AND uid = '".$data->uid."'";
                    $result = mysqli_query($conn, $update_query);
                }

                $code=json_encode($code);


                echo json_encode([
                    "success" => true,
                    "message" => "Updated",
                    "logs" => $logs,
                    "script_id" => $data->script_id,
                ]);
                $sql = "SELECT `manifest` FROM `scripts` WHERE `uid`='".$data->uid."' AND `script_id`='".$data->script_id."'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                // Assuming $row["manifest"] contains the JSON string
                $manifest = json_decode($row["manifest"], true);

                // Assuming $latest_version contains the version to be updated
                foreach ($manifest[$latest_version] as &$version) {
                    $version["last_edited"] = date("Y-m-d H:i:s");
                    $version['extraction'] = $data->extraction;
                    $version['libraries'] = $data->libraries;
                }

                // Encode the modified array back to JSON
                $manifest = json_encode($manifest);
                $query = "UPDATE scripts SET last_edited = NOW(), manifest = '$manifest', active_files = '$code' WHERE script_id = '".$data->script_id."' AND uid = '".$data->uid."'";
                $result = mysqli_query($conn, $query);
                exit;
            }else{
                echo json_encode([
                    "success" => true,
                    "message" => "New Script Created",
                    "logs" => $logs,
                    "script_id" => $data->script_id,
                    "code" =>  "1"
                ]);
                exit;
            }
            
        }
        if ($data->auto_save == "true" or (isset($data->all) && $data->all == "true") ) {
            if (!isset($data->script_id)) {
                if (isset($data->title, $data->tags, $data->description, $data->jsCode, $data->cssCode, $data->readme, $data->libraries, $data->extraction, $data->type)) {
                    $data = array(
                        'api_token' => $data->api_token,
                        'title' => $data->title,
                        'tags' => $data->tags,
                        'description' => $data->description,
                        'js_code' => $data->jsCode,
                        'css_code' => $data->cssCode,
                        'readme' => $data->readme,
                        'libraries' => $data->libraries,
                        'extraction' => $data->extraction,
                        'type' => $data->type,
                    );
                    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
                    $host = $_SERVER['HTTP_HOST'];
                    $base_url = $protocol . "://" . $host;
                    $url=$base_url."/api/create/";
                    $response=CallAPI("POST", $url, $data);
                    $response=json_decode($response);
                    
                    echo json_encode([
                        "success" => true,
                        "message" => "New Script Created",
                        "script_id" => $response->data->script_id,
                        "code" =>  "1",
                    ]);
                    exit;
                } else {
                    echo json_encode([
                        "success" => false,
                        "message" => "This is a new script and you have not provided all the required data"
                    ]);  
                    exit;
                               
                }  
            }
            if (!isset($data->all) or $data->all == "false"){
                $query = "UPDATE scripts SET auto_save = 'true' WHERE script_id = '".$data->script_id."' AND uid = '".$data->uid."'";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    $logs[]="Auto Save Enabled";
                    
                    update();
    
                } else {
                    update();
    
                    echo json_encode([
                        "success" => false,
                        "message" => "Auto Save did not update"
                    ]);
                    exit;
                }
            }else{
                update();

                echo json_encode([
                    "success" => true,
                    "message" => "Saved all"
                ]);
                exit;
            }
           
        }elseif ($data->auto_save == "false") {
            $query = "UPDATE scripts SET auto_save = 'false' WHERE script_id = '".$data->script_id."' AND uid = '".$data->uid."'";
            $result = mysqli_query($conn, $query);
            if ($result) {
                $logs[]="Auto Save Disabled";
        
                echo json_encode([
                    "success" => true,
                    "message" => "Disabled",
                    "logs" => $logs,
                    "script_id" => $data->script_id
                ]);
                exit;
        
            }
        }

        // if ($data->save == "true") {
        //     if (!isset($data->script_id)){
        //         if (isset($data->title, $data->tags, $data->description, $data->jsCode, $data->cssCode, $data->readme, $data->libraries)){
        //             $data = array(
        //                 'api_token' => $data->api_token,
        //                 'title' => $data->title,
        //                 'tags' => $data->tags,
        //                 'description' => $data->description,
        //                 'js_code' => $data->jsCode,
        //                 'css_code' => $data->cssCode,
        //                 'readme' => $data->readme,
        //                 'libraries' => $data->libraries
        //             );
        //             $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        //             $host = $_SERVER['HTTP_HOST'];
        //             $base_url = $protocol . "://" . $host;
        //             $url=$base_url."/api/create/";
        //             $response=CallAPI("POST", $url, $data);
        //             $response=json_decode($response);
        //             echo json_encode([
        //                 "success" => true,
        //                 "message" => "New Script Created",
        //                 "script_id" => $response->data->script_id
        //             ]);
        //         } else {
        //             echo json_encode([
        //                 "success" => false,
        //                 "message" => "This is a new script and you have not provided all the required data"
        //             ]);  
                               
        //         }
        //         exit;   
        //     }
            
        //         if (isset($data->jsCode)) {
        //             $dir = '../../../scripts/'.$data->uid.'/'.$data->script_id.'/';
        
        //             $dirs = array_filter(glob($dir . '/*'), 'is_dir');
        
        //             natsort($dirs);
        
        //             $latest_dir = end($dirs);
        
        //             $latest_version = basename($latest_dir);
        
        //             $jsCode=file_put_contents($dir.$latest_version.'/'.$data->script_id.'.js', $data->jsCode);
        
        //             $logs[]="JS Code Updated";
                        
        //         }
        
        //         if (isset($data->cssCode)) {
        //             $dir = '../../../scripts/'.$data->uid.'/'.$data->script_id.'/';
        
        //             $dirs = array_filter(glob($dir . '/*'), 'is_dir');
        
        //             natsort($dirs);
        
        //             $latest_dir = end($dirs);
        
        //             $latest_version = basename($latest_dir);
        
        //             $jsCode=file_put_contents($dir.$latest_version.'/'.$data->script_id.'.css', $data->cssCode);
        
        //             $logs[]="CSS Code Updated";
                        
        //         }
        
        //         if (isset($data->readme)) {
        //             $dir = '../../../scripts/'.$data->uid.'/'.$data->script_id.'/';
        
        //             $dirs = array_filter(glob($dir . '/*'), 'is_dir');
        
        //             natsort($dirs);
        
        //             $latest_dir = end($dirs);
        
        //             $latest_version = basename($latest_dir);
        
        //             $jsCode=file_put_contents($dir.$latest_version.'/'.'/README.txt', $data->readme);
        
        //             $logs[]="README Updated";
                        
        //         }
        
        //         echo json_encode([
        //             "success" => true,
        //             "message" => "Updated",
        //             "logs" => $logs,
        //             "script_id" => $data->script_id
        //         ]);
        // }
    }else{
        echo json_encode([
            "success" => false,
            "message" => "All Fields are required"
        ]);
        exit;
    }

?>