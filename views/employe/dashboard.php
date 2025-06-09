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

    require_once __DIR__ . '/../../controllers/ProductController.php';
    require_once __DIR__ . '/../../controllers/CategoryController.php';
    require_once __DIR__ . '/../../controllers/SupplierController.php';
   
    $productController = new ProductController();
    $categoryController = new CategoryController();
    $supplierController = new SupplierController();

    $categories = $categoryController->index();
    $suppliers = $supplierController->index();

    $categoryId = $_GET['categorie'] ?? '';
    $searchTerm = $_GET['search'] ?? '';

    


    if (!empty($searchTerm)) {
        // Recherche par nom de produit prioritaire
        $products = $productController->search_products($searchTerm);
    } else {
        if ($categoryId !== '' && $categoryId !== null) {
            // Filtrer par catégorie
            $products = $productController->get_products_by_category($categoryId);
        } else {
            // Pas de filtre, afficher tous
            $products = $productController->index();
        }
    }
    
?>
<!-- contenu du div container dans header.php -->
    <h1 class="text-center mb-4">Expédier des produits</h1>
    <div class="row">
        <div class="col"> </div>
        <div class="col">
            <form class="d-flex" role="search" >
                <input class="form-control me-2" type="search"  style="border-radius:2rem" name="search" placeholder="Rechercher un produit" value="<?= htmlspecialchars($searchTerm ?? '') ?>" aria-label="Search"/>
                <button class="btn btn-outline-dark" type="submit" style="border-radius:2rem">Chercher</button>
            </form>
        </div>
        <div class="col"></div>
    </div>
        
<?php include 'expedition.php' ;?>
<!--  -->
<?php include 'layout/footer.php';?>