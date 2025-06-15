<?php
session_start();

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Vous devez être connecté pour passer une commande.";
    header('Location: index.php?action=login');
    exit;
}

// Vérifie que l'utilisateur a le bon rôle (employé OU admin)
if ($_SESSION['role_id'] != 1 && $_SESSION['role_id'] != 2) {
    $_SESSION['error'] = "Accès non autorisé.";
    header('Location: index.php?action=dashboard');
    exit;
}

// Définit l'ID de l'utilisateur pour l'enregistrement
$userId = $_SESSION['user_id'];

include __DIR__ . '/../layout/header.php';
?>
<div class="container">
  <h1 class="text-center mb-4">La liste des commandes</h1>
  <?php if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($_SESSION['success']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>

  <div class="tablerounededCorner">
    <table class="table table-secondary m-auto text-center roundedTable">
      <thead class=" table-light">
        <tr>
          <th>Référence</th>
          <th>Client</th>
          <th>Date</th>
          <th>Statut</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $order): ?>
          <tr>
            <td><?= htmlspecialchars($order['customer_order_reference']) ?></td>
            <td><?= htmlspecialchars($order['customer_name']) ?></td>
            <td><?= htmlspecialchars($order['customer_order_date']) ?></td>
             <?php if ($order['customer_order_status'] !== 'Livré'): ?>
            <td style="color : red"><?= htmlspecialchars($order['customer_order_status']) ?>...</td>
            <td>
                <a href="index.php?action=mark_as_delivered&order_id=<?= $order['customer_order_id'] ?>"
                class="btn btn-outline-success" style="border-radius:2rem"
                onclick="return confirm('Confirmer la livraison ?')">
                Valider la livraison
              </a>
            </td>
             <?php else: ?>
            <td><?= htmlspecialchars($order['customer_order_status']) ?></td>
            <td>  ✔ Déjà livré</td>
              <?php endif; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
  </table>
  </div>
</div>



<?php include __DIR__ . '/../layout/footer.php'; ?>
