<?php
session_start();
require_once __DIR__ . '/classes/Comment.php';

if (!isset($_SESSION['user_id'])) {
    die("⚠ Harus login untuk menghapus komentar!");
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $commentObj = new Comment();
    if ($commentObj->delete($id, $user_id)) {
        header("Location: index.php");
        exit;
    } else {
        die("❌ Gagal menghapus! Mungkin ini bukan komentar Anda.");
    }
}
