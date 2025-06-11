<?php

require_once __DIR__ . '/../models/Customer.php';

class CustomerController {

    public function index() 
    {
        $customerModel = new Customer();
        $customers = $customerModel->get_all_customer();

        require __DIR__ . '/../views/admin/customer/index.php';
    }

    public function get_customer_by_id($id)
    {
        $customerModel = new Customer();
        $customer = $customerModel->getById($id);

        return $customer;
    }

    public function create()
    {
        require __DIR__ . '/../views/admin/customer/create.php';
    }

    public function store() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customer = trim(htmlspecialchars($_POST['customer']));
            $customer_address = trim(htmlspecialchars($_POST['customer_address']));
            $customer_phone_number = trim(htmlspecialchars($_POST['customer_phone_number']));
            $customer_email = trim(htmlspecialchars($_POST['customer_email']));
           
            $customerModel = new Customer();
            $customerModel->add_customer(
                $customer, 
                $customer_address, 
                $customer_phone_number, 
                $customer_email
            );

            header('Location: views/admin/customer/create.php?success=1');
            exit;
        } else {
            require 'views/admin/customer/create.php';
        
        }
    }
    
    public function edit()
    {
        $id = $_GET['id'];
        $customer = $this->get_customer_by_id($id);

        require __DIR__ . '/../views/admin/customer/update.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customer_id = $_GET['id'];
            $customer = trim(htmlspecialchars($_POST['customer']));
            $customer_address = trim(htmlspecialchars($_POST['customer_address']));
            $customer_phone_number = trim(htmlspecialchars($_POST['customer_phone_number']));
            $customer_email = trim(htmlspecialchars($_POST['customer_email']));
           

            $customerModel = new Customer();
            $customerModel->update_customer(
                $customer_id , 
                $customer, 
                $customer_address, 
                $customer_phone_number, 
                $customer_email
            );

            header('Location: /index.php?action=customer_list');
            exit;
        } else {
            require 'index.php?action=customer_list';
        
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customer_id = $_GET['id'];

            $customerModel = new Customer();
            $customerModel->delete_customer($customer_id);

            header('Location: /index.php?action=customer_list');
            exit;
        } else {
            require '/index.php?action=customer_list';
        }
    }
    
}
