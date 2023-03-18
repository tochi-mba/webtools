<?php
// Connect to the database
$host = "localhost";
$user = "root";
$pass = "boobz";
$dbname = "webtools";

$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
