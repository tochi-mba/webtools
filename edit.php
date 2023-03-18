<?php require "head.php";
require "is_logged.php";
require "connect.php";
?>
<!DOCTYPE html>
<html>
<head>
        <title>Code Editor for JavaScript</title>
        <meta charset="utf-8" />
        <style>
            body{
                background: rgb(30,31,31);
            }
        </style>
    </head>
    <body>
        <?php 
        require "navbar.php";
        if(isset($_POST['script'],$_POST['script_id'])){
            $uid=$_SESSION["uid"];
            $script_id=$_POST['script_id'];
            //query the database
            $sql = "SELECT scripts FROM `users` WHERE `uid`='$uid'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    $script_ids = explode(",",$row["scripts"]);
                    if (in_array($script_id, $script_ids)) {
                        $filename="./scripts/" . $_SESSION['uid'] . "/" . $_POST['script_id'] . ".js";
                        if (file_exists($filename)) {
                            $data=$_POST['script'];
                            $file = fopen($filename, 'w');
                            fwrite($file, $data);
                            fclose($file);
                        }
                    } 
                }
            }
            
            
        }
        ?>
        <div class="container" style="width: 60%; margin: 0 auto;">
            <div class="title-bar" style="text-align: center;">
                <h1>Code Editor for JavaScript</h1>
            </div>
            <div class="editor" style="display: flex; justify-content: center;">
                <form method="post" action="">
                    <input type="hidden" value="<?php echo $_GET['script_id'];?>" name="script_id">
                    <textarea style="font-family: 'Roboto Mono', monospace;  height: 400px;width: 400px;" name="script" id="script" placeholder="Type your JavaScript code here...">
                        <?php
                        if (isset($_GET['script_id']) && $_SESSION['uid']) {
                            $uid=$_SESSION["uid"];
                            $script_id=$_GET['script_id'];
                            //query the database
                            $sql = "SELECT scripts FROM `users` WHERE `uid`='$uid'";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                    $script_ids = explode(",",$row["scripts"]);
                                    if (in_array($script_id, $script_ids)) {
                                        $filename="./scripts/" . $_SESSION['uid'] . "/" . $_GET['script_id'] . ".js";
                                        if (!file_exists($filename)) {
                                            header("location: index.php");

                                        }else{
                                            echo file_get_contents("./scripts/" . $_SESSION['uid'] . "/" . $_GET['script_id'] . ".js");
                                        }
                                    }else{
                                        header("location: index.php");
                                    }
                                }
                            }
                        }
                        ?>
                    </textarea>
                    <button type="submit">Save</button>
                </form>
                <script src="codemirror/lib/codemirror.js"></script>
                <link rel="stylesheet" href="codemirror/lib/codemirror.css" />
                <script src="codemirror/mode/javascript/javascript.js"></script>
                <link rel="stylesheet" href="codemirror/theme/dracula.css" />
                <script>
                    var editor = CodeMirror.fromTextArea(document.getElementById("script"), {
                        lineNumbers: true,
                        mode: "javascript",
                        theme: "dracula"
                    });
                </script>
            </div>
        </div>
    </body>
</html>