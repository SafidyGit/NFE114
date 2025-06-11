<?php

require_once __DIR__ . '/../config/database.php';

class StockMovement
{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get_all_stockmovement()
    {
        $sql = "SELECT * FROM stockmovement ORDER BY sm_id DESC";
        $stmt = $this->db->query($sql);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    }

    public function getById($sm_id)
    {
        $sql = "SELECT * FROM stockmovement WHERE sm_id = :sm_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':sm_id' => $sm_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add_stockmovement($stockmovement, $sm_type, $sm_date, $product_id) 
    {
        $sql = "INSERT INTO stockmovement (stockmovement, sm_type, sm_date, product_id) VALUES (:stockmovement, :sm_type, :sm_date, :product_id )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':stockmovement' => $stockmovement,
            ':sm_type' => $sm_type,
            ':sm_date' => $sm_date,
            ':product_id' => $product_id,
        ]);
    }

    public function update_stockmovement($sm_id , $stockmovement, $sm_type, $sm_date, $product_id) 
    {
        $sql = "UPDATE stockmovement SET stockmovement = :stockmovement, sm_type = :sm_type, sm_date = :sm_date, product_id = :product_id WHERE sm_id = :sm_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':stockmovement' => $stockmovement, 
            ':sm_type' => $sm_type,
            ':sm_date' => $sm_date,
            ':product_id' => $product_id,
            ':sm_id' => $sm_id
        ]);
    }

    public function delete_stockmovement($sm_id) 
    {
        $sql = "DELETE FROM stockmovement WHERE sm_id = :sm_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':sm_id' => $sm_id]);
    }

}

?>

