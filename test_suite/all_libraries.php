<?php


$dir = "../libraries/"; 

// Open a directory, and read its contents
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      if (strpos($file, ".php")) {
        require "../libraries/".$file;
      }
    }
    closedir($dh);
  }
}

?>