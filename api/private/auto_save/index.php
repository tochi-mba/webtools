<?php
    $data=$_POST;
    if (isset($data['script_id'], $data['auto_save']), $data['api_token'], $data['uid']) {
        require "../validate_input.php";

        require "../user_verification.php";
        
    }else{
        echo json_encode([
            "success" => false,
            "message" => "All Fields are required"
        ]);
    }

?>