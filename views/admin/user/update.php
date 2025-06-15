
<?php include __DIR__. '/../layout/header.php';?>

<!-- Main Content -->
<div class="flex-grow-1 p-3 mt-5">
    <!-- Toggler for small screens -->
    <button class="btn btn-outline-light d-lg-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
        ☰ Menu
    </button>

<h3>Modifier un utilisateur</h3>

<?php if (isset($_GET['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show bg-success text-white border-0 shadow" role="alert" style="max-width: 600px;">
    <strong>Succès !</strong> User ajouté avec succès !
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] === 'password_mismatch'): ?>
  <div class="alert alert-danger alert-dismissible fade show bg-danger text-white border-0 shadow" role="alert" style="max-width: 600px;">
    <strong>Erreur !</strong> Les mot de passe ne sont pas identiques 
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="bg-dark text-white p-4 rounded shadow mb-4" style="max-width: 1000px;">
  <form method="POST" action="index.php?action=user_update&id=<?= $id;?>">
    
    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="username" class="form-label">Nom de l'utilisateur</label>
        <input type="text" class="form-control bg-secondary text-white border-0 shadow-none" name="username" value="<?=$user['username']?>" required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="user_email" class="form-label">Email</label>
        <input type="text" class="form-control bg-secondary text-white border-0 shadow-none" name="user_email" value="<?=$user['user_email']?>" required>
      </div>
      
      <div class="col-md-6 mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control bg-secondary text-white border-0 shadow-none" name="password" required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
        <input type="password" class="form-control bg-secondary text-white border-0 shadow-none" name="confirm_password" required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="role_id" class="form-label">Role</label>
        <select class="form-select bg-secondary text-white border-0 shadow-none" name="role_id" required>
          <?php foreach($role_list as $role): ?>
            <option value="<?=$role['role_id']?>" <?= ($user['role_id'] == $role['role_id']) ? 'selected' : ''?>>
                <?=$role['role_id']?> | <?=$role['role']?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>


    </div> 

    <div class="mt-3 text-center">
      <button type="submit" class="btn btn-primary px-4">Modifier</button>
    </div>
    
  </form>
</div>

<?php include __DIR__. '/../layout/footer.php';?>



