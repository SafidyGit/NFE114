<?php

require_once __DIR__ . '/../config/database.php';

class Category
{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get_all_category()
    {
        $sql = "SELECT * FROM category ORDER BY category_id DESC";
        $stmt = $this->db->query($sql);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    }

    public function getById($category_id)
    {
        $sql = "SELECT * FROM category WHERE category_id = :category_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['category_id' => $category_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add_category($category) {
        $sql = "INSERT INTO category (category) VALUES (:category)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':category' => $category]);
    }

    public function update_category($category_id , $category) {
        $sql = "UPDATE category SET category = :category WHERE category_id = :category_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':category' => $category, 
            ':category_id' => $category_id
        ]);
    }

    public function delete_category($category_id) {
        $sql = "DELETE FROM category WHERE category_id = :category_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':category_id' => $category_id]);
    }

}

?>

