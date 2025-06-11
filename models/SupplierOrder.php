<?php

require_once __DIR__ . '/../config/database.php';

class SupplierOrder
{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get_all_supplier_order()
    {
        $sql = "SELECT * FROM supplierorder ORDER BY supplier_order_id DESC";
        $stmt = $this->db->query($sql);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    }

    public function getById($supplier_order_id)
    {
        $sql = "SELECT * FROM supplierorder WHERE supplier_order_id = :supplier_order_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':supplier_order_id' => $supplier_order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add_supplier_order($supplier_order_reference, $supplier_order_date, $supplier_order_status, $supplier_id) 
    {
        $sql = "INSERT INTO supplierorder (supplier_order_reference, supplier_order_date, supplier_order_status, supplier_id) VALUES (:supplier_order_reference, :supplier_order_date, :supplier_order_status, :supplier_id )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':supplier_order_reference' => $supplier_order_reference,
            ':supplier_order_date' => $supplier_order_date,
            ':supplier_order_status' => $supplier_order_status,
            ':supplier_id' => $supplier_id,
        ]);
    }

    public function update_supplier_order($supplier_order_id , $supplier_order_reference, $supplier_order_date, $supplier_order_status, $supplier_id) 
    {
        $sql = "UPDATE supplierorder SET supplier_order_reference = :supplier_order_reference, supplier_order_date = :supplier_order_date, supplier_order_status = :supplier_order_status, supplier_id = :supplier_id WHERE supplier_order_id = :supplier_order_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':supplier_order_reference' => $supplier_order_reference,
            ':supplier_order_date' => $supplier_order_date,
            ':supplier_order_status' => $supplier_order_status,
            ':supplier_id' => $supplier_id,
            ':supplier_order_id' => $supplier_order_id
        ]);
    }

    public function delete_supplier_order($supplier_order_id) 
    {
        $sql = "DELETE FROM supplierorder WHERE supplier_order_id = :supplier_order_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':supplier_order_id' => $supplier_order_id]);
    }

}

?>

