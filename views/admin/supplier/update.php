<?php include __DIR__. '/../layout/header.php';?>

<!-- Main Content -->
<div class="flex-grow-1 p-3 mt-5">
    <!-- Toggler for small screens -->
    <button class="btn btn-outline-light d-lg-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
        ☰ Menu
    </button>

<h3>Modifier un fournisseur</h3>

<div class="bg-dark text-white p-4 rounded shadow mb-4" style="max-width: 1000px;">
  <form method="POST" action="index.php?action=supplier_update&id=<?= $id;?>">
    
    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="supplier" class="form-label">Nom</label>
        <input type="text" class="form-control bg-secondary text-white border-0 shadow-none" name="supplier" value="<?=$supplier['supplier']?>" required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="supplier_address" class="form-label">Adresse</label>
        <input type="text" class="form-control bg-secondary text-white border-0 shadow-none" name="supplier_address" value="<?=$supplier['supplier_address']?>" required>
      </div>


      <div class="col-md-6 mb-3">
        <label for="supplier_phone_number" class="form-label">Numero de téléphone</label>
        <input type="text" class="form-control bg-secondary text-white border-0 shadow-none" name="supplier_phone_number" value="<?=$supplier['supplier_phone_number']?>" required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="supplier_email" class="form-label">Mail</label>
        <input type="email" class="form-control bg-secondary text-white border-0 shadow-none" name="supplier_email" value="<?=$supplier['supplier_email']?>" required>
      </div>

    </div> 
    <!-- fin row -->

    <div class="mt-3 text-center">
      <button type="submit" class="btn btn-primary px-4">Modifier</button>
    </div>
    
  </form>
</div>

<?php include __DIR__. '/../layout/footer.php';?>