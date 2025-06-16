<?php include __DIR__. '/../layout/header.php';?>

<!-- Main Content -->
<div class="flex-grow-1 p-3 mt-5">
    <!-- Toggler for small screens -->
    <button class="btn btn-outline-light d-lg-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
        ☰ Menu
    </button>

<h3>Ajouter une catégorie</h3>

<?php if (isset($_GET['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show bg-success text-white border-0 shadow" role="alert" style="max-width: 600px;">
    <strong>Succès !</strong> Catégorie ajouté avec succès !
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="bg-dark text-white p-4 rounded shadow mb-4" style="max-width: 1000px;">
  <form method="POST" action="index.php?action=category_store">
      <div class="col-md-8 mb-3">
        <label for="product_reference" class="form-label">Catégorie de produit</label>
        <input type="text" class="form-control bg-secondary text-white border-0 shadow-none" name="category" required>
      </div>

    <div class="mt-3">
      <button type="submit" class="btn btn-primary px-4">Ajouter</button>
    </div>
    
  </form>
</div>

<?php include __DIR__. '/../layout/footer.php';?>
