<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/employe.css">
    <title>Employe dashboard</title>
</head>
<body>
<?php
  // Obtenir le nom du fichier courant 
  $currentPage = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar  bg-dark fixed-top ">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">Acces</a>
    <ul class="nav  justify-content-center">
      <li class="nav-item">
        <a class="nav-link <?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>" aria-current="page" href="dashboard.php">Expedition</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($currentPage == 'commande.php') ? 'active' : ''; ?>" href="commande.php">Commande</a>
      </li>
    </ul>
    <div class="dropdown d-flex">
    <button class="btn btn-outline-dark logout dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Name
  </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../../index.php?action=logout">Se déconnecter</a></li>
        </ul>
    </div>
    
  </div>
</nav>


<div class="container container-employe">
<!-- Contenu dashboard ici -->
