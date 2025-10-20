<?php
require_once "classes/Comment.php";
$commentObj = new Comment();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $commentObj->$conn->query("SELECT * FROM comments WHERE id=$id");
    $data = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $message = $_POST['message'];

    if ($commentObj->update($id, $name, $message)) {
        echo "<script>alert('Ucapan berhasil diupdate!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal update!'); window.location='index.php';</script>";
    }
}
?>

<form method="POST">
  <input type="hidden" name="id" value="<?= $data['id']; ?>">
  <input type="text" name="name" value="<?= $data['name']; ?>" required>
  <textarea name="message" required><?= $data['message']; ?></textarea>
  <button type="submit">Update</button>
</form>
