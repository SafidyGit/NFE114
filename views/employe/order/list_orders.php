<?php
session_start(); // Démarre la session pour accéder aux variables de session

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Définit un message d'erreur si non connecté
    $_SESSION['error'] = "Vous devez être connecté pour passer une commande.";
    // Redirige vers la page de connexion
    header('Location: index.php?action=login');
    exit; // Arrête l'exécution après redirection
}

// Vérifie que l'utilisateur a le rôle d'employé (2) ou d'admin (1)
if ($_SESSION['role_id'] != 1 && $_SESSION['role_id'] != 2) {
    // Message d'accès non autorisé si rôle incorrect
    $_SESSION['error'] = "Accès non autorisé.";
    // Redirection vers le tableau de bord
    header('Location: index.php?action=dashboard');
    exit;
}

// Récupère l'ID utilisateur connecté (utilisé pour enregistrement ou filtrage)
$userId = $_SESSION['user_id'];

// Inclusion de l'en-tête commun (header)
include __DIR__ . '/../layout/header.php';
?>
<div class="container">
  <!-- Titre principal centré -->
  <h1 class="text-center mb-4">La liste des commandes</h1>

  <?php if (isset($_SESSION['success'])): ?>
  <!-- Affiche un message de succès s'il existe -->
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($_SESSION['success']) ?>
    <!-- Bouton pour fermer l'alerte -->
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php unset($_SESSION['success']); // Supprime le message après affichage ?>
  <?php endif; ?>

  <div class="tablerounededCorner">
    <!-- Tableau listant toutes les commandes -->
    <table class="table table-secondary m-auto text-center roundedTable">
      <thead class="table-light">
        <tr>
          <th>Référence</th>
          <th>Client</th>
          <th>Date</th>
          <th>Statut</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- Boucle pour afficher chaque commande -->
        <?php foreach ($orders as $order): ?>
          <tr>
            <td><?= htmlspecialchars($order['customer_order_reference']) ?></td>
            <td><?= htmlspecialchars($order['customer_name']) ?></td>
            <td><?= htmlspecialchars($order['customer_order_date']) ?></td>

            <?php if ($order['customer_order_status'] !== 'Livré'): ?>
              <!-- Statut en rouge si la commande n'est pas encore livrée -->
              <td style="color : red"><?= htmlspecialchars($order['customer_order_status']) ?>...</td>
              <td>
                <!-- Bouton pour valider la livraison avec confirmation -->
                <a href="index.php?action=mark_as_delivered&order_id=<?= $order['customer_order_id'] ?>"
                  class="btn btn-outline-success" style="border-radius:2rem"
                  onclick="return confirm('Confirmer la livraison ?')">
                  Valider la livraison
                </a>
                <!-- Bouton pour voir les détails de la commande -->
                <a href="index.php?action=order_details&order_id=<?= $order['customer_order_id'] ?>" class="btn btn-outline-dark btn-sm">
                  ➕
                </a>
              </td>
            <?php else: ?>
              <!-- Statut normal si la commande est déjà livrée -->
              <td><?= htmlspecialchars($order['customer_order_status']) ?></td>
              <td>
                ✔ Déjà livré
                <!-- Bouton pour voir les détails de la commande -->
                <a href="index.php?action=order_details&order_id=<?= $order['customer_order_id'] ?>" class="btn btn-outline-dark btn-sm">
                  ➕
                </a>
              </td>
            <?php endif; ?>
            
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php
// Inclusion du pied de page commun (footer)
include __DIR__ . '/../layout/footer.php';
?>
