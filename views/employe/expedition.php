
<section class="mt-5">
  <div class="row">
    <div class="col">
      <div class="btn-group dropend">
        
        <?php if(!empty($categories)):?>
          <form method="GET" action="">
        <label>Filtrer par catégorie :</label>
          <select name="categorie" onchange="this.form.submit()" class="btn btn-secondary dropdown-toggle filter">
            <option value="">-- Toutes --</option>
            <?php foreach($categories as $categories) : ?>
            <option value="<?= $categories['category_id']; ?>"><?= $categories['category']; ?></option>
            <?php endforeach; ?>
          </select>
        </form>
        <?php endif;?>
        
      </div>
    </div>
    <div class="col text-end">
    <button type="submit" class="btn btn-warning btn-lg px-4 btn-valider">Valider</button>
    </div>
  </div>
 
  <div class="tablerounededCorner">
  <table class="table table-hover mt-3 text-center table-bordered table-striped roundedTable">
      <thead>
          <tr>
            <th scope="col">Reference</th>
            <th scope="col">Categorie</th>
            <th scope="col">Nom</th>
            <th scope="col">Prix(€)</th>
            <th scope="col">Stock</th>
            <th scope="col">Ajouter</th>
            <th scope="col">Quantité</th>
          </tr>
        </thead>
        <?php if(!empty($products)):?>
        <tbody>
        <?php foreach($products as $product) : ?>
          <tr>
          <td><?= $product['product_reference']; ?></td>
          <td><?= $product['category']; ?></td>
          <td><?= $product['product_name']; ?></td>
          <td><?= $product['product_unit_price']; ?></td>
          <td><?= $product['product_quantity_stock']; ?></td>
          
            <td>
              <input type="checkbox" name="add" id="">
            </td>
            <td>
              <input class="quantity-product" type="number" name="quantity" id="" value="1">
            </td>
          </tr>
          
          <?php endforeach; ?>
        </tbody>
    </table>
<?php endif;?>
</div>
</section>