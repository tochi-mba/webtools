<?php
   session_start();
   // Unset all session variables
   $_SESSION = array();
   // Destroy the session
   session_destroy();
?>
<script>sessionStorage.clear();
window.location="login.php";</script>
<?
   
   exit;
?>