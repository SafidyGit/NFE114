<?php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/CategoryController.php';
require_once __DIR__ . '/SupplierController.php';

class ProductController {

    public function index() 
    {
        $productModel = new Product();
        $products = $productModel->get_all_product();
        
        return $products;
    }
   
    public function get_product_by_id($id)
    {
        $productModel = new Product();
        $product = $productModel->getById($id);

        return $product;
    }
   
    public function create() 
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

            header('Location: views/admin/product/index.php');
            exit;
        } else {
            require 'views/admin/product/update.php';
        
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_GET['id'];

            $productModel = new Product();
            $productModel->delete_product($product_id);

            header('Location: views/admin/product/index.php');
            exit;
        } else {
            require 'views/admin/product/index.php';
        }
    }
   
    // For employe expedition
    public function get_products_by_category($category_id)
    {
        $productModel = new Product();
        return $productModel->getByCategory($category_id);
    }

    public function dashboard()
    {
        
    $categoryController = new CategoryController();
    $categories = $categoryController->index();

    $categoryId = $_GET['categorie'] ?? '';

    if ($categoryId !== '') {
        // Récupérer les produits filtrés
        $products = $this->get_products_by_category($categoryId);
    } else {
        // Récupérer tous les produits
        $products = $this->index();
    }
        // Charger la vue
        require  'views/employe/dashboard.php';
    }

    public function search_products($searchTerm)
    {
        $productModel = new Product();
        return $productModel->searchByName($searchTerm);
    }

    
}
