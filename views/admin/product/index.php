<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class="container">
<h3>Produits</h3>
<div>
    <a href="../../../index.php?action=logout">Se déconnecter</a>
    <a href="../../admin/dashboard.php">Dashboard</a>
</div>  
<div>
    <a href="../../../index.php?action=product_create">Ajouter un produit</a>
</div>
    <style>
        table, th, td{
            border: 1px solid black;
            border-collapse: collapse;
            border-color: #96D4D4;
        }
    </style>

<table class="table table-striped table-bordered">
<thead>
<tr>
    <th>Id</th>
    <th>Réference</th>
    <th>Nom</th>
    <th>Déscription</th>
    <th>quantité en stock</th>
    <th>seuil d'alerte</th>
    <th>prix unitaire</th>
    <th>Fourniseur</th>
    <th>Categorie</th>
    <th></th>
    <th></th>
</tr>
</thead>
<?php if(!empty($products)):?>
<tbody>    
<?php foreach($products as $product) : ?>
    <tr>
        <td><?= $product['product_id']; ?></td>
        <td><?= $product['product_reference']; ?></td>
        <td><?= $product['product_name']; ?></td>
        <td><?= $product['product_description']; ?></td>
        <td><?= $product['product_quantity_stock']; ?></td>
        <td><?= $product['product_alert_threshold']; ?></td>
        <td><?= $product['product_unit_price']; ?></td>
        <td><?= $product['supplier_id'] .' : '. $product['supplier']; ?></td>
        <td><?= $product['category_id'] .' : '. $product['category']; ?></td>
        <td>
            <a href="index.php?action=product_edit&id=<?= $product['product_id']?>&categorie=<?=$product['category_id']?>&fournisseur=<?=$product['supplier_id']?>">
                <input class="btn-sm" type="button" value="Modifier">
            </a>
        </td>
        <td>
            <form method='POST' action="/index.php?action=product_delete&id=<?= $product['product_id']?>" onsubmit="return confirm('Voulez-vous vraiment supprimer ce produit ? <?= $product['product_id'];?>?');">
                <input class="btn-lg"  style="color: red;" type="submit" value="X">
            </form>
        </td>
    </tr>
    
<?php endforeach; ?>
</tbody>
</table>
<?php endif;?>
    
</body>
</html>


