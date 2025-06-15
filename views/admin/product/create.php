<?php include __DIR__. '/../layout/header.php';?>


<!-- Main Content -->
<div class="flex-grow-1 p-3 mt-5">
    <!-- Toggler for small screens -->
    <button class="btn btn-outline-light d-lg-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
        ☰ Menu
    </button>

<h3>Ajouter un produit</h3>

<?php if (isset($_GET['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show bg-success text-white border-0 shadow" role="alert" style="max-width: 600px;">
    <strong>Succès !</strong> Produit ajouté avec succès !
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="bg-dark text-white p-4 rounded shadow mb-4" style="max-width: 1000px;">
  <form method="POST" action="index.php?action=product_store">
    
    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="product_reference" class="form-label">Réference du produit</label>
        <input type="text" class="form-control bg-secondary text-white border-0 shadow-none" name="product_reference" required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="product_name" class="form-label">Nom du produit</label>
        <input type="text" class="form-control bg-secondary text-white border-0 shadow-none" name="product_name" required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="description" class="form-label">Description du produit</label>
        <textarea class="form-control bg-secondary text-white border-0 shadow-none" 
                  id="description" name="product_description" rows="2" placeholder="Entrez la description du produit"></textarea>
      </div>

      <div class="col-md-6 mb-3">
        <label for="product_quantity_stock" class="form-label">Quantité</label>
        <input type="number" step="0.01" class="form-control bg-secondary text-white border-0 shadow-none" name="product_quantity_stock" required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="product_alert_threshold" class="form-label">Seuil d'alerte</label>
        <input type="number" step="0.01" class="form-control bg-secondary text-white border-0 shadow-none" name="product_alert_threshold" required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="product_unit_price" class="form-label">Prix unitaire (€)</label>
        <input type="number" step="0.01" class="form-control bg-secondary text-white border-0 shadow-none" name="product_unit_price" required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="supplier_id" class="form-label">Fournisseur</label>
        <select class="form-select bg-secondary text-white border-0 shadow-none" name="supplier_id" required>
          <?php foreach($supplier_list as $supplier): ?>
          <option value="<?=$supplier['supplier_id']?>">
              <?=$supplier['supplier_id']?> | <?=$supplier['supplier']?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-6 mb-3">
        <label for="category_id" class="form-label">Catégorie</label>
        <select class="form-select bg-secondary text-white border-0 shadow-none" name="category_id" required>
          <?php foreach($category_list as $category): ?>
          <option value="<?=$category['category_id']?>">
              <?=$category['category_id']?> | <?=$category['category']?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div> <!-- fin row -->

    <div class="mt-3 text-center">
      <button type="submit" class="btn btn-primary px-4">Ajouter</button>
    </div>
    
  </form>
</div>

<?php include __DIR__. '/../layout/footer.php';?>