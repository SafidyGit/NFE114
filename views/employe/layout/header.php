<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/employe.css">
    <title>Employe dashboard</title>
</head>
<body>
<?php
// Récupère l'action courante depuis l'URL (ex: dashboard, list_orders)
// Si aucune action n'est définie, $currentPage est une chaîne vide
$currentPage = $_GET['action'] ?? '';

// Vérifie si un utilisateur est connecté (user_id défini en session)
$isLoggedIn = isset($_SESSION['user_id']);

// Vérifie si l'utilisateur connecté est un administrateur (role_id == 1)
$isAdmin = $isLoggedIn && $_SESSION['role_id'] == 1;
?>

<nav class="navbar bg-dark fixed-top ">
  <div class="container">
    <!-- Lien vers la page dashboard -->
    <a class="navbar-brand" href="index.php?action=dashboard">Acces</a>

    <ul class="nav  justify-content-center">
      <!-- Onglet Expedition, actif si $currentPage vaut 'dashboard' -->
      <li class="nav-item">
        <a class="nav-link <?php echo ($currentPage == 'dashboard') ? 'active' : ''; ?>" aria-current="page" href="index.php?action=dashboard">Expedition</a>
      </li>
      <!-- Onglet Commande, actif si $currentPage vaut 'list_orders' -->
      <li class="nav-item">
        <a class="nav-link <?php echo ($currentPage == 'list_orders') ? 'active' : ''; ?>" href="index.php?action=list_orders">Commande</a>
      </li>
    </ul>

    <div class="dropdown d-flex">
      <!-- Bouton affichant le nom d'utilisateur avec menu déroulant -->
      <button class="btn btn-outline-dark logout dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <?php echo $_SESSION['username']; ?>
      </button>
      <ul class="dropdown-menu">
        <?php if ($isAdmin): ?>
          <!-- Lien vers dashboard admin visible uniquement pour les admins -->
          <li><a class="dropdown-item" href="index.php?action=admin_dashboard">Dashboard</a></li>
        <?php endif; ?>
        <!-- Lien de déconnexion toujours visible -->
        <li><a class="dropdown-item" href="index.php?action=logout">Se déconnecter</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container container-employe">
<!-- Ici s’affichera le contenu spécifique au dashboard employé -->
