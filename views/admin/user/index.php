<?php include __DIR__.'/../layout/header.php';?>

<!-- Main Content -->
  <div class="flex-grow-1 p-3 mt-5">
    <!-- Toggler for small screens -->
    <button class="btn btn-outline-light d-lg-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
      ☰ Menu
    </button>

    <h3>Liste des utilisateurs</h3>
    <a href="index.php?action=user_create">Ajouter un utilisateur</a>

<div class="table-responsive bg-dark p-3 rounded shadow">
    <table class="table table-dark table-striped table-hover table-bordered mb-0">
    <thead>
    <tr>
        <th>Id</th>
        <th>Nom de l'utilisateur</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    </thead>
    <?php if(!empty($users)):?>
    <tbody>    
    <?php foreach($users as $user) : ?>
        <tr>
            <td><?= $user['user_id']; ?></td>
            <td><?= $user['username']; ?></td>
            <td><?= $user['user_email']; ?></td>
            <td><?= $user['role_id']; ?> : <?= $user['role']; ?></td>
            <td class="d-flex align-items-center gap-2">
                <a href="index.php?action=user_edit&id=<?= $user['user_id']?>&role=<?=$user['role_id']?>">
                    <button class="btn btn-sm btn-primary">Modifier</button>
                </a>
                <form method='POST' action="index.php?action=user_delete&id=<?= $user['user_id']?>" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ? <?= $user['user_id'];?>?');" class="d-inline-block m-0 p-0">
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

