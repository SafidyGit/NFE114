<?php include __DIR__. '/../layout/header.php';?>

<!-- Main Content -->
<div class="flex-grow-1 p-3 mt-5">
    <!-- Toggler for small screens -->
    <button class="btn btn-outline-light d-lg-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
        ☰ Menu
    </button>

<h3>Commander</h3>
<?php if (isset($_GET['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show bg-success text-white border-0 shadow" role="alert" style="max-width: 600px;">
    <strong>Succès !</strong> Commande ajouté avec succès !
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="bg-dark text-white p-4 rounded shadow mb-4" style="max-width: 1000px;">
  <form method="POST" action="/index.php?action=supplier_order_store&selected_product_id=<?=$selected_product_id;?>">
    
    <div class="row">
      <div class="col-md-3 mb-3">
        <label for="supplier_order_reference" class="form-label">Référence de la commande</label>
        <input type="text" class="form-control bg-secondary text-white border-0 shadow-none" name="supplier_order_reference" required>
      </div>

      <div class="col-md-3 mb-3">
            <label for="supplier_id" class="form-label">Fournisseur</label>
            <!-- Le prix change en fontion du produit selectionné sur le select <label for="product_id" class="form-label">Produit</label>  -->
            <input type="number" class="form-control bg-secondary text-white border-0 shadow-none" 
            name="supplier_id" value="<?= $product['supplier_id'] ?? ''?>" required>
      </div>


      <div class="col-md-3 mb-3">
        <label for="supplier_order_date" class="form-label">Date de la commande</label>
        <input type="date" class="form-control bg-secondary text-white border-0 shadow-none" name="supplier_order_date" required>
      </div>

      
      <div class="col-md-3 mb-3">
        <label for="supplier_order_status" class="form-label">Status de la commande</label>
        <select class="form-select bg-secondary text-white border-0 shadow-none" name="supplier_order_status" required>
          <option>
              En attente
          </option>
          <option>
              En cours
          </option>
          <option>
              Livrée
          </option>
        </select>
      </div>
      <div class="col-md-3 mb-3">
        <label for="supplier_order_reference" class="form-label">Quantité à commander</label>
        <input type="number" class="form-control bg-secondary text-white border-0 shadow-none" name="so_quantity" required>
      </div>
      <div class="col-md-3 mb-3">
        <label for="supplier_order_reference" class="form-label">Prix d'achat</label>
        <!-- Le prix change en fontion du produit selectionné sur le select <label for="product_id" class="form-label">Produit</label>  -->
        <input type="number" class="form-control bg-secondary text-white border-0 shadow-none" 
        name="purchase_price" value="<?= $product['product_unit_price'] ?? ''?>" required>
      </div>


      <!-- Pas Afficher à l'ecran -->
      <div class="col-md-3 mb-3">
        <label for="user_id" class="form-label">User</label>
        <input type="text" class="form-control  bg-secondary text-white border-0 shadow-none" name="user_id" value="<?=$_SESSION['user_id'];?>" disabled required>
      </div>

      <div class="col-md-3 mb-3">
        <label for="product_id" class="form-label">Produit</label>
        <!-- Du js-->
         <!-- 
            Recupération de value de l'option dans l'url
            onchange="window.location.href='?action=supplier_order_create&selected_product_id=' + this.value"
         -->
        <select onchange="window.location.href='?action=supplier_order_create&selected_product_id=' + this.value"
        class="form-select bg-secondary text-white border-0 shadow-none" name="product_id" required>
          <?php foreach($product_list as $product): ?>
          <option value="<?=$product['product_id']?>" 
          <?= $selected_product_id == $product['product_id'] ? 'selected' : '';?>>
              <?=$product['product_id']?> | <?=$product['product_name']?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>


    </div> 
    <!-- fin row -->

    <div class="mt-3 text-center">
      <button type="submit" class="btn btn-primary px-4">Ajouter</button>
    </div>
    
  </form>

  
<div class="table-responsive bg-dark p-3 rounded shadow">
    <table class="table table-dark table-striped table-hover table-bordered mb-0">
    <thead>
    <tr>
        <th>Réference</th>
        <th>Nom</th>
        <th>stock</th>
        <th>seuil</th>
        <th>prix (€)</th>
        <th>Fourniseur</th>
        <th>Categorie</th>
        <th>Etat</th>
    </tr>
    </thead>
    <?php if(!empty($product_list)):?>
    <tbody>    
    <?php foreach($product_list as $product) : ?>
        <tr>
            <td><?= $product['product_reference']; ?></td>
            <td><?= $product['product_name']; ?></td>
            <td><?= $product['product_quantity_stock']; ?></td>
            <td><?= $product['product_alert_threshold']; ?></td>
            <td><?= $product['product_unit_price']; ?></td>
            <td><?= $product['supplier']; ?></td>
            <td><?= $product['category']; ?></td>
            <td>
              <?php if($product['product_quantity_stock'] > $product['product_alert_threshold']): ?>
                <button class="btn btn-success btn-sm" style="width: 70px;">En stock</button>
              <?php endif;?>
              <?php if($product['product_quantity_stock'] <= $product['product_alert_threshold'] && $product['product_quantity_stock'] > 0): ?>
                <button class="btn btn-warning btn-sm" style="width: 70px;">Alerte</button>
              <?php endif;?>
              <?php if($product['product_quantity_stock'] == 0): ?>
                <button class="btn btn-danger btn-sm" style="width: 70px;">Epuisé</button>
              <?php endif;?>
            </td>
        </tr>
        
    <?php endforeach; ?>
    </tbody>
    <?php endif;?>
    </table>
</div>

</div>

<?php include __DIR__. '/../layout/footer.php';?>