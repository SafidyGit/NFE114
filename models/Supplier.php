<?php

require_once __DIR__ . '/../config/database.php';

class Supplier
{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get_all_supplier()
    {
        $sql = "SELECT * FROM supplier ORDER BY supplier_id DESC";
        $stmt = $this->db->query($sql);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    }

    public function getById($supplier_id)
    {
        $sql = "SELECT * FROM supplier WHERE supplier_id = :supplier_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['supplier_id' => $supplier_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add_supplier($supplier, $supplier_address, $supplier_phone_number, $supplier_email) 
    {
        $sql = "INSERT INTO supplier (supplier, supplier_address, supplier_phone_number, supplier_email) VALUES (:supplier, :supplier_address, :supplier_phone_number, :supplier_email )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':supplier' => $supplier,
            ':supplier_address' => $supplier_address,
            ':supplier_phone_number' => $supplier_phone_number,
            ':supplier_email' => $supplier_email,
        ]);
    }

    public function update_supplier($supplier_id , $supplier, $supplier_address, $supplier_phone_number, $supplier_email) 
    {
        $sql = "UPDATE supplier SET supplier = :supplier, supplier_address = :supplier_address, supplier_phone_number = :supplier_phone_number, supplier_email = :supplier_email WHERE supplier_id = :supplier_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':supplier' => $supplier, 
            ':supplier_address' => $supplier_address,
            ':supplier_phone_number' => $supplier_phone_number,
            ':supplier_email' => $supplier_email,
            ':supplier_id' => $supplier_id
        ]);
    }

    public function delete_supplier($supplier_id) 
    {
        $sql = "DELETE FROM supplier WHERE supplier_id = :supplier_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':supplier_id' => $supplier_id]);
    }

}

?>

