<?php 

require "head.php"; 
require "is_logged.php";
require "connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 
    function delete_folder($folder) {
        if(!is_dir($folder)) {
            return false;
        }
        $files = glob($folder.'/*');
        foreach($files as $file) {
            if(is_dir($file)) {
                delete_folder($file);
            } else {
                unlink($file);
            }
        }
        rmdir($folder);
        return true;
    }
    
    if (isset($_POST["script_id"])) {
       // delete the sql row
       // setup the sql query variables
       $uid = $_SESSION["uid"];
       $script_id = $_POST["script_id"];
        
       // Execute query to delete row from database
       $sql = "DELETE FROM scripts WHERE uid='$uid' AND script_id='$script_id'";
       $result = mysqli_query($conn,$sql);
        
       // Check if file exists
       if (file_exists("./scripts/$uid/$script_id")) {
           // Delete the file
           delete_folder("./scripts/$uid/$script_id");
       }
        
       // Check if query was successful
       if ($result) {
           // Redirect and pass success variable
           ?>
           <script>
               window.location = 'scripts.php?delete=1&id="<?php echo $script_id ?>"&name="<?php echo $_POST["name"]?>"';
           </script>
           <?php
       }
        
    }
    
?>
</body>
</html>