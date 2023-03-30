<?php

$file_name = '../../../spam_detection/spam.txt';

// Read the contents of the file
$contents = file_get_contents($file_name);

// Decode the JSON object
$data1 = json_decode($contents, true);

// Check if the object has more than 100 keys
if (count($data1) > 100) {
    // Delete the object and make the file empty
    file_put_contents($file_name, '');
}
$api_token = $data["api_token"];

// Check if the API token is empty
if (empty($api_token)) {
    // If the API token is empty, return an error
    echo json_encode([
        "success" => false,
        "message" => "API token is required"
    ]);
    die();
}

$max_requests_per_second = 20;

// Get the api_token request header

// Check if the api_token is stored in a text file
$file_content = file_get_contents($file_name);
$dataSpam = json_decode($file_content, true);

// If the api_token exsits 
if (isset($dataSpam[$api_token])) {
	// Check if the last request time is within 1 second
	$time_elapsed = time() - $dataSpam[$api_token]['last_request_time'];

	if ($time_elapsed > 1) {
		// reset the number of requests
		$dataSpam[$api_token]['num_requests'] = 0;
	}
	
	// Increase the number of requests
	$dataSpam[$api_token]['num_requests'] += 1;
	
	// Check if the number of requests is over the limit
	if ($dataSpam[$api_token]['num_requests'] > $max_requests_per_second) {
        echo json_encode([
            "success" => false,
            "message" => "Too many requests"
        ]);
        die();
	} 
	
	// Set the new last request time
	$dataSpam[$api_token]['last_request_time'] = time();
	
	// Save the dataSpam
	file_put_contents($file_name, json_encode($dataSpam));
} else {
	// Add the new api_token to the text file
	$dataSpam[$api_token] = ['last_request_time' => time(), 'num_requests' => 0];
	file_put_contents($file_name, json_encode($dataSpam));
}

// Enter desired code here
// ...
?>