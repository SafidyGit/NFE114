<h2>Categorie de produit</h2>

<?php if (isset($_GET['success'])): ?>
    <p style="color:green;">Categorie ajoutée avec succès !</p>
<?php endif; ?>

<form method="POST" action="/index.php?action=category_store">
    <input type="text" name="category" placeholder="Categorie" required><br>
    <button type="submit">Ajouter</button>
</form>