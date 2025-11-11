<?php
require 'config.php';
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit; }
require 'header.php';

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
        $stmt = $mysqli->prepare("INSERT INTO calibrations (device_name, serial_number, calibration_date, next_due_date, performed_by, notes) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $device, $serial, $cal_date, $next_due, $performed_by, $notes);
        $ok = $stmt->execute();
        if ($ok) {
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Gagal menyimpan: " . $stmt->error;
        }
    }
}
?>
<div class="card">
  <div class="card-header card-header-custom"><h5 class="mb-0">Tambah Rekaman Kalibrasi</h5></div>
  <div class="card-body">
    <?php if ($errors): ?>
      <div class="alert alert-danger">
        <?php foreach($errors as $e) echo "<div>".htmlspecialchars($e)."</div>"; ?>
      </div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Nama Perangkat</label>
        <input name="device_name" class="form-control" required value="<?= htmlspecialchars($_POST['device_name'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Serial Number</label>
        <input name="serial_number" class="form-control" value="<?= htmlspecialchars($_POST['serial_number'] ?? '') ?>">
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Tanggal Kalibrasi</label>
          <input type="date" name="calibration_date" class="form-control" required value="<?= htmlspecialchars($_POST['calibration_date'] ?? '') ?>">
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Next Due Date</label>
          <input type="date" name="next_due_date" class="form-control" value="<?= htmlspecialchars($_POST['next_due_date'] ?? '') ?>">
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Dilakukan Oleh</label>
        <input name="performed_by" class="form-control" value="<?= htmlspecialchars($_POST['performed_by'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Catatan</label>
        <textarea name="notes" class="form-control"><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
      </div>
      <button class="btn btn-primary">Simpan</button>
      <a class="btn btn-secondary" href="index.php">Batal</a>
    </form>
  </div>
</div>
<?php require 'footer.php'; ?>
