<?php
session_start();
require_once __DIR__ . '/classes/User.php';

$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($user->register($name, $email, $password)) {
        header("Location: login.php?success=1");
        exit;
    } else {
        $error = "Registrasi gagal, email sudah dipakai.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h2>Daftar Akun</h2>
  <?php if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>
  <form method="POST">
    <input type="text" name="name" placeholder="Nama" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
  </form>
  <p>Sudah punya akun? <a href="login.php">Login</a></p>
</div>
</body>
</html>
