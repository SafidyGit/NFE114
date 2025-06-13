<?php

require_once __DIR__ . '/../models/SupplierOrder.php';
require_once __DIR__ . '/../models/Supplier.php';
require_once __DIR__ . '/../models/Product.php';

class SupplierOrderController 
{
    private SupplierOrder $supplierOrderModel;
    private Supplier $supplierModel;
    private Product $productModel;

    public function __construct(SupplierOrder $supplierOrderModel, Supplier $supplierModel, Product $productModel)
    {
        $this->supplierOrderModel = $supplierOrderModel;
        $this->supplierModel = $supplierModel;
        $this->productModel = $productModel;
    }

    public function index() 
    {
        $supplier_orders = $this->supplierOrderModel->get_all_supplier_order();

        require __DIR__ . '/../views/admin/supplier_order/index.php';
    }

    public function get_customer_by_id($id)
    {
        $customer = $this->supplierOrderModel->getById($id);

        return $customer;
    }

    public function create()
    {

        $supplier_list = $this->supplierModel->get_all_supplier();
        $product_list = $this->productModel->get_all_product();

        require __DIR__ . '/../views/admin/supplier_order/create.php';
    }

    public function store() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplier_order_reference = trim(htmlspecialchars($_POST['supplier_order_reference']));
            $supplier_order_date = trim(htmlspecialchars($_POST['supplier_order_date']));
            $supplier_order_status = trim(htmlspecialchars($_POST['supplier_order_status']));
            $supplier_id = trim(htmlspecialchars($_POST['supplier_id']));
           
            $this->supplierOrderModel->add_supplier_order(
                $supplier_order_reference, 
                $supplier_order_date, 
                $supplier_order_status, 
                $supplier_id
            );

            header('Location: views/admin/supplier_order/create.php?success=1');
            exit;
        } else {
            require 'views/admin/supplier_order/create.php';
        
        }
    }
    
    public function edit()
    {
        $id = $_GET['id'];
        $supplier_order = $this->get_customer_by_id($id);

        require __DIR__ . '/../views/admin/supplier_order/update.php';
    }


    public function update_product_from_supplierOrder()
    {

    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplier_order_id = $_GET['id'];
            $supplier_order_reference = trim(htmlspecialchars($_POST['supplier_order_reference']));
            $supplier_order_date = trim(htmlspecialchars($_POST['supplier_order_date']));
            $supplier_order_status = trim(htmlspecialchars($_POST['supplier_order_status']));
            $supplier_id = trim(htmlspecialchars($_POST['supplier_id']));
           

            $this->supplierOrderModel->update_supplier_order(
                $supplier_order_id , 
                $supplier_order_reference, 
                $supplier_order_date, 
                $supplier_order_status, 
                $supplier_id
            );

            header('Location: /index.php?action=supplier_order_list');
            exit;
        } else {
            require 'index.php?action=supplier_order_list';
        
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplier_order_id = $_GET['id'];

            $this->supplierOrderModel->delete_supplier_order($supplier_order_id);

            header('Location: /index.php?action=supplier_order_list');
            exit;
        } else {
            require '/index.php?action=supplier_order_list';
        }
    }
    
}
