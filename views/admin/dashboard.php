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
    



    
  </div>

<?php include 'layout/footer.php'; ?>