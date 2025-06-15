<?php
// Inclusion des modèles nécessaires pour la gestion des commandes clients
require_once __DIR__ . '/../models/Customer.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/CustomerOrder.php';
require_once __DIR__ . '/../models/CustomerOrderDetail.php';
require_once __DIR__ . '/../models/StockMovement.php';

class CustomerOrderController 
{
    // Déclaration des propriétés pour les différents modèles utilisés
    private $customerOrderModel;
    private $customerModel;
    private $productModel;
    private $customerOrderDetailModel;
    private $stockMovementModel;

    // Constructeur pour initialiser les modèles via injection de dépendances
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

    // Affiche la liste des commandes clients dans la vue admin
    public function index() 
    {
        $customer_orders = $this->customerOrderModel->get_all_customer_order();

        require __DIR__ . '/../views/admin/customer_order/index.php';
    }

    // Récupère un client par son ID via le modèle de commande client (probablement une méthode à revoir)
    public function get_customer_by_id($id)
    {
        $customer = $this->customerOrderModel->getById($id);

        return $customer;
    }

    // Affiche le formulaire de création d'une nouvelle commande client
    public function create()
    {
        require __DIR__ . '/../views/admin/customer_order/create.php';
    }

    // Traite la soumission du formulaire de création d'une commande client
    public function store() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération et nettoyage des données du formulaire
            $customer_order_reference = trim(htmlspecialchars($_POST['customer_order_reference']));
            $customer_order_date = trim(htmlspecialchars($_POST['customer_order_date']));
            $customer_order_status = trim(htmlspecialchars($_POST['customer_order_status']));
            $customer_id = trim(htmlspecialchars($_POST['customer_id']));
           
            // Appel au modèle pour ajouter la commande en base de données
            $this->customerOrderModel->add_customer_order(
                $customer_order_reference, 
                $customer_order_date, 
                $customer_order_status, 
                $customer_id
            );

