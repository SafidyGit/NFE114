<?php

require_once __DIR__ . '/../config/database.php';

class Product
{
    private $db;

    public function __construct() {
        // Initialise la connexion PDO à la base de données via la classe Database singleton
        $this->db = Database::getInstance()->getConnection();
    }

    // Récupère tous les produits avec leurs fournisseurs et catégories associés
    public function get_all_product()
    {
        $sql = "SELECT * FROM product 
                JOIN supplier, category
                WHERE product.supplier_id = supplier.supplier_id 
                AND product.category_id = category.category_id
                ORDER BY product_id DESC";

        $stmt = $this->db->query($sql);
        
        // Retourne un tableau associatif de tous les produits
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retourne la somme totale des quantités en stock pour tous les produits
    public function count_all_product_in_stock()
    {
        $sql = "SELECT SUM(product_quantity_stock) FROM product";
        $stmt = $this->db->query($sql);

        $count = $stmt->fetchColumn();
        
        return (int)$count;
    }

    // Retourne le nombre de produits dont la quantité en stock est nulle (épuisé)
    public function out_of_stock_count()
    {
        $sql = "SELECT COUNT(product_reference) 
                FROM product WHERE product_quantity_stock = 0";
        $stmt = $this->db->query($sql);

        $out_of_stock = $stmt->fetchColumn();
        
        return (int)$out_of_stock;
    }

    // Retourne le nombre de produits dont la quantité en stock est inférieure ou égale au seuil d'alerte (mais > 0)
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

    // Retourne le total des quantités de produits groupé par catégorie
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

    // Récupère un produit spécifique par son ID avec son fournisseur associé
    public function getById($product_id)
    {
        $sql = "SELECT * 
        FROM product 
        JOIN supplier ON product.supplier_id = supplier.supplier_id
        WHERE product_id = :product_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['product_id' => $product_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajoute un nouveau produit dans la base de données
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

    // Met à jour un produit existant par son ID
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

    // Supprime un produit par son ID
    public function delete_product($product_id) 
    {
        $sql = "DELETE FROM product WHERE product_id = :product_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':product_id' => $product_id]);
    }

    // Pour l'employé d'expédition : récupère les produits d'une catégorie spécifique
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
    
    // Recherche les produits par nom (contient la chaîne de recherche)
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

    // Met à jour la quantité en stock d'un produit donné
    public function updateStock($productId, $newQuantity) 
    {
        $sql = "UPDATE product SET product_quantity_stock = :qty WHERE product_id = :pid";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':qty' => $newQuantity, ':pid' => $productId]);
    }

}

?>
