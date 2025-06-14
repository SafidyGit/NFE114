<?php include __DIR__. '/../layout/header.php';?>

<!-- Main Content -->
<div class="flex-grow-1 p-3 mt-5">
    <!-- Toggler for small screens -->
    <button class="btn btn-outline-light d-lg-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
        ☰ Menu
    </button>

<h3>Modifier une commande</h3>

<div class="bg-dark text-white p-4 rounded shadow mb-4" style="max-width: 1000px;">
  <form method="POST" action="/index.php?action=supplier_order_update&selected_product_id=<?=$selected_product_id;?>">
    
    <div class="row">
      <div class="col-md-3 mb-3">
        <label for="supplier_order_reference" class="form-label">Référence de la commande</label>
        <input type="text" class="form-control bg-secondary text-white border-0 shadow-none" name="supplier_order_reference" value="<?=$supplier_order['supplier_order_reference']?>" readonly required>
      </div>

      <div class="col-md-3 mb-3">
            <label for="supplier_id" class="form-label">Fournisseur</label>
            <!-- Le prix change en fontion du produit selectionné sur le select <label for="product_id" class="form-label">Produit</label>  -->
            <input type="number" class="form-control bg-secondary text-white border-0 shadow-none" 
            name="supplier_id" value="<?=$supplier_order['supplier_id']?>" readonly required>
      </div>
      <div class="col-md-3 mb-3">
        <label for="supplier_order_status" class="form-label">Status de la commande</label>
        <select class="form-select bg-secondary text-white border-0 shadow-none" name="supplier_order_status" required>
          <option>
              En attente
          </option>
          <option>
              Livrée
          </option>
        </select>
      </div>
      <div class="col-md-3 mb-3">
        <label for="supplier_order_reference" class="form-label">Quantité à commander</label>
        <input type="number" min=1 class="form-control bg-secondary text-white border-0 shadow-none" name="so_quantity" required>
      </div>
      <div class="col-md-3 mb-3">
        <label for="supplier_order_reference" class="form-label">Prix d'achat</label>
        <!-- Le prix change en fontion du produit selectionné sur le select <label for="product_id" class="form-label">Produit</label>  -->
        <input type="number" class="form-control bg-secondary text-white border-0 shadow-none" 
        name="purchase_price" min=1 value="<?= $product['product_unit_price'] ?? ''?>" required>
      </div>


      <!-- Pas Afficher à l'ecran -->
      <div class="col-md-3 mb-3 d-none">
        <label for="user_id" class="form-label">User</label>
        <input type="text" class="form-control  bg-secondary text-white border-0 shadow-none" name="user_id" value="<?=$_SESSION['user_id'];?>" required>
      </div>
      <!-- --------------------------------- -->

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
      <button type="submit" class="btn btn-primary px-4">Modifier</button>
    </div>
    
  </form>

</div>

<?php include __DIR__. '/../layout/footer.php';?>