<?php include __DIR__.'/../layout/header.php';?>

<!-- Main Content -->
  <div class="flex-grow-1 p-3 mt-5">
    <!-- Toggler for small screens -->
    <button class="btn btn-outline-light d-lg-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
      ☰ Menu
    </button>

    <h3>Liste commandes</h3>
    <!-- <a href="../../../index.php?action=product_create">Ajouter un produit</a> -->

<div class="table-responsive bg-dark p-3 rounded shadow">
    <table class="table table-dark table-striped table-hover table-bordered mb-0">
    <thead>
    <tr>
        <th>Ref Commande</th>
        <th>Produits</th>
        <th>Date</th>
        <th>Status</th>
        <th>quantité</th>
        <th>Fournisseur</th>
        <th>prix (€)</th>
        <th>Montant (€)</th>
    </tr>
    </thead>
    <?php if(!empty($supplier_orders)):?>
    <tbody>    
    <?php foreach($supplier_orders as $supplier_order) : ?>
        <tr>
            <td><?= $supplier_order['supplier_order_reference']; ?></td>
            <td><?= $supplier_order['product_name']; ?></td>
            <td><?= $supplier_order['supplier_order_date']; ?></td>
            <td><?= $supplier_order['supplier_order_status']; ?></td>
            <td><?= $supplier_order['so_quantity']; ?></td>
            <td><?= $supplier_order['supplier']; ?></td>
            <td><?= $supplier_order['purchase_price']; ?></td>
            <td><?= $supplier_order['total_price']; ?></td>
        </tr>
        
    <?php endforeach; ?>
    </tbody>
    <?php endif;?>
    </table>
</div>
<?php include __DIR__.'/../layout/footer.php';?>

