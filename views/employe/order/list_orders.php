<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?action=login');
    exit;
}
if ($_SESSION['role_id'] != 2) {
    echo "Accès refusé.";
    exit;
}

include __DIR__ . '/../layout/header.php';
?>

 <h1 class="text-center mb-4">La liste des commandes</h1>
<div class="tablerounededCorner">
    <table class="table table-secondary m-3 text-center table-sm roundedTable">
  <thead>
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
        <td><?= htmlspecialchars($order['customer_order_status']) ?></td>
        <td>
          <?php if ($order['customer_order_status'] !== 'Livré'): ?>
            <a href="index.php?action=mark_as_delivered&order_id=<?= $order['customer_order_id'] ?>" onclick="return confirm('Confirmer la livraison ?')">
               Livrer
            </a>
          <?php else: ?>
            ✔ Déjà livré
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
          </div>


<?php include __DIR__ . '/../layout/footer.php'; ?>
