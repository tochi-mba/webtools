<?php
require "../../../head.php";
$hostLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

if($hostLink!=$website){
    exit;
}

?>