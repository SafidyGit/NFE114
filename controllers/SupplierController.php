<?php

require_once __DIR__ . '/../models/Supplier.php';

class SupplierController 
{
    private Supplier $supplierModel;

    public function __construct(Supplier $supplierModel)
    {
        $this->supplierModel = $supplierModel;
    }

    // Recuperer la liste des fournisseurs
    public function index() 
    {
        $suppliers = $this->supplierModel->get_all_supplier();

        require __DIR__ . '/../views/admin/supplier/index.php';
    }

    // Rechercher un fournisseur par son identifiant
    public function get_supplier_by_id($id)
    {
        $supplier = $this->supplierModel->getById($id);

        return $supplier;
    }

    // rediriger vers le formulaire de création de fournisseur
    public function create()
    {
        require __DIR__ . '/../views/admin/supplier/create.php';
    }

    // Envoyer la requete post pour enregistrer un fournisseur
    public function store() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplier = trim(htmlspecialchars($_POST['supplier']));
            $supplier_address = trim(htmlspecialchars($_POST['supplier_address']));
            $supplier_phone_number = trim(htmlspecialchars($_POST['supplier_phone_number']));
            $supplier_email = trim(htmlspecialchars($_POST['supplier_email']));
           
            $this->supplierModel->add_supplier(
                $supplier, 
                $supplier_address, 
                $supplier_phone_number, 
                $supplier_email
            );

            header('Location: index.php?action=supplier_create&success=1');
            exit;
        } else {
            header('Location: index.php?action=supplier_create');
        
        }
    }
    
    // Acceder à un formulaire de modification d'un formulaire
    public function edit()
    {
        $id = $_GET['id'];
        $supplier = $this->get_supplier_by_id($id);

        require __DIR__ . '/../views/admin/supplier/update.php';
    }

    // Requete post pour update un fournisseur
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplier_id = $_GET['id'];
            $supplier = trim(htmlspecialchars($_POST['supplier']));
            $supplier_address = trim(htmlspecialchars($_POST['supplier_address']));
            $supplier_phone_number = trim(htmlspecialchars($_POST['supplier_phone_number']));
            $supplier_email = trim(htmlspecialchars($_POST['supplier_email']));
           
            // Appel de la fonction pour enregistrer les modifications dans fournisseurs
            $this->supplierModel->update_supplier(
                $supplier_id , 
                $supplier, 
                $supplier_address, 
                $supplier_phone_number, 
                $supplier_email
            );

            header('Location: index.php?action=supplier_list');
            exit;
        } else {
            header('Location: index.php?action=supplier_list');
        
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplier_id = $_GET['id'];

            $this->supplierModel->delete_supplier($supplier_id);

            header('Location: index.php?action=supplier_list');
            exit;
        } else {
            header('Location: index.php?action=supplier_list');
        }
    }
    
}
