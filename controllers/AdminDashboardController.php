<?php
require __DIR__ . '/../models/Product.php';

class AdminDashboardController 
{
    public function index()
    {
        $productModel = new Product();
        $count = $productModel->count_all_product();

        require __DIR__ . '/../views/admin/dashboard.php';
    }















}
?>