<?php
require 'config.php';
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit; }

$id = intval($_GET['id'] ?? 0);
if ($id>0) {
    $stmt = $mysqli->prepare("DELETE FROM calibrations WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: index.php");
exit;
