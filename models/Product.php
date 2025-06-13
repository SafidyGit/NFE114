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
        $sql = "SELECT * FROM product 
                JOIN supplier, category
                WHERE product.supplier_id = supplier.supplier_id 
                AND product.category_id = category.category_id
                ORDER BY product_id DESC";

        $stmt = $this->db->query($sql);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    }

    // Methode qui retourne le nombre total des produits en stock
    public function count_all_product_in_stock()
    {
        $sql = "SELECT SUM(product_quantity_stock) FROM product";
        $stmt = $this->db->query($sql);

        $count = $stmt->fetchColumn();
        
        return (int)$count;
    }

    // Nombre de produit épuisé
    public function out_of_stock_count()
    {
        $sql = "SELECT COUNT(product_reference) 
                FROM product WHERE product_quantity_stock = 0";
        $stmt = $this->db->query($sql);

        $out_of_stock = $stmt->fetchColumn();
        
        return (int)$out_of_stock;
    }

    // Nombre de produit en dessous du seuil
    public function product_alert_stock()
    {
        $sql = "SELECT COUNT(product_reference) 
                FROM product 
                WHERE product_quantity_stock <= product_alert_threshold
                AND product_quantity_stock > 0";
        $stmt = $this->db->query($sql);

        $alert_stock = $stmt->fetchColumn();
        
        return (int)$alert_stock;
    }

    public function totalProductsByCategory()
    {
        $sql = "SELECT category.category, 
                SUM(product.product_quantity_stock) AS 'Total'  
                FROM product JOIN category 
                ON product.category_id = category.category_id 
                GROUP BY category.category";

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

    public function add_product($product_reference, $product_name,
     $product_description, $product_quantity_stock,
      $product_alert_threshold, $product_unit_price, 
      $supplier_id, $category_id) 
    {
        $sql = "INSERT INTO product (product_reference, 
        product_name, product_description, product_quantity_stock, 
        product_alert_threshold, product_unit_price, supplier_id, 
        category_id) 
        VALUES (:product_reference, :product_name, 
        :product_description, :product_quantity_stock, 
        :product_alert_threshold, :product_unit_price,
         :supplier_id, :category_id)";

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

    public function update_product($product_id , $product_reference, 
    $product_name, $product_description, $product_quantity_stock, 
    $product_alert_threshold, $product_unit_price, $supplier_id, $category_id) 
    {
        $sql = "UPDATE product SET 
            product_reference = :product_reference, 
            product_name = :product_name, 
            product_description = :product_description, 
            product_quantity_stock = :product_quantity_stock, 
            product_alert_threshold = :product_alert_threshold, 
            product_unit_price = :product_unit_price, 
            supplier_id = :supplier_id, 
            category_id = :category_id 
            WHERE product_id = :product_id";

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


    //  For employe expedition
    public function getByCategory($category_id)
    {
        $sql = "SELECT * FROM product 
                JOIN supplier ON product.supplier_id = supplier.supplier_id
                JOIN category ON product.category_id = category.category_id
                WHERE product.category_id = :category_id
                ORDER BY product_id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['category_id' => $category_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function searchByName($searchTerm)
    {
        $sql = "SELECT * FROM product 
                JOIN supplier ON product.supplier_id = supplier.supplier_id 
                JOIN category ON product.category_id = category.category_id
                WHERE product.product_name LIKE :searchTerm
                ORDER BY product_id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>

