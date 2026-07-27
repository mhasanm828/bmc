<?php
$results = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start = intval($_POST['startRoll']);
    $count = intval($_POST['count']);

    for ($i = 0; $i < $count; $i++) {
        $roll = $start + $i;
        $cookie_file = tempnam(sys_get_temp_dir(), "COOKIE_$roll");
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://app5.nu.edu.bd/nu-web/admissionTestResultQueryForm");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        curl_exec($ch);

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

        $results[] = [
            'roll' => $roll,
            'result' => strip_tags($response)
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>NU Result to CSV</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- DataTables -->
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h5 class="mb-4">🎓 NU Result Export (CSV Only)</h5>

  <form method="POST" class="row g-3 mb-4">
    <div class="col-md-4">
      <input type="number" name="startRoll" class="form-control" placeholder="Starting Roll" required>
    </div>
    <div class="col-md-4">
      <input type="number" name="count" class="form-control" placeholder="How many results?" required>
    </div>
    <div class="col-md-4">
      <button type="submit" class="btn btn-success w-100">Fetch Results</button>
    </div>
  </form>

<?php if (!empty($results)): ?>
  <div class="table-responsive">
    <table id="resultTable" class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>Roll</th>
          <th>Result Info</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($results as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['roll']) ?></td>
          <td><?= htmlspecialchars($row['result']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<script>
  $(document).ready(function () {
    $('#resultTable').DataTable({
      dom: 'Bfrtip',
      buttons: ['csv'] // Only CSV
    });
  });
</script>
</body>
</html>