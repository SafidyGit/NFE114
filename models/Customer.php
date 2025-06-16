<?php

require_once __DIR__ . '/../config/database.php';

class Customer
{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get_all_customer()
    {
        $sql = "SELECT * FROM customer ORDER BY customer_id DESC";
        $stmt = $this->db->query($sql);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    }

    public function getById($customer_id)
    {
        $sql = "SELECT * FROM customer WHERE customer_id = :customer_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':customer_id' => $customer_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add_customer($customer, $customer_address, $customer_phone_number, $customer_email) 
    {
        $sql = "INSERT INTO customer (customer, customer_address, customer_phone_number, customer_email) 
                VALUES (:customer, :customer_address, :customer_phone_number, :customer_email)";

        $stmt = $this->db->prepare($sql);

        $success = $stmt->execute([
            ':customer' => $customer,
            ':customer_address' => $customer_address,
            ':customer_phone_number' => $customer_phone_number,
            ':customer_email' => $customer_email,
        ]);

        if ($success) {
            return $this->db->lastInsertId();  // retourne l’ID du client inséré
        } else {
            return false; // échec de l’insertion
        }
    }


    public function update_customer($customer_id , $customer, $customer_address, $customer_phone_number, $customer_email) 
    {
        $sql = "UPDATE customer SET customer = :customer, customer_address = :customer_address, customer_phone_number = :customer_phone_number, customer_email = :customer_email WHERE customer_id = :customer_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':customer' => $customer, 
            ':customer_address' => $customer_address,
            ':customer_phone_number' => $customer_phone_number,
            ':customer_email' => $customer_email,
            ':customer_id' => $customer_id
        ]);
    }

    public function delete_customer($customer_id) 
    {
        $sql = "DELETE FROM customer WHERE customer_id = :customer_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':customer_id' => $customer_id]);
    }
    

}

?>

