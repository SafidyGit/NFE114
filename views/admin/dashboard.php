<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../index.php?action=login');
    exit;
}

if ($_SESSION['role_id'] != 1) {
    echo "Accès refusé.";
    exit;
}
include 'layout/header.php';
?>

 <!-- Main Content -->
  <div class="flex-grow-1 p-3 mt-5">
    <!-- Toggler for small screens -->
    <button class="btn btn-outline-light d-lg-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
      ☰ Menu
    </button>

    <h3>Bienvenue <?php echo $_SESSION['username'];?></h3>
      <div class="table-responsive bg-dark p-3 rounded shadow">
          <div class="row">
        <div class="bg-secondary col col-md-3 text-white p-4 rounded shadow d-flex justify-content-between align-items-center mb-4 m-3" style="min-width: 220px;">
          <div>
            <h6 class="text-uppercase fw-bold mb-1">Nombre de produits</h6>
            <h3 class="m-0"><?= $count_product_in_stock ?? '';?></h3>
          </div>
          <div>
            <i class="bi bi-pc-display-horizontal fs-1 text-light"></i>
          </div>
        </div>
        <div class="bg-secondary col col-md-3 text-white p-4 rounded shadow d-flex justify-content-between align-items-center mb-4 m-3" style="min-width: 220px;">
          <div>
            <h6 class="text-uppercase fw-bold mb-1">Nombre de produits epuisés</h6>
            <h3 class="m-0"><?= $out_of_stock ?? '';?></h3>
          </div>
          <div>
            <i class="bi bi-dash-circle fs-1 text-danger"></i>
          </div>
        </div>
        <div class="bg-secondary col col-md-3 text-white p-4 rounded shadow d-flex justify-content-between align-items-center mb-4 m-3" style="min-width: 220px;">
          <div>
            <h6 class="text-uppercase fw-bold mb-1">Produits sous le seuil</h6>
            <h3 class="m-0"><?= $alert_stock ?? '';?></h3>
          </div>
          <div>
            <i class="bi bi-exclamation-triangle-fill fs-1 text-warning"></i>
          </div>
        </div>
      </div>

        <table class="table table-dark table-striped table-hover table-bordered mb-0">
        <thead>
        <tr>
            <th>Catégorie</th>
            <th>Total</th>
        </tr>
        </thead>
        <?php if(!empty($totalProductsByCategory)):?>
        <tbody>    
        <?php foreach($totalProductsByCategory as $product) : ?>
            <tr>
                <td><?= $product['category']; ?></td>
                <td><?= $product['Total']; ?></td>
            </tr>
            
        <?php endforeach; ?>
        </tbody>
        <?php endif;?>
        </table>
    </div>

    
</div>

<?php include 'layout/footer.php'; ?>