<?php
require "head.php"; 
require "is_logged.php";
require "connect.php"; 

function validateInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$error_message = "";

if (isset($_POST['update'])) {
    // retrieve the form data by using the element's name attributes value as key
    $firstname  = validateInput($_POST['first_name']);
    $lastname  = validateInput($_POST['last_name']);
    $username   = validateInput($_POST['username']);
    $api_token = validateInput($_POST['api_token']);
    $api_token_hidden=$_POST['api_token_hidden'];
    if ($api_token_hidden==="1") {
        function generateApiToken() {
            require "connect.php"; 

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
        $api_token = generateApiToken();
    }
    
    //If required fields are empty
    if (empty($firstname) || empty($lastname) || empty($username)) {
        $error_message = "Please fill in the required fields";
    }
    
    //validate input
    
    //only check if there is no error message
    if (strlen($error_message) == 0) {
    //insert user info into the database
    $uid = $_SESSION['uid'];
    $sql = "UPDATE `users` SET `api_token`='$api_token', `first_name`='$firstname', `last_name`='$lastname', `username`='$username' WHERE `uid`='$uid';";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['username'] = $username;
        $_SESSION['api_token'] = $api_token;
        ?>
        <script>
            sessionStorage.setItem('username','<?php echo $_SESSION['username']?>');
            sessionStorage.setItem('api_token','<?php echo $_SESSION['api_token']?>');
        </script>
        <?php
    } else {
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edit User Info</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    body{
        background-color: #1E1F1F;
    }
</style>
<body>
    
    <?php
    require "navbar.php";?>
    <div class="container">
        <form action="" id="formUpdate" method="post">
            <h1>Edit User Information</h1>
            <hr>
            <?php if (!empty($error_message)) { ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
            <?php }
            $uid=$_SESSION['uid'];
            $sql = "SELECT * FROM users WHERE uid='$uid'";
            $result = $conn->query($sql);
        
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $firstname=$row['first_name'];
                $lastname=$row['last_name'];
                $username=$row['username'];
                $api_token=$row['api_token'];
            } else {
                echo "Incorrect login details";
            }
            
            
            ?>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" value="<?php echo $firstname ?>" class="form-control" />
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" value="<?php echo $lastname ?>" class="form-control" />
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" value="<?php echo $username ?>" class="form-control" />
            </div>
            <div class="form-group">
                <label for="username">API Token:</label>
                <input type="hidden" id="api_token_hidden" value="0" name="api_token_hidden">
                <input readOnly type="text" name="api_token" value="<?php echo $api_token ?>" class="form-control" />
                <button onclick="newToken()" type="button">Generate</button>
            </div>  
            <div class="form-group">
                <button id="submit" type="submit" name="update" class="btn btn-success"><span>Update</span></button>
            </div>
           
        </form>
    </div>
    <script>
        function newToken() {
            document.getElementById("api_token_hidden").value="1";
            form=document.getElementById("submit");
            form.click();
        }
    </script>
</body>

</html>