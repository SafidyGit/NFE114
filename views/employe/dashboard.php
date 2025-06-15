<?php
session_start(); // Démarre la session pour accéder à $_SESSION

// Vérifie si l'utilisateur est connecté et possède un rôle autorisé (1 = admin, 2 = employé)
if (
    !isset($_SESSION['user_id']) ||                          // Si aucun utilisateur n'est connecté
    !in_array($_SESSION['role_id'], [1, 2])                 // OU si le rôle n'est ni admin ni employé
) {
    // Définir un message d'erreur
    $_SESSION['error'] = "Accès non autorisé. Veuillez vous connecter avec un compte valide.";

    // Redirection vers la page de connexion
    header('Location: index.php?action=login');
    exit;
}

// À partir d'ici, l'utilisateur est bien connecté et autorisé
include __DIR__ . '/layout/header.php';
?>
<!-- contenu du div container dans header.php -->
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
        
<?php include 'expedition.php' ;?>
<!--  -->
<?php include __DIR__. '/layout/footer.php';?>