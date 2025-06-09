<?php include __DIR__.'/../layout/header.php';?>

<!-- Main Content -->
  <div class="flex-grow-1 p-3 mt-5">
    <!-- Toggler for small screens -->
    <button class="btn btn-outline-light d-lg-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
      ☰ Menu
    </button>

    <h3>Liste des produits</h3>
    <p>Ceci est le contenu principal de la page.</p>
    <a href="../../../index.php?action=product_create">Ajouter un produit</a>

<div class="table-responsive bg-dark p-3 rounded shadow">
    <table class="table table-dark table-striped table-hover table-bordered mb-0">
    <thead>
    <tr>
        <th>Id</th>
        <th>Réference</th>
        <th>Nom</th>
        <th>Déscription</th>
        <th>quantité en stock</th>
        <th>seuil d'alerte</th>
        <th>prix unitaire</th>
        <th>Fourniseur</th>
        <th>Categorie</th>
        <th>Actions</th>
    </tr>
    </thead>
    <?php if(!empty($products)):?>
    <tbody>    
    <?php foreach($products as $product) : ?>
        <tr>
            <td><?= $product['product_id']; ?></td>
            <td><?= $product['product_reference']; ?></td>
            <td><?= $product['product_name']; ?></td>
            <td><?= $product['product_description']; ?></td>
            <td><?= $product['product_quantity_stock']; ?></td>
            <td><?= $product['product_alert_threshold']; ?></td>
            <td><?= $product['product_unit_price']; ?></td>
            <td><?= $product['supplier_id'] .' : '. $product['supplier']; ?></td>
            <td><?= $product['category_id'] .' : '. $product['category']; ?></td>
            <td class="d-flex align-items-center gap-2">
                <a href="index.php?action=product_edit&id=<?= $product['product_id']?>&categorie=<?=$product['category_id']?>&fournisseur=<?=$product['supplier_id']?>">
                    <button class="btn btn-sm btn-primary">Modifier</button>
                </a>
                <form method='POST' action="/index.php?action=product_delete&id=<?= $product['product_id']?>" onsubmit="return confirm('Voulez-vous vraiment supprimer ce produit ? <?= $product['product_id'];?>?');" class="d-inline-block m-0 p-0">
                    <input class="btn btn-danger btn-sm" title="Supprimer"  type="submit" value="X">
                </form>
            </td>
        </tr>
        
    <?php endforeach; ?>
    </tbody>
    <?php endif;?>
    </table>
</div>
<?php include __DIR__.'/../layout/footer.php';?>

