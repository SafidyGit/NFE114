<?php

require_once __DIR__ . '/../models/SupplierOrder.php';
require_once __DIR__ . '/../models/SupplierOrderDetail.php';
require_once __DIR__ . '/../models/Supplier.php';
require_once __DIR__ . '/../models/Product.php';

class SupplierOrderController 
{
    private SupplierOrder $supplierOrderModel;
    private SupplierOrderDetail $supplierOrderDetailModel;
    private Supplier $supplierModel;
    private Product $productModel;

    public function __construct(SupplierOrder $supplierOrderModel, Supplier $supplierModel, Product $productModel, SupplierOrderDetail $supplierOrderDetailModel)
    {
        $this->supplierOrderModel = $supplierOrderModel;
        $this->supplierOrderDetailModel = $supplierOrderDetailModel;
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
        $next_supplier_order_id = $this->supplierOrderModel->get_last_id_supplier_order() + 1;
        $supplier_list = $this->supplierModel->get_all_supplier();
        $product_list = $this->productModel->get_all_product();

        // Recuperer l'id du produit via le select , null si id n'existe pas
        $selected_product_id = $_GET['selected_product_id'] ?? null;
        // Recup de l'id de produit pour pouvoir recup le prix dans un value
        $product = $this->productModel->getById($selected_product_id);

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
        // récuperer le prochain supplier_order_id
        $next_supplier_order_id = $this->supplierOrderModel->get_last_id_supplier_order() + 1;
        // recuperer la quantité selon l'id de produits 
        $product_for_quantity_operation = $this->productModel->getById($_GET['selected_product_id']);
        $product_quantity = $product_for_quantity_operation['product_quantity_stock'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Opération sur la commande Fournisseur
            $supplier_order_reference = trim(htmlspecialchars($_POST['supplier_order_reference']));
            $supplier_order_date = trim(htmlspecialchars($_POST['supplier_order_date']));
            $supplier_order_status = trim(htmlspecialchars($_POST['supplier_order_status']));
            $supplier_id = trim(htmlspecialchars($_POST['supplier_id']));
           
            // Opération sur la commande Fournisseur Detail
            $so_quantity = trim(htmlspecialchars($_POST['so_quantity']));
            $purchase_price = trim(htmlspecialchars($_POST['purchase_price']));
            $user_id = 1;
            $supplier_order_id = $next_supplier_order_id;
           
            // Opération sur le Produit
            $product_id = $_GET['selected_product_id'];
            $product_quantity_stock = $so_quantity + $product_quantity;
            $product_unit_price = $purchase_price;


            $this->supplierOrderDetailModel->add_supplier_order_detail(
                $so_quantity, 
                $purchase_price, 
                $user_id, 
                $product_id,
                $supplier_order_id

            );

            $this->supplierOrderModel->add_supplier_order(
                $supplier_order_reference, 
                $supplier_order_date, 
                $supplier_order_status, 
                $supplier_id

            );

            $this->supplierOrderModel->update_product_from_supplier_order(
                $product_id , 
                $product_quantity_stock, 
                $product_unit_price, 
            );

            // var_dump($_POST);
            // exit;

            header('Location: views/admin/supplier_order/create.php?success=1');
            exit;
        } else {
            require 'views/admin/supplier_order/create.php';
        
        }
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
