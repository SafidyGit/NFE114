<?php
require_once __DIR__ . '/../models/SupplierOrder.php';
require_once __DIR__ . '/../models/SupplierOrderDetail.php';
require_once __DIR__ . '/../models/Supplier.php';
require_once __DIR__ . '/../models/Product.php';

class SupplierOrderController 
{
    private SupplierOrder $supplierOrderModel;
    private SupplierOrderDetail $supplierOrderDetailModel;
    private Supplier $supplierModel;
    private Product $productModel;

    public function __construct(SupplierOrder $supplierOrderModel, Supplier $supplierModel, Product $productModel, SupplierOrderDetail $supplierOrderDetailModel)
    {
        $this->supplierOrderModel = $supplierOrderModel;
        $this->supplierOrderDetailModel = $supplierOrderDetailModel;
        $this->supplierModel = $supplierModel;
        $this->productModel = $productModel;
    }

    public function index() 
    {
        $supplier_orders = $this->supplierOrderModel->get_all_supplier_order();

        require __DIR__ . '/../views/admin/supplier_order/index.php';
    }

    public function get_customer_by_id($id)
    {
        $customer = $this->supplierOrderModel->getById($id);

        return $customer;
    }

    public function create()
    {
        
        // Recuperer l'id du produit via le select , null si id n'existe pas
        $selected_product_id = $_GET['selected_product_id'] ?? null;
        // Recup de l'id de produit pour pouvoir recup le prix dans un value
        $product = $this->productModel->getById($selected_product_id);
        

        $next_supplier_order_id = $this->supplierOrderModel->get_last_id_supplier_order() + 1;
        $supplier_list = $this->supplierModel->get_all_supplier();
        $product_list = $this->productModel->get_all_product();


        // Récuperation de la date du jour
        $date_now = new DateTime();
        $date = $date_now->format('d M Y');

        require __DIR__ . '/../views/admin/supplier_order/create.php';
    }
    
    // Enregistrement sur SupplierOrder et SupplierOrderDetail (commande Fournisseur) et update sur Produit
    public function store()
    {
        // récuperer le prochain supplier_order_id
        $next_supplier_order_id = $this->supplierOrderModel->get_last_id_supplier_order() + 1;
        // recuperer la quantité selon l'id de produits 
        $product_for_quantity_operation = $this->productModel->getById($_GET['selected_product_id']);
        $product_quantity = $product_for_quantity_operation['product_quantity_stock'];

        // Date du jours
        $date = date('Y-m-d');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récuperation des valeurs entrées danss les champs pour commande Fournisseur
            $supplier_order_reference = trim(htmlspecialchars($_POST['supplier_order_reference']));
            $supplier_order_date = $date;
            $supplier_order_status = trim(htmlspecialchars($_POST['supplier_order_status']));
            $supplier_id = trim(htmlspecialchars($_POST['supplier_id']));
           
            // Récuperation des valeurs entrées danss les champs pour commande Detail Fournisseur 
            $so_quantity = trim(htmlspecialchars($_POST['so_quantity']));
            $purchase_price = trim(htmlspecialchars($_POST['purchase_price']));
            // Fonction accessible pour l'admin seulement donc user_id = 1
            $user_id = 1;
            $supplier_order_id = $next_supplier_order_id;
           
            // Récuperation des valeurs entrées dans les champs de Produit
            $product_id = $_GET['selected_product_id'];

            // Appel à la fonction add_supplier_order() pour 
            // enregistrer une ligne dans la table supplierorder
            $this->supplierOrderModel->add_supplier_order(
                $supplier_order_reference, 
                $supplier_order_date, 
                $supplier_order_status, 
                $supplier_id

            );

            // Appel à la fonction add_supplier_order_detail() pour 
            // enregistrer une ligne dans la table supplier_order_detail
            $this->supplierOrderDetailModel->add_supplier_order_detail(
                $so_quantity, 
                $purchase_price, 
                $user_id, 
                $product_id,
                $supplier_order_id

            );

            // test si supplier_order_status == livrée
            if($supplier_order_status === 'Livrée'){
                // Récuperation des valeurs entrées dans les champs de Produit
                $product_id = $_GET['selected_product_id'];
                // Produit en stock = produit entré + stock actuel
                $product_quantity_stock = $so_quantity + $product_quantity;
                $product_unit_price = $purchase_price;
                // Appel à la fonction update_product_from_supplier_order() dans models/supplierOrder.php
                // Mise à jour de la quantité en stock / update prix possible
                $this->supplierOrderModel->update_product_from_supplier_order(
                    $product_id , 
                    $product_quantity_stock, 
                    $product_unit_price, 
                );
            }

            header('Location: index.php?action=supplier_order_create&success=1');
            exit;
        } else {
            header('Location: index.php?action=supplier_order_create');
        
        }
    }

    // Validation des commandes en attente
    public function validate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplier_order_id = $_GET['id'];
            // recuperer le supplier order detail dans l'url de post
            $supplier_order_detail_id = $_GET['sod_id']; 

            // Recuperer le supplier order detail avec l'id $supplier_order_detail_id
            $order_detail = $this->supplierOrderDetailModel->getById($supplier_order_detail_id);

            // Recuperer le product_id via l'url
            $product_id = $_GET['product_id'];
            $product = $this->productModel->getById($product_id);
            // Calcul de la quantité 
            $new_quantity_stock = $product['product_quantity_stock'] + $order_detail['so_quantity'];

            // appel de la fonction pour modifier le statut dans supllierorder 
            $this->supplierOrderModel->update_supplier_order_status($supplier_order_id, 'Livrée');

            // Appel à la fonction update_product_from_supplier_order() dans models/supplierOrder.php
            // Mise à jour de la quantité en stock / recuperation du prix, pas de modification
            $this->supplierOrderModel->update_product_from_supplier_order(
                $product_id , 
                $new_quantity_stock, 
                $product['product_unit_price'], 
            );

            header('Location: index.php?action=supplier_order_list');
            exit;
            } else {
                header('Location: index.php?action=supplier_order_list');
            
            }
    }    
    

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplier_order_id = $_GET['id'];
            $supplier_order_reference = trim(htmlspecialchars($_POST['supplier_order_reference']));
            $supplier_order_date = trim(htmlspecialchars($_POST['supplier_order_date']));
            $supplier_order_status = trim(htmlspecialchars($_POST['supplier_order_status']));
            $supplier_id = trim(htmlspecialchars($_POST['supplier_id']));
           

            $this->supplierOrderModel->update_supplier_order(
                $supplier_order_id , 
                $supplier_order_reference, 
                $supplier_order_date, 
                $supplier_order_status, 
                $supplier_id
            );

            header('Location: index.php?action=supplier_order_list');
            exit;
        } else {
            header('Location: index.php?action=supplier_order_list');
        
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplier_order_id = $_GET['id'];

            $this->supplierOrderModel->delete_supplier_order($supplier_order_id);

            header('Location: index.php?action=supplier_order_list');
            exit;
        } else {
            header('Location: index.php?action=supplier_order_list');
        }
    }
    
}
