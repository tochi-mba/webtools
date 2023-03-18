<?php

// Check if the user is logged in using a session
if (!$_SESSION["uid"])
{
    // User is not logged in, so redirect them to the login page
    header("location: login.php");
    die();
}

?>