<?php
require_once __DIR__ . '/../config/database.php';

class Role {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get_all_role()
    {
        $sql = "SELECT * FROM role ORDER BY role_id DESC";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>