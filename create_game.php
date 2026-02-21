<?php
define('SECURE_ACCESS', true);
require_once 'includes/db.php';
require_once 'includes/auth.php';

// On autorise tout utilisateur connecté (pas seulement les admins)
if (!is_logged_in()) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCSRFToken($_POST['csrf_token'] ?? '');

    $title = htmlspecialchars(trim($_POST['title']));
    $studio = htmlspecialchars(trim($_POST['studio']));
    $year = intval($_POST['release_year']);
    $desc = htmlspecialchars(trim($_POST['description']));

    // On utilise submitted_by pour correspondre au SQL
    $stmt = $pdo->prepare("INSERT INTO games (title, studio, release_year, description, status_id, submitted_by) VALUES (?, ?, ?, ?, 1, ?)");
    $stmt->execute([$title, $studio, $year, $desc, $_SESSION['user']['id']]);

    header("Location: dashboard.php?msg=success");
    exit();
}

$csrf_token = generateCSRFToken();
include 'includes/header.php';
?>
<h2>Soumettre un nouveau jeu</h2>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
    <input type="text" name="title" placeholder="Titre" required>
    <input type="text" name="studio" placeholder="Studio" required>
    <input type="number" name="release_year" placeholder="Année">
    <textarea name="description" placeholder="Description"></textarea>
    <button type="submit">Envoyer pour validation</button>
</form>
<?php include 'includes/footer.php'; ?>