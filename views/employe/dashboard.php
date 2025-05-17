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
?>
<h1>Bienvenue Employé</h1>

<div>
<a href="../../index.php?action=logout">Se déconnecter</a>
</div>