<?php
session_start();
require_once __DIR__ . '/classes/Comment.php';

if (!isset($_SESSION['user_id'])) {
    die("⚠ Harus login untuk memberi ucapan!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'] ?? '';
    $user_id = $_SESSION['user_id'];

    $commentObj = new Comment();
    if ($commentObj->create($message, $user_id)) {
        header("Location: index.php");
        exit;
    } else {
        die("❌ Gagal menambahkan komentar");
    }

    
}
