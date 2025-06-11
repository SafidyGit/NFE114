<?php

require_once __DIR__ . '/../config/database.php';

class SupplierOrderDetail
{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get_all_supplier_order_detail()
    {
        $sql = "SELECT * FROM supplierorderdetail ORDER BY supplier_order_detail_id DESC";
        $stmt = $this->db->query($sql);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    }

    public function getById($supplier_order_detail_id)
    {
        $sql = "SELECT * FROM supplierorderdetail WHERE supplier_order_detail_id = :supplier_order_detail_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':supplier_order_detail_id' => $supplier_order_detail_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add_supplier_order_detail($so_quantity, $purchase_price, $product_id, $supplier_order_id) 
    {
        $sql = "INSERT INTO supplierorderdetail (so_quantity, purchase_price, product_id, supplier_order_id) 
        VALUES (:so_quantity, :purchase_price, :product_id, :supplier_order_id )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':so_quantity' => $so_quantity,
            ':purchase_price' => $purchase_price,
            ':product_id' => $product_id,
            ':supplier_order_id' => $supplier_order_id,
        ]);
    }

    public function update_supplier_order($supplier_order_detail_id , $so_quantity, $purchase_price, $product_id, $supplier_order_id) 
    {
        $sql = "UPDATE supplierorderdetail SET so_quantity = :so_quantity, purchase_price = :purchase_price, product_id = :product_id, supplier_order_id = :supplier_order_id WHERE supplier_order_detail_id = :supplier_order_detail_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':so_quantity' => $so_quantity,
            ':purchase_price' => $purchase_price,
            ':product_id' => $product_id,
            ':supplier_order_id' => $supplier_order_id,
            ':supplier_order_detail_id' => $supplier_order_detail_id
        ]);
    }

    public function delete_supplier_order($supplier_order_detail_id) 
    {
        $sql = "DELETE FROM supplierorderdetail WHERE supplier_order_detail_id = :supplier_order_detail_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':supplier_order_detail_id' => $supplier_order_detail_id]);
    }

}

?>

