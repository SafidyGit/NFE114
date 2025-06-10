<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get_all_user()
    {
        $sql = "SELECT user.user_id, user.username, user.user_email, user.role_id, role.role FROM user 
                JOIN role ON user.role_id = role.role_id";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($username, $email, $hashedPassword, $role_id) {
        $sql = "INSERT INTO user (username, user_email, password, role_id) VALUES (:username, :user_email, :password, :role_id)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':username' => $username, 
            ':email' => $email, 
            ':password' => $hashedPassword, 
            ':role_id' => $role_id
        ]);
    }

    public function findByEmail($email){
        $sql = "SELECT * FROM user WHERE user_email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }





}
?>