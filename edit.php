<?php
session_start();
require_once __DIR__ . '/classes/Comment.php';

if (!isset($_SESSION['user_id'])) {
    die("⚠ Harus login untuk mengedit komentar!");
}

$commentObj = new Comment();
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) $_POST['id'];
    $message = $_POST['message'];

    if ($commentObj->update($id, $message, $user_id)) {
        header("Location: index.php");
        exit;
    } else {
        die("❌ Gagal update! Mungkin ini bukan komentar Anda.");
    }
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $comment = $commentObj->getById($id);

    if (!$comment || $comment['user_id'] != $user_id) {
        die("⚠ Komentar tidak ditemukan atau bukan milik Anda.");
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Komentar</title>
</head>
<body>
  <h2>Edit Komentar</h2>
  <form method="POST">
    <input type="hidden" name="id" value="<?= $comment['id'] ?>">
    <textarea name="message" required><?= htmlspecialchars($comment['message']) ?></textarea>
    <button type="submit">Simpan</button>
  </form>
</body>
</html>
