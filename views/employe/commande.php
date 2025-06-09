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
?>
 <h1 class="text-center mb-4">La liste des commandes</h1>
<?php include 'layout/footer.php';?>