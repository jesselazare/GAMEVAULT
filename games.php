<?php
define('SECURE_ACCESS', true);
require_once 'includes/db.php';
require_once 'includes/auth.php';
include 'includes/header.php';

// On récupère les jeux validés
$stmt = $pdo->query("SELECT g.*, u.username FROM games g 
                     JOIN users u ON g.submitted_by = u.id 
                     WHERE g.status_id = 2 
                     ORDER BY g.id DESC");
$games = $stmt->fetchAll();
?>

<main>
    <h2>Bibliothèque des Jeux</h2>
    <p>Tous les jeux ci-dessous ont été vérifiés et approuvés par l'administration.</p>

    <?php if (!$games): ?>
        <p style="margin-top:20px; color: orange;">Aucun jeu n'a encore été validé.</p>
    <?php else: ?>
        <div class="game-grid">
            <?php foreach ($games as $game): ?>
                <div class="game-card">
                    <h3><?= htmlspecialchars($game['title']) ?></h3>
                    <p><strong>Studio:</strong> <?= htmlspecialchars($game['studio']) ?></p>
                    <p><strong>Année:</strong> <?= htmlspecialchars($game['release_year']) ?></p>
                    <p style="margin: 10px 0; color: #aaa; font-size: 0.9em;">
                        <?= nl2br(htmlspecialchars($game['description'])) ?>
                    </p>
                    <div style="font-size: 0.8em; border-top: 1px solid #333; pt: 5px;">
                        Soumis par: <span style="color:#00ffcc"><?= htmlspecialchars($game['username']) ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>