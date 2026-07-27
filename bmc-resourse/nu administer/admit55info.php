<?php
// NU API endpoint
$url = "http://app5.nu.edu.bd/nu-web/fetchAdmitCardInformation";

// Sample input (replace with $_POST for dynamic data)
$data = [
    'admissionRoll' => '5112567'
];

// Convert data to x-www-form-urlencoded format
$postFields = http_build_query($data);

// Initialize cURL
$ch = curl_init($url);

// cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
    'X-Requested-With: XMLHttpRequest'
]);

// Execute request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    echo $response; // Return NU response
}

// Close session
curl_close($ch);
?>