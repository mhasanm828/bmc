<?php
$start = isset($_GET['startRoll']) ? intval($_GET['startRoll']) : 0;
$count = isset($_GET['count']) ? intval($_GET['count']) : 0;

echo '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>NU Result Batch</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h4 class="mb-4">Showing Results from Roll: ' . $start . ' to ' . ($start + $count - 1) . '</h4>';

for ($i = 0; $i < $count; $i++) {
  $roll = $start + $i;

  // Init cURL
  $cookie_file = tempnam(sys_get_temp_dir(), "COOKIE_$roll");
  $ch = curl_init();

  // Get session from form
  curl_setopt($ch, CURLOPT_URL, "http://app5.nu.edu.bd/nu-web/admissionTestResultQueryForm");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
  curl_exec($ch);

  // Post roll to get result
  curl_setopt($ch, CURLOPT_URL, "http://app5.nu.edu.bd/nu-web/fetchAdmissionTestResultInformation");
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, "admissionRoll={$roll}");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "X-Requested-With: XMLHttpRequest",
      "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
      "Origin: http://app5.nu.edu.bd",
      "Referer: http://app5.nu.edu.bd/nu-web/admissionTestResultQueryForm",
      "User-Agent: Mozilla/5.0"
  ]);

  $response = curl_exec($ch);
  curl_close($ch);

  echo '
  <div class="card mb-4 shadow-sm">
    <div class="card-header fw-bold">Roll: ' . $roll . '</div>
    <div class="card-body">
      <table class="table table-bordered">
        <tr><td>' . $response . '</td></tr>
      </table>
    </div>
  </div>';
}

echo '</div></body></html>';
?>