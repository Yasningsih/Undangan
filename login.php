<?php
session_start();
require_once __DIR__ . '/classes/User.php';

$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $loggedIn = $user->login($email, $password);
if ($loggedIn) {
    // simpan user_id dan email ke session
    $_SESSION['user_id'] = $loggedIn['id'];
    $_SESSION['email']   = $loggedIn['email'];
    
    header("Location: index.php");
    exit;
} else {
    $error = "Email atau password salah.";
}

}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h2>Login</h2>
  <?php if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>
  <form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
  <p>Belum punya akun? <a href="register.php">Daftar</a></p>
  <p><a href="forgot.php">Lupa password?</a></p>

</div>
</body>
</html>
