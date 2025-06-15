<?php
session_start(); // Démarre la session

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Message d'erreur si non connecté
    $_SESSION['error'] = "Vous devez être connecté pour accéder à cette page.";
    // Redirection vers la page de connexion
    header('Location: index.php?action=login');
    exit;
}

// Vérifie que l'utilisateur a le rôle admin (1) ou employé (2)
if ($_SESSION['role_id'] != 1 && $_SESSION['role_id'] != 2) {
    // Message d'erreur si accès non autorisé
    $_SESSION['error'] = "Accès non autorisé.";
    // Redirection vers le tableau de bord
    header('Location: index.php?action=dashboard');
    exit;
}

// Inclusion de l'en-tête commun
include __DIR__ . '/../layout/header.php';
?>

<div class="container mt-5 card" style="background:#000000b5; color:white ; border-radius:2rem">
    <h1 class="text-center mb-4">Détails de la commande</h1>

    <?php if (isset($order)): // Vérifie si la commande existe ?>
        <div>
            <!-- Affiche les informations générales de la commande -->
            <p><strong>Référence :</strong> <?= htmlspecialchars($order['customer_order_reference']) ?></p>
            <p><strong>Client :</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
            <p><strong>Date :</strong> <?= htmlspecialchars($order['customer_order_date']) ?></p>
            <p><strong>Statut de la commande :</strong> <?= htmlspecialchars($order['customer_order_status']) ?></p>
        </div>

        <h3 class="mb-3 text-end">Produits commandés </h3>
        <table class="table table-bordered text-center">
            <thead class="table-light">
                <tr>
                    <!-- En-têtes du tableau des détails produits -->
                    <th>Référence Produit</th>
                    <th>Nom Produit</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Sous-total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $total = 0; // Initialise le total général à 0
                    foreach ($orderDetails as $detail): 
                        // Calcule le sous-total par produit
                        $subtotal = $detail['selling_price'] * $detail['co_quantity'];
                        // Cumule dans le total général
                        $total += $subtotal;
                ?>
                    <tr>
                        <!-- Affichage des détails produit -->
                        <td><?= htmlspecialchars($detail['product_reference']) ?></td>
                        <td><?= htmlspecialchars($detail['product_name']) ?></td>
                        <td><?= htmlspecialchars($detail['co_quantity']) ?></td>
                        <td><?= number_format($detail['selling_price'], 2) ?> Ar</td>
                        <td><?= number_format($subtotal, 2) ?> Ar</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <!-- Affiche le total général en bas du tableau -->
                    <th colspan="4">Total général</th>
                    <th><?= number_format($total, 2) ?> Ar</th>
                </tr>
            </tfoot>
        </table>
    <?php else: // Si la commande n'existe pas ?>
        <div class="alert alert-danger">Commande introuvable.</div>
    <?php endif; ?>

    <!-- Bouton pour revenir à la liste des commandes -->
    <div>
        <a href="index.php?action=list_orders" class="btn btn-secondary m-4" style="border-radius:2rem"> <- Retour à la liste des commandes</a>
    </div>
</div>

<?php 
// Inclusion du pied de page commun
include __DIR__ . '/../layout/footer.php'; 
?>
