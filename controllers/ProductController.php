<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Supplier.php';

class ProductController 
{
    private Product $productModel;
    private Category $categoryModel;
    private Supplier $supplierModel;

    public function __construct(Product $productModel, Category $categoryModel, Supplier $supplierModel)
    {
        $this->productModel = $productModel;
        $this->categoryModel = $categoryModel;
        $this->supplierModel = $supplierModel;
    }

    public function index() 
    {
        // Appel de la méthode get_all_product() dans le Modèle Product pour afficher la liste des produits
        $products = $this->productModel->get_all_product();
        
        require __DIR__ . '/../views/admin/product/index.php';
    }

    // Appel de la méthode get_product_by_id($id) dans le Modèle Product pour recuperer un produits avec l'id $id
    public function get_product_by_id($id)
    {
        $product = $this->productModel->getById($id);

        return $product;
    }


    // Méthode qui va afficher le formulaire d'ajout d'un produit
    public function create()
    {
        // Récupération de la liste des catégories existantes (à afficher sur le dropdown)  
        $category_list = $this->categoryModel->get_all_category();

        // Récupération de la liste des fournisseurs existant (à afficher sur le dropdown)
        $supplier_list = $this->supplierModel->get_all_supplier();

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
            $this->productModel->add_product(
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
            header('Location: index.php?action=product_create&success=1');
            exit;
        } else {
            header('Location: index.php?action=product_create');
        }
    }

    public function edit()
    {
        $id = $_GET['id'];
        $product = $this->get_product_by_id($id);

        $category_list = $this->categoryModel->get_all_category();

        $supplier_list = $this->supplierModel->get_all_supplier();

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

            $this->productModel->update_product(
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

            $this->productModel->delete_product($product_id);

            header('Location: index.php?action=product_list');
            exit;
        } else {
            require 'index.php?action=product_list';
        }
    }
    
    // Pour employé : récupérer les produits selon la catégorie via la méthode getByCategory dans le models Product

    // Affiche la liste des produits filtrés par catégorie (pour le filtre du dashboard)
    public function get_products_by_category($category_id)
    {
        return $this->productModel->getByCategory($category_id);
    }

    // Dashboard pour employé : liste des produits avec possibilité de filtrer par catégorie ou rechercher par nom
    public function dashboard()
    {
        // Récupère toutes les catégories disponibles
        $categories = $this->categoryModel->get_all_category(); 

        // Récupère les paramètres de recherche depuis l'URL
        $searchTerm = $_GET['search'] ?? '';
        $categoryId = $_GET['categorie'] ?? '';

        // Si une recherche est saisie, on filtre par nom
        if (!empty($searchTerm)) {
            $products = $this->productModel->searchByName($searchTerm);
        } 
        // Sinon si une catégorie est sélectionnée, on filtre par catégorie
        elseif (!empty($categoryId)) {
            $products = $this->productModel->getByCategory($categoryId);
        } 
        // Sinon, on récupère tous les produits
        else {
            $products = $this->productModel->get_all_product(); 
        }

        // Affiche la vue dashboard avec les produits
        require __DIR__ . '/../views/employe/dashboard.php';
    }

    // Recherche de produit par nom (depuis la barre de recherche)
    public function searchProducts()
    {
        // Vérifie si une recherche a été envoyée via GET
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            // Nettoie le terme recherché
            $searchTerm = trim(htmlspecialchars($_GET['q']));
            // Recherche les produits correspondants
            $products = $this->productModel->searchByName($searchTerm);
        } 
        // Si aucun terme, afficher tous les produits
        else {
            $products = $this->productModel->get_all_product();
        }

        // Affiche les résultats sur la vue dashboard
        require __DIR__ . '/../views/employe/dashboard.php';
    }

    // Choisir les produits à commander (étape de sélection depuis le dashboard)
    public function selectionProduits()
    {
        session_start();

        // Si aucun produit n'est sélectionné, retourner au dashboard avec erreur
        if (!isset($_POST['products']) || empty($_POST['products'])) {
            $_SESSION['error'] = "Aucun produit sélectionné.";
            header('Location: index.php?action=dashboard');
            exit;
        }

        $productsInput = $_POST['products'];
        $selected = [];

        foreach ($productsInput as $product_id => $info) {
            // Vérifie que le checkbox du produit est bien coché
            if (isset($info['selected']) && $info['selected'] == '1') {
                // Si une quantité > 0 est fournie, on la prend, sinon on met 1 par défaut
                $quantity = isset($info['quantity']) && $info['quantity'] > 0 ? (int)$info['quantity'] : 1;

                // Récupère les informations complètes du produit en base
                $productData = $this->productModel->getById($product_id);

                if ($productData) {
                    // Vérifie si le produit est en rupture de stock
                    if ($productData['product_quantity_stock'] <= 0) {
                        $_SESSION['error'] = "Le produit '{$productData['product_name']}' est en rupture de stock.";
                        header('Location: index.php?action=dashboard');
                        exit;
                    }

                    // Vérifie si la quantité demandée est supérieure au stock disponible
                    if ($quantity > $productData['product_quantity_stock']) {
                        $_SESSION['error'] = "La quantité demandée pour '{$productData['product_name']}' est supérieure au stock disponible ({$productData['product_quantity_stock']}).";
                        header('Location: index.php?action=dashboard');
                        exit;
                    }

                    // Ajoute le produit à la sélection
                    $selected[] = [
                        'product_id' => $productData['product_id'],
                        'product_name' => $productData['product_name'],
                        'product_unit_price' => $productData['product_unit_price'],
                        'quantity' => $quantity,
                    ];
                }
            }
        }

        // Si aucun produit sélectionné ou valide, erreur
        if (empty($selected)) {
            $_SESSION['error'] = "Aucun produit sélectionné valide.";
            header('Location: index.php?action=dashboard');
            exit;
        }

        // Passe les produits sélectionnés à la vue confirm_order.php
        include __DIR__ . '/../views/employe/order/confirm_order.php';
    }


}
