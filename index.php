<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/CategoryController.php';
require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/SupplierController.php';

$action = $_GET['action'] ?? null;
$authController = new AuthController();
$userController = new UserController();
$categoryController = new CategoryController();
$productController = new ProductController();
$supplierController = new SupplierController();

// Authentication
switch ($action) {
    case 'login':
        $authController->login();
        break;
    case 'logout':
        $authController->logout();
        break;

    // Action sur les Users
    case 'user_list':
        $userController->index();
        break;

    // Possible si pas de compte connecté ??? Pas encore OK
    case 'user_create':
        $userController->create();
        break;
    case 'user_store':
        $userController->store();
        break;
    case 'user_edit':
        $userController->edit();
        break;
    case 'user_update':
        $userController->update();
        break;
    case 'user_delete':
        $userController->delete();
        break;

    // Action sur les Categories
    case 'category_list':
        $categoryController->index();
        break;
    case 'category_create':
        $categoryController->create();
        break;
    case 'category_store':
        $categoryController->store();
        break;
    case 'category_edit':
        $categoryController->edit();
        break;
    case 'category_update':
        $categoryController->update();
        break;
    case 'category_delete':
        $categoryController->delete();
        break;

    // Action sur les Produits
    case 'product_list':
        $productController->index();
        break;
    case 'product_create':
        $productController->create();
        break;
    case 'product_store':
        $productController->store();
        break;
    case 'product_edit':
        $productController->edit();
        break;
    case 'product_update':
        $productController->update();
        break;
    case 'product_delete':
        $productController->delete();
        break;

    // Action sur les Fournisseurs
    case 'supplier_list':
        $supplierController->index();
        break;
    case 'supplier_create':
        $supplierController->create();
        break;
    case 'supplier_store':
        $supplierController->store();
        break;
    case 'supplier_edit':
        $supplierController->edit();
        break;
    case 'supplier_update':
        $supplierController->update();
        break;
    case 'supplier_delete':
        $supplierController->delete();
        break;


    default:
        header('Location: index.php?action=login');
        exit;
}




?>