
<h2>Modifier un produit</h2>

<?php if (isset($_GET['success'])): ?>
    <p style="color:green;">Produits ajoutée avec succès !</p>
<?php endif; ?>

<form method="POST" action="/index.php?action=product_update&id=<?= $id ?>">
    <input type="text" name="product_reference" placeholder="product_reference" value="<?= $product['product_reference']?>" required><br>
    <input type="text" name="product_name" placeholder="product_name" value="<?= $product['product_name']?>" required><br>
    <input type="text" name="product_description" placeholder="product_description" value="<?= $product['product_description']?>" required><br>
    <input type="number" name="product_quantity_stock" placeholder="product_quantity_stock" value="<?= $product['product_quantity_stock']?>" required><br>
    <input type="number" name="product_alert_threshold" placeholder="product_alert_threshold" value="<?= $product['product_alert_threshold']?>" required><br>
    <input type="number" name="product_unit_price" placeholder="product_unit_price" value="<?= $product['product_unit_price']?>" required><br>
    <label for="supplier_id">Fournisseur : </label>
    <select name="supplier_id" id="">
        <?php foreach($supplier_list as $supplier):?>
        <option value="<?=$supplier['supplier_id']?>"
        <?= ($product['supplier_id'] == $supplier['supplier_id']) ? 'selected' : '' ?>
        >
            <?=$supplier['supplier_id']?> | <?=$supplier['supplier']?>
        </option>
        <?php endforeach;?>
    </select>
    <select name="category_id" id="">
        <?php foreach($category_list as $category):?>
        <option value="<?=$category['category_id']?>" 
        <?= ($product['category_id'] == $category['category_id']) ? 'selected' : '' ?>
        >
            <?=$category['category_id']?> | <?=$category['category']?>
        </option>
        <?php endforeach;?>
    </select>
    
    <button type="submit">Modifier</button>
</form>