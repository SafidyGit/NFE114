<?php
require_once 'controllers/AuthController.php';
require_once 'controllers/CategoryController.php';
require_once 'controllers/ProductController.php';

$action = $_GET['action'] ?? null;
$controller = new AuthController();
$categoryController = new CategoryController();
$productController = new ProductController();


if ($action === 'login') {
    $controller->login();
} elseif ($action === 'logout') {
    $controller->logout();
} elseif ($action === 'category') {
    $categoryController->index();
} 
else {
    // Page par défaut
    header('Location: index.php?action=login');
    exit;
}