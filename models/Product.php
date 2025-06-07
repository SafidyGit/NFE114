<?php

require_once __DIR__ . '/../config/database.php';

class Product
{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get_all_product()
    {
        $sql = "SELECT * FROM product JOIN supplier, category
                WHERE product.supplier_id = supplier.supplier_id AND product.category_id = category.category_id
                ORDER BY product_id DESC";

        $stmt = $this->db->query($sql);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    }

    public function getById($product_id)
    {
        $sql = "SELECT * FROM product WHERE product_id = :product_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['product_id' => $product_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add_product($product_reference, $product_name, $product_description, $product_quantity_stock, $product_alert_threshold, $product_unit_price, $supplier_id, $category_id) 
    {
        $sql = "INSERT INTO product (product_reference, product_name, product_description, product_quantity_stock, product_alert_threshold, product_unit_price, supplier_id, category_id) VALUES (:product_reference, :product_name, :product_description, :product_quantity_stock, :product_alert_threshold, :product_unit_price, :supplier_id, :category_id)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':product_reference' => $product_reference, 
            ':product_name' => $product_name, 
            ':product_description' => $product_description,
            ':product_quantity_stock' => $product_quantity_stock, 
            ':product_alert_threshold' => $product_alert_threshold,
            ':product_unit_price' => $product_unit_price, 
            ':supplier_id' => $supplier_id, 
            ':category_id' => $category_id
        ]);
    }

    public function update_product($product_id , $product_reference, $product_name, $product_description, $product_quantity_stock, $product_alert_threshold, $product_unit_price, $supplier_id, $category_id) 
    {
        $sql = "UPDATE product SET product_reference = :product_reference, product_name = :product_name, product_description = :product_description, product_quantity_stock = :product_quantity_stock, product_alert_threshold = :product_alert_threshold, product_unit_price = :product_unit_price, supplier_id = :supplier_id, category_id = :category_id WHERE product_id = :product_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':product_reference' => $product_reference, 
            ':product_name' => $product_name, 
            ':product_description' => $product_description,
            ':product_quantity_stock' => $product_quantity_stock, 
            ':product_alert_threshold' => $product_alert_threshold,
            ':product_unit_price' => $product_unit_price, 
            ':supplier_id' => $supplier_id, 
            ':category_id' => $category_id,
            ':product_id' => $product_id

        ]);
    }

    public function delete_product($product_id) 
    {
        $sql = "DELETE FROM product WHERE product_id = :product_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':product_id' => $product_id]);
    }

}

?>

