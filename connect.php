<?php
// Connect to the database
$host = "localhost";
$user = "id20471517_webtools_user";
$pass = "vmaVMb.289+z2KA";
$dbname = "id20471517_webtools";

$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
