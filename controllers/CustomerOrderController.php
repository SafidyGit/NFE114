<?php
require_once __DIR__ . '/../models/Customer.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/CustomerOrder.php';
require_once __DIR__ . '/../models/CustomerOrderDetail.php';
require_once __DIR__ . '/../models/StockMovement.php';


class CustomerOrderController 
{
    private $customerOrderModel;
    private $customerModel;
    private $productModel;
    private $customerOrderDetailModel;
    private $stockMovementModel;


    public function __construct(
        Customer $customerModel,
        Product $productModel,
        CustomerOrder $customerOrderModel,
        CustomerOrderDetail $customerOrderDetailModel,
        StockMovement $stockMovementModel
    )
    {
        $this->customerModel = $customerModel;
        $this->productModel = $productModel;
        $this->customerOrderModel = $customerOrderModel;
        $this->customerOrderDetailModel = $customerOrderDetailModel;
        $this->stockMovementModel = $stockMovementModel;
    }

    public function index() 
    {
        $customer_orders = $this->customerOrderModel->get_all_customer_order();

        require __DIR__ . '/../views/admin/customer_order/index.php';
    }

    public function get_customer_by_id($id)
    {
        $customer = $this->customerOrderModel->getById($id);

        return $customer;
    }

    public function create()
    {
        require __DIR__ . '/../views/admin/customer_order/create.php';
    }

    public function store() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customer_order_reference = trim(htmlspecialchars($_POST['customer_order_reference']));
            $customer_order_date = trim(htmlspecialchars($_POST['customer_order_date']));
            $customer_order_status = trim(htmlspecialchars($_POST['customer_order_status']));
            $customer_id = trim(htmlspecialchars($_POST['customer_id']));
           
            $this->customerOrderModel->add_customer_order(
                $customer_order_reference, 
                $customer_order_date, 
                $customer_order_status, 
                $customer_id
            );

            header('Location: views/admin/customer_order/create.php?success=1');
            exit;
        } else {
            require 'views/admin/customer_order/create.php';
        
        }
    }
    
    public function edit()
    {
        $id = $_GET['id'];
        $customer_order = $this->get_customer_by_id($id);

        require __DIR__ . '/../views/admin/customer_order/update.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customer_order_id = $_GET['id'];
            $customer_order_reference = trim(htmlspecialchars($_POST['customer_order_reference']));
            $customer_order_date = trim(htmlspecialchars($_POST['customer_order_date']));
            $customer_order_status = trim(htmlspecialchars($_POST['customer_order_status']));
            $customer_id = trim(htmlspecialchars($_POST['customer_id']));
           

            $this->customerOrderModel->update_customer_order(
                $customer_order_id , 
                $customer_order_reference, 
                $customer_order_date, 
                $customer_order_status, 
                $customer_id
            );

            header('Location: /index.php?action=customer_order_list');
            exit;
        } else {
            require 'index.php?action=customer_order_list';
        
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customer_order_id = $_GET['id'];

            $this->customerOrderModel->delete_customer_order($customer_order_id);

            header('Location: /index.php?action=customer_order_list');
            exit;
        } else {
            require '/index.php?action=customer_order_list';
        }
    }
    
    // Pour la partie employé
     public function confirm_order() // confirmer le choix des produix pour la commande
    {
        session_start();
        $selected = $_SESSION['selected_products'] ?? [];
        require __DIR__ . '/../views/employe/order/confirm_order.php';
    }

    public function submit_order()
    {
        session_start();

        // Vérifie que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Vous devez être connecté pour passer une commande.";
            header('Location: index.php?action=login');
            exit;
        }

        $userId = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customerData = $_POST['customer'] ?? null;
            $orderProducts = $_POST['order']['products'] ?? [];

            // Vérification des données reçues
            if (!$customerData || empty($orderProducts)) {
                $_SESSION['error'] = "Données manquantes pour finaliser la commande.";
                header('Location: index.php?action=dashboard');
                exit;
            }

            // Validation des champs client
            if (
                empty($customerData['customer']) ||
                empty($customerData['customer_address']) ||
                empty($customerData['customer_phone_number']) ||
                empty($customerData['customer_email'])
            ) {
                $_SESSION['error'] = "Veuillez remplir tous les champs du client.";
                header('Location: index.php?action=confirm_order');
                exit;
            }

            // 1. Insertion du client
            $customerId = $this->customerModel->add_customer(
                $customerData['customer'],
                $customerData['customer_address'],
                $customerData['customer_phone_number'],
                $customerData['customer_email']
            );

            // 2. Création de la commande
            $orderReference = 'CMD-' . date('YmdHis');
            $orderDate = date('Y-m-d');
            $orderStatus = 'En cours';

            $orderId = $this->customerOrderModel->add_customer_order(
                $orderReference,
                $orderDate,
                $orderStatus,
                $customerId
            );

            // 3. Parcours des produits sélectionnés
            foreach ($orderProducts as $productData) {
                $productId = $productData['product_id'];
                $quantity = (int) $productData['quantity'];
                $unitPrice = (float) $productData['unit_price'];
                $totalPrice = $unitPrice * $quantity;

                // Vérifie le stock
                $product = $this->productModel->getById($productId);
                if (!$product) continue;

                if ($quantity <= 0 || $quantity > $product['product_quantity_stock']) {
                    continue; // ignore produit si quantité invalide
                }

                // 3.1 Détail de commande
                $this->customerOrderDetailModel->add_customer_order_detail(
                    $quantity,
                    $totalPrice,
                    $productId,
                    $orderId,
                    $userId
                );

                // 3.2 Mise à jour du stock
                $newStock = $product['product_quantity_stock'] - $quantity;
                $this->productModel->updateStock($productId, $newStock);

                // 3.3 Mouvement de stock (sortie)
                $this->stockMovementModel->add_stockmovement(
                    'sortie',
                    $orderDate,
                    $quantity,
                    $productId
                );
            }

            // Nettoyage session produits sélectionnés (si utilisée)
            unset($_SESSION['selected_products']);

            // Redirection finale
            $_SESSION['success'] = "Commande enregistrée avec succès.";
            header('Location: index.php?action=list_orders');
            exit;
        }
    }

    public function listOrders()
    {
        // Récupérer la liste des commandes via le modèle CustomerOrder
        $orders = $this->customerOrderModel->get_customer_order_list();

        // Inclure la vue qui affichera la liste
        require __DIR__ . '/../views/employe/order/list_orders.php';
    }
    public function markAsDelivered()
    {
        if (isset($_GET['order_id'])) {
            $orderId = $_GET['order_id'];
            $this->customerOrderModel->updateOrderStatus($orderId, 'Livré');
        }

        header('Location: index.php?action=list_orders');
        exit;
    }
}
