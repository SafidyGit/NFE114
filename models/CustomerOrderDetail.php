<?php

require_once __DIR__ . '/../config/database.php';

class CustomerOrderDetail
{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get_all_customer_order_detail()
    {
        $sql = "SELECT * FROM customerorderdetail 
                ORDER BY customer_order_detail_id DESC";
        $stmt = $this->db->query($sql);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    }

    public function getById($customer_order_detail_id)
    {
        $sql = "SELECT * FROM customerorderdetail 
                WHERE customer_order_detail_id = :customer_order_detail_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':customer_order_detail_id' => $customer_order_detail_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   
    public function add_customer_order_detail($co_quantity, $selling_price, $product_id, $customer_order_id, $user_id) 
    {
        $sql = "INSERT INTO customerorderdetail (co_quantity, selling_price, product_id, customer_order_id, user_id) 
                VALUES (:co_quantity, :selling_price, :product_id, :customer_order_id, :user_id)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':co_quantity' => $co_quantity,
            ':selling_price' => $selling_price,
            ':product_id' => $product_id,
            ':customer_order_id' => $customer_order_id,
            ':user_id' => $user_id,
        ]);
    }

    
    

    public function update_customer_order($customer_order_detail_id , 
    $co_quantity, $selling_price, $product_id, $customer_order_id) 
    {
        $sql = "UPDATE customerorderdetail SET co_quantity = :co_quantity, 
                selling_price = :selling_price, product_id = :product_id, 
                customer_order_id = :customer_order_id 
                WHERE customer_order_detail_id = :customer_order_detail_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':co_quantity' => $co_quantity,
            ':selling_price' => $selling_price,
            ':product_id' => $product_id,
            ':customer_order_id' => $customer_order_id,
            ':customer_order_detail_id' => $customer_order_detail_id
        ]);
    }

    public function delete_customer_order($customer_order_detail_id) 
    {
        $sql = "DELETE FROM customerorderdetail WHERE customer_order_detail_id = :customer_order_detail_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':customer_order_detail_id' => $customer_order_detail_id]);
    }

}

?>

