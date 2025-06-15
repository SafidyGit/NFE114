<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?action=login');
    exit;
}
if ($_SESSION['role_id'] != 2) {
    echo "Accès refusé.";
    exit;
}

include __DIR__ . '/layout/header.php';
// Ces variables viennent du contrôleur
// $categories, $products, $searchTerm, $categoryId
?>

<h1 class="text-center mb-4">Expédier des produits</h1>

<div class="row">
    <div class="col"></div>
    <div class="col">
        <form class="d-flex" method="GET" action="index.php">
    <input type="hidden" name="action" value="dashboard">
    <input class="form-control me-2" type="search" name="search" placeholder="Rechercher un produit"
           value="<?= htmlspecialchars($searchTerm ?? '') ?>" style="border-radius:2rem" />
    <button class="btn btn-outline-dark" type="submit" style="border-radius:2rem">Chercher</button>
</form>
    </div>
    <div class="col"></div>
</div>
 <?php 
        // Affichage du message d'erreur s'il existe en session
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert- w-50 m-auto mt-3 text-center alert-dismissible fade show alert-login" role="alert">' 
         . htmlspecialchars($_SESSION['error']) . 
         '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>';
    unset($_SESSION['error']);
                                
}
        ?>

<?php include 'expedition.php'; ?>

<?php include __DIR__ . '/layout/footer.php'; ?>