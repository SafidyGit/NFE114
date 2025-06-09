<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/CategoryController.php';
require_once __DIR__ . '/controllers/ProductController.php';

$action = $_GET['action'] ?? null;
$authController = new AuthController();
$categoryController = new CategoryController();
$productController = new ProductController();

switch ($action) {
    case 'login':
        $authController->login();
        break;
    case 'logout':
        $authController->logout();
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


    default:
        header('Location: index.php?action=login');
        exit;
}




?>