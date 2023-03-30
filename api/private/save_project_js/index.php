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
            if (isset($data->jsCode)) {
                $dir = '../../../scripts/'.$data->uid.'/'.$data->script_id.'/';
    
                $dirs = array_filter(glob($dir . '/*'), 'is_dir');
    
                natsort($dirs);
    
                $latest_dir = end($dirs);
    
                $latest_version = basename($latest_dir);
    
                $jsCode=file_put_contents($dir.$latest_version.'/'.$data->script_id.'.js', $data->jsCode);
    
                $logs[]="JS Code Updated";
                    
            }
    
            if (isset($data->cssCode)) {
                $dir = '../../../scripts/'.$data->uid.'/'.$data->script_id.'/';
    
                $dirs = array_filter(glob($dir . '/*'), 'is_dir');
    
                natsort($dirs);
    
                $latest_dir = end($dirs);
    
                $latest_version = basename($latest_dir);
    
                $jsCode=file_put_contents($dir.$latest_version.'/'.$data->script_id.'.css', $data->cssCode);
    
                $logs[]="CSS Code Updated";
                    
            }
    
            if (isset($data->readme)) {
                $dir = '../../../scripts/'.$data->uid.'/'.$data->script_id.'/';
    
                $dirs = array_filter(glob($dir . '/*'), 'is_dir');
    
                natsort($dirs);
    
                $latest_dir = end($dirs);
    
                $latest_version = basename($latest_dir);
    
                $jsCode=file_put_contents($dir.$latest_version.'/'.'/README.txt', $data->readme);
    
                $logs[]="README Updated";
                    
            }
    
            echo json_encode([
                "success" => true,
                "message" => "Updated",
                "logs" => $logs,
                "script_id" => $data->script_id,
            ]);
            exit;
        }
        if ($data->auto_save == "true") {
            if (!isset($data->script_id)){
                if (isset($data->title, $data->tags, $data->description, $data->jsCode, $data->cssCode, $data->readme, $data->libraries)){
                    $data = array(
                        'api_token' => $data->api_token,
                        'title' => $data->title,
                        'tags' => $data->tags,
                        'description' => $data->description,
                        'js_code' => $data->jsCode,
                        'css_code' => $data->cssCode,
                        'readme' => $data->readme,
                        'libraries' => $data->libraries
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
                        "script_id" => $response->data->script_id
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
            $query = "UPDATE scripts SET auto_save = 'true' WHERE script_id = '".$data->script_id."' AND uid = '".$data->uid."'";
            $result = mysqli_query($conn, $query);
            update();
            if ($result) {
                $logs[]="Auto Save Enabled";
                
        
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Auto Save did not update"
                ]);
                exit;
            }
            update();
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