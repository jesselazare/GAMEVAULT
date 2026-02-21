<?php
define('SECURE_ACCESS', true);
require_once 'includes/db.php';
require_once 'includes/auth.php';
include 'includes/header.php';

if (!is_admin()) {
    die("<p>Accès refusé.</p>");
}

if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'approve') {
    $stmt = $pdo->prepare("UPDATE games SET status_id = 2 WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    header("Location: validate_game.php");
    exit();
}

// Retrait de la jointure "categories" qui n'existe pas dans ton SQL actuel
$stmt = $pdo->query("SELECT g.*, u.username FROM games g JOIN users u ON g.submitted_by = u.id WHERE g.status_id = 1 ORDER BY g.id DESC");
$games = $stmt->fetchAll();
?>

<main>
    <h2>Validation des jeux</h2>
    <?php if (!$games): ?>
        <p>Aucun jeu en attente.</p>
    <?php else: ?>
        <table border="1" style="width:100%;">
            <tr>
                <th>Titre</th>
                <th>Soumis par</th>
                <th>Action</th>
            </tr>
            <?php foreach($games as $game): ?>
            <tr>
                <td><?= htmlspecialchars($game['title']) ?></td>
                <td><?= htmlspecialchars($game['username']) ?></td>
                <td><a href="validate_game.php?action=approve&id=<?= $game['id'] ?>">Valider</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>