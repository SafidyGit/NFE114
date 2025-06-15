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
  // Obtenir le nom du fichier courant 
 $currentPage = $_GET['action'] ?? ''; // si action n'existe pas, ça vaut ''
 $isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = $isLoggedIn && $_SESSION['role_id'] == 1;
?>
<nav class="navbar bg-dark fixed-top ">
  <div class="container">
    <a class="navbar-brand" href="index.php?action=dashboard">Acces</a>
    <ul class="nav  justify-content-center">
      <li class="nav-item">
        <a class="nav-link <?php echo ($currentPage == 'dashboard') ? 'active' : ''; ?>" aria-current="page" href="index.php?action=dashboard">Expedition</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($currentPage == 'list_orders') ? 'active' : ''; ?>" href="index.php?action=list_orders">Commande</a>
      </li>
    </ul>
    <div class="dropdown d-flex">
    <button class="btn btn-outline-dark logout dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
   <?php echo $_SESSION['username']; ?>
  </button>
        <ul class="dropdown-menu">
          <?php if ($isAdmin): ?>
        <!-- Lien visible uniquement pour l'administrateur -->
        <li><a class="dropdown-item" href="index.php?action=admin_dashboard">Dashboard</a></li>
      <?php endif; ?>
            <li><a class="dropdown-item" href="index.php?action=logout">Se déconnecter</a></li>
        </ul>
    </div>
    
  </div>
</nav>


<div class="container container-employe">
<!-- Contenu dashboard ici -->