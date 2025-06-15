<section class="mt-5">
<!-- Formulaire de filtre par catégorie -->
<form method="GET" action="index.php">
  <input type="hidden" name="action" value="dashboard">
  <label>Filtrer par catégorie :</label>
  <select name="categorie" onchange="this.form.submit()" class="btn btn-secondary dropdown-toggle filter">
     <option value="">Choisir</option>
      <option value="">-- Toutes --</option>
      <?php foreach($categories as $categorie): ?>
          <option value="<?= $categorie['category_id']; ?>"><?= $categorie['category']; ?></option>
      <?php endforeach; ?>
  </select>
</form>

 <form method="POST" action="index.php?action=selection_produits">
   <?php 
        // Affichage du message d'erreur s'il existe en session
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger w-50 m-auto mt-3 text-center alert-dismissible fade show" role="alert">' 
         . htmlspecialchars($_SESSION['error']) . 
         ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        
    unset($_SESSION['error']);
}
        ?>
    <div class="col text-end">
        <button type="submit" class="btn btn-warning btn-lg px-4 btn-valider">Passer à la commande</button>
    </div>

  <div class="tablerounededCorner">
    <?php if (!empty($products)) : ?>

        <table class="table table-hover mt-3 text-center table-bordered table-striped roundedTable">
          <thead>
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
            <?php foreach ($products as $product): ?>
            <tr>
              <td><?= htmlspecialchars($product['product_reference']) ?></td>
              <td><?= htmlspecialchars($product['category']) ?></td>
              <td><?= htmlspecialchars($product['product_name']) ?></td>
              <td><?= number_format($product['product_unit_price'], 2) ?></td>
              <td><?= (int)$product['product_quantity_stock'] ?></td>
              <td>
                <input type="checkbox" name="products[<?= $product['product_id'] ?>][selected]" value="1">
              </td>
              <td>
                <input type="number" name="products[<?= $product['product_id'] ?>][quantity]" value="1" min="1">
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
     
    
    <?php else : ?>
      <p class="text-center mt-3">Aucun produit trouvé.</p>
    <?php endif; ?>
  </div>
    </form>
</section>