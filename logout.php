<?php
   session_start();
   // Unset all session variables
   $_SESSION = array();
   // Destroy the session
   session_destroy();
?>
<script>sessionStorage.clear();</script>
<?
   // Redirect to login page
   header("location: login.php");
   exit;
?>