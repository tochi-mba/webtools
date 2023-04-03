<?php 

require "head.php"; 
require "is_logged.php";

?>

<?php

if(isset($_GET['script_id'])){
    require "connect.php";
    $script_id = $_GET['script_id'];
    
    $uid = $_SESSION['uid'];
    
    // Check if the script_id exists
    $query = "SELECT * FROM scripts WHERE script_id = '$script_id'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
        // Script exists
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['uid'];
        if($user_id == $uid){
            $titleIDE=$row['title'];
            $librariesIDE=$row['libraries'];
            $tagsIDE=$row['tags'];
            $active_files=$row['active_files'];
            $active_files=json_decode($active_files,true);
            if($active_files['code'] == 'active'){
                $jsIDE = 'checked';
            } else {
                $jsIDE = '';
            }
            
            if($active_files['codeCss'] == 'active'){
                $cssIDE = 'checked';
            } else {
                $cssIDE = '';
            }
            $script_id = $_GET['script_id'];
            $version = $row['version']; 
            $number = (float) substr($version, 1);
            $number += 0.01;
            $versionNew = "v" . $number;
            $autosaveIDE = $row['auto_save'];
            if ($autosaveIDE == 'true') {
                $autosaveIDE = 'checked';
            } else {
                $autosaveIDE = '';
            }
            if (file_exists('./scripts/'.$_SESSION['uid'].'_private/'.$_GET['script_id'].'/'.$version)) {
                if (file_exists('./scripts/'.$_SESSION['uid'].'_private/'.$_GET['script_id'].'/'.$version.'/'.$_GET['script_id'].'.js')) {
                    $jsCodeIDE = file_get_contents('./scripts/'.$_SESSION['uid'].'_private/'.$_GET['script_id'].'/'.$version.'/'.$_GET['script_id'].'.js');
    
                 }else{
                    $jsCodeIDE = '';
                 }
                 if (file_exists('./scripts/'.$_SESSION['uid'].'_private/'.$_GET['script_id'].'/'.$version.'/'.$_GET['script_id'].'.css')) {
                    $cssCodeIDE = file_get_contents('./scripts/'.$_SESSION['uid'].'_private/'.$_GET['script_id'].'/'.$version.'/'.$_GET['script_id'].'.css');
    
                 }else{
                    $cssCodeIDE = '';
                 }
                 if (file_exists('./scripts/'.$_SESSION['uid'].'_private/'.$_GET['script_id'].'/'.$version.'/README.txt')) {
                    $readmeCodeIDE = file_get_contents('./scripts/'.$_SESSION['uid'].'_private/'.$_GET['script_id'].'/'.$version.'/README.txt');
    
                 }else{
                    $readmeCodeIDE = '';
                 }
                
            } else {
                $jsCodeIDE = '';
                $cssCodeIDE = '';
                $readmeCodeIDE = '';
            }
            $page="edit";


        } else {
            // Script does not belong to the user
            echo "Script does not belong to the user";
            exit;
        }
    } else {
        // Script does not exist
        echo "Script does not exist";
        exit;
    }
}else{
    echo "Script id not provided";
    exit;
}

require "ide.php";
?>