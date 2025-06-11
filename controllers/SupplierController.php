<?php

require_once __DIR__ . '/../models/Supplier.php';

class SupplierController {

    public function index() 
    {
        $supplierModel = new Supplier();
        $suppliers = $supplierModel->get_all_supplier();

        require __DIR__ . '/../views/admin/supplier/index.php';
    }

    public function get_supplier_by_id($id)
    {
        $supplierModel = new Supplier();
        $supplier = $supplierModel->getById($id);

        return $supplier;
    }

    public function create()
    {
        require __DIR__ . '/../views/admin/supplier/create.php';
    }

    public function store() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplier = trim(htmlspecialchars($_POST['supplier']));
            $supplier_address = trim(htmlspecialchars($_POST['supplier_address']));
            $supplier_phone_number = trim(htmlspecialchars($_POST['supplier_phone_number']));
            $supplier_email = trim(htmlspecialchars($_POST['supplier_email']));
           
            $supplierModel = new Supplier();
            $supplierModel->add_supplier(
                $supplier, 
                $supplier_address, 
                $supplier_phone_number, 
                $supplier_email
            );

            header('Location: views/admin/supplier/create.php?success=1');
            exit;
        } else {
            require 'views/admin/supplier/create.php';
        
        }
    }
    
    public function edit()
    {
        $id = $_GET['id'];
        $supplier = $this->get_supplier_by_id($id);

        require __DIR__ . '/../views/admin/supplier/update.php';
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
            $supplierModel->update_supplier(
                $supplier_id , 
                $supplier, 
                $supplier_address, 
                $supplier_phone_number, 
                $supplier_email
            );

            header('Location: /index.php?action=supplier_list');
            exit;
        } else {
            require 'index.php?action=supplier_list';
        
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplier_id = $_GET['id'];

            $supplierModel = new Supplier();
            $supplierModel->delete_supplier($supplier_id);

            header('Location: /index.php?action=supplier_list');
            exit;
        } else {
            require '/index.php?action=supplier_list';
        }
    }
    
}
