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

        public function getById($user_id)
    {
        $sql = "SELECT * FROM user WHERE user_id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add_user($username, $email, $hashedPassword, $role_id) 
    {
        $sql = "INSERT INTO user (username, user_email, password, role_id) VALUES (:username, :user_email, :password, :role_id)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':username' => $username, 
            ':user_email' => $email, 
            ':password' => $hashedPassword, 
            ':role_id' => $role_id
        ]);
    }


    public function update_user($user_id, $username, $email, $hashedPassword, $role_id) 
    {
        $sql = "UPDATE user SET username = :username, user_email = :user_email, password = :password, role_id = :role_id WHERE user_id = :user_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':username' => $username, 
            ':user_email' => $email,
            ':password' => $hashedPassword,
            ':role_id' => $role_id,
            ':user_id' => $user_id,
        ]);
    }

    public function findByEmail($email){
        $sql = "SELECT * FROM user WHERE user_email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function delete_user($user_id) 
    {
        $sql = "DELETE FROM user WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':user_id' => $user_id]);
    }


}
?>