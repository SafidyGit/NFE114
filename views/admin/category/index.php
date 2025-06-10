<?php include __DIR__. '/../layout/header.php'; ?>

<!-- Main Content -->
  <div class="flex-grow-1 p-3 mt-5">
    <!-- Toggler for small screens -->
    <button class="btn btn-outline-light d-lg-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
      ☰ Menu
    </button>

    <h3>Liste des catégories de produit</h3>
    <a href="../../../index.php?action=category_create">Ajouter une catégorie de produit</a>

    <div class="table-responsive bg-dark p-3 rounded shadow">
    <table class="table table-dark table-striped table-hover table-bordered mb-0">
        <thead>
        <tr>
            <th>Id</th>
            <th>Catégorie</th>
            <th>Actions</th>
        </tr>
        </thead>
        <?php if(!empty($categories)):?>
        <tbody>
        <?php foreach($categories as $category) : ?>
        <tr>
            <td><?= $category['category_id']; ?></td>
            <td><?= $category['category']; ?></td>
            <td class="d-flex align-items-center gap-2">
                <a href="index.php?action=category_edit&id=<?= $category['category_id']?>">
                <button class="btn btn-sm btn-primary">Modifier</button>
                </a>
                <form method='POST' action="/index.php?action=category_delete&id=<?= $category['category_id']?>" onsubmit="return confirm('Voulez-vous vraiment modifier cette catégorie <?= $category['category_id'];?>?');">
                <button class="btn btn-sm btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
        <?php endif;?>
    </table>
    </div>
    
<?php include __DIR__. '/../layout/footer.php'; ?>
