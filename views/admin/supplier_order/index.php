<?php include __DIR__.'/../layout/header.php';?>

<!-- Main Content -->
  <div class="flex-grow-1 p-3 mt-5">
    <!-- Toggler for small screens -->
    <button class="btn btn-outline-light d-lg-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
      ☰ Menu
    </button>

    <h3>Liste commandes</h3>
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
        <th></th>
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
            <td>
                <?php if($supplier_order['supplier_order_status'] === 'Livrée'):?>
                    <button class="btn btn-sm btn-success">Livrée</button>
                <?php else:?>
                <form method='POST' action="index.php?action=supplier_order_validate&id=<?= $supplier_order['supplier_order_id'];?>&product_id=<?=$supplier_order['product_id']?>&sod_id=<?=$supplier_order['supplier_order_detail_id']?>" onsubmit="return confirm('Voulez-vous vraiment valider l\'entrée de <?=$supplier_order['so_quantity']?>  <?=$supplier_order['product_name']?>?');" class="d-inline-block m-0 p-0">
                    <input class="btn btn-warning btn-sm" title="Valider"  type="submit" value="Valider">
                </form>
                <?php endif;?>
            </td>
        </tr>
        
    <?php endforeach; ?>
    </tbody>
    <?php endif;?>
    </table>
</div>
<?php include __DIR__.'/../layout/footer.php';?>

