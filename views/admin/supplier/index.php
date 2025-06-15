<?php include __DIR__.'/../layout/header.php';?>

<!-- Main Content -->
  <div class="flex-grow-1 p-3 mt-5">
    <!-- Toggler for small screens -->
    <button class="btn btn-outline-light d-lg-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
      ☰ Menu
    </button>

    <h3>Liste des Fournisseurs</h3>
    <a href="index.php?action=supplier_create">Ajouter un Fournisseur</a>

<div class="table-responsive bg-dark p-3 rounded shadow">
    <table class="table table-dark table-striped table-hover table-bordered mb-0">
    <thead>
    <tr>
        <th>Id</th>
        <th>Nom</th>
        <th>Adresse</th>
        <th>Numero de téléphone</th>
        <th>Mail</th>
        <th>Actions</th>
    </tr>
    </thead>
    <?php if(!empty($suppliers)):?>
    <tbody>    
    <?php foreach($suppliers as $supplier) : ?>
        <tr>
            <td><?= $supplier['supplier_id']; ?></td>
            <td><?= $supplier['supplier']; ?></td>
            <td><?= $supplier['supplier_address']; ?></td>
            <td><?= $supplier['supplier_phone_number']; ?></td>
            <td><?= $supplier['supplier_email']; ?></td>
            <td class="d-flex align-items-center gap-2">
                <a href="index.php?action=supplier_edit&id=<?= $supplier['supplier_id']?>">
                    <button class="btn btn-sm btn-primary">Modifier</button>
                </a>
                <form method='POST' action="/index.php?action=supplier_delete&id=<?= $supplier['supplier_id']?>" onsubmit="return confirm('Voulez-vous vraiment supprimer ce produit ? <?= $supplier['supplier_id'];?>?');" class="d-inline-block m-0 p-0">
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

