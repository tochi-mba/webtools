<?php
// Connect to the database
$host = "sql200.epizy.com";
$user = "epiz_33825562";
$pass = "MQiLFxQZcafpB1h";
$dbname = "epiz_33825562_webtools";

$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
