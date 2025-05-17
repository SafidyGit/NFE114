<?php
require_once './config/database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function add($username, $email, $hashedPassword, $role_id) {
        $sql = "INSERT INTO user (username, user_email, password, role_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$username, $email, $hashedPassword, $role_id]);
    }

    public function findByEmail($email){
        $sql = "SELECT * FROM user WHERE user_email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>