


<?php

function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}


$user_ip = getUserIP();
if(empty($user_ip)) {
    die('No IP address detected');
}

$timestamp = gmdate('Y-m-d H:i:s');

if(isset($_SESSION['user_ip'])) {
    $user_ip_data = $_SESSION['user_ip'];
    if($user_ip_data['user_ip'] == $user_ip) {
        if($timestamp - $user_ip_data['timestamp'] < 1) {
            die('Too many requests in a short period of time');
        }
        $user_ip_data['count']++;
        if($user_ip_data['count'] > 20) {
            die('Too many requests in a short period of time');
        }
    }
}else{
    $_SESSION['user_ip'] = array('user_ip' => $user_ip, 'timestamp' => $timestamp, 'count' => 1);

}


// Your code here

?>