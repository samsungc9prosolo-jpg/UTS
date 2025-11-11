<?php
require 'config.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
require 'header.php';

$sql = "SELECT * FROM calibrations ORDER BY calibration_date DESC";
$result = $mysqli->query($sql);
?>
<div class="card mb-4">
  <div class="card-header card-header-custom">
    <h5 class="mb-0">Daftar Kalibrasi</h5>
  </div>
  <div class="card-body">
    <div class="mb-3">
      <a class="btn btn-success" href="create.php">Tambah Rekaman</a>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead class="table-custom">
          <tr>
            <th>#</th>
            <th>Perangkat</th>
            <th>Serial</th>
            <th>Tgl Kalibrasi</th>
            <th>Next Due</th>
            <th>Teknisi</th>
            <th>Catatan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows>0):
            $i=1;
            while($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($row['device_name']) ?></td>
                <td><?= htmlspecialchars($row['serial_number']) ?></td>
                <td><?= htmlspecialchars($row['calibration_date']) ?></td>
                <td><?= htmlspecialchars($row['next_due_date']) ?></td>
                <td><?= htmlspecialchars($row['performed_by']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['notes'])) ?></td>
                <td>
                  <a class="btn btn-sm btn-info" href="view.php?id=<?= $row['id'] ?>">Detail</a>
                  <a class="btn btn-sm btn-primary" href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                  <a class="btn btn-sm btn-danger" href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus rekaman ini?')">Hapus</a>
                </td>
              </tr>
            <?php endwhile;
           else: ?>
            <tr><td colspan="8" class="text-center">Belum ada data.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require 'footer.php'; ?>
