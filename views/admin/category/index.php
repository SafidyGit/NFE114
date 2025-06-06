<?php
    require_once __DIR__ . '/../../../controllers/CategoryController.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class="container">
<h3>Categories</h3>
<div>
    <a href="../../index.php?action=logout">Se déconnecter</a>
    <a href="../../admin/dashboard.php">Dashboard</a>
</div>  
<div>
    <a href="create.php">Ajouter une catégorie de produit</a>
</div>

<?php
    $categoryControlleur = new CategoryController();
    $categories = $categoryControlleur->index();
?>
    <style>
        table, th, td{
            border: 1px solid black;
            border-collapse: collapse;
            border-color: #96D4D4;
        }
    </style>
<!-- style="width: 20%; text-align:center; margin:auto; border: 1px solid black; border-collapse: collapse;" -->
<table class="table table-striped table-bordered">
<thead>
<tr>
    <th>Id</th>
    <th>Categorie</th>
    <th></th>
    <th></th>
</tr>
</thead>
<tbody>    
<?php foreach($categories as $category) : ?>
    <tr>
        <td><?= $category['category_id']; ?></td>
        <td><?= $category['category']; ?></td>
        <td><a href="update.php?id=<?= $category['category_id']?>"><input class="btn-sm" type="button" value="Modifier"></a></td>
        <td>
            <form method='POST' action="/index.php?action=category_delete&id=<?= $category['category_id']?>" onsubmit="return confirm('Voulez-vous vraiment modifier cette catégorie <?= $category['category_id'];?>?');">
                <input class="btn-lg"  style="color: red;" type="submit" value="X">
            </form>
        </td>
    </tr>
    
<?php endforeach; ?>
</tbody>
</table>
    
</body>
</html>
