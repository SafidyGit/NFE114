
<h2>Modifier une Categorie de produit</h2>

<?php if (isset($_GET['success'])): ?>
    <p style="color:green;">Categorie Modifiée avec succès !</p>
<?php endif; ?>
<!-- Etape maraka -->
<form method="POST" action="/index.php?action=category_update&id=<?= $id ?>">
    <input type="text" name="category" placeholder="Categorie" value="<?= $category['category'] ?? '' ?>" required><br>
    <button type="submit">Modifier</button>
</form>