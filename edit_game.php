<?php
define('SECURE_ACCESS', true);
require_once 'includes/db.php';
require_once 'includes/auth.php';

if (!is_admin()) {
    die("Accès réservé aux administrateurs.");
}

$id = intval($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM games WHERE id = ?");
$stmt->execute([$id]);
$game = $stmt->fetch();

if (!$game) {
    die("Jeu introuvable.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCSRFToken($_POST['csrf_token'] ?? '');

    $title = htmlspecialchars(trim($_POST['title']));
    $studio = htmlspecialchars(trim($_POST['studio']));
    $year = intval($_POST['release_year']);
    $desc = htmlspecialchars(trim($_POST['description']));
    $status = intval($_POST['status_id']);

    $update = $pdo->prepare("UPDATE games SET title=?, studio=?, release_year=?, description=?, status_id=? WHERE id=?");
    $update->execute([$title, $studio, $year, $desc, $status, $id]);

    header("Location: dashboard.php?msg=updated");
    exit();
}

$csrf_token = generateCSRFToken();
include 'includes/header.php';
?>

<h2>Modifier le jeu : <?= htmlspecialchars($game['title']) ?></h2>

<form method="POST" style="display:flex; flex-direction:column; max-width:500px;">
    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
    
    <label>Titre :</label>
    <input type="text" name="title" value="<?= htmlspecialchars($game['title']) ?>" required>
    
    <label>Studio :</label>
    <input type="text" name="studio" value="<?= htmlspecialchars($game['studio']) ?>">
    
    <label>Année :</label>
    <input type="number" name="release_year" value="<?= $game['release_year'] ?>">
    
    <label>Description :</label>
    <textarea name="description" rows="5"><?= htmlspecialchars($game['description']) ?></textarea>
    
    <label>Statut :</label>
    <select name="status_id">
        <option value="1" <?= ($game['status_id'] == 1) ? 'selected' : '' ?>>En attente</option>
        <option value="2" <?= ($game['status_id'] == 2) ? 'selected' : '' ?>>Validé</option>
    </select>

    <button type="submit" style="margin-top:20px; background:#33ff00; padding:10px; border:none; cursor:pointer;">Enregistrer les modifications</button>
    <a href="dashboard.php" style="margin-top:10px; color:white; text-align:center;">Annuler</a>
</form>

<?php include 'includes/footer.php'; ?>