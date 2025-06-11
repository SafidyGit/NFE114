<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/CategoryController.php';
require_once __DIR__ . '/SupplierController.php';

class ProductController {

    public function index() 
    {
        // Appel de la méthode get_all_product() dans le Modèle Product pour afficher la liste des produits
        // Instanciation de la classe Product (models/Product.php) + appel de la méthode get_all_product();
        $productModel = new Product();
        $products = $productModel->get_all_product();
        
        require __DIR__ . '/../views/admin/product/index.php';
    }

    // Appel de la méthode get_product_by_id($id) dans le Modèle Product pour recuperer un produits avec l'id $id
    public function get_product_by_id($id)
    {
        $productModel = new Product();
        $product = $productModel->getById($id);

        return $product;
    }

    // Méthode qui va afficher le formulaire d'ajout d'un produit
    public function create()
    {
        // Récupération de la liste des catégories existantes (à afficher sur le dropdown)  
        $categoryModel = new Category();
        $category_list = $categoryModel->get_all_category();

        // Récupération de la liste des fournisseurs existant (à afficher sur le dropdown)
        $supplierModel = new Supplier();
        $supplier_list = $supplierModel->get_all_supplier();

        // La vue à retourner
        require __DIR__ . '/../views/admin/product/create.php';
    }

    // Méthode qui enregistre les données saisies via le formulaire d'ajout de produit.
    public function store() 
    {
        // Vérifie si une requete POST à été executée
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // assignation des valeurs insérées dans les champs(input) du formulaire dans des variables
            // La fonction trim() permet de supprimer les espaces 
            // htmlspecialchars() protège contre les injections XSS
            $product_reference = trim(htmlspecialchars($_POST['product_reference']));
            $product_name = trim(htmlspecialchars($_POST['product_name']));
            $product_description = trim(htmlspecialchars($_POST['product_description']));
            $product_quantity_stock = trim(htmlspecialchars($_POST['product_quantity_stock']));
            $product_alert_threshold = trim(htmlspecialchars($_POST['product_alert_threshold']));
            $product_unit_price = trim(htmlspecialchars($_POST['product_unit_price']));
            $supplier_id = trim(htmlspecialchars($_POST['supplier_id']));
            $category_id = trim(htmlspecialchars($_POST['category_id']));
           
            // Appel la fontion add_product() de models/Product.php 
            // add_product() : Méthode pour enregistrer les données dans la base de données 
            $productModel = new Product();
            $productModel->add_product(
                $product_reference, 
                $product_name, 
                $product_description, 
                $product_quantity_stock, 
                $product_alert_threshold, 
                $product_unit_price, 
                $supplier_id, 
                $category_id
            );

            // Redirection vers la page create.php avec un message de succès
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
            $productModel->update_product(
                $product_id , 
                $product_reference, 
                $product_name, 
                $product_description, 
                $product_quantity_stock, 
                $product_alert_threshold, 
                $product_unit_price, 
                $supplier_id, 
                $category_id
            );

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
        require  __DIR__ . 'views/employe/dashboard.php';
    }

    public function search_products($searchTerm)
    {
        $productModel = new Product();
        return $productModel->searchByName($searchTerm);
    }

}
