<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
  // Récuperation de la valeur de username
  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
  }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gestion de stock</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
 <link rel="stylesheet" href="public/css/employe.css">
  <style>
    body {
      min-height: 100vh;
      display: flex;
    }

    .sidebar {
      width: 250px;
    }

    @media (max-width: 991.98px) {
      .sidebar {
        display: none;
      }
    }
  </style>
</head>
<body class="bg-dark text-light">
<nav class="navbar bg-dark text-light fixed-top d-none d-md-block">
  <div class="container">
    <a class="navbar-brand" href="index.php?action=dashboard">Acces</a>
    <div class="dropdown d-flex">
    <button class="btn btn-outline-dark logout dropdown-toggle text-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    <?php echo $_SESSION['username']; ?>
  </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="index.php?action=admin_dashboard">Dashboard</a></li>
          <li><a class="dropdown-item" href="index.php?action=logout">Se déconnecter</a></li>
        </ul>
    </div>
    
  </div>
</nav>
<?php include 'sidebar.php';?>

