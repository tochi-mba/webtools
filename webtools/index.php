<?php
$user_ip = $_SERVER['REMOTE_ADDR'];

if(empty($user_ip)) {
    die('No IP address detected');
}

$timestamp = gmdate('Y-m-d H:i:s');

if(isset($_SESSION['user_ip'])) {
    $user_ip_data = $_SESSION['user_ip'];
    if($user_ip_data['user_ip'] == $user_ip) {
        if($timestamp - $user_ip_data['timestamp'] < 10) {
            die('Too many requests in a short period of time');
        }
        $user_ip_data['count']++;
        if($user_ip_data['count'] > 2) {
            die('Too many requests in a short period of time');
        }
    }
}

$_SESSION['user_ip'] = array('user_ip' => $user_ip, 'timestamp' => $timestamp, 'count' => 1);

header("location: ../scripts/".$_GET["u"]."/".$_GET["id"].".js");


?>