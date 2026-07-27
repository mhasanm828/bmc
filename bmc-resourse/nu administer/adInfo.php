<?php
// Accept admissionRoll via GET
if (!isset($_GET['admissionRoll'])) {
    echo json_encode(['error' => 'Missing admissionRoll']);
    exit;
}

$admissionRoll = $_GET['admissionRoll'];

// Define both NU endpoints
$urls = [
    "http://app55.nu.edu.bd/nu-web/fetchAdmitCardInformation",
    "http://app2.nu.edu.bd/nu-web/fetchAdmitCardInformation"
];

// Prepare POST fields
$data = ['admissionRoll' => $admissionRoll];
$postFields = http_build_query($data);

$response = null;

// Try both endpoints
foreach ($urls as $url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
        'X-Requested-With: XMLHttpRequest'
    ]);

    $response = curl_exec($ch);

    if (!curl_errno($ch) && !empty($response)) {
        curl_close($ch);
        echo $response; // Success
        exit;
    }

    curl_close($ch);
}

// If both fail
echo json_encode(['error' => 'Failed to fetch data from both NU servers']);
?>