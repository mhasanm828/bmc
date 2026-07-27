<?php
// API endpoint to fetch PIN info
$url = "http://app55.nu.edu.bd/nu-web/fetchPinInformation";

// Example input data (can be replaced by $_POST or input from frontend)
$data = [
    'hscRoll' => '237023',
    'hscPassingYear' => '2024',
    'hscBoardId' => '15',
    'birthDate' => '01-02-2007',
    'degreeName' => 'Honours'
];

// Prepare POST fields as a query string
$postFields = http_build_query($data);

// Initialize cURL session
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
    'X-Requested-With: XMLHttpRequest'
]);

// Execute the request
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'Request Error: ' . curl_error($ch);
} else {
    echo $response; // Return the NU response
}

// Close cURL session
curl_close($ch);
?>