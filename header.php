<?php
// header.php
// Pastikan file ini di-include setelah require 'config.php';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Aplikasi Kalibrasi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container d-flex justify-content-between">
    <a class="navbar-brand" href="index.php">Kalibrasi</a>
    <div>
      <?php if(isset($_SESSION['user'])): ?>
        <span class="text-white me-2">👤 <?= htmlspecialchars($_SESSION['user']['fullname'] ?: $_SESSION['user']['username']) ?></span>
        <a class="btn btn-light btn-sm me-2" href="create.php">+ Tambah</a>
        <a class="btn btn-outline-light btn-sm" href="logout.php">Logout</a>
      <?php else: ?>
        <a class="btn btn-light btn-sm" href="login.php">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container">
