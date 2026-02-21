<?php
define('SECURE_ACCESS', true);
require_once 'includes/db.php';
require_once 'includes/auth.php';
include 'includes/header.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

$role = $_SESSION['user']['role'];
$userId = $_SESSION['user']['id'];

if ($role === 'admin') {
    $stmt = $pdo->query("SELECT g.*, u.username FROM games g JOIN users u ON g.submitted_by = u.id ORDER BY g.id DESC");
} else {
    $stmt = $pdo->prepare("SELECT * FROM games WHERE submitted_by = ? ORDER BY id DESC");
    $stmt->execute([$userId]);
}
$games = $stmt->fetchAll();
?>

<main>
    <h2>Tableau de bord de <?= htmlspecialchars($_SESSION['user']['username']) ?></h2>
    
    <div style="margin-bottom: 20px;">
        <a href="create_game.php">Soumettre un jeu</a>
        <?php if($role === 'admin'): ?>
            | <a href="validate_game.php">Valider les jeux</a>
        <?php endif; ?>
    </div>

    <h3><?= ($role === 'admin') ? "Tous les jeux" : "Mes soumissions" ?></h3>
    <?php if (!$games): ?>
        <p>Aucun jeu trouvé.</p>
    <?php else: ?>
        <table border="1" style="width:100%; border-collapse: collapse;">
            <tr>
                <th>Titre</th>
                <th>Statut</th>
                <?php if($role === 'admin'): ?><th>Actions</th><?php endif; ?>
            </tr>
            <?php foreach($games as $game): ?>
            <tr>
                <td><?= htmlspecialchars($game['title']) ?></td>
                <td><?= ($game['status_id'] == 2) ? 'Validé' : 'En attente'; ?></td>
                <?php if($role === 'admin'): ?>
                <td>
                    <a href="edit_game.php?id=<?= $game['id'] ?>">Modifier</a> | 
                    <a href="delete_game.php?id=<?= $game['id'] ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <p><a href="logout.php" style="color:red;">Déconnexion</a></p>
</main>

<?php include 'includes/footer.php'; ?>