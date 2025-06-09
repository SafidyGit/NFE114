<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../index.php?action=login');
    exit;
}

if ($_SESSION['role_id'] != 2) {
    echo "Accès refusé.";
    exit;
}
include 'layout/header.php';
?>
<?php
      require_once __DIR__ . '/../../controllers/ProductController.php';
      require_once __DIR__ . '/../../controllers/CategoryController.php';
      require_once __DIR__ . '/../../controllers/SupplierController.php';
  

    $productController = new ProductController();
    $products = $productController->index();

    $categoryController = new CategoryController();
    $categories = $categoryController->index();

    $supplierController = new SupplierController();
    $suppliers = $supplierController->index();
?>
<!-- contenu du div container dans header.php -->
    <h1 class="text-center mb-4">Expédier des produits</h1>
    <div class="row">
        <div class="col"> </div>
        <div class="col">
            <form class="d-flex" role="search" >
                <input class="form-control me-2" type="search" placeholder="Chercher produit" style="border-radius:2rem" aria-label="Search"/>
                <button class="btn btn-outline-dark" type="submit" style="border-radius:2rem">Chercher</button>
            </form>
        </div>
        <div class="col"></div>
    </div>
        
<?php include 'expedition.php' ;?>
<!--  -->
<?php include 'layout/footer.php';?>