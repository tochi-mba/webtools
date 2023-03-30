<?php 

function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  foreach ($_POST as $key => $value) {
    $_POST[$key] = validateInput($value);
}
?>