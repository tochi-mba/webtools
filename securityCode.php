<?php
$uid1=$_SESSION['uid'];
$api_token1=$_SESSION['api_token'];
$sql = "SELECT scripts_id FROM users WHERE uid='$uid1' AND api_token = '$api_token1';";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$scripts_id = $row['scripts_id'];
?>