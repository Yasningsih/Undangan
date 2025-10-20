<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

?>

<?php
require_once __DIR__ . '/classes/Comment.php';
$comment = new Comment();
$comments = $comment->getAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Undangan Mepandes</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Musik -->
<div class="music-player">
  <audio autoplay loop controls>
    <source src="assets/lagu.mp3" type="audio/mpeg">
  </audio>
</div>

<div class="overlay"></div>
<div class="container">
  <h1>Om Swastyastu</h1>
  <p>Dengan penuh rasa syukur ke hadapan Ida Sang Hyang Widhi Wasa/Tuhan Yang Maha Esa,
     kami sekeluarga memohon doa restu serta kehadiran Bapak/Ibu/Saudara/i pada upacara
     Mepandes (Metatah/Mapandes) putri kami.</p>
  <p>Putri dari pasangan penuh kasih</p>
  <h3>Bapak I Wayan Suparta & Ibu Ni Made Oka Suartini.</h3>
  <p>Atas kehadiran serta doa restu Bapak/Ibu/Saudara/i, kami sekeluarga mengucapkan terima kasih.</p>
  <h3>Om Shanti Shanti Shanti Om</h3>

  <!-- Pemilik -->
  <div class="owners">
    <div class="owner">
      <img src="assets/owner1.jpg" alt="Owner 1">
      <h3>Ni Luh Gede Yasningsih</h3>
    </div>
    <div class="owner">
      <img src="assets/owner2.jpg" alt="Owner 2">
      <h3>Ni Made Murdani</h3>
    </div>
  </div>

  <!-- Info Acara -->
  <p><b>Tanggal : 12 November 2025</b></p>
  <p><b>Lokasi : Jalan Arjuna 1, no.88, Sading, Mengwi, Badung, Bali</b></p>

  <!-- Maps -->
  <h2>Lokasi Acara</h2>
<div class="maps">
  <iframe 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.199166081234!2d115.17890101533495!3d-8.58873478994356!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd22fe0c1234567%3A0xabcdef123456789!2sJalan%20Arjuna%201%2C%20Sading%2C%20Mengwi%2C%20Badung%2C%20Bali!5e0!3m2!1sid!2sid!4v1696077151234!5m2!1sid!2sid"
    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
  </iframe>
</div>

<!-- Logout -->
<h3>
  Halo, <?= htmlspecialchars($_SESSION['email']) ?> | 
  <a href="logout.php" style="color:red; font-weight:bold;">Logout</a>
</h3>


  <!-- Form Ucapan -->
<h2>Kirim Ucapan</h2>
<form action="insert.php" method="POST">
  <textarea name="message" placeholder="Tulis ucapan..." required></textarea>
  <button type="submit">💌 Kirim Ucapan</button>
</form>

  <!-- List Ucapan -->
<h2>Ucapan yang sudah masuk</h2>
<div class="comments">
<?php
// pastikan session sudah dimulai di atas file ini
if (!isset($_SESSION)) session_start();

// pastikan $comments sudah dibuat lebih atas, misal:
// $comment = new Comment();
// $comments = $comment->getAll();

// safety: jika belum ada, set jadi array kosong agar foreach aman
if (!isset($comments) || !is_array($comments)) {
    $comments = [];
}


if (!empty($comments)): 
    foreach ($comments as $c):
        // guard: pastikan $c adalah array dan punya key yg diperlukan
        if (!is_array($c)) continue;
        $displayName = htmlspecialchars($c['user_name'] ?? $c['name'] ?? 'Guest');
        $message = nl2br(htmlspecialchars($c['message'] ?? ''));
        $created = htmlspecialchars($c['created_at'] ?? '');
        $commentId = isset($c['id']) ? (int)$c['id'] : 0;
        $commentUserId = isset($c['user_id']) ? (int)$c['user_id'] : null;
?>


  <div class="comment">
    <b><?= $displayName ?></b>
    <p><?= $message ?></p>
    <small><?= $created ?></small>

    <?php
    // tampilkan tombol hanya bila user login & pemilik komentar
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $commentUserId): ?>
      <div>
        <a href="edit.php?id=<?= $commentId ?>">✏️ Edit</a>
        <a href="delete.php?id=<?= $commentId ?>" onclick="return confirm('Yakin hapus?')">🗑️ Hapus</a>
      </div>
    <?php endif; ?>
  </div>
<?php
    endforeach;
else: ?>
  <p>Belum ada ucapan, jadilah yang pertama!</p>
<?php endif; ?>
</div>


</div>
</body>
</html>
