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
        $sql = "INSERT INTO customerorder (customer_order_reference, customer_order_date, customer_order_status, customer_id) VALUES (:customer_order_reference, :customer_order_date, :customer_order_status, :customer_id )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':customer_order_reference' => $customer_order_reference,
            ':customer_order_date' => $customer_order_date,
            ':customer_order_status' => $customer_order_status,
            ':customer_id' => $customer_id,
        ]);
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

}

?>

