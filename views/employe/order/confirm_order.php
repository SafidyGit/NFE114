<?php
// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Définit un message d'erreur en session
    $_SESSION['error'] = "Vous devez être connecté pour passer une commande.";
    // Redirige vers la page de connexion
    header('Location: index.php?action=login');
    exit; // Stoppe l'exécution après redirection
}

// Vérifie que l'utilisateur a le rôle d'admin (1) ou d'employé (2)
if ($_SESSION['role_id'] != 1 && $_SESSION['role_id'] != 2) {
    // Définit un message d'erreur en session
    $_SESSION['error'] = "Accès non autorisé.";
    // Redirige vers le tableau de bord
    header('Location: index.php?action=dashboard');
    exit;
}

// Inclut le header commun de la mise en page
include __DIR__ . '/../layout/header.php';
?>
<h1>Validation commande</h1>

<!-- Formulaire POST pour soumettre la commande -->
<form method="POST" action="index.php?action=submit_order">
  <h4>Informations client</h4>

  <!-- Champs du formulaire pour les informations client (nom, adresse, téléphone, email) -->
  <label for="" style="color:grey">Nom : </label>
  <input type="text" class="formCustomer" name="customer[customer]" placeholder="Nom complet" required />
  <label for="" style="color:gray">Adresse : </label>
  <input type="text" class="formCustomer" name="customer[customer_address]" placeholder="Adresse" required />
  <label for="" style="color:gray">Telephone : </label>
  <input type="text" class="formCustomer" name="customer[customer_phone_number]" placeholder="Téléphone" required />
  <label for="" style="color:gray"> Email : </label>
  <input type="email" class="formCustomer" name="customer[customer_email]" placeholder="Email" required />

  <h4>Produits sélectionnés</h4>

<?php if (!empty($selected) && is_array($selected)): ?>
    
<div class="tablerounededCorner">
    <!-- Tableau listant les produits sélectionnés avec leurs quantités, prix unitaire et total -->

    <table class="table table-secondary m-3 text-center table-sm roundedTable">

    <thead class="table-light">
      <tr>
        <th>Produit</th>
        <th>Quantité</th>
        <th>Prix</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
      <?php
      $grandTotal = 0; // Initialisation du total général
      foreach ($selected as $p):
        $lineTotal = $p['quantity'] * $p['product_unit_price']; // Calcule le total ligne
        $grandTotal += $lineTotal; // Cumule dans le total général
      ?>
        <tr>
          <!-- Champs cachés pour envoyer les détails produits dans la requête POST -->
          <input type="hidden" name="order[products][<?= $p['product_id'] ?>][product_id]" value="<?= $p['product_id'] ?>" />
          <input type="hidden" name="order[products][<?= $p['product_id'] ?>][quantity]" value="<?= $p['quantity'] ?>" />
          <input type="hidden" name="order[products][<?= $p['product_id'] ?>][unit_price]" value="<?= $p['product_unit_price'] ?>" />
          <td><?= htmlspecialchars($p['product_name']) ?></td>
          <td><?= (int)$p['quantity'] ?></td>
          <td><?= number_format($p['product_unit_price'], 2) ?> €</td>
          <td><?= number_format($lineTotal, 2) ?> €</td>
        </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="3" align="right"><strong>Total général</strong></td>
        <td><strong><?= number_format($grandTotal, 2) ?> €</strong></td>
      </tr>
    </tfoot>
  </table>
</div>
<?php else: ?>
  <!-- Message affiché si aucun produit n'est sélectionné -->
  <p>Aucun produit sélectionné.</p>
<?php endif; ?>

<!-- Boutons Valider et Annuler la commande -->
<div class="text-end">
  <button type="submit" class="btn btn-success">Valider</button>
  <a href="index.php?action=dashboard" class="btn btn-dark">Annuler</a>
</div>

</form>

<?php
// Inclut le footer commun de la mise en page
include __DIR__ . '/../layout/footer.php';
?>
