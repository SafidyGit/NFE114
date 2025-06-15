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
        $sql = "SELECT 
        supplierorderdetail.supplier_order_detail_id, 
        supplierorderdetail.so_quantity, 
        supplierorderdetail.purchase_price,
        supplierorder.supplier_order_id, 
        supplierorder.supplier_order_date, 
        supplierorder.supplier_order_reference,
        supplierorder.supplier_order_status, 
        supplier.supplier,
        product.product_id, 
        product.product_name, 
        (supplierorderdetail.so_quantity * supplierorderdetail.purchase_price) AS 'total_price'
        FROM supplierorder
        JOIN supplierorderdetail 
        ON supplierorder.supplier_order_id = supplierorderdetail.supplier_order_id
        JOIN supplier 
        ON supplierorder.supplier_id = supplier.supplier_id
        LEFT JOIN product 
        ON supplierorderdetail.product_id = product.product_id
        ORDER BY supplierorder.supplier_order_id DESC";

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


    // Méthode qui va récuperer le dernier id dans supplier order
    public function get_last_id_supplier_order()
    {
        $sql = "SELECT MAX(supplier_order_id) FROM supplierorder" ;
        $stmt = $this->db->query($sql);

        $supplier_last_id = $stmt->fetchColumn();
        
        return (int)$supplier_last_id;
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


    // Mettre à jour le nombre et prix du produits depuis la commande fournisseur
    public function update_product_from_supplier_order($product_id, $product_quantity_stock, $product_unit_price) 
    {
        $sql = "UPDATE product SET 
            product_quantity_stock = :product_quantity_stock, 
            product_unit_price = :product_unit_price
            WHERE product_id = :product_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':product_quantity_stock' => $product_quantity_stock, 
            ':product_unit_price' => $product_unit_price, 
            ':product_id' => $product_id
        ]);
    }

    // pour Modifier le statut d'une commande via la validation d'une commande
    public function update_supplier_order_status($supplier_order_id , $supplier_order_status)
    {
        $sql = "UPDATE supplierorder SET  
        supplier_order_status = :supplier_order_status
        WHERE supplier_order_id = :supplier_order_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':supplier_order_status' => $supplier_order_status,
            ':supplier_order_id' => $supplier_order_id
        ]);
    } 


}

?>

