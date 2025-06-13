<?php
require_once __DIR__ . '/../models/Product.php';

class AdminDashboardController 
{
    private Product $productModel;

    public function __construct(Product $productModel) 
    {
        $this->productModel = $productModel;
    }

    public function index() : void
    {
        $count_product_in_stock = $this->productModel->count_all_product_in_stock();
        $out_of_stock = $this->productModel->out_of_stock_count();
        $alert_stock = $this->productModel->product_alert_stock();
        $totalProductsByCategory = $this->productModel->totalProductsByCategory();

        require __DIR__ . '/../views/admin/dashboard.php';
    }

}
?>