<?php

require_once __DIR__ . '/../models/CustomerOrder.php';

class CustomerOrderController {

    public function index() 
    {
        $customerOrderModel = new CustomerOrder();
        $customer_orders = $customerOrderModel->get_all_customer_order();

        require __DIR__ . '/../views/admin/customer_order/index.php';
    }

    public function get_customer_by_id($id)
    {
        $customerOrderModel = new Customer();
        $customer = $customerOrderModel->getById($id);

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
           
            $customerOrderModel = new Customer();
            $customerOrderModel->add_customer(
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
           

            $customerOrderModel = new Customer();
            $customerOrderModel->update_customer(
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

            $customerOrderModel = new Customer();
            $customerOrderModel->delete_customer($customer_order_id);

            header('Location: /index.php?action=customer_order_list');
            exit;
        } else {
            require '/index.php?action=customer_order_list';
        }
    }
    
}
