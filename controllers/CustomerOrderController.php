<?php
require_once __DIR__ . '/../models/Customer.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/CustomerOrder.php';
require_once __DIR__ . '/../models/CustomerOrderDetail.php';
require_once __DIR__ . '/../models/StockMovement.php';

class CustomerOrderController {
    private $customerModel;
    private $productModel;
    private $customerOrderModel;
    private $customerOrderDetailModel;
    private $stockMovementModel;

    public function __construct(
        Customer $customerModel,
        Product $productModel,
        CustomerOrder $customerOrderModel,
        CustomerOrderDetail $customerOrderDetailModel,
        StockMovement $stockMovementModel
    ) {
        $this->customerModel = $customerModel;
        $this->productModel = $productModel;
        $this->customerOrderModel = $customerOrderModel;
        $this->customerOrderDetailModel = $customerOrderDetailModel;
        $this->stockMovementModel = $stockMovementModel;
    }

    public function confirm_order()
    {
        session_start();
        $selected = $_SESSION['selected_products'] ?? [];
        require __DIR__ . '/../views/employe/order/confirm_order.php';
    }

    public function submit_order()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customerData = $_POST['customer'] ?? null;
            $orderProducts = $_POST['order']['products'] ?? [];

            if (!$customerData || empty($orderProducts)) {
                $_SESSION['error'] = "Données manquantes.";
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
                $_SESSION['error'] = "Veuillez remplir tous les champs client.";
                header('Location: index.php?action=confirm_order');
                exit;
            }

            // Ajout du client
            $customerId = $this->customerModel->add_customer(
                $customerData['customer'],
                $customerData['customer_address'],
                $customerData['customer_phone_number'],
                $customerData['customer_email']
            );

            // Génération de la référence commande
            $orderReference = 'CMD-' . date('YmdHis');

            // Création de la commande
            $orderId = $this->customerOrderModel->add_customer_order(
                $orderReference,
                date('Y-m-d'),
                'En cours',
                $customerId
            );

            // Traitement des produits
            foreach ($orderProducts as $productData) {
                $productId = $productData['product_id'];
                $quantity = (int) $productData['quantity'];
                $unitPrice = (float) $productData['unit_price'];
                $totalPrice = $unitPrice * $quantity;

                // Vérifier l'existence et la quantité en stock
                $product = $this->productModel->getById($productId);
                if ($product && $quantity > 0 && $quantity <= $product['product_quantity_stock']) {
                    $userId = $_SESSION['user_id']; // 

                    $this->customerOrderDetailModel->add_customer_order_detail(
                        $quantity,
                        $totalPrice,
                        $productId,
                        $orderId,
                        $userId
                    );

                    // Mettre à jour le stock
                    $newStock = $product['product_quantity_stock'] - $quantity;
                    $this->productModel->updateStock($productId, $newStock);

                    // Enregistrer mouvement stock (sortie)
                    $this->stockMovementModel->add_stockmovement(
                        'sortie',   
                        date('Y-m-d'),         
                        $quantity,
                        $productId
                    );
                }
            }

            // Nettoyer la session (produits sélectionnés)
            unset($_SESSION['selected_products']);

            // Redirection vers liste des commandes
            header('Location: index.php?action=list_orders');
            exit;
        }
    }
    public function listOrders()
    {
        // Récupérer la liste des commandes via le modèle CustomerOrder
        $orders = $this->customerOrderModel->get_all_customer_order();

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