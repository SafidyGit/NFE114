<h2>Inscription</h2>

<?php include __DIR__. '/../layout/header.php';?>

<?php if (isset($_GET['success'])): ?>
    <p style="color:green;">Utilisateurs ajoutée avec succès !</p>
<?php endif; ?>

<!-- Main Content -->
<div class="flex-grow-1 p-3 mt-5">
    <!-- Toggler for small screens -->
    <button class="btn btn-outline-light d-lg-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
        ☰ Menu
    </button>

<h3>Ajouter un utilisateur</h3>

<div class="bg-dark text-white p-4 rounded shadow mb-4" style="max-width: 1000px;">
  <form method="POST" action="/index.php?action=product_store">
    
    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="username" class="form-label">Nom de l'utilisateur</label>
        <input type="text" class="form-control bg-secondary text-white border-0 shadow-none" name="username" required>
      </div>

      <div class="col-md-6 mb-3">
        <label for="user_email" class="form-label">Email</label>
        <input type="text" class="form-control bg-secondary text-white border-0 shadow-none" name="user_mail" required>
      </div>
      
      <div class="col-md-6 mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="text" class="form-control bg-secondary text-white border-0 shadow-none" name="password" required>
      </div>


    </div> 

    <div class="mt-3 text-center">
      <button type="submit" class="btn btn-primary px-4">Ajouter</button>
    </div>
    
  </form>
</div>

<?php include __DIR__. '/../layout/footer.php';?>







<?php if (isset($_GET['success'])): ?>
    <p style="color:green;">Utilisateur ajouté avec succès !</p>
<?php endif; ?>

<form method="post" action="index.php?action=create">
    <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
    <input type="email" name="email" placeholder="Adresse email" required><br>
    <input type="password" name="password" placeholder="Mot de passe" required><br>
    <select name="role_id">
        <option value="1">Admin</option>
        <option value="2">Employé</option>
    </select><br>
    <button type="submit">S'inscrire</button>
</form>
