<?php
require 'config.php';
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit; }
require 'header.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) { header("Location: index.php"); exit; }

$stmt = $mysqli->prepare("SELECT * FROM calibrations WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
if (!$row) { echo "<div class='alert alert-warning'>Data tidak ditemukan.</div>"; require 'footer.php'; exit; }
?>
<div class="card">
  <div class="card-header card-header-custom"><h5 class="mb-0">Detail Kalibrasi</h5></div>
  <div class="card-body">
    <dl class="row">
      <dt class="col-sm-3">Perangkat</dt><dd class="col-sm-9"><?=htmlspecialchars($row['device_name'])?></dd>
      <dt class="col-sm-3">Serial</dt><dd class="col-sm-9"><?=htmlspecialchars($row['serial_number'])?></dd>
      <dt class="col-sm-3">Tanggal Kalibrasi</dt><dd class="col-sm-9"><?=htmlspecialchars($row['calibration_date'])?></dd>
      <dt class="col-sm-3">Next Due</dt><dd class="col-sm-9"><?=htmlspecialchars($row['next_due_date'])?></dd>
      <dt class="col-sm-3">Dilakukan Oleh</dt><dd class="col-sm-9"><?=htmlspecialchars($row['performed_by'])?></dd>
      <dt class="col-sm-3">Catatan</dt><dd class="col-sm-9"><?=nl2br(htmlspecialchars($row['notes']))?></dd>
    </dl>
    <a class="btn btn-secondary" href="index.php">Kembali</a>
  </div>
</div>
<?php require 'footer.php'; ?>
