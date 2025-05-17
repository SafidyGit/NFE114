<?php
require_once 'controllers/AuthController.php';

$action = $_GET['action'] ?? null;
$controller = new AuthController();

if ($action === 'login') {
    $controller->login();
} elseif ($action === 'logout') {
    $controller->logout();
} else {
    // Page par défaut
    header('Location: index.php?action=login');
    exit;
}