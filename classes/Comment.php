<?php
require_once __DIR__ . '/Database.php';

class Comment {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getAll() {
    $sql = "SELECT c.id, c.message, c.created_at, c.user_id, u.name AS user_name
            FROM comments c
            JOIN users u ON c.user_id = u.id
            ORDER BY c.created_at DESC";
    $result = $this->db->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

 

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM comments WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($message, $user_id) {
        $stmt = $this->db->prepare("INSERT INTO comments (message, user_id) VALUES (?, ?)");
        $stmt->bind_param("si", $message, $user_id);
        return $stmt->execute();
    }

    public function update($id, $message, $user_id) {
        // cek apakah komentar ini milik user
        $stmt = $this->db->prepare("SELECT user_id FROM comments WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();

        if ($res && $res['user_id'] == $user_id) {
            $stmt = $this->db->prepare("UPDATE comments SET message=? WHERE id=? AND user_id=?");
            $stmt->bind_param("sii", $message, $id, $user_id);
            return $stmt->execute();
        }
        return false; // bukan pemilik
    }

   public function delete($id, $user_id) {
    $stmt = $this->db->prepare("DELETE FROM comments WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    return $stmt->execute();
}

}
