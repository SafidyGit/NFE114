<section class="mt-5">
  <!-- Formulaire de filtre par catégorie (GET) -->
  <form method="GET" action="index.php">
    <!-- Champ caché pour définir l'action à 'dashboard' -->
    <input type="hidden" name="action" value="dashboard">
    <label>Filtrer par catégorie :</label>
    <!-- Liste déroulante pour choisir une catégorie, déclenche la soumission automatique au changement -->
    <select name="categorie" onchange="this.form.submit()" class="btn btn-secondary dropdown-toggle filter">
      <option value="">Choisir</option>
      <option value="">-- Toutes --</option>
      <!-- Boucle pour afficher toutes les catégories -->
      <?php foreach($categories as $categorie): ?>
          <option value="<?= $categorie['category_id']; ?>"><?= $categorie['category']; ?></option>
      <?php endforeach; ?>
    </select>
  </form>

  <!-- Formulaire pour sélectionner des produits et passer commande (POST) -->
  <form method="POST" action="index.php?action=selection_produits">
    <?php 
      // Affiche un message d'erreur si défini en session (ex: aucun produit sélectionné)
      if (isset($_SESSION['error'])) {
          echo '<div class="alert alert-danger w-50 m-auto mt-3 text-center alert-dismissible fade show" role="alert">' 
              . htmlspecialchars($_SESSION['error']) . 
              ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
          unset($_SESSION['error']); // Supprime le message d'erreur après affichage
      }
    ?>
    
    <!-- Bouton pour valider la sélection et passer à l'étape suivante -->
    <div class="col text-end">
        <button type="submit" class="btn btn-warning btn-lg px-4 btn-valider">Passer à la commande</button>
    </div>

    <!-- Conteneur avec défilement vertical pour la liste des produits -->
    <div class="tablerounededCorner" style="max-height: 400px; overflow-y: auto;">
      <!-- Vérifie qu'il y a des produits à afficher -->
      <?php if (!empty($products)) : ?>
          <!-- Tableau affichant les détails des produits -->
          <table class="table table-hover mt-3 text-center table-bordered table-striped roundedTable">
            <thead style="position: sticky; top: 0; z-index: 1;">
              <tr>
                <th>Référence</th>
                <th>Catégorie</th>
                <th>Nom</th>
                <th>Prix (€)</th>
                <th>Stock</th>
                <th>Ajouter</th>
                <th>Quantité</th>
              </tr>
            </thead>
            <tbody>
              <!-- Boucle pour afficher chaque produit dans une ligne -->
              <?php foreach ($products as $product): ?>
              <tr>
                <td><?= htmlspecialchars($product['product_reference']) ?></td>
                <td><?= htmlspecialchars($product['category']) ?></td>
                <td><?= htmlspecialchars($product['product_name']) ?></td>
                <td><?= number_format($product['product_unit_price'], 2) ?></td>
                <!-- Affiche la quantité en stock en rouge si sous le seuil d'alerte -->
               <?php if ($product['product_quantity_stock'] == 0) : ?>
                  <td style="color: red; font-weight: bold;">Épuisé</td>
              <?php elseif ($product['product_quantity_stock'] <= $product['product_alert_threshold']) : ?>
                  <td style="color: orange; font-weight: bold;"><?= (int)$product['product_quantity_stock'] ?></td>
              <?php else : ?>
                  <td><?= (int)$product['product_quantity_stock'] ?></td>
              <?php endif; ?>

                <!-- Case à cocher pour sélectionner le produit -->
                <td>
                  <input type="checkbox" name="products[<?= $product['product_id'] ?>][selected]" value="1">
                </td>

                <!-- Champ pour saisir la quantité souhaitée pour ce produit -->
                <td>
                  <input type="number" name="products[<?= $product['product_id'] ?>][quantity]" value="1" min="1">
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
      <?php else : ?>
        <!-- Message affiché si aucun produit disponible -->
        <p class="text-center mt-3">Aucun produit trouvé.</p>
      <?php endif; ?>
    </div>
  </form>
</section>
