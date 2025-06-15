<?php
// MODELS
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Role.php';
require_once __DIR__ . '/models/Product.php';
require_once __DIR__ . '/models/Category.php';
require_once __DIR__ . '/models/Supplier.php';
require_once __DIR__ . '/models/SupplierOrder.php';
require_once __DIR__ . '/models/SupplierOrderDetail.php';

require_once __DIR__ . '/models/Customer.php';
require_once __DIR__ . '/models/CustomerOrder.php';
require_once __DIR__ . '/models/CustomerOrderDetail.php';
require_once __DIR__ . '/models/StockMovement.php';

$userModel = new User();
$roleModel = new Role();
$productModel = new Product();
$categoryModel = new Category();
$supplierModel = new Supplier();
$supplierOrderModel = new SupplierOrder();
$supplierOrderDetailModel = new SupplierOrderDetail();

$customerModel = new Customer();
$customerOrderModel = new CustomerOrder();
$customerOrderDetailModel = new CustomerOrderDetail();
$stockMovementModel = new StockMovement();


// CONTROLLERS
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/AdminDashboardController.php';
require_once __DIR__ . '/controllers/CategoryController.php';
require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/SupplierController.php';
require_once __DIR__ . '/controllers/SupplierOrderController.php';
require_once __DIR__ . '/controllers/CustomerOrderController.php';

$authController = new AuthController($userModel);
$userController = new UserController($userModel, $roleModel);
$adminDashboardController = new AdminDashboardController($productModel);
$productController = new ProductController($productModel, $categoryModel, $supplierModel);
$categoryController = new CategoryController($categoryModel);
$supplierController = new SupplierController($supplierModel);
$supplierOrderController = new SupplierOrderController($supplierOrderModel, $supplierModel, $productModel, $supplierOrderDetailModel);
$coCtrl = new CustomerOrderController($customerModel, $productModel, $customerOrderModel, $customerOrderDetailModel, $stockMovementModel);

// ROUTING
// Prendre la valeur '' si pas d'action récupérée.
$action = $_GET['action'] ?? '';
if($action === ''){
    // Aucun paramètre donc on affiche la page login
    $authController->login();
    exit;
}

// Authentication
switch ($action) {
    case 'login':
        $authController->login();
        break;
    case 'logout':
        $authController->logout();
        break;

    // Admin Dashboard
    case 'admin_dashboard':
        $adminDashboardController->index();
        break;

    // Action sur les Users
    case 'user_list':
        $userController->index();
        break;

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

    
    case 'supplier_order_list':
        $supplierOrderController->index();
        break;
    case 'supplier_order_create':
        $supplierOrderController->create();
        break;
    case 'supplier_order_store':
        $supplierOrderController->update_product_from_supplierOrder();
        break;

    //Action sur la partie Employé
    case 'dashboard':
        $productController->dashboard();
        break;
    case 'search_products':
        $productController->searchProducts();
        break;
    case 'confirm_order':
        $coCtrl->confirm_order();
        break;
    case 'submit_order':
        $coCtrl->submit_order();
        break;
    case 'list_orders':
        $coCtrl->listOrders();
        break;
    case 'selection_produits':
        $productController->selectionProduits();
        break;
    case 'mark_as_delivered':
    $coCtrl->markAsDelivered();
    break;


    default:
        // Récupère ou définit le code d'état de réponse HTTP. 
        http_response_code(404);
        include __DIR__ . '/views/notFound/notFound.php';
        exit;
}

?>