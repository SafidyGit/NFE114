<h2>Inscription</h2>

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
