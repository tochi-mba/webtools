

<?php
session_start();
require "../../../connect.php"; 

function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  
if (isset($_POST['update'])&&$_POST['update']==true) {
   
    foreach ($_POST as $key => $value) {
        $_POST[$key] = validateInput($value);
    }
    $data  = $_POST;
    $error_message = "";

    //If required fields are empty
    if (empty($data['first_name']) || empty($data['last_name']) || empty($data['username'])) {
        $error_message = "Please fill in the required fields";
    }
    
    //validate input
    
    //only check if there is no error message
    if (strlen($error_message) == 0) {
    //insert user info into the database
    $uid = $_SESSION['uid'];
    $api_token = $data['api_token_hidden'] === '1' ? generateApiToken() : $data['api_token'];
    $sql = "UPDATE `users` SET `api_token`='$api_token', `first_name`='{$data['first_name']}', `last_name`='{$data['last_name']}', `username`='{$data['username']}' WHERE `uid`='$uid';";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['username'] = $data['username'];
        $_SESSION['api_token'] = $api_token;
        ?>
        <script>
            sessionStorage.setItem('username','<?php echo $_SESSION['username']?>');
            sessionStorage.setItem('api_token','<?php echo $_SESSION['api_token']?>');
        </script>
        <?php
         $sql = "SELECT * FROM users WHERE uid='$uid'";
         $result = $conn->query($sql);
         
         if ($result->num_rows > 0) {
             $row = $result->fetch_assoc();
             $firstname=$row['first_name'];
             $lastname=$row['last_name'];
             $username=$row['username'];
             $api_token=$row['api_token'];
         } 
         echo json_encode(
                array(
                    "status" => "success",
                    "message" => "User information updated successfully",
                    "data" => array(
                        "first_name" => $firstname,
                        "last_name" => $lastname,
                        "username" => $username,
                        "api_token" => $api_token
                    )
                )
            );
         
    } else {
        }
    }
}

function generateApiToken() {
    require "../../../connect.php"; 

    // Generate a random token
    $api_token = bin2hex(random_bytes(16));
    
    //Query the DB to check if the token already exists
    $query = "SELECT * FROM users WHERE api_token=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $api_token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    //If the token already exists, generate another one
    if(mysqli_num_rows($result) > 0) {
        generateApiToken();
    }
    
    return $api_token;
}
?>