
<?php include __DIR__. '/../layout/header.php';?>

<!-- Main Content -->
<div class="flex-grow-1 p-3 mt-5">
    <!-- Toggler for small screens -->
    <button class="btn btn-outline-light d-lg-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
        ☰ Menu
    </button>

<h3>Modifier un produit</h3>

<div class="bg-dark text-white p-4 rounded shadow mb-4" style="max-width: 1000px;">
  <form method="POST" action="index.php?action=product_update&id=<?= $id ?>">
    
    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="product_reference" class="form-label">Réference du produit</label>
        <input type="text" class="form-control bg-secondary text-white border-0 shadow-none" name="product_reference" value="<?= $product['product_reference']?>" required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="product_name" class="form-label">Nom du produit</label>
        <input type="text" class="form-control bg-secondary text-white border-0 shadow-none" name="product_name"   value="<?= $product['product_name']?>" required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="description" class="form-label">Description du produit</label>
        <textarea class="form-control bg-secondary text-white border-0 shadow-none" 
                  id="description" name="product_description" rows="2" placeholder="Entrez la description du produit" ><?= $product['product_description']?></textarea>
      </div>

      <div class="col-md-6 mb-3">
        <label for="product_quantity_stock" class="form-label">Quantité</label>
        <input type="number" min=1 step="0.01" class="form-control bg-secondary text-white border-0 shadow-none" name="product_quantity_stock" value="<?= $product['product_quantity_stock']?>" required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="product_alert_threshold" class="form-label">Seuil d'alerte</label>
        <input type="number" min=1 step="0.01" class="form-control bg-secondary text-white border-0 shadow-none" name="product_alert_threshold" value="<?= $product['product_alert_threshold']?>" required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="product_unit_price" class="form-label">Prix unitaire (€)</label>
        <input type="number" min=1 step="0.01" class="form-control bg-secondary text-white border-0 shadow-none" name="product_unit_price" value="<?= $product['product_unit_price']?>" required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="supplier_id" class="form-label">Fournisseur</label>
        <select class="form-select bg-secondary text-white border-0 shadow-none" name="supplier_id" required>
          <?php foreach($supplier_list as $supplier): ?>
          <option value="<?=$supplier['supplier_id']?>" <?= ($product['supplier_id'] == $supplier['supplier_id']) ? 'selected' : '' ?>>
              <?=$supplier['supplier_id']?> | <?=$supplier['supplier']?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-6 mb-3">
        <label for="category_id" class="form-label">Catégorie</label>
        <select class="form-select bg-secondary text-white border-0 shadow-none" name="category_id" required>
          <?php foreach($category_list as $category): ?>
          <option value="<?=$category['category_id']?>" <?= ($product['category_id'] == $category['category_id']) ? 'selected' : '' ?>>
              <?=$category['category_id']?> | <?=$category['category']?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div> <!-- fin row -->

    <div class="mt-3 text-center">
      <button type="submit" class="btn btn-primary px-4">Modifier</button>
    </div>
    
  </form>
</div>

<?php include __DIR__. '/../layout/footer.php';?>

