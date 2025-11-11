<?php
require 'config.php';
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit; }
require 'header.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) { header("Location: index.php"); exit; }

$stmt = $mysqli->prepare("SELECT * FROM calibrations WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$record = $res->fetch_assoc();
if (!$record) {
    echo "<div class='alert alert-warning'>Data tidak ditemukan.</div>";
    require 'footer.php';
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $device = trim($_POST['device_name'] ?? '');
    $serial = trim($_POST['serial_number'] ?? '');
    $cal_date = trim($_POST['calibration_date'] ?? '');
    $next_due = trim($_POST['next_due_date'] ?? '') ?: null;
    $performed_by = trim($_POST['performed_by'] ?? '');
    $notes = trim($_POST['notes'] ?? '');

    if ($device === '') $errors[] = "Nama perangkat diperlukan.";
    if ($cal_date === '') $errors[] = "Tanggal kalibrasi diperlukan.";

    if (!$errors) {
        $u = $mysqli->prepare("UPDATE calibrations SET device_name=?, serial_number=?, calibration_date=?, next_due_date=?, performed_by=?, notes=? WHERE id=?");
        $u->bind_param("ssssssi", $device, $serial, $cal_date, $next_due, $performed_by, $notes, $id);
        if ($u->execute()) {
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Gagal update: " . $u->error;
        }
    }
}
?>
<div class="card">
  <div class="card-header card-header-custom"><h5 class="mb-0">Edit Rekaman</h5></div>
  <div class="card-body">
    <?php if ($errors): ?>
      <div class="alert alert-danger">
        <?php foreach($errors as $e) echo "<div>".htmlspecialchars($e)."</div>"; ?>
      </div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Nama Perangkat</label>
        <input name="device_name" class="form-control" required value="<?= htmlspecialchars($_POST['device_name'] ?? $record['device_name']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Serial Number</label>
        <input name="serial_number" class="form-control" value="<?= htmlspecialchars($_POST['serial_number'] ?? $record['serial_number']) ?>">
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Tanggal Kalibrasi</label>
          <input type="date" name="calibration_date" class="form-control" required value="<?= htmlspecialchars($_POST['calibration_date'] ?? $record['calibration_date']) ?>">
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Next Due Date</label>
          <input type="date" name="next_due_date" class="form-control" value="<?= htmlspecialchars($_POST['next_due_date'] ?? $record['next_due_date']) ?>">
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Dilakukan Oleh</label>
        <input name="performed_by" class="form-control" value="<?= htmlspecialchars($_POST['performed_by'] ?? $record['performed_by']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Catatan</label>
        <textarea name="notes" class="form-control"><?= htmlspecialchars($_POST['notes'] ?? $record['notes']) ?></textarea>
      </div>
      <button class="btn btn-primary">Update</button>
      <a class="btn btn-secondary" href="index.php">Batal</a>
    </form>
  </div>
</div>
<?php require 'footer.php'; ?>
