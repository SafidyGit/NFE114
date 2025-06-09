<?php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/CategoryController.php';
require_once __DIR__ . '/SupplierController.php';

class ProductController {

    public function index() 
    {
        // Appel de la méthode get_all_product() dans le Modèle Product pour afficher la liste des produits
        $productModel = new Product();
        $products = $productModel->get_all_product();

        $categoryModel = new Category();
        $categories = $categoryModel->get_all_category();

        $supplierModel = new Supplier();
        $suppliers = $supplierModel->get_all_supplier();
        
        require __DIR__ . '/../views/admin/product/index.php';
    }

    public function get_product_by_id($id)
    {
        $productModel = new Product();
        $product = $productModel->getById($id);

        return $product;
    }


    public function create()
    {
        $categoryModel = new Category();
        $category_list = $categoryModel->get_all_category();

        $supplierModel = new Supplier();
        $supplier_list = $supplierModel->get_all_supplier();
        
        require __DIR__ . '/../views/admin/product/create.php';
    }

    public function store() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $product_reference = trim(htmlspecialchars($_POST['product_reference']));
            $product_name = trim(htmlspecialchars($_POST['product_name']));
            $product_description = trim(htmlspecialchars($_POST['product_description']));
            $product_quantity_stock = trim(htmlspecialchars($_POST['product_quantity_stock']));
            $product_alert_threshold = trim(htmlspecialchars($_POST['product_alert_threshold']));
            $product_unit_price = trim(htmlspecialchars($_POST['product_unit_price']));
            $supplier_id = trim(htmlspecialchars($_POST['supplier_id']));
            $category_id = trim(htmlspecialchars($_POST['category_id']));
           
            $productModel = new Product();
            $productModel->add_product($product_reference, $product_name, $product_description, $product_quantity_stock, $product_alert_threshold, $product_unit_price, $supplier_id, $category_id);

            header('Location: views/admin/product/create.php?success=1');
            exit;
        } else {
            require 'views/admin/product/create.php';
        
        }
    }

    public function edit()
    {
        $id = $_GET['id'];
        $product = $this->get_product_by_id($id);

        $categoryModel = new Category();
        $category_list = $categoryModel->get_all_category();

        $supplierModel = new Supplier();
        $supplier_list = $supplierModel->get_all_supplier();

        require __DIR__ . '/../views/admin/product/update.php';
    }
    
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_GET['id'];
            $product_reference = trim(htmlspecialchars($_POST['product_reference']));
            $product_name = trim(htmlspecialchars($_POST['product_name']));
            $product_description = trim(htmlspecialchars($_POST['product_description']));
            $product_quantity_stock = trim(htmlspecialchars($_POST['product_quantity_stock']));
            $product_alert_threshold = trim(htmlspecialchars($_POST['product_alert_threshold']));
            $product_unit_price = trim(htmlspecialchars($_POST['product_unit_price']));
            $supplier_id = trim(htmlspecialchars($_POST['supplier_id']));
            $category_id = trim(htmlspecialchars($_POST['category_id']));

            $productModel = new Product();
            $productModel->update_product($product_id , $product_reference, $product_name, $product_description, $product_quantity_stock, $product_alert_threshold, $product_unit_price, $supplier_id, $category_id);

            header('Location: index.php?action=product_list');
            exit;
        } else {
            require 'index.php?action=product_list';
        
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_GET['id'];

            $productModel = new Product();
            $productModel->delete_product($product_id);

            header('Location: index.php?action=product_list');
            exit;
        } else {
            require 'index.php?action=product_list';
        }
    }
    
}