            // Redirection vers la page de création avec message de succès
            header('Location: views/admin/customer_order/create.php?success=1');
            exit;
        } else {
            // Si la méthode n'est pas POST, on recharge la page de création
            require 'views/admin/customer_order/create.php';
        }
    }
    
    // Affiche le formulaire de modification d'une commande existante
    public function edit()
    {
        $id = $_GET['id'];
        $customer_order = $this->get_customer_by_id($id);

        require __DIR__ . '/../views/admin/customer_order/update.php';
    }

    // Traite la soumission du formulaire de modification d'une commande
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données postées et de l'ID de la commande à modifier
            $customer_order_id = $_GET['id'];
            $customer_order_reference = trim(htmlspecialchars($_POST['customer_order_reference']));
            $customer_order_date = trim(htmlspecialchars($_POST['customer_order_date']));
            $customer_order_status = trim(htmlspecialchars($_POST['customer_order_status']));
            $customer_id = trim(htmlspecialchars($_POST['customer_id']));
           
            // Mise à jour de la commande via le modèle
            $this->customerOrderModel->update_customer_order(
                $customer_order_id , 
                $customer_order_reference, 
                $customer_order_date, 
                $customer_order_status, 
                $customer_id
            );

            // Redirection vers la liste des commandes
            header('Location: /index.php?action=customer_order_list');
            exit;
        } else {
            // Si la méthode n'est pas POST, redirection vers la liste des commandes
            require 'index.php?action=customer_order_list';
        }
    }

    // Suppression d'une commande client
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération de l'ID de la commande à supprimer
            $customer_order_id = $_GET['id'];

            // Suppression via le modèle
            $this->customerOrderModel->delete_customer_order($customer_order_id);

            // Redirection vers la liste des commandes
            header('Location: /index.php?action=customer_order_list');
            exit;
        } else {
            // Si pas POST, redirection vers la liste des commandes
            require '/index.php?action=customer_order_list';
        }
    }
    
    // Partie réservée à l'employé pour confirmer la commande avec les produits sélectionnés
    public function confirm_order()
    {
        session_start();
        // Récupération des produits sélectionnés dans la session
        $selected = $_SESSION['selected_products'] ?? [];
        // Chargement de la vue de confirmation de commande
        require __DIR__ . '/../views/employe/order/confirm_order.php';
    }

    // Soumission finale de la commande par l'employé
    public function submit_order()
    {
        session_start();

        // Vérification que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Vous devez être connecté pour passer une commande.";
            header('Location: index.php?action=login');
            exit;
        }

        $userId = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données client et des produits commandés
            $customerData = $_POST['customer'] ?? null;
            $orderProducts = $_POST['order']['products'] ?? [];

            // Vérification que les données nécessaires sont présentes
            if (!$customerData || empty($orderProducts)) {
                $_SESSION['error'] = "Données manquantes pour finaliser la commande.";
                header('Location: index.php?action=dashboard');
                exit;
            }

            // Validation des champs du client
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

            // Insertion du client dans la base et récupération de son ID
            $customerId = $this->customerModel->add_customer(
                $customerData['customer'],
                $customerData['customer_address'],
                $customerData['customer_phone_number'],
                $customerData['customer_email']
            );

            // Création de la commande avec référence, date et statut
            $orderReference = 'CMD-' . date('m-H:i') ;
            $orderDate = date('Y-m-d');
            $orderStatus = 'En cours';

            $orderId = $this->customerOrderModel->add_customer_order(
                $orderReference,
                $orderDate,
                $orderStatus,
                $customerId
            );

            // Parcours des produits sélectionnés pour créer les détails de la commande
            foreach ($orderProducts as $productData) {
                $productId = $productData['product_id'];
                $quantity = (int) $productData['quantity'];
                $unitPrice = (float) $productData['unit_price'];
                $totalPrice = $unitPrice * $quantity;

                // Récupération du produit pour vérifier le stock
                $product = $this->productModel->getById($productId);
                if (!$product) continue;

                // Vérification que la quantité demandée est valide
                if ($quantity <= 0 || $quantity > $product['product_quantity_stock']) {
                    continue; // Ignorer si quantité invalide
                }

                // Ajout du détail de la commande (ligne produit)
                $this->customerOrderDetailModel->add_customer_order_detail(
                    $quantity,
                    $totalPrice,
                    $productId,
                    $orderId,
                    $userId
                );

                // Mise à jour du stock produit
                $newStock = $product['product_quantity_stock'] - $quantity;
                $this->productModel->updateStock($productId, $newStock);

                // Enregistrement du mouvement de stock (sortie)
                $this->stockMovementModel->add_stockmovement(
                    'sortie',
                    $orderDate,
                    $quantity,
                    $productId
                );
            }

            // Suppression des produits sélectionnés en session après validation
            unset($_SESSION['selected_products']);

            // Redirection avec message de succès vers la liste des commandes
            $_SESSION['success'] = "Commande enregistrée avec succès.";
            header('Location: index.php?action=list_orders');
            exit;
        }
    }

    // Affiche la liste des commandes pour l'employé
    public function listOrders()
    {
        // Récupération de toutes les commandes via le modèle
        $orders = $this->customerOrderModel->get_customer_order_list();

        // Inclusion de la vue qui affichera la liste
        require __DIR__ . '/../views/employe/order/list_orders.php';
    }

    // Marque une commande comme livrée
    public function markAsDelivered()
    {
        if (isset($_GET['order_id'])) {
            $orderId = $_GET['order_id'];
            // Mise à jour du statut de la commande
            $this->customerOrderModel->updateOrderStatus($orderId, 'Livré');
        }

        // Redirection vers la liste des commandes
        header('Location: index.php?action=list_orders');
        exit;
    }

    // Affiche les détails d'une commande donnée
    public function orderdetail()
    {
        // Vérification que l'ID de commande est fourni
        if (!isset($_GET['order_id'])) {
            $_SESSION['error'] = "Commande introuvable.";
            header('Location: index.php?action=list_orders');
            exit;
        }

        $orderId = $_GET['order_id'];
        // Récupération des informations de la commande
        $order = $this->customerOrderModel->get_customer_order_by_id($orderId);
        $orderDetails = $this->customerOrderDetailModel->get_order_details($orderId);

        // Vérification que la commande existe
        if (!$order) {
            $_SESSION['error'] = "Commande introuvable.";
            header('Location: index.php?action=list_orders');
            exit;
        }

        // Inclusion de la vue affichant le détail de la commande
        require __DIR__ . '/../views/employe/order/commande.php';
    }

}
