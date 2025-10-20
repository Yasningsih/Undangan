<?php
require_once "classes/User.php";
$userObj = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $newPass = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($newPass !== $confirm) {
        echo "<script>alert('Password tidak sama!');</script>";
    } else {
        if ($userObj->resetPassword($email, $newPass)) {
            echo "<script>alert('Password berhasil direset! Silakan login.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Email tidak ditemukan!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lupa Password</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="form-container">
    <h1>Reset Password</h1>
    <form method="POST">
      <input type="email" name="email" placeholder="Masukkan email Anda" required>
      <input type="password" name="new_password" placeholder="Password baru" required>
      <input type="password" name="confirm_password" placeholder="Konfirmasi password" required>
      <button type="submit">Reset Password</button>
    </form>
    <p><a href="login.php">Kembali ke Login</a></p>
  </div>
</body>
</html>
