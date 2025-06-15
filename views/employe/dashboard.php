<?php
session_start(); // Démarre la session pour accéder aux variables de session ($_SESSION)

// Vérifie si l'utilisateur est connecté et possède un rôle autorisé (1 = admin, 2 = employé)
if (
    !isset($_SESSION['user_id']) ||             // Si aucun utilisateur n'est connecté
    !in_array($_SESSION['role_id'], [1, 2])    // OU si le rôle n'est ni admin ni employé
) {
    // Définit un message d'erreur dans la session pour informer l'utilisateur
    $_SESSION['error'] = "Accès non autorisé. Veuillez vous connecter avec un compte valide.";

    // Redirige vers la page de connexion
    header('Location: index.php?action=login');
    exit; // Stoppe l'exécution du script après redirection
}

// À partir d'ici, l'utilisateur est connecté et a les droits nécessaires

// Inclusion de l'en-tête commun (header.php)
include __DIR__ . '/layout/header.php';
?>
<!-- Contenu principal affiché dans la page, après le header -->

<!-- Titre centré avec marge inférieure -->
<h1 class="text-center mb-4">Expédier des produits</h1>

<!-- Mise en page avec une ligne (row) contenant 3 colonnes -->
<div class="row">
    <div class="col"></div> <!-- Colonne vide à gauche pour espacement -->

    <!-- Colonne centrale avec un formulaire de recherche -->
    <div class="col">
        <form class="d-flex" method="GET" action="index.php">
            <!-- Champ caché pour définir l'action à "dashboard" -->
            <input type="hidden" name="action" value="dashboard">

            <!-- Champ de recherche texte avec valeur pré-remplie si existe -->
            <input class="form-control me-2" type="search" name="search" placeholder="Rechercher un produit"
                value="<?= htmlspecialchars($searchTerm ?? '') ?>" style="border-radius:2rem" />

            <!-- Bouton de soumission du formulaire -->
            <button class="btn btn-outline-dark" type="submit" style="border-radius:2rem">Chercher</button>
        </form>
    </div>

    <div class="col"></div> <!-- Colonne vide à droite pour espacement -->
</div>

<?php 
// Inclusion du fichier 'expedition.php' contenant probablement la liste ou le contenu spécifique de la page
include 'expedition.php'; 
?>

<!-- Inclusion du pied de page commun -->
<?php include __DIR__ . '/layout/footer.php'; ?>
