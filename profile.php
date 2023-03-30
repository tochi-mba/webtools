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
if (isset($_POST['update'])) {
    

    $data=array(
                "first_name" => $_POST['first_name'],
                "last_name" => $_POST['last_name'],
                "username" => $_POST['username'],
                "api_token" => $_POST['api_token'],
                "update"  => true,
                "api_token_hidden" => "1"
    );
    $url=$website."/api/private/edit_user_info/";
    $response=CallAPI("POST",$url,$data);
    $response=json_decode($response,true);


    $_SESSION['username'] = $response['data']['username'];
    $_SESSION['api_token'] = $response['data']['api_token'];
    ?>
    <script>
        sessionStorage.setItem('username','<?php echo $_SESSION['username']?>');
        sessionStorage.setItem('api_token','<?php echo $_SESSION['api_token']?>');
    </script>
    <?php
    $url=$website."/api/private/get_user_info/";
    $data=array(
        "api_token" => $_SESSION['api_token'],
        "uid" => $_SESSION['uid']
    );
    $response=CallAPI("POST",$url,$data);
    $response=json_decode($response,true);
    $firstname=$response['first_name'];
    $lastname=$response['last_name'];
    $username=$response['username'];
    $api_token=$response['api_token'];
    ?>
    <script>
        window.location="./profile.php";
    </script>
    <?php
}else{
    
    $url=$website."/api/private/get_user_info/";
    $data=array(
        "api_token" => $_SESSION['api_token'],
        "uid" => $_SESSION['uid']
    );
    
    $response=CallAPI("POST",$url,$data);
    $response=json_decode($response,true);
    $firstname=$response['first_name'];
    $lastname=$response['last_name'];
    $username=$response['username'];
    $api_token=$response['api_token'];
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