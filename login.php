<?php
require 'config.php';

// Jika sudah login, arahkan ke index
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
// menambah fitur login akun
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username && $password) {
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res->fetch_assoc();

        // Karena di db kita menyimpan SHA2(...,256), kita cocokkan menggunakan hash('sha256', ...)
        if ($user && hash('sha256', $password) === $user['password']) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'fullname' => $user['fullname']
            ];
            header("Location: index.php");
            exit;
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Silakan isi username dan password.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Kalibrasi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow p-4" style="width: 420px;">
    <h4 class="text-center mb-4 text-primary">Login Aplikasi Kalibrasi</h4>

    <?php if ($error): ?>
      <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required autofocus>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button class="btn btn-primary w-100">Login</button>
    </form>
    <div class="mt-3 small-muted text-center">Default: admin / admin123</div>
  </div>
</div>
</body>
</html>
