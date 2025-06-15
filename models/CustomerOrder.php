<?php

require_once __DIR__ . '/../config/database.php';

class CustomerOrder
{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get_all_customer_order()
    {
        $sql = "SELECT * FROM customerorder ORDER BY customer_order_id DESC";
        $stmt = $this->db->query($sql);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    }

    public function getById($customer_order_id)
    {
        $sql = "SELECT * FROM customerorder WHERE customer_order_id = :customer_order_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':customer_order_id' => $customer_order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

     public function add_customer_order($customer_order_reference, $customer_order_date, $customer_order_status, $customer_id) 
    {
        $sql = "INSERT INTO customerorder (customer_order_reference, customer_order_date, customer_order_status, customer_id) 
                VALUES (:customer_order_reference, :customer_order_date, :customer_order_status, :customer_id)";

        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            ':customer_order_reference' => $customer_order_reference,
            ':customer_order_date' => $customer_order_date,
            ':customer_order_status' => $customer_order_status,
            ':customer_id' => $customer_id,
        ]);

        if ($success) {
            return $this->db->lastInsertId();  // Retourne l’ID inséré
        } else {
            return false;  // En cas d’erreur
        }
    }

    public function update_customer_order($customer_order_id , $customer_order_reference, $customer_order_date, $customer_order_status, $customer_id) 
    {
        $sql = "UPDATE customerorder SET customer_order_reference = :customer_order_reference, customer_order_date = :customer_order_date, customer_order_status = :customer_order_status, customer_id = :customer_id WHERE customer_order_id = :customer_order_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':customer_order_reference' => $customer_order_reference,
            ':customer_order_date' => $customer_order_date,
            ':customer_order_status' => $customer_order_status,
            ':customer_id' => $customer_id,
            ':customer_order_id' => $customer_order_id
        ]);
    }

    public function delete_customer_order($customer_order_id) 
    {
        $sql = "DELETE FROM customerorder WHERE customer_order_id = :customer_order_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':customer_order_id' => $customer_order_id]);
    }

    // requête pour afficher la liste des clients partie employé
     public function get_customer_order_list()
    {
        $sql = "
        SELECT 
            co.customer_order_id,
            co.customer_order_reference,
            co.customer_order_date,
            co.customer_order_status,
            c.customer AS customer_name
        FROM 
            customerorder co
        JOIN 
            customer c ON co.customer_id = c.customer_id
        ORDER BY 
            co.customer_order_date DESC
    ";
        $stmt = $this->db->query($sql);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    }

}

?>

