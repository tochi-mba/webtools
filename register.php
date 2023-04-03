<?php require "head.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="style.css" rel="stylesheet"/>
    <script src="script.js"></script>
</head>
<body>
    
<?php
    require "connect.php";
    require "navbar.php";
    if(isset($_POST['username'],$_POST['firstname'],$_POST['lastname'],$_POST['password'])){
        function generate_uid()
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $uid = '';
            for ($i = 0; $i < 8; $i++) {
                $uid .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $uid;
        }

        
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

        //Check that all fields have data
        if (!empty($_POST['username']) && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['password'])) 
        {
        // Check that the username is valid
        if (preg_match('/^[\w_\.\-]+$/', $_POST['username'])) 
        {
        // Check that the first name is valid
            if (preg_match('/^[a-zA-Z\-]+$/', $_POST['firstname'])) 
            {
        // Check that the last name is valid
            if (preg_match('/^[a-zA-Z\-]+$/', $_POST['lastname'])) 
            {
        // Check that the password is valid
                if (strlen($_POST['password']) >= 8) 
                {
                    
                    $uid=generate_uid();
                    $uid_exists = true;
                    while($uid_exists){
                        $uid=generate_uid();
                        $sql = "SELECT `uid` FROM users WHERE uid='$uid'";
                        $result = mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result) == 0){
                            $uid_exists = false;
                        }
                    }
                    // Escape user inputs for security
                    $username = $_POST['username'];
                    $firstname = $_POST['firstname'];
                    $lastname = $_POST['lastname'];
                    $password = $_POST['password'];
                    // Hash the password
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    // Insert into database
                    $current_timestamp = gmdate("Y-m-d H:i:s", time());
                    $api_token=generateApiToken();

                    $defaultFile = "./test_suite/default.php";
                    $newFile = "./test_suite/users/$uid.php";
                    if(file_exists($defaultFile)){
                        $defaultFileContent = file_get_contents($defaultFile);
                        if(file_put_contents($newFile, $defaultFileContent)){
                            echo "New file created for user $uid in ./test_suite/";
                        } else {
                            echo "Error creating new test suite for user $uid";
                        }
                    } else {
                        echo "Default file not found";
                    }
                    $sql = "INSERT INTO `users` (`ID`, `uid`, `first_name`, `last_name`, `password`, `username`, `scripts`, `account_created`, `api_token`) VALUES (NULL, '$uid', '$firstname', '$lastname', '$password', '$username', '', '$current_timestamp', '$api_token');";
                    function generateRandomString($length) {
                        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $string = '';
                        for ($i = 0; $i < $length; $i++) {
                            $string .= $characters[rand(0, strlen($characters) - 1)];
                        }
                        return $string;
                    }
                    if ($conn->query($sql) === TRUE) {
                        echo "New record created successfully";
                        $scripts_id = generateRandomString(30);
                        $sql = "UPDATE users SET scripts_id = '".$scripts_id."' WHERE uid = '".$uid."' AND api_token = '".$api_token."'";
                        if (!mysqli_query($conn, $sql)){
                            echo json_encode([
                                "success" => false,
                                "message" => "Error: " . $sql . "<br>" . mysqli_error($conn)
                            ]);
                        }else{
                            // Create the directories
                            mkdir("./scripts/" . $uid . "_private/", 0700, true);
                            mkdir("./scripts/" . $uid . "_public/");
                            mkdir("./scripts/" . $uid . "_unlisted_".$scripts_id."/");
                            mkdir("./scripts/" . $uid . "_monetized_".$scripts_id."/",0700,true);

                            // Create an empty version.json file in each directory
                            file_put_contents("./scripts/" . $uid . "_private/manifest.json", "{}");
                            file_put_contents("./scripts/" . $uid . "_public/manifest.json", "{}");
                            file_put_contents("./scripts/" . $uid . "_unlisted_".$scripts_id."/manifest.json", "{}");
                            file_put_contents("./scripts/" . $uid . "_monetized_".$scripts_id."/manifest.json", "{}");

                        }
                       
                    } else {
                        echo "Error: " . $sql . "<br>" . $beconn->error;
                    }
                }
                else {
                    echo 'Password must be at least 8 characters.';
                }
            }
            else {
                echo 'Last name must be letters only.';
            }
            } 
            else {
            echo 'First name must be letters only.';
            }
        } 
        else {
            echo 'Username must be letters, numbers, underscores, and dashes only.';
        }
        } 
        else {
        echo 'Please fill out all fields.';
        }

    }
    ?>
    <div class="container">
            <h2>Registration</h2>
            <form action="register.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" placeholder="Enter your username" required/>
                <label for="firstname">First Name:</label>
                <input type="text" name="firstname" id="firstname" placeholder="Enter your first name" required/>
                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" id="lastname" placeholder="Enter your last name" required/>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required/>
                <input type="submit" value="Register" />
            </form>
        </div>
</body>
</html>