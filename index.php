<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/CategoryController.php';

$action = $_GET['action'] ?? null;
$authController = new AuthController();
$categoryController = new CategoryController();

switch ($action) {
    case 'login':
        $authController->login();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'category':
        $categoryController->index();
        break;
    case 'category_create':
        $categoryController->create();
        break;
    case 'category_update':
        $categoryController->update();
        break;
    case 'category_delete':
        $categoryController->delete();
        break;
    default:
        header('Location: index.php?action=login');
        exit;
}



// if ($action === 'login') {
//     $controller->login();
// } elseif ($action === 'logout') {
//     $controller->logout();
// } else {
//     // Page par défaut
//     header('Location: index.php?action=login');
//     exit;
// }