<?php

require_once __DIR__ . '/../models/Supplier.php';

class SupplierController {

    public function index() 
    {
        $supplierModel = new Supplier();
        $categories = $supplierModel->get_all_supplier();

        return $categories;
    }

    public function get_supplier_by_id($id)
    {
        $supplierModel = new Supplier();
        $supplier = $supplierModel->getById($id);

        return $supplier;
    }

    public function create() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplier = trim(htmlspecialchars($_POST['supplier']));
            $supplier_address = trim(htmlspecialchars($_POST['supplier_address']));
            $supplier_phone_number = trim(htmlspecialchars($_POST['supplier_phone_number']));
            $supplier_email = trim(htmlspecialchars($_POST['supplier_email']));
           
            $supplierModel = new Supplier();
            $supplierModel->add_supplier($supplier, $supplier_address, $supplier_phone_number, $supplier_email);

            header('Location: views/admin/supplier/create.php?success=1');
            exit;
        } else {
            require 'views/admin/supplier/create.php';
        
        }
    }
    
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplier_id = $_GET['id'];
            $supplier = trim(htmlspecialchars($_POST['supplier']));
            $supplier_address = trim(htmlspecialchars($_POST['supplier_address']));
            $supplier_phone_number = trim(htmlspecialchars($_POST['supplier_phone_number']));
            $supplier_email = trim(htmlspecialchars($_POST['supplier_email']));
           

            $supplierModel = new Supplier();
            $supplierModel->update_supplier($supplier_id , $supplier, $supplier_address, $supplier_phone_number, $supplier_email);

            header('Location: views/admin/supplier/index.php');
            exit;
        } else {
            require 'views/admin/supplier/update.php';
        
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplier_id = $_GET['id'];

            $supplierModel = new Supplier();
            $supplierModel->delete_supplier($supplier_id);

            header('Location: views/admin/supplier/index.php');
            exit;
        } else {
            require 'views/admin/supplier/index.php';
        }
    }
    
}
