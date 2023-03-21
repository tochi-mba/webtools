<?php

// Get the list of libraries
$libraries = explode(',', $_GET['libraries']);

// Clean the list of libraries to remove empty values
$libraries = array_filter($libraries);

// Initialize an array to store the contents of each library
$library_contents = array();

// Loop through each library
foreach ($libraries as $library) {
    // Get the contents of the library
    $contents = file_get_contents('../../libraries/' . $library . '.php');
    // Add the contents to the array
    $library_contents[] = $contents;
}

// Return the array of library contents
echo json_encode($library_contents);
?>