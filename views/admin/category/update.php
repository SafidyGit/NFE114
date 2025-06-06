
<?php 
    require_once __DIR__ . '/../../../controllers/CategoryController.php';

    $id = $_GET['id'];
    $categoryController = new CategoryController();
    $category = $categoryController->get_category_by_id($id);
?>

<h2>Modifier une Categorie de produit</h2>

<?php if (isset($_GET['success'])): ?>
    <p style="color:green;">Categorie Modifiée avec succès !</p>
<?php endif; ?>

<form method="POST" action="/index.php?action=category_update&id=<?= $id ?>">
    <input type="text" name="category" placeholder="Categorie" value="<?= $category['category'] ?? '' ?>" required><br>
    <button type="submit">Modifier</button>
</form>