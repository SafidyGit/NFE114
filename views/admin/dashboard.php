<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../index.php?action=login');
    exit;
}

if ($_SESSION['role_id'] != 1) {
    echo "Accès refusé.";
    exit;
}

?>
<h1>Bienvenue Admin</h1>

<div>
<a href="../../index.php?action=logout">Se déconnecter</a>
</div>

<div>
<a href="category/index.php">Liste des catégories de produits</a>
</div>